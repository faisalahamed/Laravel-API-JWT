<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseApiController extends Controller
{
    public function courseEnrollment(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'credit' => 'required',
        ]);

        $course = new Course();
        $course->user_id = auth()->user()->id;
        $course->name = $request->name;
        $course->credit = $request->credit;
        $course->save();
        return response()->json(['message' => 'course added successfully']);
    }
    public function totalCourses()
    {
        $id = auth()->user()->id;
        $courses = Course::where('user_id', $id)->get();
        return response()->json([
            'courses' => $courses
        ]);
    }
    public function deleteCourse($id)
    {
        $userid = auth()->user()->id;
        if (Course::where(['id' => $id, 'user_id' => $userid])->exists()) {
            $course = Course::find($id);
            $course->delete();
            return response()->json([
                'message' => 'courses deleted successfully'
            ]);
        }
        return response()->json([
            'message' => 'courses not found'
        ]);
    }
}
