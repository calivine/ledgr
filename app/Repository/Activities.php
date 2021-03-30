<?php


namespace App\Repository;

use App\Activity;
use App\Budget;
use App\Actions\Activity\StoreActivity;
use Carbon\Carbon;
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

    /** Get activities for $user_id between
     *  the dates, $from and $to.
     *  Returns Collection of Activity objects.
     *
     * @param  string $from
     * @param  string $to
     * @param  int    $user_id
     * @return Collection
     */
    public function getActivitiesByDate($from, $to, $user)
    {
        $key = "{$user}.{$from}.{$to}";
        $cacheKey = $this->getCacheKey($key);

        return cache()->remember($cacheKey, Carbon::now()->addSeconds(30), function () use ($user, $to, $from) {
            return DB::table('budgets')
                ->join('activities', 'budgets.id', '=', 'activities.budget_id')
                ->where('activities.user_id', '=', $user)
                ->whereBetween('activities.date', [$from, $to])
                ->get();
        });
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

    /** Get activities for the user dashboard.
     *  Returns Collection of arrays representing
     *  the activity data.
     *
     * @param  string $from
     * @param  string $to
     * @param  int    $user_id
     * @return Illuminate\Support\Collection
     */
    public function getDashboardTransactions($from, $to, $user_id)
    {

        $transactions = Activity::with('budget:id,category,planned,actual,year,month,user_id,icon')
            ->whereBetween('date', [$from, $to])
            ->where('user_id', $user_id)
            ->orderBy('date', 'desc')
            ->select('id', 'amount', 'description', 'category', 'date', 'budget_id')
            ->get();
        /*
        foreach($transactions as $transaction) {
            // $transaction->date = date_to_string($transaction->date);
            $transaction->amount = number_format($transaction->amount, 2);
        }
        */

        return $transactions;

    }

    public function getCacheKey($key)
    {
        $key = strtoupper($key);

        return self::CACHE_KEY . ".$key";
    }
}
