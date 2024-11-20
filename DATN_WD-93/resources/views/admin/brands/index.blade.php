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

    table th,
    table td {
        word-wrap: break-word !important;
        white-space: normal !important;
        max-width: 100px !important;
    }

    td.product-name {
        max-width: 100px !important;
    }
</style>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"> Danh sách thương hiệu</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Danh sách thương hiệu
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-hover datatablesSimple">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Tên thương hiệu</th>
                            <th class="text-center">Ảnh thương hiệu</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $brand)
                        <tr>
                            <td class="text-center">{{ $brand->id }}</td>
                            <td class="text-center">{{ $brand->name }}</td>
                            <td class="text-center">
                                <img src="{{ asset('upload/'.$brand->image)  }}" alt="{{ $brand->name }}" style="width: 100px; height: 100px; object-fit: cover;">
                            </td> >
                            <td class="text-center">
                                <form action="{{ route('admin.reviews.destroyReviews', $brand->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('admin.reviews.listDeletedReviews') }}" class="btn btn-secondary">Danh sách thương hiệu đã xóa</a>
            </div>
        </div>

    </div>
</main>

<script>
    function confirmSubmit(selectElement) {
        var form = selectElement.form;
        var selectedOption = selectElement.options[selectElement.selectedIndex].text;
        var defaultValue = selectElement.getAttribute('data-default-value');
        if (confirm('Are you sure to change the order status to "' + selectedOption + '" right ? ')) {
            form.submit();
        } else {
            selectElement.value = defaultValue;
            return false;
        }
    }
</script>
@endsection