<?php

namespace App\Http\Controllers;
use App\Budget;
use App\Activity;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /*
     * GET
     * /dashboard
     * User Homepage
     */
    public function index()
    {
        $response = Budget::all();
        $transactions = Activity::all();
        $categories = [];
        foreach($response as $category) {
            $categories[] = $category->category;
        }

        return view('dashboard')->with([
            'categories' => $categories,
            'transactions' => $transactions
        ]);
    }

    /*
     * POST
     * /save_transaction
     * Saves a transaction
     */
    public function saveTransaction(Request $request)
    {
        // Get input values from form
        $description = $request->input('description');
        $amount = $request->input('amount');
        $category = $request->input('category');
        $date = $request->input('transaction_date');

        dump($date);

        // Save transaction to Activities table
        $activity = new Activity();
        $activity->description = $description;
        $activity->amount = $amount;
        $activity->category = $category;
        $activity->date = $date;
        // Create function that generates random 36 character alpha-num string
        $activity->transaction_id = "TestTransaction";
        $activity->save();
    }
}
