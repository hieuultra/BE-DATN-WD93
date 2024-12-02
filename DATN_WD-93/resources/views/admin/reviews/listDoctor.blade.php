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
        <h1 class="mt-4">Danh sách đánh giá bác sĩ</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Bảng điều khiển</li>
        </ol>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Danh sách đánh giá bác sĩ
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-hover datatablesSimple">
                    <thead>
                        <tr>
                            <th class="text-center">Mã</th>
                            <th class="text-center">Tên khách hàng</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Tên bác sĩ</th>
                            <th class="text-center">Sao</th>
                            <th class="text-center">Bình luận</th>
                            <th class="text-center">Ngày tạo</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($listDoctors as $doctor)
                        @foreach($doctor->review as $review)
                        <tr>
                            <td class="text-center">{{ $review->id }}</td>
                            <td class="text-center">{{ $review->user->name }}</td>
                            <td class="text-center">{{ $review->user->email }}</td>
                            <td class="text-center">{{ $doctor->user->name }}</td> <!-- Lấy tên bác sĩ từ $doctor -->
                            <td class="text-center">{{ $review->rating }} / 5</td>
                            <td class="text-center">{{ $review->comment }}</td>
                            <td class="text-center">{{ $review->created_at }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.reviews.destroyDoctor', $review->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này không?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach

                    </tbody>
                </table>

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