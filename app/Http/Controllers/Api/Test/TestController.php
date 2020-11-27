<?php

namespace App\Http\Controllers\Api\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * api/test
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function test(){
        return response()->json(array(
           'status' => 200,
            'message' => "wersja nie 216532 ktora CI CD"
        ));
    }
}
