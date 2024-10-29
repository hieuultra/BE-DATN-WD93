<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function specialtyDoctorList()
    {
        $specialty = Specialty::orderBy('updated_at', 'desc')->get();
        $doctor = Doctor::orderBy('updated_at', 'desc')->get();
        return view('admin.specialtyDoctors.specialtyDoctorList', compact('specialty', 'doctor'));
    }
    public function viewSpecialtyAdd()
    {
        // $packages = VariantPackageProduct::orderBy('name', 'asc')->get();
        return view('admin.specialtyDoctors.specialty.viewSpecialtyAdd',);
    }
    public function specialtyAdd(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension(); //Tạo tên tệp tin duy nhất dựa trên thời gian hiện tại.
            //$request->img->extension() sẽ trả về jpg,..., là phần mở rộng của tệp tin.
            $request->image->move(public_path('upload'), $imageName); //Di chuyển tệp tin đến thư mục public/upload.
            $validatedData['image'] = $imageName; //Cập nhật dữ liệu đã xác thực với tên tệp tin hình ảnh.
        } else {
            return redirect()->back()->withInput()->withErrors(['image' => 'Vui lòng chọn ảnh specialty ']);
        }
        $specialty = Specialty::create($validatedData);

        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Thêm specialty thành công'); //Chuyển hướng người dùng đến route productList và kèm theo thông báo thành công.
    }
    //Update Form
    public function specialtyUpdateForm($id)
    {
        $specialties = Specialty::orderBy('id', 'DESC')->get();
        $specialty = Specialty::find($id); //tim id
        return view('admin.specialtyDoctors.specialty.specialtyUpdateForm', compact('specialties', 'specialty'));
    }
    //Update
    public function specialtyUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $id = $request->id;
        $package = Specialty::findOrFail($id);

        $package->update($validatedData);

        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Cập nhật specialty thành công.');
    }
    //Destroy
    public function specialtyDestroy($id)
    {
        $package = Specialty::findOrFail($id); //// Tìm sản phẩm với ID được cung cấp. Nếu không tìm thấy, sẽ ném ra một ngoại lệ ModelNotFoundException.

        $package->delete();
        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Specialty đã được xóa thành công.');
    }
}
