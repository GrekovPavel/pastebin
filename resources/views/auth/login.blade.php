<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Авторизация</title>
</head>
<body>

<div class="container ">
    <div class="col-6 mx-auto">
        <a href="{{ route('paste') }}">Главная</a>
        <a href="{{ route('register') }}">Регистрация</a>
        <a href="{{ route('login') }}">Авторизация</a>
    </div>
    <div class="col-6 mx-auto">

        <form class="form-paste" action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-title"><h2>Авторизация</h2></div>
            <div class="form-group">
                <label for="name">Логин</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="name" placeholder="Login">
                @error('name')
                    <p style="color: red"> {{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password"name="password" class="form-control" id="password" placeholder="Password">
                @error('password')
                <p style="color: red"> {{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
</div>




</body>
</html>
