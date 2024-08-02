<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Course;


class CourseController extends Controller
{
    // Helper function to check role
    protected function checkRole($role)
    {
        // Extract user from JWT token
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user || $user->role !== $role) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return null;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        $course = Course::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'user_id' => auth()->user()->id, // Add this line to set the user_id
        ]);
    
        return response()->json(['message' => 'Course created successfully', 'course' => $course], 201);
    }
    

    public function update(Request $request, $id)
    {
        // Check if the user is an Instructor
        if ($response = $this->checkRole('Instructor')) {
            return $response;
        }

        // Proceed with updating the course
        // Your course update logic here

        return response()->json(['success' => 'Course updated successfully']);
    }

    public function destroy($id)
    {
        // Retrieve the logged-in user
        $user = auth()->user();
    
        // Retrieve the course by ID
        $course = Course::find($id);
    
        // Check if the course exists
        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }
    
        // Check if the user is an admin
        if ($user->role === 'Admin') {
            // Allow the admin to delete any course
            $course->delete();
            return response()->json(['success' => 'Course deleted successfully']);
        }
    
        // Check if the user is an instructor and the owner of the course
        if ($user->role === 'Instructor' && $course->user_id === $user->id) {
            // Allow the instructor to delete their own course
            $course->delete();
            return response()->json(['success' => 'Course deleted successfully']);
        }
    
        // If the user is not authorized to delete the course
        return response()->json(['error' => 'Unauthorized to delete this course'], 403);
    }
    
}
