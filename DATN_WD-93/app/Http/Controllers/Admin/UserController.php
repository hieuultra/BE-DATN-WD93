<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
<<<<<<< HEAD
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserNoPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh sách người sử dụng';
        $search = $request->input('search');
        $searchSt = $request->input('searchStatus');
        $searchRole = $request->input('searchRole');

        $orderBy = $request->input('orderBy', 'name');
        $orderDir = $request->input('orderDir', 'asc');

        $allowedSortFields = ['name', 'email', 'phone', 'address', 'deleted_at'];
        if (!in_array($orderBy, $allowedSortFields)) {
            $orderBy = 'name';
        }

        $data = User::withTrashed()
            ->where('role', '=', 'User')
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
            ->orderBy($orderBy, $orderDir)
            ->paginate(10);
        return view('admin.users.index', compact('title', 'data'));
    }
    public function activate(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);

        if ($user) {
            $user->restore();

            return redirect()->route('admin.users.index')->with('success', 'Kích hoạt tài khoản thành công');
        }

        return redirect()->route('admin.users.index')->with('error', 'Người dùng không tồn tại hoặc đã được kích hoạt.');
    }
    public function exportexcel(Request $request)
    {
        $search = $request->input('search');
        $searchSt = $request->input('searchStatus');

        $users = User::withTrashed()
            ->where('role', '=', 'User')
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
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Tên');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Số điện thoại');
        $sheet->setCellValue('E1', 'Địa chỉ');
        $sheet->setCellValue('F1', 'Trạng thái');
        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $user->id);
            $sheet->setCellValue('B' . $row, $user->name);
            $sheet->setCellValue('C' . $row, $user->email);
            $sheet->setCellValue('D' . $row, $user->phone);
            $sheet->setCellValue('E' . $row, $user->address);
            $sheet->setCellValue('F' . $row, $user->deleted_at ? 'Đã xóa' : 'Hoạt động');
            $row++;
        }
        // Xuất file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'danh_sach_nguoi_dung.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function exportPDF(Request $request)
    {
        $search = $request->input('search');
        $searchSt = $request->input('searchStatus');

        $users = User::withTrashed()
            ->where('role', '=', 'User')
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
            ->get();

        $html = '<h1>Danh sách người dùng</h1>';
        $html .= '<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>STT</th>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Trạng thái</th> </tr>
    </thead>
    <tbody>';

        foreach ($users as $index => $user) {
            $status = $user->deleted_at ? 'Đã hủy' : 'Hoạt động';
            $html .= '<tr>
        <td>' . ($index + 1) . '</td>
        <td>' . $user->name . '</td>
        <td>' . $user->email . '</td>
        <td>' . $user->address . '</td>
        <td>' . $user->phone . '</td>
        <td>' . $status . '</td> </tr>';
        }

        $html .= '</tbody></table>';

        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('danh_sach_nguoi_dung.pdf', ['Attachment' => false]);
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

        $user = User::withTrashed()->findOrFail($id);

        // dd($user);
        return view('admin.users.edit', compact('title', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserNoPasswordRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        if ($request->isMethod('PUT')) {
            $params = $request->validated();
            if ($request->hasFile('image')) {
                $params['image'] = $request->file('image')->store('uploads/avatar', 'public');
                if ($user->image) {
                    Storage::disk('public')->delete($user->image);
                }
            } else {
                $params['image'] = $user->image;
            }
            $user->update($params);
        }

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật thành công');
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
        return redirect()->route('admin.users.index')->with('success', 'Hủy tài khoản thành công');
=======
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function userList()
    {
        $users = User::orderBy('id', 'DESC')->get();
        return view('admin.users.userList', compact('users'));
    }
    public function viewUserAdd()
    {
        $users = User::orderBy('name', 'asc')->get();
        return view('admin.users.viewUserAdd', compact('users'));
    }
    public function userAdd(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension(); //Tạo tên tệp tin duy nhất dựa trên thời gian hiện tại.
            //$request->img->extension() sẽ trả về jpg,..., là phần mở rộng của tệp tin.
            $request->image->move(public_path('upload'), $imageName); //Di chuyển tệp tin đến thư mục public/upload.
            $validatedData['image'] = $imageName; //Cập nhật dữ liệu đã xác thực với tên tệp tin hình ảnh.
        }

        $user = User::create($validatedData); // tạo một bản ghi mới trong bảng products.

        return redirect()->route('admin.users.userList')->with('success', 'Thêm account thành công'); //Chuyển hướng người dùng đến route productList và kèm theo thông báo thành công.
    }
    public function userUpdateForm($id)
    {
        $users = User::orderBy('id', 'DESC')->get();
        $acc = User::find($id); //tim id
        return view('admin.users.userUpdateForm', compact('users', 'acc'));
    }
    //update data
    public function userUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $id = $request->id;
        $acc = User::findOrFail($id);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload'), $imageName);
            $validatedData['image'] = $imageName;
            // kiểm tra hình cũ và xóa
            if (!empty($acc->image)) {
                $oldImagePath = public_path('upload/' . $acc->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $acc->update($validatedData);

        return redirect()->route('admin.users.userList')->with('success', 'Cập nhật account thành công.');
    }
    public function userDestroy($id)
    {
        $acc = User::findOrFail($id); //// Tìm sản phẩm với ID được cung cấp. Nếu không tìm thấy, sẽ ném ra một ngoại lệ ModelNotFoundException.
        if (!empty($acc->image)) {
            $imgpath = "upload/" . $acc->image; //duong dan
            if (file_exists($imgpath)) {
                unlink($imgpath); //xoa
            }
        }
        $acc->delete();
        return redirect()->route('admin.users.userList')->with('success', 'account đã được xóa thành công.');
>>>>>>> main
    }
}
