<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение Email</title>
</head>
<body>
<h2>Здравствуйте, {{ $user->name }}!</h2>
<p>Для подтверждения вашего email, пожалуйста, нажмите на кнопку ниже:</p>
<a href="{{ $verificationUrl }}" style="background: blue; color: white; padding: 10px; text-decoration: none; border-radius: 5px;">
    Подтвердить Email
</a>
<p>Если вы не регистрировались, просто проигнорируйте это письмо.</p>
</body>
</html>
