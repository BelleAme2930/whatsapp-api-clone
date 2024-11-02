<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Send a message to a chatroom with an optional attachment.
     *
     * @param  Request  $request
     * @param  int  $chatroomId
     * @return JsonResponse
     */
    public function sendMessage(Request $request, int $chatroomId): JsonResponse
    {
        $validator = $this->validateMessage($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = $request->user();
        $this->ensureAttachmentDirectoriesExist();

        $attachmentPath = $this->handleAttachmentUpload($request);

        $message = Message::create([
            'chatroom_id' => $chatroomId,
            'user_id' => $user->id,
            'message' => $request->message,
            'attachment_path' => $attachmentPath,
        ]);

        event(new MessageSent($message));

        return response()->json($message, 201);
    }

    /**
     * List messages in a chatroom, including full URLs for attachments.
     *
     * @param  int  $chatroomId
     * @return JsonResponse
     */
    public function listMessages(int $chatroomId): JsonResponse
    {
        $messages = Message::where('chatroom_id', $chatroomId)
            ->with('user')
            ->get()
            ->map(function ($message) {
                if ($message->attachment_path) {
                    $message->attachment_url = url('storage/' . $message->attachment_path);
                }
                return $message;
            });

        return response()->json($messages);
    }

    /**
     * Validate the message request data.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateMessage(Request $request)
    {
        return Validator::make($request->all(), [
            'message' => 'required|string',
            'attachment' => 'nullable|file|max:20480',
        ]);
    }

    /**
     * Ensure required directories for attachments exist.
     *
     * @return void
     */
    protected function ensureAttachmentDirectoriesExist(): void
    {
        $directories = ['root/picture', 'root/video'];

        foreach ($directories as $directory) {
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
        }
    }

    /**
     * Handle the attachment upload and return the path.
     *
     * @param  Request  $request
     * @return string|null
     */
    protected function handleAttachmentUpload(Request $request): ?string
    {
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $mimeType = $file->getMimeType();

            $validMimeTypes = [
                'image' => 'root/picture',
                'video' => 'root/video',
            ];

            foreach ($validMimeTypes as $type => $directory) {
                if (str_starts_with($mimeType, $type)) {
                    return $file->storeAs($directory, $file->getClientOriginalName(), 'public');
                }
            }

            return null;
        }

        return null;
    }
}
