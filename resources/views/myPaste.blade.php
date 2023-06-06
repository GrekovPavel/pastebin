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
        <h2>Моя паста:</h2>
        <div>{{ $data }}</div>
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
