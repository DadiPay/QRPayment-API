<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\mobile\UpdateSetPinRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Trait\HttpResponses as TraitHttpResponses;

class SetPinController extends Controller
{
    use traitHttpResponses;
    public function setPin(UpdateSetPinRequest $request)
    {
    
        $request->validated($request->all());
        $user = User::where('u_id', auth()->user()->u_id)->first();
        if($user){
            $update = User::where('u_id', auth()->user()->u_id)
                ->update([
                    'pin' => $request->input('pin'), 
                ]);

                if($update){
                    return $this->success ([
                        'user' => [
                            'fullname' => $user->fullname,
                            'phone_number' => $user->phone_number,
                            'email' => $user->email,
                            'u_id' => $user->u_id,
                            'next' => 'Dashboard'
                        ],
            
                    ]); 
            }

        }else{
            return response()->json(['error' => 'User not found.'], 404);
        }
    }

}
