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
        <input type="text" placeholder="name" name="name">
        <input type="number" placeholder="R$/HR" name="price_per_hour">
        <input type="number" placeholder="duração minutos" name="duration_minutes">
        <input type="number"  placeholder="abre" name="opens_at">
        <input type="number" placeholder="close" name="closes_at">
        <input type="text" placeholder="description" name="description">
        <input type="submit" value="registrar">
        
    </form>
</body>
</html>