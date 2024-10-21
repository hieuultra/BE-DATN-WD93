@extends('admin.layout')
@section('titlepage','')

@section('content')

<main>
    <div class="container-fluid px-4">
      <h1 class="mt-4">List categories</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>

      <!-- Data -->
      <div class="card mb-4">

        {{-- hien thi tb success --}}

        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          List categories
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
          <table id="datatablesSimple">
            <thead>
              <tr>
                <th>ID</th>
                <th>Category name</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach($categories as $item)
            <tr>
              <td> {{ $item->id }}</td>
              <td>{{ $item->name }}</td>
              <td><img src="{{ asset('upload/'.$item->img)  }}" height="150" width="300" alt=""></td>
              <td class="{{ $item->status == true ? 'text-success' : 'text-danger' }}">
                {{ $item->status == true ? 'Display' : 'Hidden' }}
              </td>
              <td class="text-center">
                   <!-- Thêm nút update -->
                   <a href="" class="btn btn-warning">
                    <form action="{{ route('admin.categories.cateUpdateForm', $item->id) }}" method="GET">
                        <button style="background: none;  border: none; outline: none;" type="submit">
                            <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                              <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001"/>
                            </svg>
                        </button>
                        </form>
                   </a>
                 <!-- Thêm nút delete -->
                 <a href="" class="btn btn-danger">
                    <form action="{{ route('admin.categories.cateDestroy', $item->id) }}" method="POST">
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
          <a href="{{ route('admin.categories.viewCateAdd') }}">
            <input type="submit" class="btn btn-primary" name="them" value="ADD">
          </a>
        </div>
      </div>
    </div>
  </main>

@endsection
