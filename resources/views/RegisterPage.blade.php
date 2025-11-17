<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form method="POST">
    @csrf

    <input type="text" name="name" value="{{ old('name', '') }}">
    @error('name')
        <p>{{ $message }}</p> 
    @enderror

    <input type="email" name="email" value="{{ old('email', '') }}">
    @error('email')
        <p>{{ $message }}</p>
    @enderror

    <input type="text" name="password">
    @error('password')
        <p>{{ $message }}</p>
    @enderror

    <button type="submit">Cadastrar</button>
</form>
</body>
</html>