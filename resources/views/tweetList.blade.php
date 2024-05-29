<!DOCTYPE html>
<html>
<head>
    <title>Tweets</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .container {
            text-align: center;
        }
        #contentInput {
            display: block;
            margin-top: 10px;
            margin-bottom: 10px;
            width: 500px;
            height: 200px;
            overflow-wrap: break-word;
            resize: vertical;
        }
        #titleInput {
            display: block;
            margin-top: 10px;
            width: 500px;
            height: 50px;
        }
        #itemList {
            display: inline-block;
            vertical-align: top; /* Align the list to the top */
            text-align: left; /* Align the text to the left */
            margin-right: 20px; /* Add margin to create space between the list and the input fields */
        }
        h1{
            font-size: 40px;
        }
        table {
            width: 500px; /* Set the table width to 100% */
            border-collapse: collapse; /* Collapse borders between cells */
            margin-bottom: 20px; /* Add margin to separate the table and input fields */
        }
        th, td {
            width: 500px;
            border: 1px solid #ddd; /* Add borders to table cells */
            padding: 8px; /* Add padding to table cells */
        }
        .deleteItemButton {
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tweets</h1>
        <table id="itemList">
        <tbody>
        <td style='width:200px'>User</td>
        <td style='width:150px'>Title</td>
        <td>Comment</td>
        <td style='width:30px'>Delete?</td>
    @foreach ($tweets as $tweet)
        <tr>
            <td style='width:200px'>{{ $tweet->user->name }}</td>
            <td style='width:150px'>{{ $tweet->title }}</td>
            <td>{{ $tweet->content }}</td>
            @if ($tweet->user_id === Auth::id())
                <td style='width:30px'>
                    <span style='width:30px' class="deleteItemButton" data-index="{{ $tweet->id }}">X</span>
                </td>
            @else
                <td style='width:30px'></td>
            @endif
        </tr>
    @endforeach
</tbody>

        </table>
        <input type="text" id="titleInput" placeholder="Title">
        <textarea type="text" id="contentInput" placeholder="Comment"></textarea>
        <x-primary-button id="addItemButton"  class="ms-3">Send</x-primary-button>
        </div>    

        <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.deleteItemButton', function() {
                var data = $(this).data();
                $.ajax({
                    url: '{{ route('delete.item') }}',
                    type: 'POST',
                    data: { id: data },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('An error occurred.');
                        console.log(xhr);
                    }
                });
            });
            
            $('#addItemButton').click(function() {
                var title = $('#titleInput').val();
                var text = $('#contentInput').val();
                if (title && text) {
                    $.ajax({
                        url: '{{ route('add.tweet') }}',
                        type: 'POST',
                        data: { title: title, text: text },
                        success: function(response) {
                        location.reload();
                        },
                        error: function(xhr) {
                            alert('An error occurred.');
                            console.log(xhr);
                        }
                    });
                } else {
                    alert('Please enter values for both fields.');
                }
            });
        });
    </script>
</body>
</html>