<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;

use App\Http\Requests\mobile\LoginUserRequest as MobileLoginUserRequest;
use App\Http\Requests\mobile\StoreUserRequest as MobileStoreUserRequest;
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
            $alpha = substr(str_shuffle("MNOP"), 0, 1);
            $vendor_account = "{$alpha}{$num}";
            $user = User::where('account', $vendor_account)->first();  
            if ($user === null) {
                return $vendor_account; 
             }else{
                $this->wallet_code();
             }

             // this is subject to test until it breaks to see if it actually works
                                
    }

    public function login(MobileLoginUserRequest $request)
    {
         $request->validated($request->all());
 
         if(!Auth::attempt($request->only(['email', 'password'])) || !Auth::attempt($request->only(['phone_number', 'password']))){
             return $this->error('', 'Email/Phone number or Password dont match', '401');
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
            'account' => $vendor_code,
            'u_id' =>  Str::random(40),
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'fullname' => $request['fullname'],
            'phone_number' => $request['phone_number'],
            'password' => $request['password'],
            'wallet_id' =>  Str::random(20),
            

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
                'fullname' => $vendor->fullname,
                'phone_number' => $vendor->phone_number,
                'email' => $vendor->email,
                'u_id' => $vendor->u_id,
                'next' => 'bank verification'
            ],

            'token' => $token,
        ]);

       

    }


    public function logout(Request $request)
    {
        return 'working';
    }

}
