<?php

namespace App\Http\Controllers;
use App\Activity;
use App\Budget;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /*
     * POST
     * /transaction/new
     * Saves a transaction
     */
    public function saveTransaction(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'amount' => 'required',
            'category' => 'required',
            'transaction_date' => 'required'
        ]);

        // Get input values from form
        $description = $request->input('description');
        $amount = $request->input('amount');
        $category = $request->input('category');
        $date = $request->input('transaction_date');

        // Get User Object
        $user = $request->user();

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

        // Update Actual Budget Value
        $budget = Budget::where([
            ['category', $category],
            ['period', date('F')],
            ['year', date('Y')],
            ['user_id', $user->id]
        ])->first();

        $budget->actual = $budget->actual + $amount;

        $budget->save();
        $activity->save();

    }

    /*
     * POST
     * /transaction/category/update
     * Update Transaction's Category
     */
    public function updateCategory(Request $request)
    {
        $update_name = $request->input('update_name');
        $id = $request->input('id');

        $activity = Activity::find($id);
        $activity->category = $update_name;
        $activity->save();

        return response()->json([
            'id' => $id,
            'category' => $update_name
        ]);
    }
}
