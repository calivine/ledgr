<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /*
     * GET
     * /account
     * Get Account Settings Page
     */
    public function displayAccount()
    {
        $user = Auth::user();

        return view('account.index')->with([
            'api_token' => $user->api_token,
            'email' => $user->email,
            'name' => $user->name

        ]);



    }
}
