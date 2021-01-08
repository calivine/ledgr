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
        // Update Actual Budget Value
        Log::debug('Updating budget: ' . $transaction->budget_id . ' by ' . $transaction->amount);
        $budget = Budget::where([
            ['id', $transaction->budget_id]
        ])->firstOrFail();

        $budget->actual += $transaction->amount;
        $budget->save();
    }
}
