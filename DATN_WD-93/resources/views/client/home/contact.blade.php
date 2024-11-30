@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
<script>
  $().ready(function() {
    $("#demoForm").validate({
      onfocusout: false,
      onkeyup: false,
      onclick: false,
      rules: {
        "name": {
          required: true,

        },
        "email": {
          required: true,
          email: true
        },
        "phone": {
          required: true,
        },
        "subject": {
          required: true,
        },
        "message": {
          required: true,

        }
      },
      messages: {
        "name": {
          required: "Bắt buộc nhập name",
        },
        "email": {
          required: "Bắt buộc nhập email",
          email: "Hãy nhập dúng định dạng email"
        },
        "phone": {
          required: "Bắt buộc nhập tel",
        },
        "subject": {
          required: "Bắt buộc nhập subject",

        },
        "message": {
          required: "Bắt buộc nhập message",
        }

      }
    });
  });
</script>
<style>
  label.error {
    color: red;
  }
</style>

<style>
  .tbao {
    text-align: center;
    color: green;
  }
</style>
<!-- Contact Start -->
<div class="container-fluid pt-5">
  <div class="text-center mb-4">
    <h2 class="section-title px-5">
      <span class="px-2">Liên hệ chúng tôi</span>
    </h2>
  </div>
  <h2 class="tbao">
    <?php
    if (isset($tbao) && ($tbao) != "") {
      echo $tbao;
    }
    ?>
  </h2>
  <div class="row px-xl-5">
    <div class="col-lg-7 mb-5">
      <div class="contact-form">
        <div id="success"></div>
        <form name="sentMessage" action="{{ route('subscribe') }}" method="POST" id="demoForm">
            @csrf
          {{-- <div class="control-group">
            <input type="text" class="form-control" name="name" placeholder="Nhập tên" required="required" data-validation-required-message="Please enter your name" />
            <p class="help-block text-danger"></p>
          </div> --}}
          <p style="font-weight: bold">Mỗi tháng chúng tôi đều có những đợt giảm giá dịch vụ và sản phẩm nhằm tri ân khách hàng. Để có thể cập nhập kịp thời những đợt giảm giá này,
             vui lòng nhập địa chỉ email của bạn vào ô dưới đây!</p>
          <div class="control-group">
            <label for="email">Nhập email để đăng ký nhận ưu đãi:</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Nhập email" required="required" data-validation-required-message="Please enter your email" />
            <p class="help-block text-danger"></p>
          </div>
          {{-- <div class="control-group">
            <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại" required="required" data-validation-required-message="Please enter your phone" />
            <p class="help-block text-danger"></p>
          </div>
          <div class="control-group">
            <input type="text" class="form-control" name="subject" placeholder="Nhập chủ đề" required="required" data-validation-required-message="Please enter a subject" />
            <p class="help-block text-danger"></p>
          </div>
          <div class="control-group">
            <textarea class="form-control" rows="6" name="message" placeholder="Nhập nội dung" required="required" data-validation-required-message="Please enter your message"></textarea>
            <p class="help-block text-danger"></p>
          </div> --}}
          <div>
            <input class="btn btn-primary py-2 px-4" type="submit" name="send" value="Đăng ký">
          </div>
        </form>
        @if(session('success'))
        <p>{{ session('success') }}</p>
        @endif

        @error('email')
            <p style="color: red;">{{ $message }}</p>
        @enderror
      </div>
    </div>
    <div class="col-lg-5 mb-5">
      <div class="bg-light p-30 mb-30">
        <iframe style="width: 100%; height: 250px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
      </div>
      <h5 class="font-weight-semi-bold mb-3">Liên hệ</h5>
      <p>
        Đại diện: NHÀ THUỐC INSTINCT PHARMACY - INSTINCT PHARMACY
      </p>
      <div class="d-flex flex-column mb-3">
        <h5 class="font-weight-semi-bold mb-3">THÔNG TIN CÔNG TY</h5>
        <p class="mb-2">
          <i class="fa fa-map-marker-alt text-primary mr-3"></i> Địa chỉ: 161 Bạch đằng, Phường 2, Quận Tân Bình, TP.HN
        </p>
        <p class="mb-2">
          <i class="fa fa-envelope text-primary mr-3"></i>hieubt@gmail.com
        <p class="mb-2">
          <i class="fa fa-phone-alt text-primary mr-3"></i>+0966888888
        </p>
      </div>
      <div class="d-flex flex-column">
        <h5 class="font-weight-semi-bold mb-3">Mã số doanh nghiệp: 8363764162</h5>
        <p class="mb-2">
          <i class="fa fa-map-marker-alt text-primary mr-3"></i>Thời gian làm việc: Từ 08h00 đến 21h00
        </p>
        <p class="mb-2">
          <i class="fa fa-envelope text-primary mr-3"></i>dattc@gmail.cpm
        </p>
        <p class="mb-0">
          <i class="fa fa-phone-alt text-primary mr-3"></i>+0969488340
        </p>
      </div>
    </div>
  </div>

</div>

@endsection
