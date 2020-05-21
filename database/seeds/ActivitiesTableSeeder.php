<?php

use App\Activity;
use App\Budget;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents('database/backup.json');
        $json_data = json_decode($json, true);

        foreach($json_data as $transaction) {
            $transaction = decrypt($transaction);
            $budget = Budget::find($transaction['budget_id']);
            if ($budget == null)
            {
                $budget = new Budget();
                $budget->actual = $transaction['amount'];
                $budget->category = $transaction['category'];
                $budget->planned = 0;
                $budget->save();
                Log::info('Creating new budget item.');

            }
            else
            {
                Log::info('Found budget item to link.');
            }
            $user = User::find($transaction['user_id']);

            $activity = new Activity();
            $activity->description = $transaction['description'];
            $activity->amount = $transaction['amount'];
            $activity->category = $transaction['category'];
            $activity->date = $transaction['date'];
            // Create function that generates random 36 character alpha-num string
            $activity->transaction_id = "TestTransaction";
            // Link To User Signed-In
            $activity->user()->associate($user);
            // Link To Budget Category
            $activity->budget()->associate($budget);
            $activity->save();

        }
    }
}
