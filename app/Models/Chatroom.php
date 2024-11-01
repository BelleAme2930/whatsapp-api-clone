<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chatroom extends Model
{
    protected $fillable = [
        'name',
        'max_members',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chatroom_members');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
