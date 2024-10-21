<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\StaffNoPasswordRequest;
use App\Http\Requests\UserNoPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Danh sách người nhân viên';
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
            ->where('role', '!=', 'User')
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
        return view('admin.staffs.index', compact('title', 'data'));
    }
    public function activate(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);

        if ($user) {
            $user->restore();

            return redirect()->route('admin.staffs.index')->with('success', 'Kích hoạt tài khoản thành công');
        }

        return redirect()->route('admin.staffs.index')->with('error', 'nhân viên không tồn tại hoặc đã được kích hoạt.');
    }
    public function exportexcel(Request $request)
    {
        $search = $request->input('search');
        $searchSt = $request->input('searchStatus');

        $users = User::withTrashed()
            ->where('role', '!=', 'User')
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
            if ($user->role == 'Admin') {
                $role = 'Quản trị viên';
            } elseif ($user->role == 'Doctor') {
                $role = 'Bác sỹ';
            } elseif ($user->role == 'Pharmacist') {
                $role = 'Nhân viên bán thuốc';
            } else {
                $role = $user->role;
            }
            $sheet->setCellValue('F' . $row, $role);
            $sheet->setCellValue('G' . $row, $user->deleted_at ? 'Đã xóa' : 'Hoạt động');

            $row++;
        }
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
            ->where('role', '!=', 'User')
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

        $html = '<h1>Danh sách nhân viên</h1>';
        $html .= '<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>STT</th>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Trạng thái</th>
            <th>Vai trò</th>  <!-- Thêm cột Vai trò -->
        </tr>
    </thead>
    <tbody>';

        foreach ($users as $index => $user) {
            $status = $user->deleted_at ? 'Đã hủy' : 'Hoạt động';

            // Xử lý vai trò
            if ($user->role == 'Admin') {
                $role = 'Quản trị viên';
            } elseif ($user->role == 'Doctor') {
                $role = 'Bác sỹ';
            } elseif ($user->role == 'Pharmacist') {
                $role = 'Nhân viên bán thuốc';
            } else {
                $role = $user->role; // Trường hợp vai trò không khớp
            }

            $html .= '<tr>
            <td>' . ($index + 1) . '</td>
            <td>' . $user->name . '</td>
            <td>' . $user->email . '</td>
            <td>' . $user->address . '</td>
            <td>' . $user->phone . '</td>
            <td>' . $role . '</td>
            <td>' . $status . '</td>
        </tr>';
        }

        $html .= '</tbody></table>';

        // Thiết lập và xuất file PDF
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans'); // Đặt font hỗ trợ tiếng Việt
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
        $title = 'Thêm admin cho hệ thống ';
        return view('admin.staffs.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        if ($request->isMethod('POST')) {
            $params = $request->validated();
            $params['password'] = Hash::make($params['password']);
            if ($request->hasFile('image')) {
                $params['image'] = $request->file('image')->store('uploads/avatar', 'public');
            } else {
                $params['image'] = null;
            }
            // dd($params);
            User::create($params);
            return redirect()->route('admin.staffs.index')->with('success', 'Thêm nhân viên thành công');
        };
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
        $title = 'Chỉnh sửa nhân viên ';

        $user = User::withTrashed()->findOrFail($id);

        // dd($user);
        return view('admin.staffs.edit', compact('title', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StaffNoPasswordRequest $request, string $id)
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

        return redirect()->route('admin.staffs.index')->with('success', 'Cập nhật thành công');
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
        return redirect()->route('admin.staffs.index')->with('success', 'Hủy tài khoản thành công');
    }
}
