<?php


namespace App\Actions\Budget;

use App\Budget;
use App\Actions\Utility\DateUtility;
use App\Actions\Budget\GetBudget;


class StoreBudget
{
    public function __construct($user)
    {
        // Generate New Budget Sheet
        $year = date('Y');
        $this_month = date('F');

        $last_month = DateUtility::last_month();

        $saved_budget = new GetBudget($user, $year, $last_month);

        // If there is a Budget from the last month,
        // Copy it's contents into a new Budget
        if (sizeof($saved_budget->budget) > 0) {
            foreach($saved_budget->budget as $budget) {
                $new_budget = new Budget;
                $new_budget->category = $budget['category'];
                $new_budget->year = $year;
                $new_budget->period = $this_month;
                $new_budget->planned = $budget['planned'];

                $new_budget->user()->associate($user);

                $new_budget->save();

            }

        }
        // Else, copy new Budget sheet from file storage
        else {
            $new_user = $user;

            $json = file_get_contents('../database/budget.json');
            $json_data = json_decode($json, true);

            foreach($json_data['data'] as $budget) {
                $new_budget = new Budget;

                $new_budget->category = $budget['category'];
                $new_budget->year = $year;
                $new_budget->period = $this_month;

                $new_budget->user()->associate($new_user);

                $new_budget->save();
            }
        }
    }

}


