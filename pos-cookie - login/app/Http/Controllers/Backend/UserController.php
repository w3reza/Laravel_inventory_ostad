<?php

namespace App\Http\Controllers\Backend;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function Registration(Request $request)
    {
        try {
            $request->validate([
                'firstName' => 'required|string|max:50',
                'lastName' => 'required|string|max:50',
                'email' => 'required|email|string|max:50|unique:users,email',
                'mobile' => 'required|string|max:50',
                'password' => 'required|string|min:3',
            ]);

            $user = new User();
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully',
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }
    public function UserLogin(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|string|max:50',
                'password' => 'required|string|min:3',
            ]);

            $user = User::where('email', $request->input('email'))->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('authToken')->plainTextToken;
                    return response()->json([
                        'status' => 'success',
                        'message' => 'User Login Successfully',
                        'token' => $token,
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'The provided Password are incorrect.',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The provided user is not found.',
                ]);
            }
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function UserProfile(Request $request)
    {
        try {
            return Auth::user();

        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }


    function UserLogout(Request $request){
        // $UserID = Auth::user()->id;
        // dd($UserID);
        //dd($request->all());
        $request->user()->tokens()->delete();


        return response()->json([
            'status' => 'success',
            'message' => 'User Logout Successfully',
        ]);
    }


    // public function UserLogout(Request $request)
    // {
    //     try {
    //         //$request->user()->tokens()->delete();
    //         $request->user()->currentAccessToken()->delete();
    //        //Auth::user()->tokens()->delete();
    //         //return redirect()->route('login');
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'User Logout Successfully',
    //         ]);
    //     } catch (Exception $exception) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $exception->getMessage(),
    //         ]);
    //     }
    // }

    public function UserProfileUpdate(Request $request)
    {
        try {
            $request->validate([
                'firstName' => 'required|string|max:50',
                'lastName' => 'required|string|max:50',
                'email' => 'required|email|string|max:50|unique:users,email,' . $request->user()->id,
                'mobile' => 'required|string|max:50',
            ]);

            user::where('id', Auth::user()->id)->update([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'mobile' => $request->mobile,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User Profile Updated Successfully',
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function SendOTP(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|string|max:50',
            ]);

            $user = User::where('email', $request->email)->first();
            if ($user) {
                $UserEmail = $user->email;
                $otp = rand(1000, 9999);
                User::where('email', $request->email)->update([
                    'otp' => $otp,
                ]);
                Mail::to($UserEmail)->send(new OTPMail($otp));
                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP Send Successfully',
                    'otp' => $otp,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The provided user is not found.',
                ]);
            }
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function VerifyOTP(Request $request){
        try {
            $request->validate([
                'email' => 'required|email|string|max:50',
                'otp' => 'required|string|max:50',
            ]);
            $UserEmail = $request->input('email');
            $otp = $request->input('otp');

            $user = User::where('email','=', $UserEmail)->where('otp','=',  $otp)->first();

            if(!$user){
                return response()->json([
                    'status' => 'error',
                    'message' => 'The provided OTP is not found.',
                ]);
            }

            User::where('email', $UserEmail)->update([
                'otp' => 0,
            ]);

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'OTP Verify Successfully',
                'token' => $token,
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage(),
            ]);
        }
    }

    function ResetPassword(Request $request){

        try{
            $request->validate([
                'password' => 'required|string|min:3'
            ]);
            $id=Auth::id();



            $password=$request->input('password');

            User::where('id','=',$id)->update(['password'=>Hash::make($password)]);
            return response()->json(['status' => 'success', 'message' => 'Request Successful']);

        }catch (Exception $e){
            return response()->json(['status' => 'fail', 'message' => $e->getMessage(),]);
        }
    }
}
