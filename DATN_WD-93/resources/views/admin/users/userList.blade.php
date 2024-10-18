@extends('admin.layout')
@section('titlepage','')

@section('content')

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">List accounts</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>

        <!-- Data -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                List account
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
                            <th>Username</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Image</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                           <tbody>
                            @foreach($users as $item)
                            <tr>
                               <td>{{ $item->id }}</td>
                               <td>{{ $item->username }}</td>
                                {{-- <td class="password-column">{{ $item->password }}</td> --}}
                               <td>{{ $item->name }}</td>
                                <td>{{ $item->address }}</td>
                                <td>{{ $item->phone }}</td>
                               <td>{{ $item->email }}</td>
                               <td><img src="{{ asset('upload/'.$item->image)  }}" height="150" width="300" alt=""></td>
                                <td>{{ $item->role }}</td>
                                <td class="text-center">
                                    <!-- Thêm nút update -->
                                    {{-- <a href="" class="btn btn-warning">
                                     <form action="{{ route('admin.account.accUpdateForm', $item->id) }}" method="GET">
                                         <button type="submit">
                                                   Edit
                                        </button>
                                         </form>
                                    </a> --}}
                                  <!-- Thêm nút delete -->
                                  <a href="" class="btn btn-danger">
                                     <form action="{{ route('admin.users.userDestroy', $item->id) }}" method="POST">
                                         @csrf
                                         @method('DELETE')
                                         {{-- Sử dụng @method('DELETE') trong đoạn mã nhằm mục đích gửi một yêu cầu HTTP DELETE từ form HTML.  --}}
                                         <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                             Delete
                                         </button>
                                     </form>
                                  </a>
                               </td>
                             </tr>
                             @endforeach
                    </tbody>
                </table>
                <a href="{{ route('admin.users.viewUserAdd') }}">
                    <input type="submit" class="btn btn-primary" name="them" value="ADD">
                </a>

            </div>
        </div>
    </div>
</main>

@endsection
