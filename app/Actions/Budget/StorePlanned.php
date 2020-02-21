<?php


namespace App\Actions\Budget;

use App\Budget;
use Illuminate\Http\Request;



class StorePlanned
{
    public function __construct(Request $request)
    {
        $new_planned = $request->input('new_value');
        $id = $request->input('id');

        $budget = Budget::find($id);
        $budget->planned = $new_planned;
        $budget->save();

        $this->rda = [
            'planned' => $new_planned
        ];
    }

}