<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>@yield('titlepage')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
      rel="stylesheet"
    />

    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />
    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }} " rel="stylesheet" />
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }} " rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/style1.css') }}" rel="stylesheet" />
    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- <link rel="stylesheet" href="{{ asset('css/styleAppoinment.css') }}"> --}}
    <link rel="icon" href="/img/logotrangweb.jpg" type="image/x-icon">
  </head>
<style>
    /* CSS for snowflakes */
    .snowflake {
    position: fixed;
    top: 0;
    width: 10px;
    height: 10px;
    background: white;
    border-radius: 50%;
    opacity: 0.7;
    animation: fall linear infinite;
}

@keyframes fall {
    0% {
        transform: translateY(0) rotate(0deg);
    }
    100% {
        transform: translateY(100vh) rotate(360deg);
    }
}
#chatbox-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
      }

      #toggle-chatbox {
        padding: 10px 20px;
        background-color: #ffff00c2;
        color: rgb(0, 0, 0);
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }

      .chatbox {
        display: none;  /* Initially hidden */
        width: 300px;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        position: relative;
        bottom: 60px;
        right: 0;
      }

      .chat-header {
        background-color: #cdc200;
        padding: 10px;
        color: white;
        text-align: center;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
      }

      .chat-content {
        max-height: 200px;
        overflow-y: auto;
        padding: 10px;
        font-size: 14px;
      }

      .chat-input {
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .chat-input input {
        width: 80%;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
      }

      .chat-input button {
        padding: 8px 15px;
        background-color: #ffc506;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }

      .message {
        background-color: #f0f0f0;
        padding: 8px;
        margin-bottom: 10px;
        border-radius: 5px;
      }


</style>
<!-- CSS for Popup -->
  <body>

    <!-- Kiểm tra route và chỉ hiển thị popup khi ở trang chủ -->
    @if (request()->routeIs('home'))
    <!-- Popup Modal -->
    <div id="popup-modal" class="popup-modal" onclick="closePopupOutside(event)">
      <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <img src="{{ asset('img/20241108071509-0-PopupNgaydoi-1086x612px.webp') }}" alt="Thông báo" style="width:100%; height:auto;">
        <p style="text-align: center; font-size: 1.2em; color: #ffea00;">Chào mừng bạn đến với cửa hàng của chúng tôi!</p>
      </div>
    </div>

    <!-- CSS for Popup -->
    <style>
      .popup-modal {
        display: flex;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        justify-content: center;
        align-items: center;
      }
      .popup-content {
        position: relative;
        background-color: transparent; /* Loại bỏ nền trắng */
        padding: 20px;
        border-radius: 10px;
        width: 80%;
        max-width: 400px;
        box-shadow: none; /* Loại bỏ bóng */
        text-align: center;
      }
      .popup-content img {
        border-radius: 10px;
      }
      .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 1.5em;
        cursor: pointer;
        color: white; /* Thay đổi màu nếu cần */
      }
    </style>

    <!-- JavaScript to Handle Popup Display -->
    <script>
      // Display the popup on page load
      document.addEventListener("DOMContentLoaded", function() {
        var popup = document.getElementById("popup-modal");
        popup.style.display = "flex";
      });

      // Function to close the popup
      function closePopup() {
        var popup = document.getElementById("popup-modal");
        popup.style.display = "none";
      }

      // Close popup when clicking outside of the popup content
      function closePopupOutside(event) {
        var popupContent = document.querySelector(".popup-content");
        if (!popupContent.contains(event.target)) {
          closePopup();
        }
      }
    </script>
@endif

    <!-- Topbar Start -->
    <div class="container-fluid">
      <div class="row bg-secondary py-1 px-xl-5">
        <marquee behavior="scroll" direction="left" scrollamount="9">
          {{-- <span style="font-size: 18px; color: red"
            >Free exchange for 30 days.</span
          > --}}
          <img src="{{asset('img/9eaf8645b78d6bc41a5b06a4db109296.png') }}" alt="">
          <img src="{{asset('img/eaa44ae488d28a2bf8329e21e1146ece.png') }}" alt="">
        </marquee>
      </div>
      <div
        class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex"
      >
        <div class="col-lg-4">
          <a href="{{ route('home') }}" class="text-decoration-none">
            <span class="h1 text-uppercase text-primary bg-dark"
              >Instinct</span
            >
            <span class="h1 text-uppercase text-dark bg-primary ml-n1"
              >Pharmacy</span
            >
          </a>
        </div>
        <div class="col-lg-4 col-6 text-left">
            <form action="{{ route('products.search') }}" method="GET">
            <div class="input-group">
              <input
                type="text" name="query"
                class="form-control"
                placeholder="Tìm kiếm sản phẩm" name="kyw"
              />
              <div class="input-group-append">
                <span class="input-group-text bg-transparent text-primary">
                  <i class="fa fa-search"></i>
                </span>
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-4 col-6 text-right">
          <p class="m-0">Dịch vụ khách hàng</p>
          <h5 class="m-0">0987654321</h5>
        </div>
      </div>
    </div>
    <!-- Topbar End -->

    @include('header')

    <main>
       @yield('content')
    </main>

    @include('footer')
        <!-- Chatbox HTML -->
        <div id="chatbox-container">
            <button id="toggle-chatbox" onclick="toggleChatbox()">Chat</button>
            <div id="chatbox" class="chatbox">
              <div id="chat-header" class="chat-header">
                <span>Chat</span>
                <button id="close-chatbox" onclick="toggleChatbox()">X</button>
              </div>
              <div id="chat-content" class="chat-content">
                <!-- Messages will be displayed here -->
              </div>
              <div id="chat-input" class="chat-input">
                <input type="text" id="message-input" placeholder="Nhập tin nhắn..." />
                <button onclick="sendMessage()">Gửi</button>
              </div>
            </div>
          </div>

<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"
><i class="fa fa-angle-double-up"></i
></a>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

<!-- Contact Javascript File -->
<script src="{{ asset('mail/jqBootstrapValidation.min.js') }}"></script>
<script src="{{ asset('mail/contact.js') }}"></script>

<!-- Template Javascript -->
<script src="{{ asset('js/main.js') }}"></script>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

<script>
    function changeLanguage(lang) {
      localStorage.setItem('preferredLanguage', lang);
      location.reload();
    }

    // Load preferred language on page load
    document.addEventListener("DOMContentLoaded", function() {
      const lang = localStorage.getItem('preferredLanguage') || 'en';
      document.documentElement.lang = lang; // Set language attribute in HTML for accessibility

      if (lang === 'vi') {
        // Adjust content for Vietnamese
        // e.g., replace text or load language-specific resources
      } else {
        // Adjust content for English or default language
      }
    });
  </script>
<script>
let snowflakes = [];
const maxSnowflakes = 100; // Số bông tuyết tối đa

function createSnowflake() {
  if (snowflakes.length >= maxSnowflakes) return;

  const snowflake = document.createElement("div");
  snowflake.className = "snowflake";
  snowflake.style.left = Math.random() * window.innerWidth + "px";
  snowflake.style.animationDuration = Math.random() * 3 + 2 + "s";
  snowflake.style.opacity = Math.random();
  document.body.appendChild(snowflake);
  snowflakes.push(snowflake);

  setTimeout(() => {
    snowflake.remove();
    snowflakes = snowflakes.filter((flake) => flake !== snowflake);
  }, 5000); // Tự động xóa sau 5 giây
}

setInterval(createSnowflake, 100);


</script>
<script>
    // Toggle chatbox visibility
    function toggleChatbox() {
      const chatbox = document.getElementById('chatbox');
      const display = chatbox.style.display;
      chatbox.style.display = display === 'none' || display === '' ? 'block' : 'none';
    }

    // Send message to AI and display in the chatbox
    function sendMessage() {
      const messageInput = document.getElementById('message-input');
      const message = messageInput.value.trim();
      if (message) {
        addMessageToChat('Bạn: ' + message, 'user');

        // Send the message to AI (or server) via AJAX
        $.ajax({
          url: '{{ route("chat.ai") }}', // Đường dẫn tới route của bạn
          method: 'POST',
          data: {
            message: message,
            _token: '{{ csrf_token() }}' // Nếu bạn sử dụng Laravel, thêm token CSRF
          },
          success: function(response) {
            // Hiển thị phản hồi từ AI
            addMessageToChat('AI: ' + response.message, 'ai');
          },
          error: function() {
            alert('Có lỗi xảy ra, vui lòng thử lại!');
          }
        });

        messageInput.value = ''; // Xóa ô nhập sau khi gửi
      }
    }

    // Add message to the chatbox
    function addMessageToChat(message, sender) {
      const chatContent = document.getElementById('chat-content');
      const messageElement = document.createElement('div');
      messageElement.classList.add(sender === 'ai' ? 'ai-message' : 'user-message');
      messageElement.textContent = message;
      chatContent.appendChild(messageElement);
      chatContent.scrollTop = chatContent.scrollHeight; // Cuộn xuống cuối
    }
  </script>

</body>

</html>
