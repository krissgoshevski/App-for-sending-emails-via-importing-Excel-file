
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Emails</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>

          body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        /* Define your custom CSS styles for elements other than the navbar here */
        .container {
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 250px;
            text-align: center;
        }

        #sendEmailButton {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            max-width: 150px;
            text-align: center;
        }

        #sendEmailButton:hover {
            background-color: #45a049;
        }

        hr {
            height: 2px;
            background-color: grey;
            border: none;
            margin: 20px 0;
        }

        .preview-email {
            font-size: 12px; /* Adjust the font size as needed */
        }

    </style>
</head>
<body>


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{ route('import.excel.get') }}">Import</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index.page') }}">View Table</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('preview.emails') }}">Preview Emails</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

@foreach ($previewEmails as $email)
    <p class="preview-email">{!! $email !!}</p>
    <hr>
@endforeach

    <!-- Send Email Form -->
    @if(!empty($previewEmails))
    <form id="sendEmailForm" action="{{ route('send-multiple-emails') }}" method="POST" class="container">
        @csrf <!-- Add CSRF token -->

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <button id="sendEmailButton" type="button" class="btn btn-success">Send Emails</button>
            </div>
        </div>
    </form>
    @else
    <div class="alert alert-danger" role="alert">
        Немате импортирано табела, за да ги видете сите меилови треба прво да импортирате табела
    </div>
    @endif

    <!-- jQuery Script -->
    <script>
        $(document).ready(function () {
            $('#sendEmailButton').click(function () {
                $('#sendEmailForm').submit();
            });
        });
    </script>

</body>
</html>
