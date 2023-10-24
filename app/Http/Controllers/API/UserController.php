<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\user;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function userLogin(Request $request)
    {
        $input = $request->all();

        Auth::attempt($input);
        $user = Auth::user();
        $token = $user->createToken('Token Name')->accessToken;
        return response([
            'status'=> 200, 
            'token' => $token
        ],200);
        //dd($token);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function getUserDetails(Request $request)
    {
        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
            return response([
                'data' => $user
            ],200);
        }else{
            return response([
                'data' => 'Unauthorized'
            ],401);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function userLogout(user $user)
    {
        if(Auth::guard('api')->check()){
            $accessToken = Auth::guard('api')->user()->token();

            \DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update([
                    'revoked' => true
                ]);
            $accessToken->revoke();
            return response([
                'data' => 'Unauthorize',
                'message' => 'User Logout Successfully'
            ],200);
        }else{
            return response([
                'data' => 'Unauthorize'
            ],401);
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
}
