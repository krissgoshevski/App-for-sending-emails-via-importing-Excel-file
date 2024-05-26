<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <div class="btn">
        <!-- Add an ID to the button for easier selection -->
        <button id="sendEmailButton" type="button" class="btn btn-success">Store Emails</button>
    </div>

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            // Add a click event listener to the button
            $('#sendEmailButton').click(function () {
                // Redirect to the desired route using JavaScript
                window.location.href = '/store'; // Replace '/store-emails' with your desired route
            });
        });
    </script>
</body>
</html>
