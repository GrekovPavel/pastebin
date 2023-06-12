<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <title>Страница пользователя</title>
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

        <div class="container">
            <div class="col-6 mx-auto">
                <h2>Мои пасты:</h2>
                @foreach($myPastes as $data)
                    <ul>
                        <li>
                            <a href="{{ $data->link }}">{{ mb_substr($data->content, 0, 15) . "..." }}  </a>
                            <div class="">{{ $data->updated_at }}</div>
                        </li>
                    </ul>
                @endforeach
                {{ $myPastes->links() }}
            </div>
        </div>
    </body>
</html>
