<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function enroll($courseId)
    {
        $user = Auth::user();
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        // Check if the user is already enrolled
        $existingEnrollment = Enrollment::where('user_id', $user->id)
                                        ->where('course_id', $courseId)
                                        ->first();

        if ($existingEnrollment) {
            return response()->json(['message' => 'Already enrolled'], 400);
        }

        // Enroll the user in the course
        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $courseId,
        ]);

        return response()->json(['message' => 'Successfully enrolled in course'], 200);
    }

    public function withdraw($courseId)
    {
        $user = Auth::user();
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        // Check if the user is enrolled
        $enrollment = Enrollment::where('user_id', $user->id)
                                ->where('course_id', $courseId)
                                ->first();

        if (!$enrollment) {
            return response()->json(['message' => 'Not enrolled'], 400);
        }

        // Withdraw the user from the course
        $enrollment->delete();

        return response()->json(['message' => 'Successfully withdrawn from course'], 200);
    }
}
