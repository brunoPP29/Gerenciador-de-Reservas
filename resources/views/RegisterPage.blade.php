<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<form method="POST">
    @csrf

    <input placeholder="user" type="text" name="user" value="{{ old('user', '') }}">
    @error('name')
        <p>{{ $message }}</p> 
    @enderror

    <input placeholder="email" type="email" name="email" value="{{ old('email', '') }}">
    @error('email')
        <p>{{ $message }}</p>
    @enderror

    <input placeholder="password" type="text" name="password">
    @error('password')
        <p>{{ $message }}</p>
    @enderror

    <button type="submit">Cadastrar</button>
</form>
</body>
</html>