<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lựa chọn dịch vụ</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        .body1 {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }


        .container {
            max-width: 800px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 2em;
            color: #333;
        }


        .service-options {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .option {
            background-color: #ffffff;
            border: 2px solid #e2e2e2;
            border-radius: 10px;
            padding: 20px;
            width: 200px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .option:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


        .option-icon {
            font-size: 40px;
            color: #4a90e2;
            margin-bottom: 10px;
        }

        .option-title {
            font-size: 1.2em;
            margin-bottom: 5px;
            color: #333;
        }

        .option-description {
            font-size: 0.9em;
            color: #666;
        }

        .custom-link {
            display: inline-block;
            text-decoration: none;
            /* Xóa gạch chân mặc định */
            color: #fff;
            /* Màu chữ */
            background-color: #4a90e2;
            /* Màu nền */
            padding: 10px 20px;
            /* Khoảng cách nội dung */
            border: 2px solid #4a90e2;
            /* Viền màu xanh */
            border-radius: 8px;
            /* Bo góc viền */
            font-weight: bold;
            /* Chữ đậm */
            transition: all 0.3s ease;
            /* Hiệu ứng chuyển động mượt mà */
        }

        .custom-link:hover {
            background-color: #fff;
            /* Nền trắng khi hover */
            color: #4a90e2;
            /* Đổi màu chữ */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Hiệu ứng bóng đổ */
            transform: translateY(-2px);
            /* Dịch chuyển lên trên nhẹ */
        }
    </style>
</head>

<body>
    @extends('layout')
    @section('content')

    <div class="body1">
        <div class="container">
            <h1>Bạn muốn lựa chọn dịch vụ nào</h1>
            <a href="{{route('appoinment.index')}}" class="custom-link">Quay lại</a>
            <div class="service-options">

                <div class="option" onclick="window.location.href='/chat-ai'">
                    <div class="option-icon">🤖</div>
                    <div class="option-title">Chat AI</div>
                    <div class="option-description">Trò chuyện với AI để nhận hỗ trợ tức thì.</div>
                </div>


                <div class="option" onclick="window.location.href='/chat-zalo'">
                    <div class="option-icon">📞</div>
                    <div class="option-title">Tư vấn qua điện thoại & Zalo</div>
                    <div class="option-description">Gọi hoặc nhắn tin Zalo để tư vấn trực tiếp.</div>
                </div>


                <div class="option" onclick="window.location.href='/huong-dan-dl'">
                    <div class="option-icon">🩺</div>
                    <div class="option-title">Hướng dẫn đặt lịch khám</div>
                    <div class="option-description">Hướng dẫn đặt lịch khám nếu bạn là người lần đầu tiên sử dụng.</div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>

</html>