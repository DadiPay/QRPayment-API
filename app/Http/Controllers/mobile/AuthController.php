<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\mobile\LoginUserRequest as MobileLoginUserRequest;
use App\Http\Requests\mobile\mobile\StoreUserRequest as MobileStoreUserRequest;
use App\Http\Requests\StorePersonalRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\StoreVendorRequest;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Vendor;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Trait\HttpResponses as TraitHttpResponses;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   
    use traitHttpResponses;

    public function wallet_code($vendor_account = NULL)
    {     

            $num = substr(str_shuffle("0123456789"), 0, 4);
            $alpha = substr(str_shuffle("MNO"), 0, 1);
            $vendor_account = "{$num}{$alpha}";
            return $vendor_account;      
                                
    }

    public function login(MobileLoginUserRequest $request)
    {
         $request->validated($request->all());
 
         if(!Auth::attempt($request->only(['email', 'password']))){
             return $this->error('', 'Email or Password dont match', '401');
         }
 
         $user = User::where('email', $request->email)->first();
 
 
         $token = $user->createToken('myappToken')->plainTextToken;
 
         return $this->success ([
             'user' => [
                 'firstname' => $user->firstname,
                 'lastname' => $user->lastname,
                 'dadi_code' => $user->dadi_code,
                 'phone_number' => $user->phone_number,
                 'email' => $user->email,
             ],
             'token' => $token,
         ]);
    }

    public function register(MobileStoreUserRequest $request)
    {
        // Returns header value with default as fallback
        if(!$request->headers->has('accept')){
            return 'set header properly';
        }

        // Returns boolean
        $request->headers->has('some_header');

        $request->validated($request->all());
        if(Auth::attempt($request->only(['email']))){
            return $this->errors('', 'User already exists', '204');
        }

        //set client code
        $vendor_code = $this->wallet_code($request['vendor_id']);


        $vendor = User::create([
            'dadi_code' => $vendor_code,
            'vendor_id' =>  Str::random(40),
            'u_id' =>  Str::random(15),
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'firstname' => $request['firstname'],
            'middlename' => $request['middlename'],
            'lastname' => $request['lastname'],
            'phone_number' => $request['phone_number'],
            // 'banking_status' => $request['banking_status'],
            // 'vendor_category' => $request['vendor_category'],
            // 'business_address' => $request['business_address'],
            // 'home_address' => $request['home_address'],
            // 'NIN' => $request['NIN'],
            // 'BVN' => $request['BVN'],
            // 'NOK' => $request['NOK'],
            // 'NOK_number' => $request['NOK_number'],
            // 'NOK_address' => $request['NOK_address'],
        ]);

        $token = $vendor->createToken("API TOKEN OF {$request['firstname']} {$request['middlename']} {$request['lastname']}")->plainTextToken;

        return $this->success ([
            'user' => [
                'firstname' => $vendor->firstname,
                'lastname' => $vendor->lastname,
                'middlename' => $vendor->middlename,
                'phone_number' => $vendor->phone_number,
                'email' => $vendor->email,
                'vendor_id' => $vendor->vendor_id,
            ],

            'token' => $token,
        ]);

       

    }


    public function logout(Request $request)
    {
        return 'working';
    }

}
