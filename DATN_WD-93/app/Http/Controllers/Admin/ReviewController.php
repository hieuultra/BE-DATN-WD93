<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Hiển thị danh sách đánh giá
    public function list()
    {
        $reviews = Review::with(['user', 'product'])->whereNull('deleted_at')->get();
        return view('admin.reviews.list', compact('reviews'));
    }

    // Xóa mềm đánh giá
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete(); // Xóa mềm
        return redirect()->route('admin.reviews.listReviews')->with('success', 'Review soft deleted successfully');
    }

    // Hiển thị đánh giá đã xóa
    public function listDeleted()
    {
        $listDeleted = Review::onlyTrashed()->with(['user', 'product'])->get();
        return view('admin.reviews.listDeleted', compact('listDeleted'));
    }
    // Khôi phục đánh giá đã xóa mềm
    public function restore($id)
    {
        $review = Review::onlyTrashed()->findOrFail($id);
        $review->restore();
        return redirect()->route('admin.reviews.listReviews')->with('success', 'Review restored successfully');
    }
}
