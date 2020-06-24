<?php

use Illuminate\Database\Seeder;
use App\Budget;

class BudgetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents('database/budget.json');
        $json_data = json_decode($json, true);

        foreach($json_data['data'] as $budget) {
            $new_budget = new Budget;

            $new_budget->category = $budget['category'];
            $new_budget->year = $budget['year'];
            $new_budget->month = $budget['period'];

            $new_budget->save();
        }
    }
}
