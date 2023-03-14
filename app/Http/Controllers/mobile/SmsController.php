<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /*
    [[[[[[[[[[[[[[[[[[[[[[VERIFY NIN OR BVN]]]]]]]]]]]]]]]]]]]]]]
    */


    public function verification($request)
    {
        // Returns header value with default as fallback
        if(!$request->headers->has('accept')){
            return 'set header properly';
        }

        // Returns boolean
        $request->headers->has('some_header');

        $request->validated($request->all());

        //CALL TO NIN VERIFICATION API TO GET NAME AND PHONE NUMBER
    
        // APPRUVE TEST TOKEN = eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.'eyJpc3MiOiJodHRwczovL2FwaS5hcHBydXZlLmNvIiwianRpIjoiMjBkYzg3MmMtMjIxMi00ODk5LTgzNTItMDQ0ZDIyYjgxMmFiIiwiYXVkIjoiZGVmZGM1MjAtNWRiNi00NjRkLTk5NWQtZmI4Nzk4YzZiYWIzIiwic3ViIjoiYTIwNDFiNGYtN2Q5YS00YWJkLTk4ZWItNDNkZWE3YjkxOGMzIiwibmJmIjowLCJzY29wZXMiOlsidmVyaWZpY2F0aW9uX3ZpZXciLCJ2ZXJpZmljYXRpb25fbGlzdCIsInZlcmlmaWNhdGlvbl9kb2N1bWVudCIsInZlcmlmaWNhdGlvbl9pZGVudGl0eSJdLCJleHAiOjMyNTU4MjUzODYsImlhdCI6MTY3NzkwMjE4Nn0'.l1-cP0Kn4ptVZtLi4GvDTH7GmOoEyPh1wQTstkE02gc

        $response = Http::retry(10, 200)
                    ->withHeaders(['Authorization' => 'Bearer '.env('APPRUVE_TEST') ])
                    ->acceptJson()
                    ->post("https://api.appruve.co/v1/verifications/ng/bvn",[
                        'name' => 'Steve',
                        'role' => 'Network Administrator',
                    ]);
            if ($response['resultSizeEstimate'] == 0) { // if returns no result, tr searching with name, time nd amount
                $this->updateTransaction($request); //update transaction
                return $this->resultSizeError($response['resultSizeEstimate'], '');
            }

    }



    /*
    [[[[[[[[[[[[[[[[[[[[[[OTP MORE]]]]]]]]]]]]]]]]]]]]]]
    */

    public function sendsms($number, $token = null)
    {

        $number = substr($number, 1);
        $number = "234" . $number;
        // return $number;
        if(!$token){
            $response = Http::retry(10, 200)
                // ->withHeaders(['Authorization' => 'Bearer '.env('APPRUVE_TEST') ])
                ->acceptJson()
                ->post("https://api.ng.termii.com/api/sms/send",[
                    'to' => '2349079417401',
                    'from' => 'N-Alert',
                    'sms' => 'Hi there, this is DadiPay digital wallet service, pay for utility',
                    'type' => 'plain',
                    'channel' => 'dnd',
                    'api_key' => env('TERMII_API_KEY'),
                ]);
    
                return $response;
        } else{
            $response = Http::retry(10, 200)
                // ->withHeaders(['Authorization' => 'Bearer '.env('APPRUVE_TEST') ])
                ->acceptJson()
                ->post("https://api.ng.termii.com/api/sms/send",[
                    'to' => '2349079417401',
                    'from' => 'N-Alert',
                    'sms' => 'Hi there, this is DadiPay digital wallet service, your password reset token is '. $token,
                    'type' => 'plain',
                    'channel' => 'dnd',
                    'api_key' => env('TERMII_API_KEY'),
                ]);
    
                return $response;
        }
    }


    public function sendwhatsapp($number)
    {

        $number = substr($number, 1);
        $number = "234" . $number;
        // return $number;
        $curl = curl_init();
        $data = array("api_key" => env('TERMII_API_KEY'), "to" => "2349079417401",  "from" => "TID",
        "sms" => "Hi there, testing Termii ",  "type" => "plain",  "channel" => "whatsapp" );

        $post_data = json_encode($data);

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ng.termii.com/api/sms/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $post_data,
        CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    
    }




    public function sendotpmobile($number)
    {

        $number = substr($number, 1);
        $number = "234" . $number;
        // return $number;
        $response = Http::retry(10, 200)
                ->acceptJson()
                ->post("https://api.ng.termii.com/api/sms/otp/send",[
                    "api_key" => env('TERMII_API_KEY'),
                    "message_type" => "NUMERIC",
                    "to" => "2349079417401",
                    "from" => "DadiPay",
                    "channel" => "generic",
                    "pin_attempts" => 10,
                    "pin_time_to_live" =>  10,
                    "pin_length" => 4,
                    "pin_placeholder" => "< 7878 >",
                    "message_text" => "Your DadiPay pin is < 7878 >. It will expire in 5 minutes",
                    "pin_type" => "NUMERIC",
                ]);
                return $response;
    }






    public function sendotpmail($email)
    {

       $response = Http::retry(10, 200)
                ->acceptJson()
                ->post("https://api.ng.termii.com/api/email/otp/send",[
                    "email_address" => "drrowly99@gmail.com", 
                    "code" => "12345", 
                    "api_key" => env('TERMII_API_KEY'),  
                    "email_configuration_id" => "44b10130-7e72-415b-8261-f8394b262ee8"
                ]);
                return $response;

    
    }    

    public function verifyotp($pin, $id)
    {
        $response = Http::retry(10, 200)
                ->withHeaders(['Authorization' => 'Bearer '.env('APPRUVE_TEST') ])
                ->acceptJson()
                ->post("https://api.ng.termii.com/api/sms/otp/verify",[
                    "api_key" => env('TERMII_API_KEY'),
                    "pin_id" => $id,
                    "pin" => $pin,
                ]);
                return $response;

         
    }


    public function help(string $request){
        return $request;
    }   
}
