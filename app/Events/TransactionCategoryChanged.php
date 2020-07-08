<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class TransactionCategoryChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Transaction Category was changed Event
     *
     */

    // ID of Transaction that is being updated
    public $id;

    // New category to be changed to.
    public $new_category;

    // User ID
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $new_category, $user)
    {
        $this->id = $id;
        $this->new_category = $new_category;
        $this->user = $user;
        Log::info($new_category);
    }
}
