<?php

namespace App\Listeners;

use App\Budget;
use App\Events\IconWasChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateIcon
{
    /**
     * Handle the event.
     *
     * @param  IconWasChanged  $event
     * @return void
     */
    public function handle(IconWasChanged $event)
    {
        $id = $event->id;
        $icon = $event->icon;

        $budget = Budget::find($id);

        $budget->icon = $icon;
        $budget->save();
    }
}
