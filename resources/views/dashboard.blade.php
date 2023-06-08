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
        <form method="post" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
        </form>
    </div>

</div>



</body>
</html>
