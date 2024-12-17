<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tư vấn hỗ trợ QR Code</title>
    <style>
        .container {
            display: flex;
            flex-direction: row;
            max-width: 900px;
            width: 90%;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        /* QR Code Section */
        .qr-code {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #007bff;
            padding: 20px;
        }

        .qr-code img {
            width: 180px;
            height: 180px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* User Info Section */
        .user-info {
            flex: 2;
            padding: 30px;
            text-align: left;
        }

        .user-info h4 {
            margin-top: 0;
            color: #007bff;
            font-size: 1.8rem;
        }

        .user-info h4 {
            margin-top: 10px;
            font-size: 1.2rem;
            color: #555;
        }

        .user-info p {
            margin: 12px 0;
            color: #444;
            font-size: 1rem;
            line-height: 1.5;
        }

        .user-info .label {
            font-weight: bold;
            color: #007bff;
        }

        /* Button for Return */
        .back-button {
            text-decoration: none;
            font-size: 1rem;
            color: #007bff;
            font-weight: bold;
        }

        .back-button:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .qr-code {
                padding: 15px;
                background-color: #0069d9;
            }

            .user-info {
                padding: 20px;
            }

            .user-info h2 {
                font-size: 1.5rem;
            }

            .user-info p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    @extends('layout')
    @section('content')
    
    <div class="container">
        <!-- QR Code Section -->
        <div class="qr-code">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode(url('/')) }}" alt="QR Code">
        </div>

        <!-- User Info Section -->
        <div class="user-info">
            <h4>QUÉT QR ĐỂ ĐƯỢC NHÂN VIÊN CỦA CHÚNG TÔI TƯ VẤN TRỰC TIẾP</h4>
            <a href="{{route('viewSikibidi')}}" class="back-button">← Quay lại</a>
            <h4>Rất vui được hỗ trợ bạn!</h4>
            <p><span class="label">📞 Số điện thoại:</span> +123 456 7890</p>
            <p><span class="label">📧 Email:</span> anbatukom@example.com</p>
            <p><span class="label">📍 Địa chỉ:</span> 123 Main St, Thanh Xuân, Hà Nội</p>
        </div>
    </div>
    @endsection
</body>

</html>
