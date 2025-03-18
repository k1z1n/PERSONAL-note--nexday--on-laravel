<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение Email</title>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Comfortaa', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
        }

        .header {
            background: #222;
            color: white;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
        }

        .container {
            width: 600px;
            background: #ffffff;
            padding: 40px;
            border-radius: 8px;
            margin: 40px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn {
            background: #222;
            color: white;
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
<div class="header">Nexday</div>
<div class="container">
    <h2>Подтвердите ваш Email</h2>
    <p>Нажмите на кнопку ниже, чтобы подтвердить ваш адрес электронной почты.</p>
    <a href="{{ $url }}" class="btn">Подтвердить Email</a>
    <p>Если вы не запрашивали подтверждение, просто проигнорируйте это письмо.</p>
</div>
</body>
</html>
