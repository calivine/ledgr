<?php

namespace App\Listeners;

use App\Budget;
use App\Events\PlannedBudgetChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdatePlanned
{
    /**
     * Handle the event.
     *
     * @param  PlannedBudgetChanged  $event
     * @return void
     */
    public function handle(PlannedBudgetChanged $event)
    {
        $id = $event->id;
        $new_planned = $event->new_value;

        $budget = Budget::find($id);
        $budget->planned = $new_planned;
        $budget->save();


    }
}
