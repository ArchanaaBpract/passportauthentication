<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Auth;


class UsersController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors(), 'status' => false], 422);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
      
        /**Take note of this: Your user authentication access token is generated here **/
        $data['token'] =  $user->createToken('MyApp')->accessToken;
        $data['name'] =  $user->name;

        return response(['data' => $data, 'message' => 'Account created successfully!', 'status' => true]);
    }  

      /**
     * login user to our application
     */
    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = ['token' => $token];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);
        }
    }


    /**
     * logout user
     */
    public function logout (Request $request) {
        $user = auth()->user()->token();
        dd($user);
        $user->revoke();
        return 'logged out'; 
    }




    /**
     * refresh token
     */


    // public function refresh()
    // {
    //    $http = new Client();
    
    //    $response = $http->post('http://localhost/token/public/oauth/token', [
    //               'form_params' => [
    //                     'grant_type'    => 'refresh_token',
    //                     'client_id' => 1,
    //                     'client_secret' => '*******',
    //                     'refresh_token' => '',
    //                     'scope'         => '*',
    //                 ],
    //             ]);
    
    //    $data = json_decode((string)$response->getBody(), true);
    
    //    return [
    //       'access_token' => $data['access_token'],
    //       'expires_in'   => $data['expires_in']       
    //    ];
    // }
    public function get()
    {
        return 1;
    }

     
}