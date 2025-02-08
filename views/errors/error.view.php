<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        h1 { font-size: 50px; }
        p { font-size: 20px; }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            color: white;
            background: #007BFF;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1>Error Code: <?= $errorCode ?></h1>
    <p><b>Error Message: <?= $errorMessage ?></b></p>
    <a href="/">Go Home</a>
</body>
</html>
