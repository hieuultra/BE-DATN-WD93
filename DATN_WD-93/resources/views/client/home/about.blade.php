@extends('layout')
@section('titlepage', 'Instinct - Instinct Pharmacy System')
@section('title', 'Welcome')

@section('content')

    <style>
        .full-screen-img {
            width: 100vw;
            object-fit: cover;
            object-position: center;
            margin-top: -30px;
            margin-bottom: -60px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            line-height: 1.6;
            color: #333;
        }

        .custom-container {
            padding-left: 240px;
            /* Khoảng cách bên trái */
            padding-right: 240px;
            /* Khoảng cách bên phải */
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 40px;
            background-color: #ffffff00;
            border-radius: 10px;
            /* box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); */
        }

        .info-content {
            max-width: 700px;
        }

        .info-content h2 {
            font-size: 48px;
            color: #222;
        }

        h2 {
            font-size: 48px;
            color: #222;
        }

        .underline {
            width: 150px;
            height: 3px;
            background-color: #2891cc;
            margin: 10px 0 20px;
        }

        .info-content p {
            margin-bottom: 20px;
        }

        .info-content ul {
            list-style: none;
        }

        .info-content ul li {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .info-content ul li::before {
            content: '✔️';
            color: #007bff;
            font-size: 23px;
            margin-right: 10px;
        }

        .info-image {
            flex-shrink: 0;
        }

        .info-image img {
            max-width: 220px;
            transform: scale(1.4);
            margin-top: 70px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .info-content p {
            font-size: 18px;
        }

        .stats-section {
            display: flex;
            position: relative;
            justify-content: space-between;
            gap: 20px;
            padding: 20px 0;
            background-color: #ffffff;
            /* Đặt màu nền trắng cho toàn bộ section */
            max-width: 1400px;
            margin: 0 auto;
            margin-bottom: -130px;
            margin-top: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            z-index: 2;

        }

        .stat-card {
            text-align: center;
            background-color: #f4f9fc00;
            /* Màu nền của từng phần tử, có thể thay đổi tùy ý */
            padding: 20px;
            border-radius: 10px;
            width: 23%;
        }

        .stat-icon img {
            width: 39px;
            height: 39px;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #2891cc;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 16px;
            color: #333;
        }

        .vision-mission {
            background-color: #ffffff;
            /* Màu nền cho toàn bộ phần */
            padding: 40px 0;
            z-index: 1;
            position: relative;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        .card {
            /* background-color: #f9f9f9; */
            border: 1px solid #ffffff;
            border-radius: 10px;
            padding: 20px;
            flex: 1 1 calc(33.333% - 20px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            padding: 10px;
            font-size: 30px;
            font-weight: bold;
            color: #2891cc;
            margin-bottom: 15px;
        }

        .card-description {
            padding: 10px;
            font-size: 18px;
            line-height: 1.6;
            color: black;
        }

        .location-advantage {
            display: flex;
            flex-wrap: wrap;
            /* Đảm bảo tương thích với các màn hình nhỏ */
            align-items: center;
            justify-content: center;
            width: 100%;
            /* Full màn hình */
        }

        .image-container {
            margin-left: 10px;
            flex: 1;
            max-width: 50%;
            /* Đặt tỷ lệ hình ảnh */
        }

        .image-container img {
            width: 100%;
            height: auto;
            object-fit: cover;
            /* Đảm bảo ảnh không bị méo */
        }

        .content {
            margin-left: 50px;
            flex: 1;
            max-width: 50%;
            /* Đặt tỷ lệ nội dung */
            padding: 20px;
            box-sizing: border-box;
        }

        .content h2 {
            font-size: 48px;
            color: #222;
            margin-bottom: 15px;
            position: relative;
        }

        .content p {
            font-size: 18px;
            line-height: 1.6;
            max-width: 90%;
            color: #555;
        }

        .hospital-model-section {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            padding: 100px;
            background-color: #f0f8ff;
            /* Nền nhẹ */
        }

        .hospital-model-content {
            flex: 1;
            max-width: 50%;
            padding: 20px;
        }

        .hospital-model-content h2 {
            font-size: 48px;
            color: #222;
            margin-bottom: 15px;
            position: relative;
        }

        .hospital-model-content p {
            font-size: 18px;
            max-width: 90%;
            line-height: 1.6;
            color: #555;
        }

        .hospital-model-slider {
            flex: 1;
            max-width: 50%;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }

        .hospital-model-slides {
            display: flex;
            transition: transform 0.5s ease;
            width: 300%;
            /* Đảm bảo không gian cho các ảnh */
        }

        .hospital-model-slides img {
            width: 100%;
            flex: 1;
            object-fit: cover;
            border-radius: 10px;
            flex-shrink: 0;
        }

        .hospital-model-dots {
            text-align: center;
            margin-top: 15px;
        }

        .hospital-dot {
            height: 10px;
            width: 10px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            cursor: pointer;
        }

        .prev-btn,
        .next-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            /* Màu nền mờ */
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 20px;
            cursor: pointer;
            z-index: 10;
        }

        .prev-btn {
            left: 10px;
        }

        .next-btn {
            right: 10px;
        }

        .prev-btn:hover,
        .next-btn:hover {
            background-color: #2891cc;
            /* Màu nền khi hover */
        }

        /* Tổng quát */
        .team-section {
            /* padding: 50px 0; */
            background-color: #f8f9fa;
        }

        .section-title {
            text-align: center;
            font-size: 48px;
            color: #222;
            margin-top: 100px;
            /* margin-bottom: 100px; */
            font-weight: bold;
        }

        /* Cards */

        .team-card {
            /* height: 400px; */
            width: 600px;
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            position: relative;
            overflow: hidden;
        }


        .team-card-overlay {
            width: 100%;
            padding: 40px;
            color: white;
            text-align: center;
        }

        .team-card-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #ffffff;
        }

        .team-card-text {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .timeline {
            display: flex;
            align-items: flex-start;
            margin-top: 60px;
        }

        .years {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .year {
            padding: 25px 30px;
            /* border: 2px solid #ccc; */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.284);
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .year.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .year:hover {
            background-color: #0056b3;
            color: white;
        }

        .timeline-content {
            /* text-align: center; */
            margin: 20px;
        }

        #timeline-title {
            font-size: 26px;
            color: #333;
            margin-bottom: 20px;
        }

        .timeline-image-container {
            /* text-align: center; */
            margin: 50px 0;
        }

        #timeline-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 50px 80px 50px 120px;
            transform: scale(1.3);
        }

        #timeline-description {
            text-align: justify;
            max-width: 1000px;
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin-top: 15px;
        }

        /* Giao diện dịch vụ khám chữa */
        .service-section {
            padding: 40px 20px;
        }

        .service-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            max-width: 1600px;
            margin: 0 auto;
        }

        /* Cột trái */
        .left-column {
            flex: 1;
        }


        .service-item {
            background-color: #ffffff;
            padding: 25px;
            margin-bottom: 25px;
            border-left: 4px solid #eeeeee;
            border-radius: 5px;
        }

        .service-item h3 {
            font-size: 23px;
            color: #0066cc;
            margin-bottom: 10px;
        }

        .service-item p {
            font-size: 14px;
            line-height: 1.6;
        }

        .service-item.highlight {
            background-color: #00a950;
            color: white;
        }

        .service-item.highlight h3 {
            color: white;
        }

        /* Cột phải */
        .right-column {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .service-image {
            max-width: 100%;
            height: auto;
            transform: scale(1.3);
            border-radius: 10px;
            margin-top: 70px;
            margin-left: 50px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
    <img src="{{ asset('img/sanh-trang-gioi-thieu.png') }}" alt="" class="full-screen-img">
    <div class="container-fluid my-5 custom-container" style="background-color: #f0f8ff">
        <section class="info-section">
            <div class="info-content" style="margin-top: 60px">
                <h2>Về Phòng khám Đa khoa</h2>
                <div class="underline"></div>
                <p>
                    Được xây dựng và thành lập bởi Công ty TNHH Tổ hợp Y tế Phương Đông - Đơn vị thành viên của Tập đoàn
                    Intracom, Bệnh viện Đa khoa Phương Đông có nền tảng sức mạnh vững chắc về mọi mặt, từ năng lực tài
                    chính, bộ máy con người, cơ sở vật chất, hạ tầng kỹ thuật. Với phương châm chia sẻ giá trị tốt đẹp cho
                    xã hội về chăm sóc sức khỏe, Bệnh viện đa khoa Phương Đông là bước tiến tiếp theo của Intracom trên hành
                    trình “Tỏa sáng cùng đất nước”.
                </p>
                <ul>
                    <li>Đứng đầu trong lĩnh vực y tế, luôn đặt uy tín lên hàng đầu.</li>
                    <li>Đội ngũ với đầy kinh nghiệm, đam mê và nhiệt huyết trong công việc.</li>
                    <li>Trang thiết bị hiện đại, hàng đầu thế giới.</li>
                </ul>
            </div>
            <div class="info-image">
                <img src="{{ asset('img/1-trang-gioi-thieu.webp') }}" alt="Thiết bị y tế hiện đại">
            </div>
        </section>
        <section class="stats-section">
            <div class="stat-card">
                <div class="stat-icon">
                    <img src="{{ asset('img/icon3-trang-gioi-thieu.webp') }}" alt="Chuyên khoa">
                </div>
                <div class="stat-number">12+</div>
                <div class="stat-label">Chuyên khoa</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <img src="{{ asset('img/icon3-trang-gioi-thieu.webp') }}" alt="Chuyên khoa">
                </div>
                <div class="stat-number">666+</div>
                <div class="stat-label">Bác sĩ, y tá giỏi</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <img src="{{ asset('img/icon2-trang-gioi-thieu.webp') }}" alt="Chuyên khoa">
                </div>
                <div class="stat-number">100%</div>
                <div class="stat-label">Khách hàng hài lòng</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <img src="{{ asset('img/icon1-trang-gioi-thieu.webp') }}" alt="Chuyên khoa">
                </div>
                <div class="stat-number">5+</div>
                <div class="stat-label">Năm kinh nghiệm</div>
            </div>
        </section>


    </div>
    <div class="container-fluid my-5" style="background-color: #f9f9f9">
        <section class="vision-mission" style="background-color: #f9f9f9">
            <div class="custom-container" style="margin-top: 120px;">
                <h2 style="font-size: 48px;
            color: #222;">Tầm nhìn - Sứ mệnh của chúng tôi
                </h2>
                <div class="underline" style="margin-bottom: 50px"></div>
                <div class="card-container">
                    <div class="card">
                        <h3 class="card-title">Tiêu Chuẩn 5 Sao</h3>
                        <p class="card-description">
                            Chủ tịch Hội đồng thành viên Công ty TNHH Tổ hợp Y tế Phương Đông - Ông Nguyễn Thanh Việt cho
                            biết:
                            "Bệnh viện Phương Đông được xây dựng theo tiêu chuẩn 5 sao, đặt mục tiêu trở thành nhà cung cấp
                            hàng đầu các dịch vụ.
                        <div class="underline" style="width: 100px; margin-left: 10px"></div>
                        </p>
                    </div>
                    <div class="card">
                        <h3 class="card-title">Vươn Tầm Quốc Tế</h3>
                        <p class="card-description">
                            Bệnh viện Đa khoa Phương Đông định hướng phát triển trở thành đơn vị y tế hàng đầu khu vực và
                            vươn tầm quốc tế,
                            đem đến các dịch vụ đẳng cấp, góp phần nâng cao chất lượng sống của người Việt.
                        <div class="underline" style="width: 100px; margin-left: 10px"></div>
                        </p>
                    </div>
                    <div class="card">
                        <h3 class="card-title">Nâng Niu Từng Sự Sống</h3>
                        <p class="card-description">
                            Cùng với sứ mệnh “Nâng niu từng sự sống”, mỗi con người tại Phương Đông luôn nỗ lực không ngừng
                            học hỏi
                            và hoàn thiện mình để mang nền y học hiện đại thế giới đến với con người Việt Nam.
                        </p>
                        <div class="underline" style="width: 100px; margin-left: 10px"></div>

                    </div>
                </div>
            </div>
        </section>


    </div>
    <div class="container-fluid my-5">

        <section class="location-advantage">
            <div class="image-container">
                <img src="{{ asset('img/full2-trang-gioi-thieu.webp') }}" alt="Lợi thế địa lý" />
            </div>
            <div class="content">
                <h2>Lợi thế địa lý của chúng tôi</h2>
                <div class="underline"></div>
                <p>
                    Nằm trên địa bàn phường Cổ Nhuế 2, quận Bắc Từ Liêm, Hà Nội, tọa lạc giữa các khu dân cư có mật độ dân
                    số
                    cao như: khu dân cư Cổ Nhuế, khu dân cư Tây Hồ Tây, khu đô thị Ciputra, khu đô thị Bắc Cổ Nhuế Chèm.
                    Bệnh
                    viện Đa khoa Phương Đông được coi là điểm sáng về y tế khu vực phía Tây Hà Nội, là địa chỉ khám chữa
                    bệnh
                    tin cậy cho gần 180.000 cư dân có nhu cầu sử dụng dịch vụ y tế chất lượng cao.
                </p>
            </div>
        </section>
        <section class="hospital-model-section" style="margin-top: 50px">
            <div class="hospital-model-content">
                <h2>Mô hình bệnh viện xanh</h2>
                <div class="underline"></div>
                <p>
                    Được tư vấn và phát triển bởi Vamed - Tập đoàn đã có nhiều hỗ trợ cho hệ thống y tế công cộng của Việt
                    Nam trong hơn 20 năm qua với mục tiêu hiện đại hóa hệ thống bệnh viện, Bệnh viện Đa khoa Phương Đông là
                    một trong những đơn vị y tế tiên phong tại Việt Nam xây dựng theo mô hình bệnh viện xanh kết hợp điều
                    trị và nghỉ dưỡng thuận tự nhiên.
                    Tòa nhà chính được bao quanh bởi khuôn viên hàng nghìn cây xanh, hồ điều hòa, quảng trường rộng lớn với
                    tổng diện tích gần 10ha.
                </p>
                <p>
                    Với tổng mức đầu tư 198 triệu USD, bệnh viện có quy mô hơn 1.000 giường bệnh. Giai đoạn 1, bệnh viện đưa
                    vào hoạt động 250 giường với các chuyên khoa gồm: Khoa Phụ Sản, Khoa Nhi, Khoa Ngoại, Khoa Xét Nghiệm,
                    Khoa Khám Bệnh, Khoa Chẩn Đoán Hình Ảnh, Khoa Liên Chuyên Khoa, Khoa Dược, Trung Tâm Tư vấn và Tiêm
                    chủng Vắc-xin...
                </p>
            </div>
            <div class="hospital-model-slider" id="slider1">
                <div class="hospital-model-slides">
                    <img src="{{ asset('img/full2-1-trang-gioi-thieu.webp') }}" alt="Slide 1" />
                    <img src="{{ asset('img/full2-2-trang-gioi-thieu.webp') }}" alt="Slide 2" />
                    <img src="{{ asset('img/full2-3-trang-gioi-thieu.webp') }}" alt="Slide 3" />
                </div>
                <div class="hospital-model-dots">
                    <span class="hospital-dot"></span>
                    <span class="hospital-dot"></span>
                    <span class="hospital-dot"></span>
                </div>
                <button class="prev-btn">&#10094;</button>
                <button class="next-btn">&#10095;</button>
            </div>
        </section>
    </div>

    <div class="container-fluid my-5" style="padding-left: 0; padding-right: 0;">
        <section class="team-section">
            <h2 class="section-title">Đội ngũ bác sĩ giàu kinh nghiệm, giàu tâm huyết</h2>
            <div class="underline" style="margin: 20px 0 70px 700px; width: 500px;"></div>
            <div class="team-cards row" style="margin-bottom: -50px">
                <div class="team-card col-md-4"
                    style="background-image: url('{{ asset('img/nenthe1-trang-gioi-thieu.png') }}');">
                    <div class="team-card-overlay">
                        <h3 class="team-card-number">01</h3>
                        <div class="underline" style="width: 523px; background-color: rgb(224, 224, 224)"></div>
                        <p class="team-card-text">
                            Bệnh viện Đa khoa Phương Đông quy tụ đội ngũ bác sĩ có trình độ chuyên môn cao, giàu kinh
                            nghiệm, có nhiều năm công tác và giữ vị trí quan trọng tại các bệnh viện tuyến trung ương
                            cũng
                            như hợp tác với đồng đảo đội ngũ các chuyên gia đầu ngành trong và ngoài nước tư vấn chuyên
                            môn và thăm khám trực tiếp.
                        </p>
                    </div>
                </div>
                <div class="team-card col-md-4"
                    style="background-image: url('{{ asset('img/nenthe2-trang-gioi-thieu.png') }}');">
                    <div class="team-card-overlay">
                        <h3 class="team-card-number">02</h3>
                        <div class="underline" style="width: 523px; background-color: rgb(224, 224, 224)"></div>
                        <p class="team-card-text">
                            Bên cạnh đó, đội ngũ điều dưỡng, hộ sinh, kỹ thuật viên tại bệnh viện đều là những gương mặt
                            trẻ, nhiệt huyết, giàu kinh nghiệm, được đào tạo bài bản, luôn đề cao tinh thần trách nhiệm,
                            hết lòng tận tụy với công việc, tận tâm với người bệnh, giúp người bệnh an tâm, thoải mái
                            trong
                            suốt quá trình thăm khám.
                        </p>
                    </div>
                </div>
                <div class="team-card col-md-4"
                    style="background-image: url('{{ asset('img/nenthe3-trang-gioi-thieu.png') }}');">
                    <div class="team-card-overlay">
                        <h3 class="team-card-number">03</h3>
                        <div class="underline" style="width: 523px; background-color: rgb(224, 224, 224)"></div>
                        <p class="team-card-text">
                            Thông qua các chương trình hợp tác trong nước và quốc tế, các bác sĩ, điều dưỡng tại Bệnh
                            viện Đa khoa Phương Đông liên tục được cập nhật kiến thức y tế mới nhất, bám sát với sự phát
                            triển của nền y học thế giới. Cực kỳ tiện lợi và hiện đại khi sử dụng dịch vụ của chúng tôi rất
                            mong quý khách ủng hộ.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="container-fluid my-5 custom-container" style="background-color: #f0f8ff;">
        <section class="hospital-model-section" style="margin-top: 50px">
            <div class="hospital-model-content">
                <h2>Trang thiết bị hiện đại</h2>
                <div class="underline"></div>
                <p>
                    Bệnh viện Đa khoa Phương Đông đầu tư đồng bộ về cơ sở vật chất, trang thiết bị nhập khẩu từ các thương
                    hiệu hàng đầu thế giới như: Philips (Hà Lan/Mỹ), GE Healthcare (Mỹ), Beckman Coulter (Mỹ), Roche-Hitachi
                    (Nhật Bản), Olympus (Nhật Bản), Nihon Kohden (Nhật Bản),... đảm bảo các tiêu chí về hiệu quả, an toàn,
                    tiết kiệm thời gian, chính xác và thân thiện với môi trường.
                </p>
            </div>
            <div class="hospital-model-slider" id="slider2">
                <div class="hospital-model-slides">
                    <img src="{{ asset('img/anhnho1-trang-gioi-thieu.webp') }}" alt="Slide 1" />
                    <img src="{{ asset('img/anhnho3-trang-gioi-thieu.webp') }}" alt="Slide 2" />
                    <img src="{{ asset('img/anhnho4-trang-gioi-thieu.webp') }}" alt="Slide 3" />
                </div>
                <div class="hospital-model-dots">
                    <span class="hospital-dot"></span>
                    <span class="hospital-dot"></span>
                    <span class="hospital-dot"></span>
                </div>
                <button class="prev-btn">&#10094;</button>
                <button class="next-btn">&#10095;</button>
            </div>
        </section>
    </div>
    <div class="container-fluid my-5 custom-container">
        <h2>Lịch sử hình thành</h2>
        <div class="underline"></div>
        <div class="timeline">
            <!-- Các năm -->
            <div class="years">
                <div class="year active" data-year="2002">2020</div>
                <div class="year" data-year="2006">2021</div>
                <div class="year" data-year="2018">2022</div>
                <div class="year" data-year="2019">2024</div>
            </div>
        </div>
        <div class="timeline-content">
            <h2 id="timeline-title">Thành lập doanh nghiệp</h2>
            <div class="timeline-image-container">
                <img id="timeline-image" src="{{ asset('img/full2-trang-gioi-thieu.webp') }}" alt="Default Image" />
            </div>
            <p id="timeline-description">
                Ngày 21/12/2002, thành lập công ty Cổ phần Đầu tư Xây dựng Hạ tầng và Giao thông (Intracom) thuộc Tổng Công
                ty Đầu tư và Phát triển nhà Hà Nội. Công ty hoạt động đa lĩnh vực gồm: đầu tư xây dựng bất động sản, năng
                lượng sạch, xây lắp, sản xuất vật liệu, y tế, nông nghiệp, du lịch nghỉ dưỡng… Với mục tiêu trở thành công
                ty đa ngành nghề hàng đầu Việt Nam, Intracom đã và đang đầu tư xây dựng nhiều dự án, công trình có đóng góp
                đáng kể vào sự phát triển của Thủ đô và cả nước.
            </p>
        </div>
    </div>
    <div class="container-fluid custom-container" style="background-color: #f4f5f6">
        <section class="service-section">
            <h2 style="margin-top: 30px;">Dịch vụ thăm khám, điều trị và chăm sóc tận tình</h2>
            <div style="margin-bottom: 80px;" class="underline"></div>
            <div class="service-container">
                <!-- Cột trái -->

                <div class="left-column">

                    <div class="service-item">
                        <h3>Đội ngũ bác sĩ giàu y đức</h3>
                        <p>Luôn coi người bệnh là trung tâm, mọi sự chăm sóc đều hướng đến xóa bỏ tâm lý sợ hãi, lo lắng,
                            ngột ngạt khi đến bệnh viện, để không chỉ thân bệnh mà cả tâm bệnh cũng được chữa lành.</p>
                    </div>
                    <div class="service-item highlight">
                        <h3>Cảm giác thư thái, bình yên</h3>
                        <p>Khách hàng đến với Phương Đông sẽ được trải nghiệm cảm giác thư thái như đang đi nghỉ dưỡng tại
                            một không gian sang trọng, yên bình và xanh trong.</p>
                    </div>
                    <div class="service-item">
                        <h3>Chi phí hợp lý, tiết kiệm</h3>
                        <p>Bằng việc mở rộng liên kết, hợp tác với các đơn vị Bảo hiểm trên cả nước, Phương Đông đem đến cơ
                            hội khám chữa bệnh chất lượng cao với chuyên gia hàng đầu cùng mức chi phí hợp lý, tiết kiệm cho
                            đông đảo người dân.</p>
                    </div>
                </div>

                <!-- Cột phải -->
                <div class="right-column">
                    <img src="{{ asset('img/dichvu-trang-gioi-thieu.webp') }}" alt="Dịch vụ thăm khám"
                        class="service-image">
                </div>
            </div>
        </section>

    </div>
    <div class="container-fluid custom-container" style="background-color: #0385d0dc; padding-bottom: 70px">
        <section class="info-section">
            <div class="info-content" style="margin-top: 60px">
                <h2 style="color: white">Hợp tác và đào tạo chuyên sâu</h2>
                <div style="background-color: white" class="underline"></div>
                <p style="color: white">
                    Trong tiến trình phát triển của mình, Bệnh viện Đa khoa Phương Đông luôn nỗ lực trau dồi chuyên môn, cập
                    nhật các tiến bộ khoa học kỹ thuật, đồng thời không ngừng hợp tác với các đơn vị y tế đầu ngành trong
                    nước và quốc tế trong thăm khám, điều trị và đào tạo chuyên môn như: Đại học Y Hà Nội, Bệnh viện Nhi
                    Trung ương, Bệnh viện Ung bướu Hà Nội, Bệnh viện Lão khoa Trung ương, Bệnh viện Châm cứu Trung ương,
                    Công ty Philips Việt Nam, Viện Công nghệ sinh học... nhằm hoàn thiện chất lượng dịch vụ, đáp ứng toàn
                    diện nhu cầu khám, chữa bệnh của người dân.
                </p>
            </div>
            <div class="info-image">
                <img src="{{ asset('img/battay-trang-gioi-thieu.webp') }}" alt="Thiết bị y tế hiện đại">
            </div>
        </section>
    </div>
    <div class="container-fluid custom-container">
        <div style="margin-left: 30px">
            <h2 style="margin-top: 80px; margin-left: 400px">Ban lãnh đạo phòng khám</h2>
            <div style="margin-bottom: 100px; margin-left: 630px" class="underline"></div>
            <div class="row justify-content-center">
                <!-- Card 1 -->
                <div class="col-md-4 mb-3">
                    <div class="card text-center shadow">
                        <img src="{{ asset('img/lanhdao3-trang-gioi-thieu.webp') }}" class="card-img-top"
                            alt="Ông Nguyễn Thanh Việt">
                        <div class="card-body">
                            <h5 class="card-title">Nguyễn Thanh Việt</h5>
                            <p class="text-muted">Chủ tịch Hội đồng thành viên</p>
                            <p class="text-success fw-bold">PHÒNG KHÁM ĐA KHOA</p>
                            <div style="margin-bottom: -20px; margin-left: 30px; width: 300px;" class="underline"></div>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col-md-4 mb-3">
                    <div class="card text-center shadow">
                        <img src="{{ asset('img/lanhdao2-trang-gioi-thieu.webp') }}" class="card-img-top"
                            alt="PGS.TS.BS Nguyễn Trung Chính">
                        <div class="card-body">
                            <h5 class="card-title">Nguyễn Trung Chính</h5>
                            <p class="text-muted">Giám đốc</p>
                            <p class="text-success fw-bold">PHÒNG KHÁM ĐA KHOA</p>
                            <div style="margin-bottom: -20px; margin-left: 30px; width: 300px;" class="underline"></div>

                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="col-md-4 mb-3">
                    <div class="card text-center shadow">
                        <img src="{{ asset('img/lanhdao1-trang-gioi-thieu.webp') }}" class="card-img-top"
                            alt="Ông Nguyễn Công Minh">
                        <div class="card-body">
                            <h5 class="card-title">Nguyễn Công Minh</h5>
                            <p class="text-muted">Phó giám đốc</p>
                            <p class="text-success fw-bold">PHÒNG KHÁM ĐA KHOA</p>
                            <div style="margin-bottom: -20px; margin-left: 30px; width: 300px;" class="underline"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h2 style="margin-top: 80px; margin-left: 400px">Chứng nhận & giải thưởng</h2>
        <div style="margin-bottom: 100px; margin-left: 630px" class="underline"></div>
        <div class="row justify-content-center" style="margin-bottom: 100px">
            <!-- Award 1 -->
            <div class="col-md-3 mb-3">
                <img src="{{ asset('img/giaithuong4-trang-gioi-thieu.webp') }}" class="img-fluid shadow rounded"
                    alt="Award 1">
            </div>
            <!-- Award 2 -->
            <div class="col-md-3 mb-3">
                <img src="{{ asset('img/giaithuong3-trang-gioi-thieu.webp') }}" class="img-fluid shadow rounded"
                    alt="Award 2">
            </div>
            <!-- Award 3 -->
            <div class="col-md-3 mb-3">
                <img src="{{ asset('img/giaithuong2-trang-gioi-thieu.webp') }}" class="img-fluid shadow rounded"
                    alt="Award 3">
            </div>
            <!-- Award 4 -->
            <div class="col-md-3 mb-3">
                <img src="{{ asset('img/giaithuong1-trang-gioi-thieu.webp') }}" class="img-fluid shadow rounded"
                    alt="Award 4">
            </div>
        </div>
    </div>

    <script>
        function initializeSlider(sliderId, slideWidthPercentage) {
            const slider = document.getElementById(sliderId); // Lấy phần tử slider theo id
            const slides = slider.querySelector('.hospital-model-slides');
            const dots = slider.querySelectorAll('.hospital-dot');
            const prevBtn = slider.querySelector('.prev-btn');
            const nextBtn = slider.querySelector('.next-btn');

            let slideIndex = 0;

            // Hàm hiển thị slide hiện tại
            function showSlides(index) {
                const totalSlides = slides.children.length;

                // Reset chỉ số nếu vượt giới hạn
                if (index >= totalSlides) slideIndex = 0;
                if (index < 0) slideIndex = totalSlides - 1;

                // Cập nhật vị trí slide
                slides.style.transform = `translateX(-${slideIndex * slideWidthPercentage}%)`;

                // Cập nhật trạng thái cho các dots
                dots.forEach((dot, i) => {
                    dot.style.backgroundColor = i === slideIndex ? '#2891cc' : '#bbb';
                });
            }

            // Hàm xử lý nút "next"
            nextBtn.addEventListener('click', () => {
                slideIndex++;
                showSlides(slideIndex);
            });

            // Hàm xử lý nút "prev"
            prevBtn.addEventListener('click', () => {
                slideIndex--;
                showSlides(slideIndex);
            });

            // Hàm xử lý khi nhấn vào dot
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    slideIndex = index;
                    showSlides(slideIndex);
                });
            });

            // Chạy slide tự động
            function autoSlide() {
                slideIndex++;
                showSlides(slideIndex);
            }

            // Hiển thị slide đầu tiên và bắt đầu auto-slide
            showSlides(slideIndex);
            setInterval(autoSlide, 7000); // Thay đổi slide mỗi 7 giây
        }

        // Khởi động slider cho mỗi slider, với tỷ lệ slide khác nhau
        initializeSlider('slider1', 33.33); // Slider 1 sử dụng 100% chiều rộng
        initializeSlider('slider2', 60); // Slider 2 sử dụng 33.33% chiều rộng
    </script>
    <script>
        // Dữ liệu nội dung theo từng năm
        const timelineData = {
            2002: {
                title: "Thành lập doanh nghiệp",
                image: "img/full2-trang-gioi-thieu.webp",
                description: "Ngày 21/12/2002, thành lập công ty Cổ phần Đầu tư Xây dựng Hạ tầng và Giao thông (Intracom) thuộc Tổng Công ty Đầu tư và Phát triển nhà Hà Nội. Công ty hoạt động đa lĩnh vực gồm: đầu tư xây dựng bất động sản, năng lượng sạch, xây lắp, sản xuất vật liệu, y tế, nông nghiệp, du lịch nghỉ dưỡng… Với mục tiêu trở thành công ty đa ngành nghề hàng đầu Việt Nam, Intracom đã và đang đầu tư xây dựng nhiều dự án, công trình có đóng góp đáng kể vào sự phát triển của Thủ đô và cả nước.",
            },
            2006: {
                title: "Tái tạo cơ cấu doanh nghiệp",
                image: "img/year1-trang-gioi-thieu.webp",
                description: "Năm 2006, Công ty Cổ phần Đầu tư Hạ tầng và Giao thông tiến hành cổ phần hóa doanh nghiệp từ 100% vốn nhà nước sang hình thức cổ đông sở hữu. Bước chuyển mình mạnh mẽ này đã giúp Intracom tái tạo cơ cấu doanh nghiệp, đổi mới cơ chế quản lý, phát huy tốt hiệu quả sản xuất kinh doanh, tăng sức cạnh tranh và khả năng hội nhập trên thương trường.",
            },
            2018: {
                title: "Mở rộng thị trường",
                image: "img/year2-trang-gioi-thieu.webp",
                description: "Năm 2018, Intracom mở rộng đầu tư phát triển lĩnh vực y tế thông qua việc khánh thành và đưa vào hoạt động Bệnh viện Đa khoa Phương Đông theo mô hình bệnh viện khách sạn do ông Nguyễn Thanh Việt làm Chủ tịch Hội đồng thành viên. Ngày 24/09/2018 Bệnh viện Đa khoa Phương Đông chính thức đón nhận Giấy phép hoạt động khám bệnh, chữa bệnh số 234/BYT - GPHD do Bộ Y tế cấp phép.",
            },
            2019: {
                title: "Đổi mới công nghệ",
                image: "img/year3-trang-gioi-thieu.webp",
                description: "Ngày 24/02/2019, Bệnh viện Đa khoa Phương Đông chính thức khai trương trước sự tham dự và chứng kiến của Lãnh đạo Đảng, Nhà nước, Bộ Y tế, các Bộ, Ban Ngành TW và địa phương, cũng như các đơn vị Báo chí - Truyền thông trên cả nước, đánh dấu chặng đường phát triển mới của Bệnh viện Đa khoa Phương Đông và Intracom Group.",
            },
        };

        // Lấy các phần tử mới
        const yearButtons = document.querySelectorAll(".year");
        const timelineTitle = document.getElementById("timeline-title");
        const timelineImage = document.getElementById("timeline-image");
        const timelineDescription = document.getElementById("timeline-description");

        // Gắn sự kiện click cho từng năm
        yearButtons.forEach((button) => {
            button.addEventListener("click", () => {
                // Xóa class active khỏi tất cả các năm
                yearButtons.forEach((btn) => btn.classList.remove("active"));

                // Thêm class active cho nút được nhấp
                button.classList.add("active");

                // Lấy dữ liệu nội dung tương ứng
                const selectedYear = button.dataset.year;
                const data = timelineData[selectedYear];

                // Cập nhật nội dung
                timelineTitle.textContent = data.title;
                timelineImage.src = data.image;
                timelineDescription.textContent = data.description;
            });
        });
    </script>
@endsection
