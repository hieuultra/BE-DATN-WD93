@extends('admin.layout')
@section('titlepage','')

@section('content')
<style>
.pagination {
    margin-top: 20px;
    display: flex;
    justify-content: center;
}

.pagination a {
    margin: 0 5px;
    padding: 5px 10px;
    text-decoration: none;
    background-color: #316b7d;
    color: #fff;
    border-radius: 3px;
}
.pagination li {
    list-style-type: none;
}
table th, table td {
        word-wrap: break-word !important;
        white-space: normal !important;
        max-width: 100px !important; /* Giới hạn chiều rộng cho tên sản phẩm */
    }

 td.product-name {
        max-width: 100px !important;
    }

</style>
<main>
    <div class="container-fluid px-4">
      <h1 class="mt-4">List products</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>

      <!-- Data -->
      <div class="card mb-4">
        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          List categories
        </div>
        {{-- <form action="index.php?act=list_pro" method="post">
            <select class="form-select" name="category_id" id="">
                <option value="0">Chon danh muc</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
          <input class="btn btn-primary" type="submit" name="listok" value="GO">
        </form> --}}
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
          <table id="datatablesSimple">
            <thead>
              <tr>
                <th>ID</th>
                <th>Category name</th>
                <th>Product name</th>
                <th>Image</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach($products as $item)
                 <tr>
                    <td>{{ $item->idProduct }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td class="product-name">{{ $item->name }}</td>
                    <td><img src="{{ asset('upload/'.$item->img)  }}" width="200" height="150" alt=""></td>
                    <td>{{ number_format($item->price,0,'.',',')}} $</td>
                    <td>{{ number_format($item->discount,0,'.',',') }} %</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="{{ $item->is_type == true ? 'text-success' : 'text-danger' }}">
                        {{ $item->is_type == true ? 'Display' : 'Hidden' }}
                      </td>
                    <td class="action">
                    <a href="" class="btn btn-warning">
                    <!-- Thêm nút update -->
                      <form action="{{ route('admin.products.productUpdateForm', $item->id) }}" method="GET">
                        <button style="background: none;  border: none; outline: none;" type="submit">
                            <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                              <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001"/>
                            </svg>
                         </button>
                     </form>
                    </a>
                     <!-- Thêm nút delete -->
                     {{-- <a href="" class="btn btn-danger">
                        <form action="{{ route('admin.products.productDestroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE') --}}
                                    {{-- Sử dụng @method('DELETE') trong đoạn mã nhằm mục đích gửi một yêu cầu HTTP DELETE từ form HTML.  --}}
                                    {{-- <button  style="background: none;  border: none; outline: none;" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                        <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                          <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                        </svg>
                                      </button> --}}
                         {{-- </form>
                     </a> --}}
                     <!-- Nút xóa mềm -->
                     <a href="" class="btn btn-danger">
                        <form action="{{ route('admin.products.softDelete', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button  style="background: none;  border: none; outline: none;" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa mềm không?')">
                                <svg style="color: orange" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16">
                                    <path d="M12.643 1H3.357L3 2v10h10V2l-.357-1zM8 3.5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0v-5a.5.5 0 0 1 .5-.5zm-3 1A.5.5 0 0 1 5.5 5v3a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5zm6 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                                SoftDelete
                            </button>
                        </form>
                     </a>

                  <!-- Nút xóa cứng -->
                  <a href="" class="btn btn-light mt-3">
                        <form action="{{ route('admin.products.hardDelete', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button  style="background: none;  border: none; outline: none;" type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa cứng không?')">
                                <svg style="color: red" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>
                                HardDelete
                            </button>
                        </form>
                  </a>
                  {{-- Variant - Product --}}
                  <a href="" class="btn btn-primary mt-3">
                    <!-- Thêm nút update -->
                      <form action="{{ route('admin.products.productVariant', $item->id) }}" method="GET">
                        <button style="background: none;  border: none; outline: none;" type="submit">
                          <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                          </svg>
                         </button>
                     </form>
                    </a>
                    </td>
                  </tr>
                  @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-center">
            {{ $products->links('pagination::default') }}
         </div>
          <a href="{{ route('admin.products.viewProAdd') }}">
            <input type="submit" class="btn btn-primary" name="them" value="ADD">
          </a>
        </div>
      </div>
    </div>
  </main>

@endsection
