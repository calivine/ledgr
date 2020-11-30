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

    /**
    * Returns a single budget category item.
    *
    */
    public function category($user, $category, $filter = null)
    {
        if (is_null($filter))
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

    /**
    * Returns the current period's budget
    *
    */
    public function categories($user, $filter = null)
    {

        if (is_null($filter)) {
            $key = "categories.{$user}";
            $cacheKey = $this->getCacheKey($key);
            return cache()->remember($cacheKey, Carbon::now()->addMinutes(2), function () use ($user) {
                return DB::table('budgets')
                    ->where([
                        ['year', '=', $year ?? date('Y')],
                        ['month', '=', $month ?? date('F')],
                        ['user_id', '=', $user]
                    ])
                    ->select('category',
                             'planned',
                             'actual')
                    ->orderBy('category')
                    ->get();
            }
        }
        else {
            $key = "categories.{$user}.{$filter}"
            $cacheKey = $this->getCacheKey($key);
            return cache()->remember($cacheKey, Carbon::now()->addMinutes(2), function () use ($user, $filter) {
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
            }
        }
    }


    public function getCacheKey($key)
    {
        $key = strtoupper($key);

        return self::CACHE_KEY . ".$key";
    }
}
