@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')


 <!-- LinkTitle Start -->
 <div class="container-detail-product mb-2">
    <div class="row">
        <div class="col" style="padding-left: 0px">
            <nav class=" d-flex justify-content-start bg-light mb-30 text-link-title">
                <a class="nav-link" href="#">Trang Chủ</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                  </svg>
                <a class="nav-link" href="#">Sinh Lý - Nội Tiết Tố</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11A.5.5 0 0 1 2 8"/>
                  </svg>
                <span class="nav-link" >Cân bằng nội tiết tố</span>
            </nav>
        </div>
    </div>
</div>
<!-- LinkTitle End -->

<!-- Product Detail Start -->
    <div class="container-detail-product">
        <div class="row detailPro">
            <div class="col-4">
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <img  class="imgDetailPro" src="https://cdn.nhathuoclongchau.com.vn/unsafe/636x0/filters:quality(90)/https://cms-prod.s3-sgn09.fptcloud.com/00500122_vien_uong_ho_tro_can_bang_noi_tiet_to_leana_ocavill_60v_7335_628b_large_f28d3d0fc2_2968dd9c90.jpg">
                    </div>
                </div>
                <div class="row mt-5 " style="padding: 0px;  margin-left: 5px; display: flex; justify-content: space-between">
                   
                        <div class="abImg">
                            <img src="https://cdn.nhathuoclongchau.com.vn/unsafe/375x0/filters:quality(90)/https://cms-prod.s3-sgn09.fptcloud.com/00500122_vien_uong_ho_tro_can_bang_noi_tiet_to_leana_ocavill_60v_7335_628b_large_f28d3d0fc2_2968dd9c90.jpg" alt="" srcset="">
                        </div>
                
                   
                        <div class="abImg">
                            <img src="https://cdn.nhathuoclongchau.com.vn/unsafe/375x0/filters:quality(90)/https://cms-prod.s3-sgn09.fptcloud.com/00500122_vien_uong_ho_tro_can_bang_noi_tiet_to_leana_ocavill_60v_1653290867_c587619fb0.jpg" alt="" srcset="">
                        </div>
                 
              
                        <div class="abImg">
                            <img src="https://cdn.nhathuoclongchau.com.vn/unsafe/375x0/filters:quality(90)/https://cms-prod.s3-sgn09.fptcloud.com/00500122_vien_uong_ho_tro_can_bang_noi_tiet_to_leana_ocavill_60v_8390_628b_large_20bc2b2b0b.jpg" alt="" srcset="">
                        </div>

                        <div class="abImg">
                            <img  src="https://cdn.nhathuoclongchau.com.vn/unsafe/375x0/filters:quality(90)/https://cms-prod.s3-sgn09.fptcloud.com/00500122_vien_uong_ho_tro_can_bang_noi_tiet_to_leana_ocavill_60v_4969_628b_large_ada4fa0e68.jpg" alt="" srcset="">
                        </div>
                
                </div>
            </div>
            <div class="col-8">
                <div class="trade-mark">
                    <span>Thương Hiệu: </span>
                    <span><a href="">OCAVILL</a></span>
                </div>
                <div class="name-product">
                    <span>Viên uống LéAna Ocavill hỗ trợ cân bằng nội tiết tố (60 viên)</span>      {{-- name product --}}
                </div>
                <div class="code-product">
                    <span>000512</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-dot" viewBox="0 0 16 16">
                        <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                    </svg>
                    <svg style="color: yellow" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-dot" viewBox="0 0 16 16">
                        <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                    </svg>
                    <span>4.9</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-dot" viewBox="0 0 16 16">
                        <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                    </svg>
                    <a href="" style="color: blue; text-decoration: none">44 đánh giá</a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-dot" viewBox="0 0 16 16">
                        <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                    </svg>
                    <a href="" style="color: blue; text-decoration: none">439 bình luận</a>
                </div>
                <div class="price-product">
                    <span>544.000 đ</span>
                    <span>/Hộp</span>
                </div>
                <div class="variant-product">
                    <span>Chọn đơn vị tính:</span>
                    <button type="button">Hộp</button>
                    <button type="button">Vỉ</button>
                    <button type="button">Chai</button>
                    <button type="button">Lọ</button>
                </div>
                <div class="row info-product mt-5">
                    <div class="col" style="padding: 0px">
                        <span class="title-info-product">Danh Mục:</span>
                    </div>
                    <div class="col">
                        <span class="content-info-product">Cân Bằng Nội Tiết Tố</span>
                    </div>
                </div>
                <div class="row info-product">
                    <div class="col " style="padding: 0px">
                        <span class="title-info-product">Dạng Bào Chế:</span>
                    </div>
                    <div class="col ">
                        <span class="content-info-product"> Viên Nén Mềm</span>
                    </div>
                </div>
                <div class="row info-product">
                    <div class="col " style="padding: 0px">
                        <span class="title-info-product">Quy Cách:</span>
                    </div>
                    <div class="col ">
                        <span class="content-info-product"> Hộp 60 viên</span>
                    </div>
                </div>
                <div class="row info-product">
                    <div class="col " style="padding: 0px">
                        <span class="title-info-product">Xuất Xứ Thương Hiệu:</span>
                    </div>
                    <div class="col ">
                        <span class="content-info-product"> Bulgaria</span>
                    </div>
                </div>
                <div class="row info-product">
                    <div class="col " style="padding: 0px">
                        <span class="title-info-product">Nhà Sản Xuất:</span>
                    </div>
                    <div class="col ">
                        <span class="content-info-product"> PHYTOPHARMA LTD</span>
                    </div>
                </div>
                <div class="row info-product">
                    <div class="col " style="padding: 0px">
                        <span class="title-info-product">Nước Sản Xuất:</span>
                    </div>
                    <div class="col ">
                        <span class="content-info-product"> Bulgaria</span>
                    </div>
                </div>
                <div class="row info-product">
                    <div class="col " style="padding: 0px">
                        <span class="title-info-product">Thành Phần:</span>
                    </div>
                    <div class="col ">
                        <span class="content-info-product">Tinh dầu hoa anh thảo, Vitamin E, Nhân Sâm, Lepidium meyenii, Trinh nữ</span>
                    </div>
                </div>
                <div class="row info-product">
                    <div class="col " style="padding: 0px">
                        <span class="title-info-product">Mô Tả Ngắn:</span>
                    </div>
                    <div class="col ">
                        <span class="content-info-product">
                            Léana Ocavill hỗ trợ cân bằng nội tiết tố. Hỗ trợ cải thiện các triệu chứng thời kỳ tiền mãn kinh,
                            mãn kinh do suy giảm nội tiết tố. Hỗ trợ hạn chế quá trình lão hóa, giúp đẹp da.</span>
                    </div>
                </div>
                <div class="row info-product">
                    <div class="col " style="padding: 0px">
                        <span class="title-info-product">Số Đăng Ký:</span>
                    </div>
                    <div class="col ">
                        <span class="content-info-product">9677/2021/ĐKSP</span>
                    </div>
                </div>
                {{-- Tăng giảm số lượng --}}
                <div class="d-flex info-product pt-3 ">
                    <p class="title-info-product">Chọn số lượng: </p>
                    <div class="d-flex  justify-content-center btn-cart px-5">
                        <button type="button" class="drop"  onclick="decreaseQuantity()">
                              <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                 <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8"/>
                              </svg>
                        </button>
                        <input type="button" class="quantity"  id="quantityInput" value="1">
                        <button type="button" class="plus" id="plus"  onclick="increaseQuantity()">
                           <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                           </svg>
                        </button>
                    </div>
                </div>
                <div class="d-flex justify-content-between info-product ">
                    <button class="btn-addCart">Chọn Mua</button>
                    <button class="btn-seachCart">Tìm Tại Cửa Hàng</button>
                </div>
                <hr class="info-product">
                <div class="info-product d-flex">
                    <div class="d-flex justify-content-start">
                        <svg style="padding-top: 8px; color:blue" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16">
                            <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z"/>
                        </svg>
                        <div>
                            <p style="margin-bottom:0px; color: black; font-size: 16px">Đổi trả trong 30 ngày</p>
                            <p style="color: gray; font-size: 14px">kể từ ngày mua hàng</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start ps-3 px-3">
                        <svg style="padding-top: 8px; color:blue" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                            <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                            <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
                          </svg>
                        <div>
                            <p style="margin-bottom:0px; color: black; font-size: 16px">Miễn phí 100%</p>
                            <p>đổi thuốc</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <svg style="padding-top: 8px; color:blue" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                            <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
                          </svg>
                        <div>
                            <p style="margin-bottom:0px; color: black; font-size: 16px">Miễn phí vận chuyển</p>
                            <p style="color: gray; font-size: 14px">theo chính sách mua hàng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content product -->
        <div class="row contentPro">
            <div class="col col-lg-2 pt-3">
                <p style="color: black">Mô Tả Sản Phẩm</p>
            </div>
            <div class="col-8 pt-3">
                <h4>Tên sản phẩm</h4>                  {{-- đổ tên sản phẩm ở đây --}}
                <hr>
                <span>Nội dung dài của sản phẩm</span>  {{-- đổ mô tả dài ở đây --}}
            </div>
        </div>
        <!-- content end -->
    </div>
<!-- Product Detail End -->
    {{-- show list sản phẩm --}}
<!-- Products Start -->

<!-- Products End -->

<script>
// Hàm để giảm số lượng
var newQuanti = '';
         function decreaseQuantity() {
                  var input = document.getElementById("quantityInput" );
                  var currentValue = parseInt(input.value);

                  if (currentValue > 0) {
                     input.value = currentValue -1;
                  }
                  newQuanti = input.value;
                  if (newQuanti == 0) {
                     var confirmDelete = confirm('Số lượng tối thiểu phải là 1');
                     if (confirmDelete) {
                        input.value = currentValue;
                        newQuanti = input.value;
                     }
                  }
            }
        // Hàm để tăng số lượng
        function increaseQuantity() {
            var input = document.getElementById("quantityInput");
            var currentValue = parseInt(input.value);
            input.value = currentValue + 1;
            newQuanti =input.value;

        }

</script>
@endsection
