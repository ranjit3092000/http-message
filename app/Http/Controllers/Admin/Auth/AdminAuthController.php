<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Appuser;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login()
    {
        return view('Admin.Auth.login');
    }

    public function loginredirect(Request $request)
    {

        $rules = array(
            'email' => 'required|email',
            'password' => 'required',
        );

        $validatorMesssages = array(
            'email.required' => "Email id required",
            'password.required' => "Password id required",
        );

        $validator = Validator::make($request->all(), $rules, $validatorMesssages);
        if ($validator->fails()) {
            $error = json_decode($validator->errors());
            return response()->json(['status' => 401, 'error1' => $error]);
        }

        $admin = Appuser::where('email', $request->email)->first();
        if (empty($admin)) {
            $error = ['email' => "Email Not Found"];
            return response()->json(['status' => 401, 'error1' => $error]);
        }
        $encryptedPassword = $request->password;
        if ($encryptedPassword === $admin->password) {
            Auth::login($admin);
            $redirect = url('/');
            // dd($redirect);
            return response()->json([
                'status' => 200,
                'redirect' => route('welcome') // Replace with your intended route
            ]);
        } else {
            $error = ['password' => "Wrong Password"];
            return response()->json(['status' => 401, 'error1' => $error]);
        }

        return view('welcome');
    }


    public function dashboard(){
        
        return view('welcome');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }


    public function register(Request $request){

        return view('Admin.Auth.register');
    }

    public function store(Request $request){

        // dd('hi');
        $rules = array(
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:appuser,email',
            'password' => 'required|min:4|confirmed',
            // 'terms' => 'accepted',
        );  

        $validatorMesssages = array(
            'name.required' => "Name required",
            'email.required' => "Email required",
            'password.required' => "Password required",
        );

        $validator = Validator::make($request->all(), $rules, $validatorMesssages);

        if ($validator->fails()) {
            $error = json_decode($validator->errors());
            return response()->json(['status' => 401, 'error1' => $error]);
        }

        $admin = Appuser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]); 

        return response()->json([
            'status' => 1,
            'redirect' => route('login')
        ]);
    }

}
