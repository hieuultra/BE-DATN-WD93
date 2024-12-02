<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    // Hiển thị danh sách đánh giá sp
    public function list()
    {
        $reviews = Product::with(['review.product'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.reviews.list', compact('reviews'));
    }

    // Xóa mềm đánh giá
    public function destroy($id)
    {
        $review = Review::find($id);
        $review->delete(); // Xóa mềm
        return redirect()->route('admin.reviews.listReviews')->with('success', 'Xóa thành công');
    }

    // Hiển thị đánh giá đã xóa
    public function listDeleted()
    {
        $listDeleted = Review::onlyTrashed()->with(['user', 'product'])->get(); //Lọc ra chỉ các bản ghi đã bị xóa mềm
        return view('admin.reviews.listDeleted', compact('listDeleted'));
    }
    // Khôi phục đánh giá đã xóa mềm
    // public function restore($id)
    // {
    //     $review = Review::onlyTrashed()->findOrFail($id);
    //     $review->restore();
    //     return redirect()->route('admin.reviews.listReviews')->with('success', 'Khôi phục thành công');
    // }

    public function listDoctorReviews()
    {
        // Lấy tất cả bác sĩ kèm đánh giá và thông tin người đánh giá
        $listDoctors = Doctor::with(['review.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.reviews.listDoctor', compact('listDoctors'));
    }
    public function destroyDoctor($id)
    {
        $review = Review::find($id);
        $review->delete(); // Xóa mềm
        return redirect()->route('admin.reviews.listDoctorReviews')->with('success', 'Xóa thành công');
    }

}
