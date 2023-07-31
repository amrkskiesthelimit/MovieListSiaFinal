<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use App\Http\Middleware\HandleInertiaRequests;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Movies/Index', [
            'movies' => Movie::orderBy('title')->get()
        ]);
    }

    public function search($searchKey) {
        return inertia('Movies/Index', [
            'movies' => Movie::where('title', 'like', "%$searchKey%")->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Movies/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            "email" => "required"

        ]);

        $fileName = null;


        if($request->pic){
            $fileName = time().'.'.$request->pic->extension();
            $request->pic->move(public_path('images/product_pics'), $fileName);
            $fields['pic'] = $fileName;
        }

        $Movie = Movie::create([
            "user_id" => auth()->id(),
            "title" => $request->title,
            "description" => $request->description,
            "email" => $request->email,
            "pic" => $fileName,
        ]);

        return redirect('/movies');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        $user = auth()->user();
        return inertia('Movies/Show', [
            'movie' => $movie,
            'user' => $user
        ]);
    }

    public function toggle(Movie $movie) {
        $movie->enabled = !$movie->enabled;
        $movie->save();
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        return inertia('Movies/Edit', compact('movie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {

        $request->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'email' => 'string|required'
        ]);

        $movie->update($request->all());

        return redirect('/movies');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect('/movies')->with('Info', 'Movie has just been deleted!.');

    }
    public function pdf() {
        $movies = Movie::all();
        $pdf = PDF::loadView('pdf.movie', compact('movies'));

        return $pdf->stream();
    }

    public function email(Movie $movie) {
        $movies = Movie::all();
        $pdf = PDF::loadView('pdf.movie', compact('movies'));

        $filename = 'records/' . $movie->title . "_" . $movie->id . ".pdf";
        $pdf->save($filename);

        Mail::send('email.soa', ['movie'=>$movie], function($message) use ($movie, $filename){
            $message->to($movie->email);
            $message->subject('Movie List');
            $message->attach($filename);
        });

        return back();
      }
}
