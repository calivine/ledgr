<?php


namespace App\Repository;

use App\Activity;
use App\Budget;
use App\Actions\Activity\StoreActivity;
use DB;
use Log;
use Illuminate\Http\Request;


class Activities
{
    CONST CACHE_KEY = 'ACTIVITIES';

    public function all($user)
    {
        return DB::table('budgets')
            ->join('activities', 'budgets.id', '=', 'activities.budget_id')
            ->where('activities.user_id', '=', $user)
            ->orderBy('activities.date', 'desc')
            ->get();

    }

    public function getActivitiesByDate($from, $to, $user)
    {

        if (!preg_match('/^[\d]{4}-[\d]{1,2}-[\d]{1,2}$/', $from))
        {
            Log::info('Error');
            //return json('status' => 500);
        }
        else
        {
            Log::info('Okay');
        }
        return DB::table('budgets')
            ->join('activities', 'budgets.id', '=', 'activities.budget_id')
            ->where('activities.user_id', '=', $user)
            ->whereBetween('activities.date', [$from, $to])
            ->get();
    }

    public function storeTransaction($request)
    {
        $date = $request->input('date');
        $amount = $request->input('amount');
        $description = $request->input('description');
        $category = $request->input('category');
        Log::info($date . ' ' . $amount . ' ' . $description . ' ' . $category);
        $user = $request->user();

        $activity = new StoreActivity($date, $amount, $description, $category, $user);

        return $activity;

    }
}
