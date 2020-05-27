<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlannedBudgetChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * New Planned Budget
     *
     */
     public $id;

     public $new_value;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $planned)
    {
        $this->id = $id;
        $this->new_value = $planned;
    }
}
