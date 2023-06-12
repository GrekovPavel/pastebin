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
        <a href="/" ><h2>Моя паста:</h2></a>
        <div>{{ $data }}</div>
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
                    </li>
                </ul>
            @endif
        @endforeach
    </div>
    @endif

</div>



</body>
</html>
