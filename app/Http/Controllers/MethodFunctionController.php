<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\MockProjectMethod;
use App\Models\MockRequestLog;
use Illuminate\Http\Request;
use App\Models\MockProject;

class MethodFunctionController extends Controller
{
    function set_request_log($type,$method_id,$name,$request_url,$request_body,$request_method,$response){
        $creat_time=date('Y-m-d h:i:s', time());
        $log=array(
            "id"=>"",
            "type"=>$type,
            "method_id"=>$method_id,
            "name"=>$name,
            "request_url"=>$request_url,
            "request_body"=>$request_body,
            "request_method"=>$request_method,
            "response"=>$response,
            "creat_time"=>$creat_time
        );
        $result=MockRequestLog::insert($log);
//        dd($result);
        if ($result != true) {
            echo "新记录插入失败";
        }



    }

    public static function getmethod_uri($uri)
    {
        $methodRes = MockProjectMethod::get();
        foreach (json_decode($methodRes) as $value) {
            $method_uri = $value->uri;
            if (strpos($uri, $method_uri) or strpos($uri, $method_uri) === 0) {
                $method_uri = $method_uri;
                return $method_uri;
            }

        }
    }

    public static function getmethod_id($data, $uri) #$data不要删除，下面的$rule 规则里需要用到
    {
        $methodRes = MockProject::select(
            'mock_project.id',
            'mock_project_method.project_id',
            'mock_project.rule',
            'mock_project_method.id',
            'mock_project_method.name',
            'mock_project_method.route'
        )->leftJoin('mock_project_method', 'mock_project.id', 'mock_project_method.project_id')
            ->where('mock_project_method.uri', $uri)
            ->get();

        foreach ($methodRes as $methodRe) {
            $rule = $methodRe->rule;
            $route = $methodRe->route;
            if (strlen($route) != 0) {
                eval($rule);
                if ($route == $value) {
                    $method_id = $methodRe->id;
                    $name = $methodRe->name;
                    $result = array(
                        "method_id" => $method_id,
                        "name" => $name
                    );

                    return $result;
                }
            }
            else {
                $method_id = $methodRe->id;
                $name = $methodRe->name;
                $result = array(
                    "method_id" => $method_id,
                    "name" => $name
                );

                return $result;

            }

        }
        $result = array(
            "method_id" => 0,
            "name" => "未找到方法"
        );

        return $result;
    }


    public static function getvin()
    {
        $chars = array(
            "A",
            "B",
            "C",
            "D",
            "E",
            "F",
            "G",
            "H",
            "I",
            "J",
            "K",
            "L",
            "M",
            "N",
            "O",
            "P",
            "Q",
            "R",
            "S",
            "T",
            "U",
            "V",
            "W",
            "X",
            "Y",
            "Z",
            "0",
            "1",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9"
        );


        $charsLen = count($chars) - 1;
        shuffle($chars);                            //打乱数组顺序
        $str = '';
        for ($i = 0; $i < 17; $i++) {
            $str .= $chars[mt_rand(0, $charsLen)];    //随机取出一位
        }
        return $str;
    }

    public static function gettongdun_id()
    {
        $time = time();
        $n = rand(0, 9);
        $id = "WF20181207180" . $time . $n;
        return $id;
    }

    public static function getcreatbusinessno()
    {
        $Businessno = "CL" . time() . "000";;
        return $Businessno;
    }

    public static function getbusinessno($data)
    {
        $Businessno = json_decode($data)->Businessno;
        // echo "12312";
        return $Businessno;
    }

    public static function getestageOrderNo()
    {
        $estageOrderNo = 'test' . md5(time());
        return $estageOrderNo;
    }

    public static function getorderNo($data)
    {
        $orderNo = json_decode($data)->pub->orderNo;
        return $orderNo;


    }

    public static function getSign($data, $businessno, $status)
    {
        $Sign = md5("message=测试回调" . "ordernum=" . $businessno . "status=" . $status . "statusdes=订单状态tokenid=119userid=1122408895b2e-1f70-4539-97a2-3454f8986b08");
        $Sign = strtoupper($Sign);
        return $Sign;

    }

    public static function get_url($platform, $env)
    {

        $url = "http://" . $env . "-" . $platform . "-docker-" . $env . ".beta.saasyc.com";
        return $url;

    }
}
