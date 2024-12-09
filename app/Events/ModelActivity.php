<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModelActivity
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user, $action, $entity, $entity_name, $message, $timestamp;

    /**
     * Create a new event instance.
     */
    public function __construct($user, $action, $entity, $entity_name, $message)
    {
        $this->user = $user;
        $this->action = $action;
        $this->entity = $entity;
        $this->entity_name = $entity_name;
        $this->message = $message;
        $this->timestamp = now();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
