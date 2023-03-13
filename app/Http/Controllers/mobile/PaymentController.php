<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class PaymentController extends Controller
{
    //
    public function generateQRCode(Request $request){

        $user_uid = auth()->user()->u_id;
        $user = User::where('u_id', $user_uid)->first();
        $wallet_id = strval($user->wallet_id);
        $encrypt = Crypt::encryptString($wallet_id);
        $response = [
            "status" => "Success",
            "code" => 200,
            "encrypted_code" => $encrypt
        ];
        return $response;

    }

    public function generatePaymentDetails(Request $request, $code){
        
        $encrypted_string = $code;
        $decrypt = Crypt::decryptString($encrypted_string);
        $user = User::where('wallet_id', $decrypt)->first();
        $vendor = Vendor::where('wallet_id', $decrypt)->first();

        if($vendor !== null){
            $response = [
                "vendor_name" => $vendor->fullname,
                "account" => $vendor->bank_account_number,
                "business_category" => $vendor->business_category,
                "phone_number" => $vendor->phone_number
            ];

            return $response;
        }elseif($user !== null){
            $response = [
                "vendor_name" => $user->fullname,
                "account" => $user->bank_account_number,
                "phone_number" => $user->phone_number
            ];
            return $response;
        } else{
            return response([
                "message" => "Vendor/User not found"
            ],404);
        }
    }
}
