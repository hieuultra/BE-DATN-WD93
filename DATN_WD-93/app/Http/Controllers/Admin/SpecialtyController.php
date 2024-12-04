<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Package;
use App\Models\Specialty;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function specialtyDoctorList(Request $request)
    {
        $classification = $request->get('classification');

        $specialtyQuery = Specialty::query();
        if ($classification) {
            $specialtyQuery->where('classification', $classification);
        }
        $specialty = $specialtyQuery->orderBy('updated_at', 'desc')->paginate(3);

        $doctorQuery = Doctor::query();
        if ($classification) {
            $doctorQuery->whereHas('specialty', function ($query) use ($classification) {
                $query->where('classification', $classification);
            });
        }
        $doctor = $doctorQuery->orderBy('updated_at', 'desc')->paginate(3);

        $packageQuery = Package::query();
        if ($classification) {
            $packageQuery->whereHas('specialty', function ($query) use ($classification) {
                $query->where('classification', $classification);
            });
        }
        $package = $packageQuery->orderBy('updated_at', 'desc')->paginate(3);
        return view('admin.specialtyDoctors.specialtyDoctorList', compact('specialty', 'doctor', 'package'));
    }
    public function viewSpecialtyAdd()
    {
        return view('admin.specialtyDoctors.specialty.viewSpecialtyAdd',);
    }
    public function specialtyAdd(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'classification' => 'required',
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
        $specialty = Specialty::find($id);
        $specialty->name = $request->name;
        $specialty->description = $request->description;
        if ($request->hasFile('image')) {

            if ($specialty->image && File::exists(public_path('uploads/' . $specialty->image))) {
                File::delete(public_path('upload/' . $specialty->image));
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload'), $imageName);
            $specialty->image = $imageName;
        }
        $specialty->classification = $request->classification;
        $specialty->save();

        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Cập nhật specialty thành công.');
    }
    //Destroy
    public function specialtyDestroy($id)
    {
        $specialty = Specialty::findOrFail($id);
        $specialty->classification = 0;
        $specialty->save();
        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Specialty đã được cho dừng hoạt động.');
    }
}
