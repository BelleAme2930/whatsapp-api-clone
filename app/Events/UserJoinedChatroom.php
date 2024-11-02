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

    public User $user;
    public int $chatroomId;

    /**
     * Create a new event instance.
     *
     * @param  User  $user
     * @param  int  $chatroomId
     */
    public function __construct(User $user, int $chatroomId)
    {
        $this->user = $user;
        $this->chatroomId = $chatroomId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('chatroom.' . $this->chatroomId),
        ];
    }

    /**
     * Prepare the data to be broadcast with the event.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
        ];
    }
}
