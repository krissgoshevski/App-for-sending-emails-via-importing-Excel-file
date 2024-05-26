<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Table</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        #emailTable {
            border-collapse: collapse;
            margin: 20px auto;
            width: 100%;
            height: 100px;
        }

        #emailTable th,
        #emailTable td {
            border: 1px solid black;
            padding: 15px;
            text-align: center;
        }

        #emailTable th {
            background-color: #343a40;
            color: white;
        }

        .center-align {
            text-align: center;
        }

        .form-container {
            padding: 20px;
            margin-bottom: 20px;
            background-color: #ffffff;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        #deleteTableButton {
    background-color: #dc3545; /* Red background color */
    border-color: #dc3545; /* Red border color */
    color: #fff; /* White text color */
    border-radius: 5px; /* Rounded corners */
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

@if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif


<!-- Email Table -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-25">
            @if (!empty($rows))
            <table class="table table-bordered" id="emailTable">
                <thead class="thead-light">
                    <tr>
                        <th>Емаил</th>
                        <th>Корисник</th>
                        <th>Адреса</th>
                        <th>Почеток</th>
                        <th>Крај</th>
                        <th>Времетраење</th>
                        <th>Верзија</th>
                        <th>Наслов прв дел</th>
                        <th>Наслов втор дел</th>
                        <th>Прва реченица</th>
                        <th>Причина</th>

                    </tr>
                </thead>

            @else
            <div class="alert alert-danger" role="alert">
                Немате импортирано табела
            </div>
            @endif

            <tbody>
                @php $skipFirstRow = true; @endphp
                @foreach ($rows as $row)
                    {{-- Skip the first row --}}
                    @if ($skipFirstRow)
                        @php $skipFirstRow = false; continue; @endphp
                    @endif

                    {{-- Check if any value in the row is not null or not empty --}}
                    @if (array_filter($row, function($value) { return !is_null($value) && $value !== ''; }))
                        <tr>
                            <td class="center-align"><a href="mailto:{{ $row[0] ?? '' }}">{{ $row[0] ?? '' }}</a></td>
                            <td class="center-align">{{ $row[1] ?? '' }}</td>
                            <td class="center-align">{{ $row[2] ?? '' }}</td>
                            <td class="center-align">{{ $row[3] ?? '' }}</td>
                            <td class="center-align">{{ $row[4] ?? '' }}</td>
                            <td class="center-align">{{ $row[5] ?? '' }}</td>
                            <td class="center-align">{{ $row[6] ?? '' }}</td>
                            <td class="center-align">{{ $row[7] ?? '' }}</td>
                            <td class="center-align">{{ $row[8] ?? '' }}</td>
                            <td class="center-align">{{ $row[9] ?? '' }}</td>
                            <td class="center-align">{{ $row[10] ?? '' }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>

            </table>



@if (!empty($rows))
<button class="btn btn-danger btn-lg d-block mx-auto my-3 px-4" onclick="event.preventDefault(); document.getElementById('delete-form').submit();">Delete Table</button>

<form id="delete-form" action="{{ route('delete.excel') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endif


        </div>
    </div>
</div>

</body>
</html>
