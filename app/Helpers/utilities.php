<?php

use Illuminate\Support\Facades\Request;

/**
 * Utility function to quickly dump data to the page
 * @param null $mixed
 */
function ddump($mixed = null)
{
    echo '<pre>';
    var_dump($mixed);
    echo '</pre>';
}


/**
 * Generate user logs
 *
 */
 function log_client()
 {
     $user_agent = Request::userAgent();
     $id = Request::user()->id ?? 'Guest';
     $method = Request::method();
     $ip = Request::ip();
     $request_uri = Request::path();

     return '/' . $request_uri . ' ' . $method . ' ' . now() . ': User: ' . $id . ' (' . $ip . ') ' . $user_agent;
 }
