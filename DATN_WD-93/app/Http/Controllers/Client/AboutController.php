<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    function about()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $spe = Specialty::whereIn('classification', ['chuyen_khoa', 'kham_tu_xa'])
            ->orderBy('name', 'asc')
            ->get();
        $orderCount = 0; // Mặc định nếu chưa đăng nhập
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        return view('client.home.about', compact('orderCount', 'categories', 'spe'));
    }
    public function handleChat(Request $request)
    {
        // Lấy tin nhắn từ người dùng
        $userMessage = $request->input('message');

        // Xử lý hoặc gọi API AI ở đây (ví dụ: sử dụng OpenAI API)
        $aiResponse = $this->getAiResponse($userMessage);

        // Trả về phản hồi từ AI
        return response()->json(['message' => $aiResponse]);
    }

    private function getAiResponse($message)
    {
        // Gọi OpenAI API hoặc một dịch vụ AI khác ở đây
        // Ví dụ: Trả về một câu trả lời giả lập
        return "Đây là câu trả lời từ AI cho tin nhắn: " . $message;
    }
}
