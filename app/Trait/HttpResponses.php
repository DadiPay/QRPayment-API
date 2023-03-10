<?php

namespace App\Trait;

trait HttpResponses{
    protected function success ($data, $message = null, $code = 200){
        return response()->json([
            'success' => true,
            'status' => 'Request was successful',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error ($data, $message = null, $code = null){
        return response()->json([
            'error' => true,
            'status' => 'An error occurred',
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function paymentInfo ($data, $info = null, $code = 200){
        return response()->json([
            'success' => true,
            'status' => 'Result found',
            'data' => $data
        ]);
    }

    protected function resultSizeError ($resultSize = null, $code){
        return response()->json([
            'success' => true,
            'status' => 'Transaction not found',
            'message' => 'Transaction might take a while to reflect, retry until 5 minutes',
            'Transaction_record' => $resultSize,
            
        ]);
    }

    protected function resultSizeSuccess ($resultSize = null, $load = null){
        $resultSize > 0 ? $resultSize = 1 : $resultSize = 'Error:something happened';
        return response()->json([
            'success' => true,
            'status' => 'Transaction found',
            'message' => 'Perform your desired operation',
            'Transaction_record' => $resultSize,
            'payload' => $load
            
        ]);
    }
}

