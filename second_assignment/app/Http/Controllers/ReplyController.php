<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $thread = Thread::find($request->thread_id);

        if (!$thread) {
            return response()->json(['error' => 'Thread not found'], 404);
        }

        $validatedData = $request->validate([
            'thread_id' => 'required|exists:threads,id',
            'content' => 'required|string',
        ]);

        $reply = Reply::create([
            'thread_id' => $validatedData['thread_id'],
            'user_id' => $user->id,
            'content' => $validatedData['content'],
        ]);

        return response()->json(['message' => 'Reply created successfully', 'reply' => $reply], 201);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $reply = Reply::find($id);

        if (!$reply) {
            return response()->json(['error' => 'Reply not found'], 404);
        }

        // Check if user is the author of the reply or an instructor
        if ($user->role === 'Instructor' || $user->id === $reply->user_id) {
            $reply->delete();
            return response()->json(['message' => 'Reply deleted successfully'], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
