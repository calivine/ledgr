<?php

namespace App\Actions\Activity;

use App\Activity;
use App\Actions\Budget\UpdateActual;
use Illuminate\Http\Request;

/**
 * Update the category name for a single transaction
 * @category Action
 * @author Alex Caloggero
 *
 */


class UpdateCategory
{
    public function __construct(Request $request)
    {
        $update_name = $request->input('update_name');
        $id = $request->input('id');

        // Get Associated Transaction By ID
        $activity = Activity::find($id);

        // Update Budget Actuals
        new UpdateActual($update_name, $activity->category, $activity->amount, $request->user()->id);

        $activity->category = $update_name;
        $activity->save();
        $this->rda = [
            'id' => $id,
            'update_name' => $update_name
        ];
    }
}
