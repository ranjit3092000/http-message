<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

class AfterAuthApiController extends Controller
{
    public function getUserDetails(Request $request)
    {
        try {
            // Make sure the request expects JSON
            $request->headers->set('Accept', 'application/json');
            
            // Get the authenticated user using the provided token
            $user = JWTAuth::parseToken()->authenticate();
    
            return response()->json(['result' => $user]);
    
        } catch (TokenExpiredException $e) {
            // Return JSON response for expired token
            return response()->json(['error' => 'Token has expired'], 401);
    
        } catch (TokenInvalidException $e) {
            // Return JSON response for invalid token
            return response()->json(['error' => 'Token is invalid'], 401);
    
        } catch (JWTException $e) {
            // Return JSON response for other token errors
            return response()->json(['error' => 'Token is missing or unauthorized'], 401);
        }
    }

    public function Logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function Refresh()
    {
        return response()->json([
            'token' => JWTAuth::refresh(),
        ]);
    }

    public function Support(Request $request){

        $data = new \Stdclass();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'message' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $data = new Support();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->message = $request->message;
        $data->save();

        return response()->json(['status' => 1, 'message' => 'Your support request has been submitted successfully', 'data' => $data]);

    }

    public function editProile(Request $request){
        $data = new \Stdclass();

    }

}

