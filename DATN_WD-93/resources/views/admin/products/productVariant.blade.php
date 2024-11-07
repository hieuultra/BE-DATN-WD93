@extends('admin.layout')
@section('titlepage','')
@section('content')
 <!-- Quill css -->
 <link href="{{ asset('assets/admin/libs/quill/quill.core.js') }}" rel="stylesheet" type="text/css" />
 <link href="{{ asset('assets/admin/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
 <link href="{{ asset('assets/admin/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
 {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
 <meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Update product</h1>
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        <div class="row">
            <!-- Phần bên trái -->
            <div class="col-lg-4">
                <div class="row">
        <input type="hidden" name="id" value="{{ $product->id }}">
        <div class="mb-3">
            <label  class="form-label">ID</label>
            <input  disabled type="text" class="form-control" value="{{ $product->idProduct }}" name="idProduct">
        </div>

      <div class="mb-3">
        <label class="form-label">Name</label>
        <input disabled type="text" class="form-control" name="name" value="{{ $product->name}}">
      </div>

      <div class="mb-3">
        <label class="form-label">Category</label>
        <select disabled class="form-select" name="category_id">
            <option value="0">Choose categories</option>
            @foreach ($categories as $item)
            @if ($item->id == $product->category_id)
                <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
            @else
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endif
            @endforeach
        </select>
      </div>

      {{-- <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="img">
        <img src="{{ asset('upload/'.$product->img)}}" width="120" height="100" alt="">
      </div> --}}

      <div class="mb-3">
        <label class="form-label">Discount</label>
        <input type="number" class="form-control" name="discount" value="{{ $product->discount}}">
      </div>
      <div class="mb-3">
        <label class="form-label">Description Short</label>
        <textarea disabled class="form-control" placeholder="Leave a description product here" style="height: 100px" name="content" >{{ $product->content}}</textarea>
      </div>

      <label for="is_type" class="form-label">Status:</label>
      <div class="form-check">
          <input disabled class="form-check-input" type="radio" name="is_type" id="flexRadioDefault1" value="1" {{ $product->is_type == 1 ? 'checked' : '' }}>
          <label class="form-check-label" for="flexRadioDefault1">
            Display
          </label>
      </div>
      <div class="form-check mb-3">
          <input class="form-check-input" type="radio" name="is_type" id="flexRadioDefault2" value="0" {{ $product->is_type == 0 ? 'checked' : '' }}>
          <label class="form-check-label" for="flexRadioDefault2">
            Hidden
          </label>
      </div>

                  <label for="" class="form-label">Other Customized:</label>
                    <div class="form-switch mb-3 ps-3 d-flex justify-content-between">
                        <div class="form-check">
                            <input disabled class="form-check-input bg-danger" type="checkbox" name="is_new" {{ $product->is_new == 1 ? 'checked' : '' }}>
                            <label for="is_new" class="form-check-label">NEW</label>
                        </div>

                        <div class="form-check">
                            <input disabled class="form-check-input bg-secondary" type="checkbox" name="is_hot" {{ $product->is_hot == 1 ? 'checked' : '' }}>
                            <label for="is_hot" class="form-check-label">HOT</label>
                        </div>

                        <div class="form-check">
                            <input disabled class="form-check-input bg-warning" type="checkbox" name="is_hot_deal" {{ $product->is_hot_deal == 1 ? 'checked' : '' }}>
                            <label for="is_hot_deal" class="form-check-label">HOT DEAL</label>
                        </div>

                        <div class="form-check">
                            <input disabled class="form-check-input bg-success" type="checkbox" name="is_show_home" {{ $product->is_show_home == 1 ? 'checked' : '' }}>
                            <label for="is_show_home" class="form-check-label">SHOW HOME</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phần bên phải -->
            <div class="col-lg-8">
                <div class="row">
                    <div class="mb-3">
                        <label for="Description" class="form-check-label">Description Long</label>
                        <div id="quill-editor" style="height: 400px;">

                        </div>
                        <textarea disabled name="description" id="nd_content" class="d-none">Enter Description Long</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="img" onchange="showImage(event)">
                        <img id="imgPro" src="{{ asset('upload/'.$product->img)}}" alt="Image Product" style="width:150px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Album Image</label>
                        <i id="add-row" class="mdi mdi-plus text-muted fs-18 rounded-2 border ms-3 p-1" style="cursor: pointer"></i>
                        <table class="table align-middle table-nowrap mb-0">
                               <tbody id="image-table-body">
                               @foreach($product->imageProduct as $index => $imgs)
                               <tr>
                                <td class="d-flex align-items-center">
                                    <img id="preview_{{ $index }}" src="{{ Storage::url($imgs->image) }}"
                                     class="me-3" alt="Image Product" style="width:50px;">

                                    <input type="file" id="img" class="form-control" name="list_img[{{ $imgs->id }}]" onchange="previewImage(this, {{ $index }})">
                                    <input type="hidden" name="list_img[{{ $imgs->id }}]" value="{{ $imgs->id }}">
                                </td>
                                <td>
                                    <i class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1"
                                     style="cursor: pointer" onclick="removeRow(this)"></i>
                                </td>
                            </tr>
                               @endforeach
                               </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>




        <div class="row mt-3 mb-3">
                {{-- box left --}}
                <div class="col-lg-4">
                    <form action="{{ route('admin.productVariant.variantProductUpdate') }}" method="post">
                        <div class="mt-3 mb-3">
                            <label class="form-label">Variant:</label>
                            @foreach ($variantPros as $vp)
                                @if ($product->id == $vp->id_product)
                                    @foreach ($variants as $v)
                                        @if ($vp->id_variant == $v->id)
                                        <button class="variant-button" data-id="{{$vp->id}}" id="btnQuantity-{{$v->id}}"  style="width: auto; height: 40px; margin-left: 20px; border: 2px solid lightskyblue; border-radius:10px " type="button">
                                            {{$v->name}}
                                            <input type="hidden" class="idVariantProduct-{{$vp->id}}" value="{{$vp->id}}">
                                        </button>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                        <div class="mb-3 d-flex">
                            <label class="form-label">Quantity:</label>
                            <div class="ms-3 mx-3" >
                                <input type="text" class="form-control" id="quantity-display">
                            </div>
                        </div>
                        <div class="mb-3 d-flex">
                            <label class="form-label">Price:</label>
                            <div class="ms-3 mx-3" >
                                <input type="text" class="form-control" id="price-display">
                            </div>
                        </div>
                        <input type="hidden" name="" id="idProduct" value="{{ $product->id }}">
                        <button class="btn btn-primary" id="editProductVariant">Save</button>
                        {{-- <form action="{{ route('admin.products.variantProductDestroy') }}" method="POST">
                            <input type="hidden" name="" id="idProduct" value="{{ $product->id }}">
                            <button id="destroy" class="btn btn-danger">DEL</button>
                        </form> --}}
                    </form>
                    <form action="{{ route('admin.productVariant.VariantProductDestroy') }}">
                        <button class=" btn btn-danger mt-3" style="width: 60px;" id="deleteProductVariant">DEL</button>
                    </form>
                </div>
                {{-- box-right --}}
                <div class="col-lg-8">
                    <form action="{{ route('admin.productVariant.variantProductAdd') }}" method="post" id="demoForm">
                        @csrf
                           {{-- Hàng thứ nhất --}}
                            <div class="col">
                               <div class="mb-3">
                                    <label class="form-label">Variant Products</label>
                                    <select class="form-select" name="id_variant">
                                        <option value="0">Choose Variant Products</option>
                                        @foreach($variants as $vp)
                                        <option value="{{ $vp->id }}">{{ $vp->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        {{-- Hàng thứ 2 --}}
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="number" class="form-control" value="{{ old('price') }}" name="price" placeholder="Price">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" class="form-control" value="{{ old('quantity') }}" name="quantity" placeholder="Quantity">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id_product" value="{{$product->id}}">
                        <input type="submit" class="btn btn-primary" value="Add">
                        <a href="{{ route('admin.products.productList') }}">
                            <input type="button" class="btn btn-primary" value="LIST_PRO">
                        </a>
                    </form>
                </div>

  </div>

   <!-- Quill Editor Js -->
   <script src="{{ asset('assets/admin/libs/quill/quill.core.js') }}"></script>
   <script src="{{ asset('assets/admin/libs/quill/quill.min.js') }}"></script>
    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
   <script>
    //hien thi image khi add
    function showImage(event){
        const imgPro = document.getElementById('imgPro');
        const file =  event.target.files[0];
        const reader = new FileReader();
        reader.onload = function(){
            imgPro.src = reader.result;
            imgPro.style.display = "block";
        }
        if(file){
            reader.readAsDataURL(file);
        }
    }
  </script>

   <!-- content -->
   <script>
    document.addEventListener('DOMContentLoaded', function(){
        var quill = new Quill("#quill-editor", {
            theme: "snow",
    })
    //hien thi nd cu
    var old_content = `{!! $product->description !!}`;
    quill.root.innerHTML = old_content;
    //update lai textarea an khi content quill_editor thay doi
    quill.on('text-change', function() {
        document.getElementById('nd_content').value = quill.root.innerHTML;
    });
})
   </script>

   <!-- add album anh -->
   <script>
document.addEventListener('DOMContentLoaded', function(){
        var rowCount = {{ count($product->imageProduct) }};
      document.getElementById('add-row').addEventListener('click', function(){
        var tableBody = document.getElementById('image-table-body');
        var newRow= document.createElement('tr');
        newRow.innerHTML= ` <td class="d-flex align-items-center">
                            <img id="preview_${rowCount}" src="https://cdn.icon-icons.com/icons2/510/PNG/512/image_icon-icons.com_50366.png"
                            class="me-3" alt="Image Product" style="width:50px;">
                            <input type="file" class="form-control" name="list_img[id_${rowCount}]" onchange="previewImage(this, ${rowCount})">
                        </td>
                        <td>
                            <i class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1"
                            style="cursor: pointer" onclick="removeRow(this)"></i>
                        </td>`;
                        tableBody.appendChild(newRow);
                        rowCount++;
      })
                    });
                    //change image cua tung item
                    function previewImage(input, rowIndex){
                        if(input.files && input.files[0]){
                            const reader = new FileReader();
               reader.onload = function(e){
               document.getElementById(`preview_${rowIndex}`).setAttribute('src', e.target.result);
                   }
                   reader.readAsDataURL(input.files[0]);
                        }
                    }
                    function removeRow(item){
                        var row = item.closest('tr');
                        row.remove();
                    }
   </script>


   {{-- GET Quantity  & price --}}
   <script>
    var variantId;
    $(document).ready(function() {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $('.variant-button').on('click', function() {
            variantId = $(this).attr('data-id');
            // alert(variantId);
            $.ajax({
                type: "POST",
                url: '{{ route("admin.products.getVariantQuantity") }}',
                data: {
                    variantId :variantId,
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#quantity-display').val(`${response.quantity}`);
                        $('#price-display').val(`${response.price}`);
                    } else {
                        // alert(response.message);
                        $('#quantity-display').val(`${response.message}`);
                        $('#price-display').val(`${response.message}`);
                    }
                },
                error: function(xhr) {
                    alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
                }
            });

        });
        $("#editProductVariant").click(function (e) {
            e.preventDefault();
            var inputQuantiValue = $('#quantity-display').val();
            var inputPriceValue = $('#price-display').val();
            // var inputIdValue = $('.variant-button').val();
            // var inputIdProductValue = $('#idProduct').val();
            $.ajax({
                type: "POST",
                url:  '{{ route("admin.products.variantProductUpdate") }}',
                data: {
                    variantId:variantId,
                    // idProduct:inputIdProductValue,
                    quantity:inputQuantiValue,
                    price:inputPriceValue
                },
                success: function (response) {
                    console.log("Thành Công!!!!");

                }
            });
        });
         //delete
         var inputId;
        $(".variant-button").click(function (e) {
            e.preventDefault();
            inputId = $(this).attr('data-id');
            // alert(inputId);
        });
        $("#deleteProductVariant").click(function (e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '{{ route("admin.productVariant.VariantProductDestroy") }}',
                    data: {
                        id:inputId,
                    },
                    success: function (response) {
                      console.log('Thành Công!!!');
                      if(response){
                        window.location.reload();
                      }else{
                        alert('Xóa thất bại!');
                      }
                    }
                });
        });
    });
   </script>

@endsection
