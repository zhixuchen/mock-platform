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
        $method_id=$getmethod["method_id"];
        $method_name=$getmethod["name"];
        $methodRes = MockProjectMethod::where('id', $method_id)->first();
        $error_result=array("url"=>$url,"method"=>$request_method,"body"=>$data);
        $error_result=json_encode($error_result);
        $response = $methodRes->result ?? $error_result;
        $methodPragram = $methodRes->pragram ?? '';
        $pragrams = explode(',', $methodPragram);
        foreach ($pragrams as $pragram) {
            if ($pragram == "vin") {
                $vin = MethodFunctionController::getvin();
                $response = str_replace("{{vin}}", $vin, $response);
            } elseif ($pragram == "tongdun_id") {
                $tongdun_id = MethodFunctionController::gettongdun_id();
                $response = str_replace("{{tongdun_id}}", $tongdun_id, $response);

            } elseif ($pragram == "creatbusinessno") {
                $businessno = MethodFunctionController::getcreatbusinessno();
                $response = str_replace("{{businessno}}", $businessno, $response);

            } elseif ($pragram == "businessno") {

                $businessno = MethodFunctionController::getbusinessno($data);
                $response = str_replace("{{businessno}}", $businessno, $response);

            } elseif ($pragram == "estageOrderNo") {
                $estageOrderNo = MethodFunctionController::getestageOrderNo();
                $response = str_replace("{{estageOrderNo}}", $estageOrderNo, $response);


            } elseif ($pragram == "orderNo") {
                $orderNo = MethodFunctionController::getorderNo($data);
                $response = str_replace("{{orderNo}}", $orderNo, $response);


            }

        }
        MethodFunctionController::set_request_log("request",$method_id,$method_name,$url,$data,$request_method,$response);

        return response()->json(json_decode($response, true));

    }
}
