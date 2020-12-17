<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Activity\DestroyActivity;
use App\Actions\Budget\StoreCategory;
use App\Http\Resources\ActivityCollection;
use App\Http\Resources\BudgetCollection;
use Facades\App\Repository\Activities;
use Facades\App\Repository\Budgets;
use Facades\App\Repository\Budget;
use App\Budget\BudgetSheet;
use Log;

class ApiController extends Controller
{
    public function getBudgetCategories(Request $request)
    {
        $user = $request->user()->id;
        $filter = $request->query('filter', 'all');
        if (preg_match('/categories\/([A-Za-z_]+)/', $request->url(), $category_match))
        {
            // URL included category name to filter by.
            $category_match[1] = preg_replace('/_/', ' ', $category_match[1]);

            $response = Budgets::category($user, $category_match[1], $filter);
        }
        /* Depreciated
        else if (preg_match('/labels/', $request->url()))
        {
            $labels = [];
            $response = Budgets::labels($user);
            foreach($response as $item) {
                $labels[] = $item->category;
            }
            return response()->json([
                'data' => $labels
            ], 200);
        }
        */
        else
        {
            $response = Budgets::categories($user, $filter);
        }

        return new BudgetCollection($response);
    }
    /*
    public function getBudgetCategory(Request $request)
    {
        $user = $request->user()->id;
        $request_url = $request->url();

        preg_match('/category\/([A-Za-z]+)/', $request_url, $match);

        if (preg_match('/planned/', $request_url))
        {
            $response = Budget::category($user, $match[1], 'planned');
        }
        else if (preg_match('/actual/', $request_url))
        {
            $response = Budget::category($user, $match[1], 'actual');
        }
        else
        {
            $response = Budget::category($user, $match[1]);
        }

        return new BudgetCollection($response);
    }
    */

    public function getAllTransactions(Request $request)
    {
        $user = $request->user()->id;
        $transactions = Activities::all($user);
        return new ActivityCollection($transactions);
    }

    public function getTransactionsByDate(Request $request)
    {
        $user = $request->user()->id;
        $request_url = $request->url();

        // Get to and from dates from URL.
        preg_match_all('/[\d]{4}-[\d]{1,2}-[\d]{1,2}/', $request_url, $dates);

        $from = $dates[0][0];
        $to = $dates[0][1];

        $transactions = Activities::getActivitiesByDate($from, $to, $user);

        return new ActivityCollection($transactions);

    }

    public function store(Request $request)
    {
        Log::info('Storing activity');
        $activity = Activities::storeTransaction($request);

        return response()->json([
            'data' => $activity
        ], 200);

    }

    public function storeCategory(Request $request)
    {
        $user = $request->user()->id;

        Log::info('Storing category');
        $budget = new StoreCategory($request->input('category'), $request->input('planned'), $user);
        return response()->json([
            'data' => $budget
        ], 200);

    }

    public function total(Request $request)
    {
        $user = $request->user()->id;
        // Get to and from dates from URL.
        preg_match_all('/[\d]{4}-[\d]{1,2}-[\d]{1,2}/', $request->url(), $dates);

        $from = $dates[0][0];
        $to = $dates[0][1];

        $transactions = Activities::getActivitiesByDate($from, $to, $user);

        return response()->json([
            'data' => round($transactions->sum('amount'),2)
        ], 200);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function getBudgetCategoryTest(Request $request)
    {
        Log::info("Budget category test.");
        return $request->url();
    }

    public function destroyTransaction(Request $request)
    {
        $id = $request->query('id');

        new DestroyActivity($id);

        return response()->json([
            'data' => 'Ok'
        ], 200);

    }
}
