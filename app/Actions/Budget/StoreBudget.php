<?php


namespace App\Actions\Budget;

use App\Budget;


class StoreBudget
{
    public function __construct($user)
    {
        // Generate New Budget Sheet
        $date = date('Y');
        $period = date('F');

        $new_user = $user;

        $json = file_get_contents('../database/budget.json');
        $json_data = json_decode($json, true);

        foreach($json_data['data'] as $budget) {
            $new_budget = new Budget;

            $new_budget->category = $budget['category'];
            $new_budget->year = $date;
            $new_budget->period = $period;

            $new_budget->user()->associate($new_user);

            $new_budget->save();
        }
    }

}