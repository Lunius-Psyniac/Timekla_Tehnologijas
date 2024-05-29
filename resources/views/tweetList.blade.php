<!DOCTYPE html>
<html>
<head>
    <title>Your Title</title>
</head>
<body>
    <h1>Data from Controller</h1>
    <ul>
        @foreach($tweets as $tweet)
            <li>{{ $tweet->attribute }}</li>
        @endforeach
    </ul>
</body>
</html>