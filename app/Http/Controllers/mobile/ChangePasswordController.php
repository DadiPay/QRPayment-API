<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\mobile\ChangePasswordRequest;
use App\Http\Requests\mobile\ForgetPasswordRequest;
use Illuminate\Http\Request;
use App\Trait\HttpResponses as TraitHttpResponses;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    use traitHttpResponses;


    public function forget(ForgetPasswordRequest $request){

        $request->validated($request->all());

        if(!Auth::attempt($request->only(['phone_number']))){
            return $this->error('', 'user does not exist', '401');
         }else{
            return 'hmm';
         }
        

    }


    public function change(ChangePasswordRequest $request){

        $request->validated($request->all());

        if(!Auth::attempt($request->only(['email', 'password']))){
            return $this->error('', 'user does not exist', '401');
         }

    }
}
