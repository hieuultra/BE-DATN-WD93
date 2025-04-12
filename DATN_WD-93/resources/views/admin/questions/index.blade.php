@extends('admin.layout')
@section('titlepage','')

@section('content')

<main>
    <div class="container-fluid px-4">
      <h1 class="mt-4">Danh sách câu hỏi từ khách hàng</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Bảng điều khiển</li>
      </ol>

      <!-- Data -->
      <div class="card mb-4">

        {{-- hien thi tb success --}}

        <div class="card-header">
          <i class="fas fa-table me-1"></i>
          Danh sách câu hỏi từ khách hàng
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
    @foreach($questions as $q)
    <div class="card my-3">
        <div class="card-header">
            <strong>{{ $q->name ?? $q->user->name ?? 'Khách' }}</strong> hỏi về
            <a href="{{ route('product.detail', $q->product->id) }}">{{ $q->product->name }}</a>:
        </div>
        <div class="card-body">
            <p><strong>Câu hỏi:</strong> {{ $q->question }}</p>

            @if($q->answer)
                <div class="mt-3">
                    <strong>Trả lời:</strong> {{ $q->answer }}<br>
                    <small class="text-muted">Được trả lời bởi {{ $q->answeredBy->name ?? 'Admin' }} lúc {{ $q->answered_at }}</small>
                </div>
            @else
                <form method="POST" action="{{ route('admin.questions.answer', $q->id) }}">
                    @csrf
                    <div class="form-group mt-3">
                        <label>Trả lời câu hỏi:</label>
                        <textarea name="answer" class="form-control" rows="3" required></textarea>
                    </div>
                    <button class="btn btn-success mt-2">Gửi trả lời</button>
                </form>
            @endif
        </div>
    </div>
@endforeach
  </main>

@endsection
