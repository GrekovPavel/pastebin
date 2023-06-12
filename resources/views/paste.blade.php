<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>


    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
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


    @if($myPastes)
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h2>Последние public пасты:</h2>
                    @foreach($dataTable as $data)
                        @if($data->access_paste === "public")
                            <ul>
                                <li>
                                    <a href="{{ $data->link }}">{{ mb_substr($data->content, 0, 15) . "..." }}  </a>
                                    <div class="">{{ $data->updated_at }}</div>
                                    <p>Пожаловаться</p>
                                    <form id="report-form" method="post">
                                        @csrf
                                        <input type="hidden" name="paste_id" value="{{ $data->id }}">
                                        <div class="form-group">
                                            <label for="reason">Причина:</label>
                                            <textarea class="form-control" name="reason"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Отправить жалобу</button>
                                    </form>
                                </li>
                            </ul>
                        @endif
                    @endforeach
                </div>
                <div class="col-6">
                    <h2>Мои пасты:</h2>
                    @foreach($myPastes as $data)
                        <ul>
                            <li>
                                <a href="{{ $data->link }}">{{ mb_substr($data->content, 0, 15) . "..." }}  </a>
                                <div class="">{{ $data->updated_at }}</div>
                            </li>
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
    @else

        <div class="col-6 mx-auto">
            <h2>Последние public пасты:</h2>
            @foreach($dataTable as $data)
                @if($data->access_paste === "public")
                    <ul>
                        <li>
                            <a href="{{ $data->link }}">{{ mb_substr($data->content, 0, 15) . "..." }}  </a>
                            <div class="">{{ $data->updated_at }}</div>
                            <p>Пожаловаться</p>
                            <form id="report-form" method="post">
                                @csrf
                                <input type="hidden" name="paste_id" value="{{ $data->id }}">
                                <div class="form-group">
                                    <label for="reason">Причина:</label>
                                    <textarea class="form-control" name="reason"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Отправить жалобу</button>
                            </form>
                        </li>
                    </ul>
                @endif
            @endforeach
        </div>
    @endif
</div>
</body>
</html>
