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
        MethodFunctionController::getmethod_id($request_uri);
        $data = $request->all();
        $methodRes = MockProjectMethod::where('uri', $request_uri)->first();
        $response = $methodRes->result ?? '';
        $methodPragram = $methodRes->pragram ?? '';
        $pragrams = explode(',', $methodPragram);
        foreach ($pragrams as $pragram) {
            if ($pragram == "vin") {
                $vin = MethodFunctionController::getvin();
                $json_result = str_replace("{{vin}}", $vin, $response);
            } elseif ($pragram == "tongdun_id") {
                $tongdun_id = MethodFunctionController::gettongdun_id();
                $json_result = str_replace("{{tongdun_id}}", $tongdun_id, $response);

            } elseif ($pragram == "creatbusinessno") {
                $businessno = MethodFunctionController::getcreatbusinessno();
                $json_result = str_replace("{{businessno}}", $businessno, $response);

            } elseif ($pragram == "businessno") {

                $businessno = MethodFunctionController::getbusinessno($data);
                $json_result = str_replace("{{businessno}}", $businessno, $response);

            } elseif ($pragram == "estageOrderNo") {
                $estageOrderNo = MethodFunctionController::getestageOrderNo();
                $json_result = str_replace("{{estageOrderNo}}", $estageOrderNo, $response);


            } elseif ($pragram == "orderNo") {
                $orderNo = MethodFunctionController::getorderNo($data);
                $json_result = str_replace("{{orderNo}}", $orderNo, $response);


            }

        }


        $res = MockProject::select(
            'mock_project.id',
            'mock_project_method.project_id',
            'mock_project.rule',
            'mock_project_method.id',
            'mock_project_method.name',
            'mock_project_method.route'
        )->leftJoin('mock_project_method', 'mock_project.id', 'mock_project_method.project_id')
            ->where('mock_project_method.uri', $uri)
            ->get()->toArray();
        dd($res);
        return $json_result;

    }
}
