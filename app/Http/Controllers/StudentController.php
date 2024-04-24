<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentCollection;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return StudentCollection::collection(Student::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        try {
            Student::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Thêm học sinh thành công!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy học sinh này!'
            ], 404);
        } else {
            return new StudentCollection($student);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy học sinh này!'
            ], 404);
        } else {
            $student->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thông tin học sinh thành công!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy học sinh này!'
            ], 404);
        } else {
            $student->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa học sinh thành công!'
            ]);
        }
    }
}
