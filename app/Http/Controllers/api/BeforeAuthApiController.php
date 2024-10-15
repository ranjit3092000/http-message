<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Appuser;
use App\Models\Appuserdevice;
use \StdClass;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth; 


class BeforeAuthApiController extends Controller
{

    public function Register(Request $request)
    {
        $data = [];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:appuser',
            'password' => 'required|string|min:4',
            'device_unique_id' => 'required',
            'device_type' => 'required',
            'os_version' => 'required',
            'app_version' => 'required',
            'device_token' => 'required',
            'device_name' => 'required',
        ]);

        if ($validator->fails()) {
            $error = json_decode($validator->errors());
            return response()->json(['data' => $data, 'message' => $validator->errors()->first(), 'status' => 0]);
        }

        
        $admin = Appuser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        $token = JWTAuth::fromUser($admin);

        $appuser_device = Appuserdevice::insert([
            'appuser_id' => $admin->id,
            'device_unique_id' => $request->device_unique_id,
            'device_type' => $request->device_type,
            'os_version' => $request->os_version,
            'app_version' => $request->app_version,
            'device_token' => $request->device_token,
            'device_name' => $request->device_name,
            'jwt_token' => $token,
        ]);

        $data = userObject($admin->id);

        // dd($data);
        return response()->json([
            'status' => 200,
            'message' => 'Registered Successfully',
            'data' => $data
        ]);
    }

    public function Login(Request $request)
    {
        $data = new \Stdclass();

        // Validate the request
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|string|email|max:255',
            // 'device_unique_id' => 'required',
            // 'device_type' => 'required',
            // 'os_version' => 'required',
            // 'app_version' => 'required',
            'password' => 'required|min:6',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['data' => $data, 'message' => $validator->errors()->first(), 'status' => 0]);
        }

        // Check if user exists
        $user = Appuser::where('email', $request->input('email'))->first();
        // if (!$user) {
        //     return response()->json(['data' => $data, 'message' => 'User not found', 'status' => 0]);
        // }

        // $data = userObject($user->id);
        
        // Attempt to authenticate and generate a JWT token
        if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {
            return response()->json(['data' => $data, 'message' => 'Unauthorized', 'status' => 0]);
        }

        // $appuser_device = Appuserdevice::insert([
        //     'appuser_id' => $user->id ??'',
        //     'device_unique_id' => $request->device_unique_id??'',
        //     'device_type' => $request->device_type??'',
        //     'os_version' => $request->os_version??'',
        //     'app_version' => $request->app_version??'',
        //     'device_token' => $request->device_token??'',
        //     'device_name' => $request->device_name??'',
        //     'jwt_token' => $token??'',
        // ]);

        // Return the JWT token on success
  
        return $this->respondWithToken($token);
    }

    // public function Login(Request $request)
    // {
    //     $data = new \Stdclass();

    //     // Validate the request
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|string|email|max:255',
    //         'password' => 'required|string|min:4',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['data' => $data, 'message' => $validator->errors()->first(), 'status' => 0]);
    //     }

    //     // Check if user exists
    //     $user = Appuser::where('email', $request->input('email'))->first();
    //     if (!$user) {
    //         return response()->json(['data' => $data, 'message' => 'User not found', 'status' => 0]);
    //     }
        
    //     // Check credentials manually
    //     if (!Auth::attempt($request->only('email', 'password'))) {
    //         dd($request);
    //         return response()->json(['data' => $data, 'message' => 'Invalid credentials', 'status' => 0]);
    //     }

    //     // Attempt to authenticate and generate a JWT token
    //     if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {
    //         return response()->json(['data' => $data, 'message' => 'Unauthorized', 'status' => 0]);
    //     }

    //     // Return the JWT token on success
    //     return $this->respondWithToken($token);
    // }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'status' => 1
        ]);
    }
    
}
