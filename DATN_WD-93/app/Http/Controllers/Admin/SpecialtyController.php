<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function specialtyDoctorList()
    {
<<<<<<< Updated upstream
        $specialty = Specialty::orderBy('updated_at', 'desc')->get();
        $doctor = Doctor::orderBy('updated_at', 'desc')->get();
        return view('admin.specialtyDoctors.specialtyDoctorList', compact('specialty', 'doctor'));
=======
        $specialties = Specialty::withCount('doctor')->paginate(5);
        return view('admin.specialties.view', compact('specialties'));
>>>>>>> Stashed changes
    }
    public function viewSpecialtyAdd()
    {
<<<<<<< Updated upstream
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
            $imageName = time() . '.' . $request->image->extension(); 
            $request->image->move(public_path('upload'), $imageName); 
            $validatedData['image'] = $imageName; 
        } else {
            return redirect()->back()->withInput()->withErrors(['image' => 'Vui lòng chọn ảnh specialty ']);
        }
        $specialty = Specialty::create($validatedData);

        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Thêm specialty thành công');
    }
    
    public function specialtyUpdateForm($id)
    {
        $specialties = Specialty::orderBy('id', 'DESC')->get();
        $specialty = Specialty::find($id); 
        return view('admin.specialtyDoctors.specialty.specialtyUpdateForm', compact('specialties', 'specialty'));
    }
    
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
    
    public function specialtyDestroy($id)
    {
        $package = Specialty::findOrFail($id); 

        $package->delete();
        return redirect()->route('admin.specialties.specialtyDoctorList')->with('success', 'Specialty đã được xóa thành công.');
=======
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
        ], [
            'name.required' => 'Tên chuyên ngành là bắt buộc.',
            'name.string' => 'Tên chuyên ngành phải là chuỗi ký tự.',
            'name.max' => 'Tên chuyên ngành không được dài quá 255 ký tự.',
            'description.required' => 'Mô tả là bắt buộc.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.'
        ]);


        $specialty = new Specialty();
        $specialty->name = $request->name;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload'), $imageName);
            $specialty->image = $imageName;
        }
        $specialty->description = $request->description;
        $specialty->faculty = $request->faculty;
        $specialty->save();



        return response()->json(['success' => true, 'data' => $specialty]);
    }

    public function edit($id)
    {
        $specialty = Specialty::where('id', $id)->first();
        return view('admin.specialties.edit', compact('specialty'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp',
            'description' => 'string',
        ], [
            'name.string' => 'Tên chuyên ngành phải là chuỗi ký tự.',
            'name.max' => 'Tên chuyên ngành không được dài quá 255 ký tự.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.'
        ]);
        $specialty = Specialty::find($id);
        $specialty->name = $request->name;
        if ($request->hasFile('image')) {

            if ($specialty->image && File::exists(public_path('uploads/' . $specialty->image))) {
                File::delete(public_path('upload/' . $specialty->image));
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload'), $imageName);
            $specialty->image = $imageName;
        }
        $specialty->description = $request->description;
        $specialty->faculty = $request->faculty;
        $specialty->save();

        return redirect()->route('admin.specialties.specialtyList')->with('success', 'Cập nhật thành công');
    }



    public function destroy($id)
    {
        $doctorCount = Doctor::where('specialty_id', $id)->count();

        if ($doctorCount > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa vì có bác sĩ đang sử dụng chuyên khoa này.'
            ], 400);
        }

        $specialty = Specialty::findOrFail($id);
        if ($specialty->image && File::exists(public_path('upload/' . $specialty->image))) {
            File::delete(public_path('upload/' . $specialty->image));
        }

        $specialty->delete();

        return response()->json(['success' => true, 'message' => 'Xóa chuyên khoa thành công.']);
>>>>>>> Stashed changes
    }
}
