<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::all();
        return view('admin.specialties.view', compact('specialties'));
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|nullable|string',
        ], [
            'name.required' => 'Tên chuyên ngành là bắt buộc.',
            'name.string' => 'Tên chuyên ngành phải là chuỗi ký tự.',
            'name.max' => 'Tên chuyên ngành không được dài quá 255 ký tự.',
            'description.required' => 'Mô tả là bắt buộc.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.'
        ]);

       
        $specialty = Specialty::create($validated);

        
        return response()->json(['success' => true, 'data' => $specialty]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|nullable|string',
        ], [
            'name.required' => 'Tên chuyên ngành là bắt buộc.',
            'name.string' => 'Tên chuyên ngành phải là chuỗi ký tự.',
            'name.max' => 'Tên chuyên ngành không được dài quá 255 ký tự.',
            'description.required' => 'Mô tả là bắt buộc.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.'
        ]);

        $specialty = Specialty::findOrFail($id);
        $specialty->update($validated);

        return response()->json(['success' => true, 'data' => $specialty]);
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
    
        Specialty::destroy($id);
    
        return response()->json(['success' => true, 'message' => 'Xóa chuyên khoa thành công.']);
    }
    
}
