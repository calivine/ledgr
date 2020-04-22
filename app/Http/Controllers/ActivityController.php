<?php

namespace App\Http\Controllers;

use App\Actions\Activity\DestroyActivity;
use App\Actions\Activity\StoreActivity;
use App\Actions\Activity\UpdateCategory;
use App\Actions\Budget\UpdateActual;
use App\Actions\ProgressBar\BudgetTotals;
use App\Actions\ProgressBar\MonthlyTotal;
use App\Activity;
use App\Budget\BudgetSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Handles requests that process Activity (transactions) data.
 *
 * @category   Controllers
 *
 * @author     Alex Caloggero
 */
class ActivityController extends Controller
{
    /*
     * POST
     * /transaction
     * Saves a transaction
     */
    public function storeTransaction(Request $request)
    {
        $id = $request->user()->id;
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|min:0|numeric',
            'category' => 'required|string',
            'transaction_date' => 'required|date|regex:/[0-9]{4}-[0-9]{2}-[0-9]{2}/'
        ]);

        // Save New Transaction
        new StoreActivity($request);

        // Add Amount to Budget Actual Category
        new UpdateActual($request->input('category'), null, $request->input('amount'), $id);

        $budget = new BudgetSheet($id);

        // Recalculate budget category totals so progress bars update in client.
        $monthly_total_bar = new MonthlyTotal($budget->budget);
        $budget_totals = new BudgetTotals($budget->budget);
        Log::info('Saved new transaction: ' . $request->input('description'));

        return response()->json([
            'monthly_total' => $monthly_total_bar->rda,
            'budget_totals' => $budget_totals->rda
        ]);
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

    /**
     * GET
     * /transaction/{id}/delete
     * Display confirm transaction delete page.
     */
     public function deleteTransaction($id)
     {
          return view('activity.delete')->with([
              'id' => $id
          ]);
     }

     /**
      * POST
      * /transaction/{id}/destroy
      * Delete transaction.
      */
      public function destroyTransaction($id)
      {
          new DestroyActivity($id);

          return redirect(route('dashboard'));

      }
}
