<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MethodFunctionController;
use App\Http\Controllers\Controller;
use App\Models\MockProject;
use App\Models\MockProjectMethod;
use Illuminate\Http\Request;

class MethodController extends MethodFunctionController
{
    public function methodRes(Request $request)
    {
        $uri = '/' . trim($request->uri, '/');
        $request_uri = MethodFunctionController::getmethod_uri($uri);
        $request_method=$request->method();
        $url="http://".$request->getHttpHost().$request->getRequestUri();
        $data =json_encode( $request->all());
        $getmethod=MethodFunctionController::getmethod_id($data,$request_uri);
        $method_name=$getmethod["name"];
        $error_result=json_encode(array("url"=>$url,"method"=>$request_method,"body"=>$data));
        $method_id=$getmethod["method_id"];
        $response=MethodFunctionController::method_request($method_id,$data,$error_result);
        MethodFunctionController::set_request_log("request",$method_id,$method_name,$url,$data,$request_method,$response);
        return response()->json(json_decode($response, true));

    }

}
