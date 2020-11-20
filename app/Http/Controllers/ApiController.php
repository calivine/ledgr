<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ActivityCollection;
use Facades\App\Repository\Activities;
use Log;

class ApiController extends Controller
{

    public function getTransactionsByDate(Request $request)
    {
        $user = $request->user()->id;

        // Get to and from dates from URL.
        preg_match_all('/[\d]{4}-[\d]{1,2}-[\d]{1,2}/', $request->url(), $dates);

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
            "result" => $activity
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

        return $transactions->sum('amount');
    }

    public function user(Request $request)
    {
        return $request->user();
    }
}
