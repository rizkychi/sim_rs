<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\cr_user;

class LoginController extends Controller
{
    public function doLogin(Request $request)
    {
        $user = cr_user::where('username', $request->username)->first(); //find username

        //username found
        if ($user) {
            if ($user->kunci == $request->kunci) {
                return ['status' => true, 'message' => 'login success', 'response' => $user];
            } else {
                return ['status' => false, 'message' => 'password does not match'];
            }
        }

        //username not found
        return ['status' => false, 'message' => 'username not found'];
    }
}
