<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Http\Controllers\mobile\SmsController;
use App\Http\Requests\mobile\ChangePasswordRequest;
use App\Http\Requests\mobile\ForgetPasswordRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Trait\HttpResponses as TraitHttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;


class ChangePasswordController extends Controller
{
    use traitHttpResponses;

    private $smsController;

    public function __construct(SmsController $smsController)
    {
        $this->smsController = $smsController;
    }

    public function forget(ForgetPasswordRequest $request){

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits_between:10,12',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $user = User::where('phone', $request->input('phone'))->first();
    
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
    
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'phone' => $request->input('phone'),
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        $this->smsController->sendsms($user->phone, $token);
        return response()->json(['success' => 'Password reset link sent to your phone.'], 200);

    

        // if(!Auth::attempt($request->only(['phone_number']))){
        //     return $this->error('', 'user does not exist', '401');
        //  }else{
        //     return 'hmm';
        //  }
        

    }


    public function change(ChangePasswordRequest $request){

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits_between:10,12',
            'token' => 'required|string',
            'password' => 'required|string|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $user = User::where('phone', $request->input('phone'))->first();
    
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
    
        $reset = DB::table('password_reset_tokens')
                    ->where('phone', $request->input('phone'))
                    ->where('token', $request->input('token'))
                    ->first();
    
        if (!$reset) {
            return response()->json(['error' => 'Invalid token.'], 400);
        }
    
        $user->password = Hash::make($request->input('password'));
        $user->save();
    
        DB::table('password_reset_tokens')
            ->where('phone', $request->input('phone'))
            ->where('token', $request->input('token'))
            ->delete();
    
        return response()->json(['success' => 'Password updated successfully.'], 200);
    
        // $request->validated($request->all());

        // if(!Auth::attempt($request->only(['email', 'password']))){
        //     return $this->error('', 'user does not exist', '401');
        //  }

    }
}
