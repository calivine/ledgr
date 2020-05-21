<?php

namespace App\Actions\Budget;

use App\Budget;
use App\Budget\BudgetSheet;
use Illuminate\Support\Facades\Log;

/**
 * Budget-action class for generating monthly budget data.
 *
 * @category   Actions
 *
 * @param      user $user
 *
 * @author     Alex Caloggero
 */
class StoreBudget
{


    public function __construct($user, $month = null, $year = null)
    {
        $this->rda = [];
        // Generate New Budget Sheet
        $id = $user->id;
        $year = $year ?? date('Y');
        $this_month = $month ?? date('F');
        $last_month = last_month();

        $saved_budget = new BudgetSheet($id, $last_month, $year);

        // If there is a Budget from the last month,
        // Copy it's contents into a new Budget
        if (sizeof($saved_budget->budget) > 0) {
            Log::info('Building budget from previous month.');
            foreach($saved_budget->budget as $budget) {
                Log::debug(gettype($budget));

                $new_budget = new Budget;
                $new_budget->category = $budget->category;
                $new_budget->year = $year;
                $new_budget->period = $this_month;
                $new_budget->planned = $budget->planned;
                $new_budget->icon = $budget->icon;

                $new_budget->user()->associate($user);

                $new_budget->save();
                $budget = [
                    'id' => $new_budget->id,
                    'category' => $new_budget->category,
                    'planned' => $new_budget->planned,
                    'period' => $new_budget->period,
                    'year' => $new_budget->year,
                    'actual' => 0,
                    'icon' => $new_budget->icon
                ];
                $this->rda[] = $budget;
            }
        }
        // Else, copy new Budget sheet from file storage
        else {
            Log::info('Building budget from budget.json');
            $new_user = $user;

            $json = file_get_contents(database_path('budget.json'));
            $json_data = json_decode($json, true);

            foreach($json_data['data'] as $budget) {
                $new_budget = new Budget;

                $new_budget->category = $budget['category'];
                $new_budget->year = $year;
                $new_budget->period = $this_month;
                $new_budget->icon = $budget['icon'];

                $new_budget->user()->associate($new_user);

                $new_budget->save();
                $budget = [
                    'id' => $new_budget->id,
                    'category' => $new_budget->category,
                    'planned' => $new_budget->planned,
                    'period' => $new_budget->period,
                    'year' => $new_budget->year,
                    'actual' => 0,
                    'icon' => $new_budget->icon
                ];
                $this->rda[] = $budget;
            }
        }
    }

}
