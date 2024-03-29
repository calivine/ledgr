<?php

namespace App\Http\Controllers;

use App\Actions\Activity\DestroyActivity;
use App\Actions\Activity\StoreActivity;
use App\Actions\Activity\UpdateCategory;
use App\Actions\Budget\UpdateActual;
use App\Actions\ProgressBar\MonthlyTotal;
use App\Events\TransactionCategoryChanged;
use App\Activity;
use App\User;
use App\Budget\BudgetSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Facades\App\Repository\Activities;

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

        // Get input values from form
        $description = $request->input('description');
        $amount = $request->input('amount');
        $category = $request->input('category');
        $date = $request->input('transaction_date');

        $user = $request->user();

        // Save New Transaction
        $activity = new StoreActivity($date, $amount, $description, $category, $user);

        $new_transaction = [
            'date' => date_to_string($activity->rda['date']),
            'amount' => number_format($activity->rda['amount'], 2),
            'description' => $activity->rda['description'],
            'category' => $activity->rda['category'],
            'icon' => $activity->rda['budget']['icon'],
            'id' => $activity->rda['id'],
        ];

        // Add Amount to Budget Actual Category
        // new UpdateActual($request->input('category'), null, $request->input('amount'), $id);

        // Get Budget Sheet
        $budget = new BudgetSheet($id);

        // Recalculate budget category totals so progress bars update in client.
        $monthly_total_bar = new MonthlyTotal($budget->budget);
        // $monthly_total_bar = new MonthlyTotal($budget->budget);
        // $budget_totals = new BudgetTotals($budget->budget);
        // Log::info('Budget totals bar: ');
        // Log::info($monthly_total_bar->rda['budget_totals']);
        // Log::info('Monthly totals bar: ');
        // Log::info($monthly_total_bar->rda['monthly_total']);
        // Log::info($new_transaction);

        return response()->json([
            'monthly_total' => $monthly_total_bar->rda['monthly_total'],
            'budget_totals' => $monthly_total_bar->rda['budget_totals'],
            'new_transaction' => $new_transaction
        ]);
    }

    /*
     * POST
     * /transaction/category/update
     * Update Transaction's Category
     * @param    String    New category name
     * @param    Integer   Transaction ID
     */
    public function updateCategory(Request $request)
    {
        $request->validate([
            'update_name' => 'required|string',
            'id' => 'required'
        ]);

        $id = $request->input('id');
        $new_category = $request->input('update_name');
        $user_id = $request->user()->id;

        event(new TransactionCategoryChanged($id, $new_category, $user_id));
        // $action = new UpdateCategory($request);

        return response()->json([
            'id' => $id,
            'category' => $new_category
        ]);
    }

    /**
     * GET
     * /transaction/{id}/delete
     * Display confirm transaction delete page.
     */
     public function deleteTransaction($id)
     {
          return view('content.activity.delete')->with([
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

          return redirect()->route('transactions')->with(['alert' => 'Transaction Was Deleted']);

      }

      /**
       * GET
       * /transactions
       * Get a user's transactions.
       */
       public function getTransactions()
       {
           $user_id = Auth::id();
           $transactions = Activities::all($user_id);


           return view('content.activity.transactions')->with([
               'transactions' => $transactions
           ]);
       }


       /**
        * POST
        * /transaction/save/all
        * Mass save group of transactions
        */
        public function storeTransactions(Request $request)
        {
            $user = $request->user();
            $transaction = $request->all();

            $row = 0;
            $row_count = ((count($transaction)-2)/4);

            while($row < $row_count) {
                $amount = $transaction['amount' . $row];
                $description = $transaction['description' . $row];
                $category = $transaction['category' . $row];
                Log::debug($transaction['date' . $row]);
                // Wants Dates in the format: YYYY-MM-DD
                if (str_contains($transaction['date' . $row], '/')) {
                    $transaction['date' . $row] = preg_replace('/\//', "-", $transaction['date' . $row]);
                    Log::debug($transaction['date' . $row]);
                }
                new StoreActivity($transaction['date' . $row], $amount, $description, $category, $user);
                $row++;
            }
            return redirect()->route('dashboard')->with(['alert' => 'Transactions Saved']);
        }
}
