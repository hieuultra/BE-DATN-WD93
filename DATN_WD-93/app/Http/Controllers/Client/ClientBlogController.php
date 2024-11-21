<?php

namespace App\Http\Controllers\Client;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Block;

class ClientBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderCount = 0;
        $categories = Category::orderBy('name', 'asc')->get();
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        $blogTT = Blog::where('topic_id', 2)->take(4)->get();
        $blogSK = Blog::where('topic_id', 1)->take(3)->get();
        $listTopic = Topic::take(9)->get();
        return view('client.blogs.index', compact('blogSK', 'blogTT', 'listTopic', 'orderCount', 'categories'));
    }
    public function list(Request $request)
    {
        $orderCount = 0;
        $categories = Category::orderBy('name', 'asc')->get();
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }
        $topic_id = $request->input('topic_id');
        $listTopic = Topic::take(9)->get();
        if ($request->topic_id) {
            $blogs = Blog::where('topic_id', $request->topic_id)
                ->orderBy('id', 'desc')
                ->paginate(12);
        } else {
            // $blogs = Blog::withCount('review') // Đếm số lượt đánh giá
            //     ->withAvg('review', 'rating') // Tính trung bình số sao
            //     ->orderBy('id', 'desc')
            //     ->paginate(12);
            //phan trang 9sp/1page
        }

        // if ($request->has('topic') && $request->topic) {
        //     $query->where('topic_id',$request->topic);
        // }
        // if ($request->has('search') && $request->search) {
        //     $query->where('name', 'like', '%' . $request->search . '%');
        // }
        // $blogs = Blog::where('topic_id', $request->topic_id)->paginate(12);
        return view('client.blogs.list', compact('blogs','listTopic',  'orderCount', 'categories'));
    }
    public function show(string $id)
    {
        $orderCount = 0;
        $categories = Category::orderBy('name', 'asc')->get();
        if (Auth::check()) {
            $user = Auth::user();
            $orderCount = $user->bill()->count(); // Nếu đăng nhập thì lấy số lượng đơn hàng
        }

        $showBlog = Blog::findOrFail($id);
        $relatedBlog = Blog::where('topic_id', $showBlog->topic_id)
            ->where('id', '!=', $showBlog->id)->take(3)->get();
        $blogSK = Blog::where('topic_id', 1)->take(3)->get();
        $listTopic = Topic::take(9)->get();
        return view('client.blogs.show', compact('showBlog', 'relatedBlog', 'listTopic', 'orderCount', 'categories'));
    }
}