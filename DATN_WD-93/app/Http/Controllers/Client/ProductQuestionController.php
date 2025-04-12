<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\ProductQuestion;
use App\Http\Controllers\Controller;

class ProductQuestionController extends Controller
{
    public function store(Request $request)
{
    // Validate đầu vào
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'question' => 'required|string|max:1000',
        'name' => 'required_without:user_id',
        'email' => 'required_without:user_id|email',
    ]);

    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (auth()->check()) {
        // Nếu đã đăng nhập, lấy tên và email từ người dùng
        $user = auth()->user();
        $name = $user->name;
        $email = $user->email;
    } else {
        // Nếu chưa đăng nhập, lấy thông tin từ form (dành cho khách vãng lai)
        $name = $request->name;
        $email = $request->email;
    }

    // Debugging: Kiểm tra giá trị trước khi lưu
    dd([
        'user_id' => auth()->id(),
        'name' => $name,
        'email' => $email,
        'product_id' => $request->product_id,
        'question' => $request->question,
    ]);

    // Lưu câu hỏi vào DB
    ProductQuestion::create([
        'product_id' => $request->product_id,
        'user_id' => auth()->id(), // Nếu đã đăng nhập, lấy user_id
        'name' => $name,
        'email' => $email,
        'question' => $request->question,
    ]);

    return redirect()->back()->with('success', 'Câu hỏi của bạn đã được gửi thành công!');
}

    public function index()
    {
        $questions = ProductQuestion::with('product')->orderBy('created_at', 'desc')->get();
        return view('admin.questions.index', compact('questions'));
    }

    public function answer(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required|string|max:3000',
        ]);

        $question = ProductQuestion::findOrFail($id);
        $question->update([
            'answer' => $request->answer,
            'is_answered' => true,
            'answered_at' => now(),
            'answered_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Đã trả lời câu hỏi!');
    }
}
