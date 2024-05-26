<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Import</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style> 
        /* Custom CSS for #importExcelForm */
        #importExcelForm {
            background-color: #f8f9fa; /* Light gray background */
            border-radius: 10px; /* Rounded corners */
            padding: 20px; /* Padding around the form */
            margin: 20px auto; /* Center the form horizontally */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Drop shadow effect */
            max-width: 600px; /* Limit the width of the form */
        }

        /* Style for form elements */
        #importExcelForm .form-group label {
            font-weight: bold; /* Make labels bold */
            color: #333; /* Dark gray text color */
        }

        #importExcelForm .btn-primary {
            background-color: #007bff; /* Blue button background */
            border-color: #007bff; /* Blue button border color */
        }

        #importExcelForm .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
            border-color: #0056b3; /* Darker blue border on hover */
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

<br><br>

<!-- Import Excel Form Container -->
<div class="container">
    <form id="importExcelForm" action="{{ route('import-excel') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="excelFile">Import Excel File:</label>
                    <input type="file" name="excelFile" class="form-control-file" id="excelFile" accept=".xlsx, .xls">
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-block">Import</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>
