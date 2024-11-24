@extends('admin.layout')
@section('titlepage','')

@section('content')

<main>
    <div class="container-fluid px-4">
      <h1 class="mt-4">DANH SÁCH ĐƠN HÀNG</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>

      <!-- Data -->
      <div class="card mb-4">

        {{-- hien thi tb success --}}

        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          DANH SÁCH ĐƠN HÀNG
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
                <th class="text-center">Mã đơn hàng</th>
                <th class="text-center">Ngày đặt</th>
                <th class="text-center">Người đặt hàng</th>
                <th class="text-center">Người nhận hàng</th>
                <th class="text-center">Địa chỉ giao hàng</th>
                <th class="text-center">Số điện thoại nhận hàng</th>
                <th class="text-center">Tổng tiền</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Hành động</th>
              </tr>
            </thead>
            <tbody>
                @foreach($listBills as $item)
                <tr>
                    <th class="text-center">
                        <a href="{{ route('admin.bills.show', $item->id) }}">
                        {{ $item->billCode }}
                    </a>
                    </th>
                    <td class="text-center">
                        {{ $item->created_at->format('d-m-Y') }}
                    </td>
                    <td class="text-center">
                        {{ $item->user->name }}
                    </td>
                    <td class="text-center">
                        {{ $item->nameUser }}
                    </td>
                    <td class="text-center">
                        {{ $item->addressUser }}
                    </td>
                    <td class="text-center">
                        {{ $item->phoneUser }}
                    </td>
                    <td class="text-center">
                         {{ number_format($item->totalPrice,0,',','.') }}VND
                    </td>
                    <td class="text-center" style="color: dodgerblue">
                       <form action="{{ route('admin.bills.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status_bill" class="form-select w-75" onchange="confirmSubmit(this)" data-default-value="{{ $item->status_bill }}">
                               @foreach ($statusBill as $key => $value)
                                     <option value="{{ $key }}"
                                     {{ $key == $item->status_bill ? 'selected' : '' }}
                                     {{ $key == $type_da_huy ? 'disabled' : '' }}
                                     >
                                     {{ $value }}</option>
                               @endforeach
                        </select>
                        <input type="hidden" name="da_giao_hang" value="1">
                       </form>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.bills.show', $item->id) }}" class="btn btn-primary">Xem thêm</a>
                        {{-- @if ($item->status_bill === $type_da_huy)
                        <form action="{{ route('admin.bills.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE') --}}
                            {{-- Sử dụng @method('DELETE') trong đoạn mã nhằm mục đích gửi một yêu cầu HTTP DELETE từ form HTML.  --}}
                            {{-- <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                Delete
                            </button>
                        </form>
                        @endif --}}
                    </td>
                </tr>
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
        if (confirm('Are you sure to change the order status to "' + selectedOption + '" right ? '  )) {
       form.submit();
        }else{
            selectElement.value = defaultValue;
            return false;
        }
    }
</script>


@endsection


