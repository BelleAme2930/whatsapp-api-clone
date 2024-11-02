<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /**
     * Send a message to a chatroom with an optional attachment.
     */
    public function sendMessage(Request $request, $chatroomId)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
            'attachment' => 'nullable|file',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = $request->user();

        if (!Storage::disk('public')->exists('root/picture')) {
            Storage::disk('public')->makeDirectory('root/picture');
        }
        if (!Storage::disk('public')->exists('root/video')) {
            Storage::disk('public')->makeDirectory('root/video');
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $mimeType = $file->getMimeType();

            if (str_starts_with($mimeType, 'image')) {
                $attachmentPath = $file->storeAs('root/picture', $file->getClientOriginalName(), 'public');
            } elseif (str_starts_with($mimeType, 'video')) {
                $attachmentPath = $file->storeAs('root/video', $file->getClientOriginalName(), 'public');
            } else {
                return response()->json(['error' => 'Invalid attachment type. Only images and videos are allowed.'], 400);
            }
        }

        $message = Message::create([
            'chatroom_id' => $chatroomId,
            'user_id' => $user->id,
            'message' => $request->message,
            'attachment_path' => $attachmentPath,
        ]);

        return response()->json($message, 201);
    }

    /**
     * List messages in a chatroom, including full URLs for attachments.
     */
    public function listMessages($chatroomId)
    {
        $messages = Message::where('chatroom_id', $chatroomId)
            ->with('user')
            ->get()
            ->map(function ($message) {
                if ($message->attachment_path) {
                    $message->attachment_url = asset('storage/' . $message->attachment_path);
                }
                return $message;
            });

        return response()->json($messages);
    }
}
