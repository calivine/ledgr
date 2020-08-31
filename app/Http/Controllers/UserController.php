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

        return view('content.account.index')->with([
            'api_token' => $user->api_token,
            'email' => $user->email,
            'name' => $user->name
        ]);
    }

    /*
     * PUT
     * /account/theme/update
     * Update site's theme
     */

     public function updateTheme(Request $request)
     {
         $user = Auth::user();
         $user->theme = $request->input('theme');
         $user->save();

         return redirect()->route('account')->with(['alert' => 'Settings Saved.']);

     }
}
