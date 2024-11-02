<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserJoinedChatroom implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The user who joined the chatroom.
     *
     * @var User
     */
    public User $user;

    /**
     * The chatroom ID.
     *
     * @var int
     */
    public int $chatroomId;

    /**
     * Create a new event instance.
     *
     * @param  User  $user
     * @param  int  $chatroomId
     * @return void
     */
    public function __construct(User $user, int $chatroomId)
    {
        $this->user = $user;
        $this->chatroomId = $chatroomId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|PresenceChannel
     */
    public function broadcastOn(): Channel|PresenceChannel
    {
        return new PresenceChannel('chatroom.' . $this->chatroomId);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'joined_at' => now()->toDateTimeString(),
        ];
    }
}
