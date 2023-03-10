<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use Illuminate\Support\Facades\Http;

class Sms_tokenController extends Controller
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

        // $update = User::where('phone_number', '92093034')
        //         ->update([
        //             'firstname' => $request['firstname'],
        //             'middlename' => $request['middlename'],
        //             'lastname' => $request['lastname'],
        //             'NIN' => $request['lastname'],
        //             'DOB' => $request['lastname'],
                 
        //         ]);


        // return $this->success ([
        //     'user' => [
        //         'firstname' => $update->firstname,
        //         'middlename' =>  $update->middlename,
        //         'lastname' =>  $update->lastname,
         
        //     ],

        //     // 'token' => $token,
        // ]);
    }



    /*
    [[[[[[[[[[[[[[[[[[[[[[OTP MORE]]]]]]]]]]]]]]]]]]]]]]
    */

    public function sendsms()
    {

        $response = Http::retry(10, 200)
                ->withHeaders(['Authorization' => 'Bearer '.env('SEND_CHAMP') ])
                ->acceptJson()
                ->post("https://api.sendchamp.com/api/v1/sms/send",[
                    'to' => '2349067082842',
                    'sender_name' => 'DAlert',
                    'message' => 'Hi there, welcome to DadiPay digital wallet service',
                    'route' => 'dnd',
                ]);
        return $response;

        // $response = Http::retry(10, 200)
        //         // ->withHeaders(['Authorization' => 'Bearer '.env('APPRUVE_TEST') ])
        //         ->acceptJson()
        //         ->post("https://api.ng.termii.com/api/sms/send",[
        //             'to' => '2349079417401',
        //             'from' => 'fastBeep',
        //             'sms' => 'Hi there, welcome to DadiPay digital wallet service',
        //             'type' => 'plain',
        //             'channel' => 'generic',
        //             'api_key' => env('TERMII_API_KEY'),
        //         ]);
    
    }




    public function sendotp()
    {
        // $obj = ['description' => 'demo'];

        // $response = Http::retry(10, 200)
        // ->withHeaders(['Authorization' => 'Bearer '.env('SEND_CHAMP') ])
        // ->acceptJson()
        // ->post("https://api.sendchamp.com/api/v1/verification/create",[
        //     'channel' => 'sms',
        //     'sender' => 'DAlert',
        //     'token_type' => 'numeric',
        //     'token_length' => '5',
        //     'expiration_time' => '60',
        //     'customer_mobile_number' => '2349079417401',
        //     'meta_data'=>  array ('description' => 'demo'),
          
       
        // ]);
        // return $response;

 
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.sendchamp.com/api/v1/verification/create',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "channel":"sms",
    "sender":"Sendchamp",    
    "token_type":"numeric",
    "token_length":"5",
    "expiration_time":60,
    "customer_mobile_number":"2349079417401",
    "customer_email_address":"drrowly99@gmail.com"
   
}',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Authorization: Bearer '.env('SEND_CHAMP') ,
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;




        // $response = Http::retry(10, 200)
        //         // ->withHeaders(['Authorization' => 'Bearer '.env('APPRUVE_TEST') ])
        //         ->acceptJson()
        //         ->post("https://api.ng.termii.com/api/sms/otp/send",[
        //             "api_key" => env('TERMII_API_KEY'),
        //             "message_type" => "NUMERIC",
        //             "to" => "09079417401",
        //             "from" => "fastBeep",
        //             "channel" => "dnd",
        //             "pin_attempts" => 10,
        //             "pin_time_to_live" =>  5,
        //             "pin_length" => 4,
        //             "pin_placeholder" => "< 7878 >",
        //             "message_text" => "Your pin is < 7878 >",
        //             "pin_type" => "NUMERIC",
        //         ]);
        //         return $response;
    }
    
    public function verifyotp()
    {
        // $response = Http::retry(10, 200)
        //         ->withHeaders(['Authorization' => 'Bearer '.env('APPRUVE_TEST') ])
        //         ->acceptJson()
        //         ->post("https://api.ng.termii.com/api/sms/otp/verify",[
        //             "api_key" => "Your API key",
        //             "pin_id" => "NUMERIC",
        //             "pin" => "eg. 2348109077743",
        //         ]);

                $response = Http::retry(10, 200)
                ->withHeaders(['Authorization' => 'Bearer '.env('SEND_CHAMP') ])
                ->acceptJson()
                ->post("https://api.sendchamp.com/api/v1/verification/confirm",[
           
                    "verification_reference" => "MN-OTP-0963d8ee-23df-488e-8dc6-20229999b1e1",
                    "verification_code" => "02341",
                ]);

                return $response;
                
         
    }


    public function help(string $request){
        return $request;
    }   
}
