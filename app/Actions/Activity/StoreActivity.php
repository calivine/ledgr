<?php


namespace App\Actions\Activity;

use App\Activity;
use App\Actions\Budget\StoreBudget;
use App\Budget;
use App\Events\TransactionWasCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class StoreActivity
{
    public function __construct($date, $amount, $description, $category, $user)
    {
        $year = date('Y', strtotime($date));
        $month = date('F', strtotime($date));
        Log::info($year . $month . $user->id . $category);
        // Get Budget Category To Associate w/ Activity
        $budget = Budget::where([
            ['year', '=', $year],
            ['month', '=', $month],
            ['user_id', '=', $user->id],
            ['category', '=', $category]
        ])->first();

        // If Budget Sheet Doesn't Exist,
        if ($budget == null)
        {
            // Create a new budget sheet for the transaction's date
            new StoreBudget($user, $month, $year);
            $budget = Budget::where([
                ['year', '=', $year],
                ['month', '=', $month],
                ['user_id', '=', $user->id],
                ['category', '=', $category]
            ])->first();
        }
        Log::info($budget);


        // Save Transaction To Activities Table
        $activity = new Activity();

        $activity->description = $description;
        $activity->amount = $amount;
        $activity->category = $category;
        $activity->date = $date;
        // Create function that generates random 36 character alpha-num string
        // $activity->transaction_id = "TestTransaction";
        // Link To User Signed-In
        $activity->user()->associate($user);
        // Link To Budget Category
        $activity->budget()->associate($budget);
        $activity->save();

        $this->rda = $activity;

        event(new TransactionWasCreated($activity));
    }

}
