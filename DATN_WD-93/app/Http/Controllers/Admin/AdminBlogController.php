<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\Storage;

class AdminBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Quản lí bài viết';
        $listBlog = Blog::orderByDesc('created_at')->paginate(10);
        return view('admin.blogs.index', compact('title', 'listBlog'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tạo bài viết';
        $listTopic = Topic::query()->get();

        return view('admin.blogs.create', compact('title', 'listTopic'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        if ($request->isMethod("POST")) {
            $params = $request->except('_token');

            //Xử lí hình ảnh đại diện
            if ($request->hasFile('image')) {
                $params['image'] = $request->file('image')->store('uploads/blogs', 'public');
            } else {
                $params['image'] = null;
            }

            //Thêm sản phẩm
            Blog::query()->create($params);
            return redirect()->route('admin.blogs.index')->with('success', 'Thêm sản phẩm thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Chỉnh sửa sản phẩm';
        $listTopic = Topic::query()->get();
        $blog = Blog::query()->findOrFail($id);
        return view('admin.blogs.edit', compact('title', 'listTopic','blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, string $id)
    {
        if ($request->isMethod("PUT")) {
            $params = $request->except('_token','_method');

            $blog = Blog::query()->findOrFail($id); 

            //Xử lí hình ảnh đại diện
            if ($request->hasFile('image')) {
                if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                    Storage::disk('public')->delete($blog->image);
                }
                $params['image'] = $request->file('image')->store('uploads/blogs', 'public');
            } else {
                $params['image'] = $blog->image;
            }
            $blog->update($params);
            return redirect()->route('admin.blogs.index')->with('success', 'Cập nhật bài viết thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::query()->findOrFail($id);
        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Xóa sản phẩm thành công');
    }
}
