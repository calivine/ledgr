<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ActivityCollection;
use Facades\App\Repository\Activities;
use Log;

class ApiController extends Controller
{
    public function store(Request $request)
    {
        //
    }

    public function get(Request $request)
    {
        $user = $request->user()->id;
        return $user;
    }

    public function getTransactionsByDate(Request $request)
    {
        $user = $request->user()->id;

        $url = $request->url();
        // Get to and from dates from URL.
        preg_match_all('/[\d]{4}-[\d]{1,2}-[\d]{1,2}/', $url, $dates);

        $from = $dates[0][0];
        $to = $dates[0][1];

        $transactions = Activities::getActivitiesByDate($from, $to, $user);

        return new ActivityCollection($transactions);

    }
}
