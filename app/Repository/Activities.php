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
        return DB::table('activities')
            ->where('user_id', '=', $user)
            ->whereBetween('date', [$from, $to])
            ->get();
    }

    public function storeTransaction($request)
    {
        $date = $request->input('date');
        $amount = $request->input('amount');
        $description = $request->input('description');
        $category = $request->input('category');

        $user = $request->user();

        $activity = new StoreActivity($date, $amount, $description, $category, $user);

        return $activity;

    }
}
