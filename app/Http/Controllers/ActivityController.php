<?php

namespace App\Http\Controllers;
use App\Activity;
use App\Actions\Activity\StoreActivity;
use App\Actions\Activity\UpdateCategory;
use App\Actions\Budget\UpdateActual;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /*
     * POST
     * /transaction
     * Saves a transaction
     */
    public function storeTransaction(Request $request)
    {
        $request->validate([
            'description' => 'required|string|alpha_num',
            'amount' => 'required|min:0|numeric',
            'category' => 'required|string',
            'transaction_date' => 'required|date'
        ]);

        // Save New Transaction
        new StoreActivity($request);

        new UpdateActual($request->input('category'), null, $request->input('amount'), $request->user()->id);

    }

    /*
     * POST
     * /transaction/category/update
     * Update Transaction's Category
     */
    public function updateCategory(Request $request)
    {
        $request->validate([
            'update_name' => 'required|string',
            'id' => 'required'
        ]);

        $action = new UpdateCategory($request);

        return response()->json([
            'id' => $action->rda['id'],
            'category' => $action->rda['update_name']
        ]);
    }
}
