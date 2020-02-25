<?php


namespace App\Actions\Budget;

use App\Budget;
use Illuminate\Http\Request;

class UpdateActual
{
    public function __construct(Request $request)
    {
        // Get input values from form
        $amount = $request->input('amount');
        $category = $request->input('category');

        // Get User Object
        $user = $request->user();

        // Update Actual Budget Value
        $budget = Budget::where([
            ['category', $category],
            ['period', date('F')],
            ['year', date('Y')],
            ['user_id', $user->id]
        ])->first();

        $budget->actual = $budget->actual + $amount;

        $budget->save();
    }

}