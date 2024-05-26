

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imported Excel Data</title>
</head>
<body>
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

       <!-- Import Excel Form Container -->
<div class="container form-container">
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


    <h1>Imported Excel Data</h1>

    @if (!empty($rows))
        <table border="1">
            <thead>
                <tr>
                    <!-- Define table headers based on your data structure -->
                    <th>Column 1</th>
                    <th>Column 2</th>
                    <!-- Add more headers as needed -->
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr>
                        <!-- Display data in table cells -->
                        <td>{{ $row[0] }}</td> <!-- Replace 'column1' with the actual key of your data -->
                        <td>{{ $row[1] }}</td> <!-- Replace 'column2' with the actual key of your data -->
                        <!-- Add more columns as needed -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No data imported yet.</p>
    @endif
</body>
</html>
