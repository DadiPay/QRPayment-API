<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class PaymentController extends Controller
{
    //
    public function generateQRCode(Request $request){

        $user = User::where('u_id', $request->input('u_id'))->first();
        $unique_id = strval($user->wallet_id);
        $encrypt = Crypt::encryptString($unique_id);
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
        $vendor = ""; //do a check to find out if it is a vendor using the foreign key from the user object
        if($vendor !== null){
            $response = [
                "vendor_name" => $vendor->fullname,
                "account" => $vendor->bank_account_number,
                "business_category" => $vendor->business_category,
                "phone_number" => $vendor->phone_number
            ];

            return $response;
        }else{
            return response([
                "message" => "Vendor not found"
            ],404);
        }
    }
}
