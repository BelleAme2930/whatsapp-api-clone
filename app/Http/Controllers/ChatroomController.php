<?php

namespace App\Http\Controllers;

use App\Models\Chatroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatroomController extends Controller
{
    /**
     * Create a new chatroom.
     */
    public function createChatroom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'max_members' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $chatroom = Chatroom::create([
            'name' => $request->name,
            'max_members' => $request->max_members,
        ]);

        return response()->json($chatroom, 201);
    }

    /**
     * List all chatrooms.
     */
    public function listChatrooms()
    {
        $chatrooms = Chatroom::all();
        return response()->json($chatrooms);
    }

    /**
     * Enter a chatroom.
     */
    public function enterChatroom(Request $request, $chatroomId)
    {
        $user = $request->user();

        $chatroom = Chatroom::find($chatroomId);
        if (!$chatroom) {
            return response()->json(['message' => 'Chatroom not found'], 404);
        }

        if ($chatroom->members()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'User already in the chatroom'], 400);
        }

        if ($chatroom->members()->count() >= $chatroom->max_members) {
            return response()->json(['message' => 'Chatroom is full'], 400);
        }

        $chatroom->members()->attach($user->id);

        return response()->json(['message' => 'Successfully entered the chatroom']);
    }

    /**
     * Leave a chatroom.
     */
    public function leaveChatroom(Request $request, $chatroomId)
    {
        $user = $request->user();

        $chatroom = Chatroom::find($chatroomId);
        if (!$chatroom) {
            return response()->json(['message' => 'Chatroom not found'], 404);
        }

        $chatroom->members()->detach($user->id);

        return response()->json(['message' => 'Successfully left the chatroom']);
    }
}
