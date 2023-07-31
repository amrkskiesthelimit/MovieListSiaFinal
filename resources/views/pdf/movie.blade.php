<!DOCTYPE html>
<html>
<head>
    <title>Movie Information</title>

</head>
<body>
    <h2>Movie List</h2>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>

            </tr>
        </thead>
        <tbody>
            @foreach($movies as  $movie)
                <tr>


                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->description }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
