<?php
namespace App\Http\Controllers\AppApi;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

class PublicApiController extends Controller
{
    use Helpers;

    protected function respondForAuth($status, $code, $message, $token=null, $user=null){
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'token' => $token,
            'user' => $user
        ]);
    }

    protected function respondForDataMerge($status, $code, $message, $data=null){
        return response()->json(collect([
            'status' => $status,
            'code' => $code,
            'message' => $message
        ])->merge($data));
    }

    public function respondForData($status, $code, $message, $data=null){
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
    protected function respondForAction($status, $code = 200, $message="success"){
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message
        ]);
    }

    protected function respondForSearch($status, $code, $message, $requests=null, $artist=null){
        return response()->json([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'requests' => $requests,
            'artists' => $artist
        ]);
    }
}