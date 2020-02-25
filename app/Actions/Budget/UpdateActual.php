<?php


namespace App\Actions\Budget;

use App\Budget;

class UpdateActual
{
    public function __construct($new_category, $old_category, $amount, $user_id)
    {
        // Get input values from form
        // $amount = $request->input('amount');
        // $category = $request->input('category');

        // Get User Object
        // $user = $request->user();

        // Update Actual Budget Value
        $budget = Budget::where([
            ['category', $new_category],
            ['period', date('F')],
            ['year', date('Y')],
            ['user_id', $user_id]
        ])->first();

        $budget->actual = $budget->actual + $amount;

        $budget->save();

        // Subtract Amount From Old Category
        if ($old_category != null) {
            $budget = Budget::where([
                ['category', $old_category],
                ['period', date('F')],
                ['year', date('Y')],
                ['user_id', $user_id]
            ])->first();

            $budget->actual = $budget->actual - $amount;

            $budget->save();
        }

    }

}