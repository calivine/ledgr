<?php

namespace App\Events;

use App\Activity;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TransactionWasCreated
{
    use SerializesModels;

    /**
    * The new transaction.
    *
    */
    public $transaction;
    /**
     * Create a new TransactionWasCreated event instance.
     *
     * @var \App\Activity
     *
     */
    public function __construct(Activity $activity)
    {
        $this->transaction = $activity;
    }
}
