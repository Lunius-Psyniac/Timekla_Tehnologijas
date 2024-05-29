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
                @foreach (session('items', []) as $key => $item)
                    <tr>
                        <td>{{ $item }}</td>
                        <td style='width:30px'><span class="deleteItemButton" data-index="{{ $key }}">X</span></td>
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
                var index = $(this).data('index');
                $.ajax({
                    url: '{{ route('delete.item') }}',
                    type: 'POST',
                    data: { index: index },
                    success: function(response) {
                        $('#itemList tbody').empty();
                        $.each(response.items, function(index, item) {
                            $('#itemList tbody').append('<tr><td>' + item + '<td style="width:30px"><span class="deleteItemButton" data-index="' + index + '">X</span></td></tr>');
                        });
                    },
                    error: function(xhr) {
                        alert('An error occurred.');
                        console.log(xhr);
                    }
                });
            });
            
            $('#addItemButton').click(function() {
                var field1 = $('#titleInput').val();
                var field2 = $('#contentInput').val();
                if (field1 && field2) {
                    $.ajax({
                        url: '{{ route('add.item') }}',
                        type: 'POST',
                        data: { field1: field1, field2: field2 },
                        success: function(response) {
                            $('#itemList tbody').empty();
                            $.each(response.items, function(index, item) {
                                $('#itemList tbody').append('<tr><td>' + item + '<td style="width:30px"><span class="deleteItemButton" data-index="' + index + '">X</span></td></tr>');
                            });
                            $('#titleInput').val('');
                            $('#contentInput').val('');
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