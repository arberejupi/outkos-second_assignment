<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Retrieve all course IDs the user is enrolled in
        $courseIds = $user->courses->pluck('id')->toArray();

        // Fetch threads for these courses
        $threads = Thread::whereIn('course_id', $courseIds)->get();

        return response()->json(['threads' => $threads], 200);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $course = Course::find($request->course_id);

        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        // Check if user is an instructor of the course
        if ($user->role !== 'Instructor') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $thread = Thread::create([
            'course_id' => $validatedData['course_id'],
            'user_id' => $user->id,
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
        ]);

        return response()->json(['message' => 'Thread created successfully', 'thread' => $thread], 201);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $thread = Thread::find($id);

        if (!$thread) {
            return response()->json(['error' => 'Thread not found'], 404);
        }

        // Check if user is an instructor of the course or an admin
        if ($user->role === 'Admin' || ($user->role === 'Instructor' && $thread->user_id === $user->id)) {
            $thread->delete();
            return response()->json(['message' => 'Thread deleted successfully'], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
