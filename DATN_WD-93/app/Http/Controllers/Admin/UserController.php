<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserNoPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh sách người sử dụng';
        $search = $request->input('search');
        $searchSt = $request->input('searchStatus');
        $searchRole = $request->input('searchRole');

        $data = User::withTrashed()
            ->where('role', 'User')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($searchSt !== null, function ($query) use ($searchSt) {
                if ($searchSt == 1) {
                    return $query->whereNull('deleted_at');
                } elseif ($searchSt == 0) {
                    return $query->whereNotNull('deleted_at');
                }
            })
            // ->when($searchRole !== null && $searchRole !== 'all', function ($query) use ($searchRole) {
            //     return $query->where('role', '=', $searchRole);
            // })
            ->paginate(10);
        // $data = User::withTrashed()
        //     ->orderBy('id')
        //     ->get();
        // dd($data);
        return view('admin.users.index', compact('title', 'data'));
        // return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $title = 'Thêm admin cho hệ thống ';
        // return view('admin.users.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        // if ($request->isMethod('POST')) {
        //     $params = $request->validated();
        //     $params['password'] = Hash::make($params['password']);
        //     if ($request->hasFile('image')) {
        //         $params['image'] = $request->file('image')->store('uploads/avatar', 'public');
        //     } else {
        //         $params['image'] = null;
        //     }
        //     // dd($params);
        //     User::create($params);
        //     return redirect()->route('admin.users.index')->with('success', 'Thêm user thành công');
        // };
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Chỉnh sửa người dùng ';

        $user = User::findOrFail($id);

        // dd($user);
        return view('admin.users.edit', compact('title', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserNoPasswordRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        if ($request->isMethod('POST')) {
            $params = $request->validated();
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            if ($request->hasFile('image')) {
                $params['image'] = $request->file('image')->store('uploads/avatar', 'public');
            } else {
                $params['image'] = $user->image;
            }
            $user->update($params);

            return redirect()->route('admin.users.index')->with('success', 'Cập nhật user thành công');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Xóa người dùng thành công');
    }
}
