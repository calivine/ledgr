<?php


namespace App\Actions\Budget;

use App\Budget;
use Illuminate\Http\Request;

/**
 * Updates planned budget value.
 *
 * @category   Actions
 *
 * @param      numeric $id
 * @param      numeric $planned
 *
 * @author     Alex Caloggero
 */
class UpdatePlanned
{
    public function __construct($id, $planned)
    {
        $new_planned = $planned;
        $budget_id = $id;

        $budget = Budget::find($budget_id);
        $budget->planned = $new_planned;
        $budget->save();

        $this->rda = [
            'planned' => $new_planned
        ];
    }
}
