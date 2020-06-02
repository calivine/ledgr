<?php

namespace App\Listeners;

use App\Activity;
use App\Budget;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Events\TransactionCategoryChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateActual
{
    /**
     * Handle the event.
     *
     * @param  TransactionCategoryChanged  $event
     * @return void
     */
    public function handle(TransactionCategoryChanged $event)
    {
        $user_id = $event->user;
        /*
        $test = User::where('id', $user_id)->with(['activities' => function ($query) use ($event) {
            $query->where('id', $event->id);
        }])->first();
        Log::info($test);
        */
        $activity = Activity::where('id', $event->id)->with('budget')->first();
        Log::info('Updating: ' . $activity);
        $activity->category = $event->new_category;
        $activity->budget->actual -= $activity->amount;

        // Get and update the new budget category.
        $new_transaction_category = Budget::where([
            ['category', $event->new_category],
            ['period', $activity->budget->period],
            ['year', $activity->budget->year],
            ['user_id', $user_id]
        ])->first();
        $new_transaction_category->actual += $activity->amount;
        $new_transaction_category->save();
        $activity->budget()->dissociate();
        $activity->budget()->associate($new_transaction_category);
        $activity->save();
        Log::info('Complete: ' . $activity);


    }
}
