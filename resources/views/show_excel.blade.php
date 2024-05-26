<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
      

        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

#emailTable {
    width: 100%;
    border-collapse: collapse;
    margin: 20px auto;
}

#emailTable th,
#emailTable td {
    border: 1px solid black;
    padding: 8px;
    text-align: center;
}

#emailTable th {
    background-color: #f2f2f2;
}

.center-align {
    text-align: center;
}

    </style>
</head>
<body>


<center> <h2> All details of Excel file </h2> </center>

    <table border="1px solid black" id="emailTable">
    <thead>
        <tr>
            <th>Е-mail адреси</th>
            <th>Корисник или Circuit ID</th>
            <th>Адреса</th>
            <th>Почеток</th>
            <th>Крај</th>
            <th>Времетраење</th>
            <th>Англиска или Македонска верзија</th>
            <th>Наслов на порака</th>
            <th>Прва реченица во пораката</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $row)
            <tr>
                
                <td class="center-align"><a href="mailto:{{ $row[0] }}">{{ $row[0] }}</a></td>
                <td class="center-align">{{ $row[1] }}</td>
                <td class="center-align">{{ $row[2] }}</td>
                <td class="center-align">{{ $row[3] }}</td>
                <td class="center-align">{{ $row[4] }}</td>
                <td class="center-align">{{ $row[5] }}</td>
                <td class="center-align">{{ $row[6] }}</td>
                <td class="center-align">{{ $row[7] }}</td>
                <td class="center-align">{{ $row[8] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
