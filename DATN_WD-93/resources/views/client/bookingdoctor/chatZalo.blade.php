<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile with QR Code</title>
    <style>
        .body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f9;
        }

        .container {
            display: flex;
            width: 600px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .qr-code {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            border-right: 2px solid #e0e0e0;
        }

        .qr-code img {
            width: 150px;
            height: 150px;
        }

        .user-info {
            flex: 2;
            padding: 20px;
        }

        .user-info h2 {
            margin-top: 0;
            color: #333;
        }

        .user-info p {
            margin: 8px 0;
            color: #555;
        }

        .label {
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>

<body>
    @extends('layout')
    @section('content')
    <div class="body">
        <div class="container">
            <div class="qr-code">
                <img src="https://thegame-onemega.com/wp-content/uploads/2024/11/The-Game-November-2024-Article-Banner-WIDE_T1.jpg" alt="QR Code">
            </div>

            <div class="user-info">
                <h2>VUI LÒNG QUÉT QR ĐỂ ĐƯỢC BÁC SỸ ĂN BA TỬ KHANG TƯ VẤN TRỰC TIẾP</h2>
                <h1>Ta là Ăn Bá Tử Khang</h1>
                <p><span class="label">Phone:</span> +123 456 7890</p>
                <p><span class="label">Email:</span> anbatukom@example.com</p>
                <p><span class="label">Address:</span> 123 Main St, Anytown, USA</p>
            </div>
        </div>
    </div>
    @endsection
</body>

</html>