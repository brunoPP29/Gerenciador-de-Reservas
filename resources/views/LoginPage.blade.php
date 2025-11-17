<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/reservas/resources/css/app.css">
    <title>Document</title>
</head>
<body>
    <div class="teste">Login Page</div>
    <p>{{ $message ?? '' }}</p>
    <form method="post">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        @csrf 
        <input name="user" type="text" placeholder="user">
        <input name="password" type="password" placeholder="password">
        <input type="submit" value="Logar!">
    </form>
    <div>
        <a href="register">Cadastrar-se</a><br>
        <a href="enterprise">Sou empresa</a>
    </div>
</body>
</html>