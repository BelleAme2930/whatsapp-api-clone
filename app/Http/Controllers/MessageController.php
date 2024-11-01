<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Broadcast;

class MessageController extends Controller
{
    /**
     * Send a message to a chatroom.
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

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        $message = Message::create([
            'chatroom_id' => $chatroomId,
            'user_id' => $user->id,
            'message' => $request->message,
            'attachment_path' => $attachmentPath,
        ]);

        Broadcast::channel('chatroom.' . $chatroomId, function ($user) {
            return true;
        });

        broadcast(new MessageSent($message))->toOthers();
        info('MessageSent event broadcasted', ['message' => $message]);
        return response()->json($message, 201);
    }

    /**
     * List messages in a chatroom.
     */
    public function listMessages($chatroomId)
    {
        $messages = Message::where('chatroom_id', $chatroomId)
            ->with('user')
            ->get();

        return response()->json($messages);
    }
}
