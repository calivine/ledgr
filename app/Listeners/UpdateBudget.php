<?php

namespace App\Listeners;

use App\Activity;
use App\Budget;

use Illuminate\Support\Facades\Log;

class UpdateBudget
{
    /**
     * Handle the event.
     *
     */
    public function handle($event)
    {
        $transaction = $event->transaction;
        Log::info($transaction);
        // Update Actual Budget Value
        $budget = Budget::where([
            ['id', $transaction->budget_id]
        ])->firstOrFail();

        $budget->actual += $transaction->amount;
        $budget->save();
    }
}
