<?php

namespace App\Events;

use App\Models\Penggunaan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PenggunaanCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $penggunaan;

    /**
     * Create a new event instance.
     */
    public function __construct(Penggunaan $penggunaan)
    {
        $this->penggunaan = $penggunaan;

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
