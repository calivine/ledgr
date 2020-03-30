<?php


namespace App\Actions\Activity;

use App\Activity;
use App\Budget;
use Illuminate\Http\Request;


class StoreActivity
{
    public function __construct(Request $request)
    {
        // Get input values from form
        $description = $request->input('description');
        $amount = $request->input('amount');
        $category = $request->input('category');
        $date = $request->input('transaction_date');

        $year = date('Y', strtotime($date));
        $month = date('F', strtotime($date));

        // Get User Object
        $user = $request->user();

        // Get Budget Category To Associate w/ Activity
        $budget = Budget::where([
            ['year', '=', $year],
            ['period', '=', $month],
            ['user_id', '=', $user->id],
            ['category', '=', $category]
        ])
        ->first();
        // Save Transaction To Activities Table
        $activity = new Activity();

        $activity->description = $description;
        $activity->amount = $amount;
        $activity->category = $category;
        $activity->date = $date;
        // Create function that generates random 36 character alpha-num string
        $activity->transaction_id = "TestTransaction";
        // Link To User Signed-In
        $activity->user()->associate($user);
        // Link To Budget Category
        $activity->budget()->associate($budget);
        $activity->save();
    }

}
