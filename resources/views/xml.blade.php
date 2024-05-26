<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XML Viewer</title>
</head>
<body>
    <h1>XML Viewer</h1>
    <a href="{{ route('download.xml') }}" target="_blank">Download XML</a>
    <hr>
    <pre>
        <?php echo htmlspecialchars(file_get_contents(storage_path('app/public/new_DD_I.xml'))); ?>
    </pre>

</body>
</html>
