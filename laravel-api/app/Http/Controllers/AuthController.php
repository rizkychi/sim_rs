<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Validator;
use DB;

use App\Models\cr_app;
use App\Models\cr_user;
use App\Models\cr_token;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = cr_user::where('username', $request->username)->first(); //find username
        
        //username found
        if ($user) {
            if ($user->kunci == $request->kunci) {
                $token = $this->update_token($user->user_id);
                return ['status' => true, 'message' => 'login success', 'token' => $token];
            } else {
                return ['status' => false, 'message' => 'password does not match'];
            }
        }

        //username not found
        return ['status' => false, 'message' => 'username not found'];
    }

    public function register(Request $request)
    {
        //validation for username (must be unique)
        $rules = [
            'username' => 'unique:cr_user,username'
        ];

        $msg = [
            'unique' => 'username has been taken'
        ];

        $validator = Validator::make($request->all(), $rules, $msg);
        
        if ($validator->fails()) {
            return ['status' => false, 'message' => $validator->errors()->first()];
        }

        //transaction for user and token
        DB::beginTransaction();
        try {
            //create new user
            $user = new cr_user();
            $user->user_id      = $request->username;
            $user->username     = $request->username;
            $user->user         = $request->user;
            $user->kunci        = $request->kunci;
            $user->peran_id     = cr_user::PERAN; 
            $user->save();

            //create user token
            $last_token_id  = cr_token::latest('token_id')->first()->token_id; // find latest token_id

            $token = new cr_token();
            $token->token_id    = ++$last_token_id;
            $token->token       = Str::random(60);
            $token->app_id      = cr_app::ID;
            $token->user_id     = $user->user_id;
            $token->save();

            DB::commit(); // all good
            return ['status' => true, 'message' => 'user successfully created'];
        } catch (\Exception $e) {
            DB::rollback(); // something went wrong
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    public function update_token($user_id)
    {
        $token = cr_token::where('user_id', $user_id)->first(); //find token
        $token->token = Str::random(60);
        $token->update();
        return $token->token;
    }

    public function forbidden()
    {
        return ['status' => false, 'message' => 'You need valid authorization '];
    }
}
