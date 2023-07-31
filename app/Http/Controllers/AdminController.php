<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Admin/Email');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function sendEmailToAllMovies(Request $request) {
        // $email = movie::pluck('email');

        $movie = Movie::all();

        if ($request->message != null && $request->subject != null) {
            $subject = $request->subject;
            $content = $request->message;

            foreach ($movie as $co) {
                $title = $co->title;


                $email      = $co->email;

                Mail::send('email.bulk-mail', ['content' => $content, 'movie' => $title], function($message) use ($subject, $email, $title) {
                    $message->to($email, $title);
                    $message->subject($subject);
                });
            }
        } else {
            return back()->with('error', 'Field Should Not be Empty.');
        }

        return back()->with('success', 'Emails are sent successfully.');
    }
}
