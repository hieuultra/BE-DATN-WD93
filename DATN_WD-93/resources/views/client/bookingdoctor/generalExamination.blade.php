<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bố cục 3 cột với ảnh và tên</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 10px;
        }

        .column {
            flex: 1;
            min-width: 200px;
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
        }

        .column img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .name {
            margin-top: 10px;
            font-size: 18px;
        }
    </style>
</head>

<body>
    @extends('layout')
    @section('content')
    <h1 style="text-align: center;">Các gói khám tổng quát có thể bạn quan tâm</h1>
    <div class="container">
        @foreach($specialtytq as $specialtytq)
        <div class="column">
            <img src="{{ asset('upload/' . $specialtytq->image) }}" alt="Ảnh 1">
            <div class="name">{{$specialtytq->name}}</div>
        </div>
        @endforeach
    </div>
    @endsection
</body>

</html>