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

    public function getCacheKey($key)
    {
        $key = strtoupper($key);

        return self::CACHE_KEY . ".$key";
    }
}
