<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponseTrait
{
    public function successResponse($data){
        return response()->json([
            "status" => true,
            "message" => "Successful",
            "data" => $data,
        ], 200
        );
    }
    public function errorResponse($message){
        return response()->json([
            "status" => false,
            "message" => $message != null ? $message : "Something went wrong."
        ], 404
        );
    }
}