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
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <a href="enterprise">Logar</a>
                </div>
            @endif
        @csrf
        <input type="text" name="name" placeholder="Nome da empresa">
            @error('name')
                <p>{{ $message }}</p>
            @enderror        
        <input type="email" placeholder="email" name="email">
            @error('email')
                <p>{{ $message }}</p>
            @enderror        
        <input type="text" name="phone" placeholder="phone">
            @error('phone')
                <p>{{ $message }}</p>
            @enderror        
        <input type="text" name="password" placeholder="senha">
            @error('password')
                <p>{{ $message }}</p>
            @enderror
        <input type="submit" value="Registrar empresa">
    </form>
</body>
</html>