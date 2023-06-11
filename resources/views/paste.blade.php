<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Pastebin</title>
</head>
<body>

<div class="container ">
    <div class="col-6 mx-auto">
        <a href="{{ route('paste') }}">Главная</a>
        <a href="{{ route('register') }}">Регистрация</a>
        <a href="{{ route('login') }}">Авторизация</a>
    </div>
    <div class="col-6 mx-auto">
        <form class="form-paste" action="/submit" method="post">
            @csrf
            <div class="form-title"><h2>Новая паста</h2></div>
            <div class="form-group">
                <label for="pasteTextarea"></label>
                <textarea class="form-control" name="pasteTextarea" id="pasteTextarea" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="expiration_time">Срок действия пасты</label>
                <select class="form-control" id="expiration_time" name="expiration_time">
                    <option value="">Без ограничений</option>
                    <option value="10">10 Минут</option>
                    <option value="60">1 час</option>
                    <option value="180">3 часа</option>
                    <option value="1440">1 день</option>
                    <option value="10080">1 неделя</option>
                    <option value="43800">1 месяц</option>
                </select>
            </div>
            <div class="form-group">
                <label for="access_paste">Ограничение доступа пасты</label>
                <select class="form-control" id="access_paste" name="access_paste">
                    <option value="public">Доступна всем</option>
                    <option value="unlisted">Доступна только по ссылке</option>
                    @if(Auth::check())
                        <option value="private">Доступна только мне</option>
                    @endif
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>


    <div class="col-6 mx-auto">
      <h2>Последние пасты:</h2>
        @foreach($dataTable as $data)
            <ul>
                <li>
                    <a href="{{ $data->link }}">{{ $data->content }}</a>
                    <div class="">{{ $data->updated_at }}</div>
                </li>
            </ul>
        @endforeach
    </div>


</div>



</body>
</html>
