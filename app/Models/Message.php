<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'chatroom_id',
        'user_id',
        'message',
        'attachment_path',
    ];

    public function chatroom(): BelongsTo
    {
        return $this->belongsTo(Chatroom::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
