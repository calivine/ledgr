<?php


namespace App\Repository;

use App\Activity;
use App\Budget;
use App\Actions\Activity\StoreActivity;
use Carbon\Carbon;
use DB;
use Log;
use Illuminate\Http\Request;

class Budgets
{
    CONST CACHE_KEY = 'BUDGETS';


    public function all($user)
    {
        return Budget::where('user_id', $user)
            ->get();
        /*
        return DB::table('budgets')
            ->where('user_id', '=', $user)
            ->get();
        */
    }

    /**
     * Get collection of budget data based on key/value
     */
    public function get($key, $value, $user)
    {
        return Budget::where([
            ['user_id', $user],
            [$key, $value]])->get();
    }

    /**
    * Returns the current period's budget
    *
    */
    public function categories($user, $filter)
    {

        if ($filter == 'all') {
            $key = "categories.{$user}";
            $cacheKey = $this->getCacheKey($key);
            return cache()->remember($cacheKey, Carbon::now()->addSeconds(30), function () use ($user) {
                return DB::table('budgets')
                    ->where([
                        ['year', '=', $year ?? date('Y')],
                        ['month', '=', $month ?? date('F')],
                        ['user_id', '=', $user]
                    ])
                    ->select('category',
                             'planned',
                             'actual',
                             'month',
                             'year')
                    ->orderBy('category')
                    ->get();
            });
        }
        else {
            $key = "categories.{$user}.{$filter}";
            $cacheKey = $this->getCacheKey($key);
            return cache()->remember($cacheKey, Carbon::now()->addSeconds(30), function () use ($user, $filter) {
                return DB::table('budgets')
                    ->where([
                        ['year', '=', $year ?? date('Y')],
                        ['month', '=', $month ?? date('F')],
                        ['user_id', '=', $user]
                    ])
                    ->select('category',
                             $filter)
                    ->orderBy('category')
                    ->get();
            });
        }
    }


    public function category($user, $category, $filter)
    {
        if ($filter == 'all')
        {
            return DB::table('budgets')
                ->where([
                    ['year', '=', $year ?? date('Y')],
                    ['month', '=', $month ?? date('F')],
                    ['user_id', '=', $user],
                    ['category', '=', $category]
                ])
                ->select('category',
                         'planned',
                         'actual')
                ->orderBy('category')
                ->get();
        }
        else
        {
            return DB::table('budgets')
                ->where([
                    ['year', '=', $year ?? date('Y')],
                    ['month', '=', $month ?? date('F')],
                    ['user_id', '=', $user],
                    ['category', '=', $category]
                ])
                ->select('category',
                         $filter)
                ->orderBy('category')
                ->get();
        }
    }

    public function labels($user)
    {
        $key = "categories.{$user}.labels";
        $cacheKey = $this->getCacheKey($key);
        return cache()->remember($cacheKey, Carbon::now()->addSeconds(30), function () use ($user) {
            return DB::table('budgets')
                ->where([
                    ['year', '=', $year ?? date('Y')],
                    ['month', '=', $month ?? date('F')],
                    ['user_id', '=', $user]
                ])
                ->select('category')
                ->orderBy('category')
                ->get();
        });

    }


    public function getCacheKey($key)
    {
        $key = strtoupper($key);

        return self::CACHE_KEY . ".$key";
    }
}
