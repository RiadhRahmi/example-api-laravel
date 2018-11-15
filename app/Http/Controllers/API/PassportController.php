<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;

class PassportController extends Controller
{
//
    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $user['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(['data' => $user, 'status' => $this->successStatus]);
        } else {
            return response()->json(['data' => 'Unauthorised', 'status' => 401]);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors(), 'status' => 401]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['role'] = User::EDITOR;
        $user = User::create($input);
        $user['token'] = $user->createToken('MyApp')->accessToken;

        return response()->json(['data' => $user, 'status' => 201]);
    }


    public function logout(Request $request)
    {
        $accessToken = Auth::user()->token();
//      DB::table('oauth_refresh_tokens')
//          ->where('access_token_id', $accessToken->id)
//          ->update([
//              'revoked' => true
//          ]);

        $accessToken->revoke();
        return response()->json(['data' => 'Logout Successful', 'status' => $this->successStatus]);
    }


}


//Personal access client created successfully.
//Client ID: 1
//Client Secret: f4SP4pcLPm8Cyfa9KF9ZxfCSNHOlDw3pP6jBlxiQ
//Password grant client created successfully.
//Client ID: 2
//Client Secret: MKu7SlS7sfcnWkPoVXiRTebCuR9Ii0OGOSQuMnqr
