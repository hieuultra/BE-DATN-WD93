@extends('admin.layout')
@section('titlepage','')

@section('content')
<!-- Quill css -->
<link href="{{ asset('assets/admin/libs/quill/quill.core.js') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">


<div class="container-fluid mt-4 px-4">
    <h1 class="mt-4">Thêm sản phẩm</h1>
    <form action="{{ route('admin.products.productAdd') }}" method="post" enctype="multipart/form-data" id="demoForm">
        @csrf
        <div class="row">
            <!-- Phần bên trái -->
            <div class="col-lg-4">
                <div class="row">
                    <div class="mb-3">
                        <label class="form-label">Mã</label>
                        <input type="text" class="form-control @error('idProduct') is-invalid @enderror" value="{{ old('idProduct') }}" name="idProduct" placeholder="Mã sản phẩm">
                        @error('idProduct')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tên</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" placeholder="Tên">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                            <option value="0">Chọn danh mục</option>
                            @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thương hiệu</label>
                        <select class="form-select @error('brand_id') is-invalid @enderror" name="brand_id">
                            <option value="0">Chọn thương hiệu</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" name="price" placeholder="Price">
                        @error('price')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div> --}}

                    <div class="mb-3">
                        <label class="form-label">Giảm giá (%)</label>
                        <input type="number"
                        class="form-control @error('discount') is-invalid @enderror" value="{{ old('discount') }}"
                        name="discount"
                        placeholder="Discount"
                        min="0">
                        @error('discount')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" name="quantity" placeholder="Quantity">
                        @error('quantity')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div> --}}

                    <div class="mb-3">
                        <label class="form-label">Mô tả ngắn</label>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                            placeholder="Leave a description product here" style="height: 100px" name="content">{{ old('content') }}</textarea>
                        @error('content')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <label for="is_type" class="form-label">Trạng thái:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_type" id="flexRadioDefault1" value="1" checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                            Hiện
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="is_type" id="flexRadioDefault2" value="0">
                        <label class="form-check-label" for="flexRadioDefault2">
                            Ẩn
                        </label>
                    </div>

                    <label for="" class="form-label">Tùy chọn khác:</label>
                    <div class="form-switch mb-3 ps-3 d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input bg-danger" type="checkbox" name="is_new" checked>
                            <label for="is_new" class="form-check-label">Sản <br> phẩm mới</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input bg-secondary" type="checkbox" name="is_hot" checked>
                            <label for="is_hot" class="form-check-label">Sản <br> phẩm nóng</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input bg-warning" type="checkbox" name="is_hot_deal" checked>
                            <label for="is_hot_deal" class="form-check-label">Giảm <br> giá mạnh</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input bg-success" type="checkbox" name="is_show_home" checked>
                            <label for="is_show_home" class="form-check-label">Hiện <br> trang chủ</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phần bên phải -->
            <div class="col-lg-8">
                <div class="row">
                    <div class="mb-3">
                        <label for="Description" class="form-check-label">Mô tả dài</label>
                        <div id="quill-editor" style="height: 400px;">

                        </div>
                        <textarea name="description" id="nd_content" class="d-none">Nhập mô tả dài</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ảnh</label>
                        <input type="file" class="form-control" name="img" onchange="showImage(event)">
                        <img id="imgPro" src="" alt="Image Product" style="width:150px; display: none">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thư viện ảnh</label>
                        <i id="add-row" class="mdi mdi-plus text-muted fs-18 rounded-2 border ms-3 p-1" style="cursor: pointer"></i>
                        <table class="table align-middle table-nowrap mb-0">
                            <tbody id="image-table-body">
                                <tr>
                                    <td class="d-flex align-items-center">
                                        <img id="preview_0" src="https://cdn.icon-icons.com/icons2/510/PNG/512/image_icon-icons.com_50366.png"
                                            class="me-3" alt="Image Product" style="width:50px;">
                                        <input type="file" class="form-control" name="list_img[id_0]" onchange="previewImage(this, 0)">
                                    </td>
                                    <td>
                                        <i class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1"
                                            style="cursor: pointer" onclick="removeRow(this)"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    {{-- bien the --}}
                    {{-- <div class="mb-3">
                        <h5>Product Variants</h5>
                        <table class="table align-middle table-nowrap mb-0" id="variant-table">
                            <thead>
                                <tr>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Add rows dynamically using JavaScript -->
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary mt-3" id="add-variant">Add Variant</button>
                    </div> --}}


                </div>
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="Thêm" name="them">
        <a href="{{ route('admin.products.productList') }}">
            <input type="button" class="btn btn-primary" value="Quay lại">
        </a>
    </form>
</div>

<!-- Quill Editor Js -->
<script src="{{ asset('assets/admin/libs/quill/quill.core.js') }}"></script>
<script src="{{ asset('assets/admin/libs/quill/quill.min.js') }}"></script>

<script>
    //hien thi image khi add
    function showImage(event) {
        const imgPro = document.getElementById('imgPro');
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function() {
            imgPro.src = reader.result;
            imgPro.style.display = "block";
        }
        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>

<!-- content -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill("#quill-editor", {
            theme: "snow",
        })
        //hien thi nd cu
        var old_content = `{!! old('description') !!}`;
        quill.root.innerHTML = old_content;

        //update lai textarea an khi content quill_editor thay doi
        quill.on('text-change', function() {
            document.getElementById('nd_content').value = quill.root.innerHTML;
        });
    })
</script>

<!-- add album anh -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var rowCount = 1;
        document.getElementById('add-row').addEventListener('click', function() {
            var tableBody = document.getElementById('image-table-body');
            var newRow = document.createElement('tr');
            newRow.innerHTML = ` <td class="d-flex align-items-center">
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
    function previewImage(input, rowIndex) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById(`preview_${rowIndex}`).setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);

        }
    }

    function removeRow(item) {
        var row = item.closest('tr');
        row.remove();
    }
</script>

@endsection
