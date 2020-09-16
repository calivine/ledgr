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
     $id = Request::user()->id;
     $method = Request::method();
     $ip = Request::ip();

     return $method . ' ' . now() . ': User: ' . $id . ' (' . $ip . ') ' . $user_agent;
 }
