<?php

namespace App\Http\Controllers;

use App\Models\Chatroom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatroomController extends Controller
{
    /**
     * Create a new chatroom.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function createChatroom(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'max_members' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $chatroom = Chatroom::create($validator->validated());

        return response()->json($chatroom, 201);
    }

    /**
     * List all chatrooms.
     *
     * @return JsonResponse
     */
    public function listChatrooms(): JsonResponse
    {
        $chatrooms = Chatroom::all();
        return response()->json($chatrooms);
    }

    /**
     * Enter a chatroom.
     *
     * @param  Request  $request
     * @param  int  $chatroomId
     * @return JsonResponse
     */
    public function enterChatroom(Request $request, int $chatroomId): JsonResponse
    {
        $user = $request->user();
        $chatroom = $this->findChatroom($chatroomId);

        if (!$chatroom) {
            return response()->json(['message' => 'Chatroom not found'], 404);
        }

        if ($this->userInChatroom($user, $chatroom)) {
            return response()->json(['message' => 'User already in the chatroom'], 400);
        }

        if ($this->chatroomIsFull($chatroom)) {
            return response()->json(['message' => 'Chatroom is full'], 400);
        }

        $chatroom->members()->attach($user->id);

        return response()->json(['message' => 'Successfully entered the chatroom']);
    }

    /**
     * Leave a chatroom.
     *
     * @param  Request  $request
     * @param  int  $chatroomId
     * @return JsonResponse
     */
    public function leaveChatroom(Request $request, int $chatroomId): JsonResponse
    {
        $user = $request->user();
        $chatroom = $this->findChatroom($chatroomId);

        if (!$chatroom) {
            return response()->json(['message' => 'Chatroom not found'], 404);
        }

        $chatroom->members()->detach($user->id);

        return response()->json(['message' => 'Successfully left the chatroom']);
    }

    /**
     * Find a chatroom by its ID.
     *
     * @param  int  $chatroomId
     * @return Chatroom|null
     */
    protected function findChatroom(int $chatroomId): ?Chatroom
    {
        return Chatroom::find($chatroomId);
    }

    /**
     * Check if the user is already in the chatroom.
     *
     * @param  mixed  $user
     * @param  Chatroom  $chatroom
     * @return bool
     */
    protected function userInChatroom($user, Chatroom $chatroom): bool
    {
        return $chatroom->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if the chatroom is full.
     *
     * @param  Chatroom  $chatroom
     * @return bool
     */
    protected function chatroomIsFull(Chatroom $chatroom): bool
    {
        return $chatroom->members()->count() >= $chatroom->max_members;
    }
}
