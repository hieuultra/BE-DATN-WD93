@extends('admin.layout')
@section('titlepage','')

@section('content')

<main>
    <div class="container-fluid px-4">
      <h1 class="mt-4">Danh sách biến thể</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Bảng điều khiển</li>
      </ol>

      <!-- Data -->
      <div class="row">
        {{-- Package --}}
        <div class="col">
          <div class="card mb-4">

            {{-- hien thi tb success --}}

            <div class="card-header d-flex justify-content-between">
              <div>
                <i class="fas fa-table me-1"></i>
                Danh sách biến thể
              </div>
              <a href="{{ route('admin.variantPros.packageAdd') }}">
                <input type="submit" class="btn btn-primary" name="them" value="Thêm">
              </a>
            </div>
            <div class="card-body">
                            {{-- Hiển thị thông báo --}}
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
            <table class="table" >
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col">Tên</th>
                  <th class="text-center" scope="col">Hành động</th>
                </tr>
              </thead>
              <tbody>
                @foreach($packages as $items)
                <tr>
                  <th scope="row">{{$items->id}}</th>
                  <td>{{$items->name}}</td>
                  <td class="text-center">
                    <a href="" class="btn btn-warning">
                      <form action="{{ route('admin.variantPros.viewpackageUpdate', $items->id) }}" method="GET">
                          <button style="background: none;  border: none; outline: none;" type="submit">
                            <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                              <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001"/>
                            </svg>
                         </button>
                          </form>
                     </a>
                   <!-- Thêm nút delete -->
                   <a href="" class="btn btn-danger">
                      <form action="{{ route('admin.variantPros.packageDestroy', $items->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          {{-- Sử dụng @method('DELETE') trong đoạn mã nhằm mục đích gửi một yêu cầu HTTP DELETE từ form HTML.  --}}
                          <button  style="background: none;  border: none; outline: none;" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                            <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                              <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                            </svg>
                          </button>
                      </form>
                   </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
      {{-- List Product Variant --}}
      <div class="row">
        {{-- Package --}}
        <div class="col">
          <div class="card mb-4">

            {{-- hien thi tb success --}}

            <div class="card-header d-flex justify-content-between">
              <div>
                <i class="fas fa-table me-1"></i>
                Danh sách sản phẩm biến thể
              </div>
              {{-- <a href="{{ route('admin.productVariant.viewProductVariantAdd') }}">
                <input type="submit" class="btn btn-primary" name="them" value="ADD">
              </a> --}}
            </div>
            <div class="card-body">
                            {{-- Hiển thị thông báo --}}
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
            <table class="table" >
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col" style="width: 280px;">Tên</th>
                  <th scope="col"  style="width: 220px;" >Ảnh</th>
                  <th scope="col" style="width: 200px;" >Danh mục</th>
                  <th scope="col">Biến thể</th>
                  <th scope="col">Giá</th>
                  <th scope="col">Số lượng</th>
                  {{-- <th class="text-center" style="width: 190px;" scope="col">Action</th> --}}
                </tr>
              </thead>
              <tbody>

               @foreach($variantPro as $vpPro)
               <tr>
                <th scope="row">{{ $vpPro->id }}</th>
                <td>
                    @foreach ($product as $pro)
                        @if (($vpPro->id_product) == ($pro->id))
                            {{$pro->name}}
                        @endif
                    @endforeach
                </td>
                <td>

                  @foreach ($product as $pro)
                        @if (($vpPro->id_product) == ($pro->id))
                        <img src="{{ asset('upload/'.$pro->img)  }}" width="150" height="90" alt="">
                        @endif
                    @endforeach
                </td>
                <td>
                  @foreach ($product as $pro)
                  @if (($vpPro->id_product) == ($pro->id))
                     @foreach ($cates as $cate)
                         @if (($cate->id) == ($pro->category_id))
                             {{$cate->name}}
                         @endif
                     @endforeach
                  @endif
              @endforeach
                </td>
                <td>
                  @foreach ($packages as $pack)
                        @if (($vpPro->id_variant ) == ($pack->id))
                            {{$pack->name}}
                        @endif
                    @endforeach
                </td>
                <td>{{$vpPro->price}}</td>
                <td>{{$vpPro->quantity}}</td>
                {{-- <td class="text-center">
                  <a href="" class="btn btn-warning">
                    <form action="{{ route('admin.productVariant.viewVariantProductUpdate', $vpPro->id) }}" method="GET">
                        <button style="background: none;  border: none; outline: none;" type="submit">
                          <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001"/>
                          </svg>
                       </button>
                        </form>
                   </a> --}}
                 <!-- Thêm nút delete -->
                 {{-- <a href="" class="btn btn-danger">
                    <form action="{{ route('admin.productVariant.VariantProductDestroy', $vpPro->id) }}" method="POST">
                        @csrf
                        @method('DELETE') --}}
                        {{-- Sử dụng @method('DELETE') trong đoạn mã nhằm mục đích gửi một yêu cầu HTTP DELETE từ form HTML.  --}}
                        {{-- <button  style="background: none;  border: none; outline: none;" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                          <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                          </svg>
                        </button>
                    </form>
                 </a>
                </td> --}}
              </tr>
               @endforeach
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>

  </main>

@endsection
