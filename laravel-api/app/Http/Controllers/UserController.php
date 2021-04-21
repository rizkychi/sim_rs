<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\cr_token;
use App\Models\cr_user;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $token = cr_token::where('token', $request->bearerToken())->first();
        return $token->cr_user;
    }

    public function update(Request $request)
    {
        $token = cr_token::where('token', $request->bearerToken())->first();
        $user  = cr_user::where('user_id', $token->user_id)->first();
        $user->user  = $request->user;
        $user->kunci = $request->kunci;
        
        if ($user->update()) {
            return ['status' => true, 'message' => 'user update success', 'user' => $user];
        } else {
            return ['status' => false, 'message' => 'user update error'];
        }
    }

    public function destroy(Request $request)
    {
        $token = cr_token::where('token', $request->bearerToken())->first();
        $user  = cr_user::where('user_id', $token->user_id)->first();

        $token->delete();
        $user->delete();

        return ['status' => true, 'message' => 'user deleted'];
    }
}
