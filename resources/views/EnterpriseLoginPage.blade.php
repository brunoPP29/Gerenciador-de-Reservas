<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="post">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        @csrf 
        <input placeholder="email" type="text" name="email">
        <input type="passowrd" placeholder="passoword" name="password">
        <input type="submit" value="Logar!">
    </form>

    <a href="registerEnterprise">Cadastrar</a>
</body>
</html>