<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function generateQRCode(Request $request){

        $vendor_vid = auth()->user()->v_id;
        $vendor = Vendor::where('u_id', $vendor_vid)->first();
        $wallet_id = strval($vendor->wallet_id);
        $encrypt = Crypt::encryptString($wallet_id);
        $response = [
            "status" => "Success",
            "code" => 200,
            "encrypted_code" => $encrypt
        ];
        return $response;

    }
}
