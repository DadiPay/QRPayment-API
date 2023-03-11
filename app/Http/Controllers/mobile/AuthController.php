<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;

use App\Http\Requests\mobile\LoginUserRequest as MobileLoginUserRequest;
use App\Http\Requests\mobile\StoreUserRequest as MobileStoreUserRequest;
use App\Http\Requests\mobile\UpdateSetPinRequest as MobileUpdateSetPinRequest;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Vendor;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Trait\HttpResponses as TraitHttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   
    use traitHttpResponses;

    public function wallet_code()
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
 
    
         if(!Auth::attempt($request->only(['email', 'password']))){
            return $this->error('', 'user does not exist', '401');
         }elseif(!Auth::attempt($request->only(['phone_number', 'password']))){
            return $this->error('', 'user does not exist pass', '401');
         }
         $user = User::where('email', $request->email)->first();
 
         $token = $user->createToken('myappToken')->plainTextToken;
 
         return $this->success ([
             'user' => [
                 'fullname' => $user->fullname,
                 'account' => $user->account,
                 'wallet_amount' => $user->wallet_amount,
                 'phone_number' => $user->phone_number,
                 'email' => $user->email,
                 'u_id' => $user->u_id,
             ],
             'token' => $token,
         ]);
    }











    public function verifyBank(MobileLoginUserRequest $request)
    {
         $request->validated($request->all());
 
         $user = User::where('u_id', $request->u_id)->first();
 
         $update = User::where('u_id', $request->u_id)
                ->update([
                    'firstname' => $request->firstname, 
                    'lastname' => $request->lastname, 
                    'middlename' => $request->middlename, 
                    'bank_name' => $request->bank_name, 
                    'bank_account_no' => $request->bank_account_no, 
                    'verified_bank_user' => $request->bank_account_no, 
                ]);
                $token = $user->createToken("API TOKEN OF {$request['firstname']}")->plainTextToken;
                return $this->success ([
                    'user' => [
                        'firstname' => $update->firstname,
                        'phone_number' => $update->phone_number,
                        'email' => $update->email,
                        'u_id' => $update->u_id,
                        'next' => 'Set pin'
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
        $user_account = $this->wallet_code();


        $user = User::create([
            'account' => $user_account,
            'u_id' =>  Str::random(40),
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'fullname' => $request['fullname'],
            'phone_number' => $request['phone_number'],
            'password' => bcrypt($request['password']),
            'wallet_id' =>  Str::random(20),
            
        ]);

        $token = $user->createToken("API TOKEN OF {$request['fullname']}")->plainTextToken;

        return $this->success ([
            'user' => [
                'fullname' => $user->fullname,
                'phone_number' => $user->phone_number,
                'email' => $user->email,
                'u_id' => $user->u_id,
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
