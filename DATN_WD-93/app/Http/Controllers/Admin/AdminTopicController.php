<?php

namespace App\Http\Controllers\Admin;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Storage;

class AdminTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Chuyên mục';
        $listTopic = Topic::orderByDesc('status')->paginate(10);

        return view('admin.topics.index', compact('title','listTopic'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm chuyên mục';
        return view('admin.topics.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TopicRequest $request)
    {
        if ($request->isMethod('POST')) {
            $param = $request->except('_token');
            if ($request->hasFile('img')) {
                $file_path = $request->file('img')->store('uploads/topics','public');
            } else {
                $file_path = null;
            }
            $param['img'] = $file_path;
            Topic::create($param);
            return redirect()->route('admin.topics.index')->with('success', 'Thêm danh mục thành công');
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
        $title = 'Sửa chuyên mục';

        $topic = Topic::findOrFail($id);

        return view('admin.topics.edit', compact('title', 'topic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TopicRequest $request, string $id)
    {
        if ($request->isMethod('PUT')) {
            $param = $request->except('_token', '_method');
            $topic = Topic::findOrFail($id);

            if ($request->hasFile('img')) {
                if ($topic->img && Storage::disk('public')->exists($topic->img)) {
                    Storage::disk('public')->delete($topic->img);
                }
                $file_path = $request->file('img')->store('uploads/topics','public');
            } else {
                $file_path = $topic->img;
            }
            $param['img'] = $file_path;
            $topic->update($param);
            return redirect()->route('admin.topics.index')->with('success', 'Cập nhật danh mục thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();
        if ($topic->img && Storage::disk('public')->exists($topic->img)) {
            Storage::disk('public')->delete($topic->img);
        }
        return redirect()->route('admin.topics.index')->with('success', 'Xóa chuyên mục thành công');

    }
}
