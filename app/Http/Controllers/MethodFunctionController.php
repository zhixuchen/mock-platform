<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\MockProjectMethod;
use Illuminate\Http\Request;

class MethodFunctionController extends Controller
{
    public static function getmethod_uri($uri){
        $methodRes = MockProjectMethod::get();
        foreach  (json_decode($methodRes) as $value){
            $method_uri=$value->uri;
            if(strpos($uri,$method_uri) or strpos($uri,$method_uri)===0) {
                $method_uri = $method_uri;
                return $method_uri;
            }

        }
//        $conn=mysql::mysql_connect();
//        $result = $conn->query($sql);
//        if ($result->num_rows > 0) {
//
//            while($row = $result->fetch_assoc()) {
//
//                if(strpos($uri,$row["uri"]) or strpos($uri,$row["uri"])===0){
//                    $method_uri=$row["uri"];
//                    return $method_uri;
//
//                }
//            }}

//        mysqli_close($conn);
    }

    public static function getmethod_id($uri)
    {
        $method_uri = MethodFunctionController::getmethod_uri($uri);
        $methodRes = MockProjectMethod::where('uri', $method_uri);
        foreach (json_decode($methodRes) as $methodRe) {
            $rule = $methodRe->rule;
            eval($rule);
            var_dump($value);
        }
    }


    public static function getvin(){
        $chars = array(
            "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );


        $charsLen = count($chars) - 1;
        shuffle($chars);                            //打乱数组顺序
        $str = '';
        for($i=0; $i<17; $i++){
            $str .= $chars[mt_rand(0, $charsLen)];    //随机取出一位
        }
        return $str;
    }

    public static function gettongdun_id(){
        $time = time();
        $n = rand(0, 9);
        $id = "WF20181207180" . $time . $n;
        return $id;
    }

    public static function getcreatbusinessno(){
        $Businessno="CL".time() . "000";;
        return $Businessno;
    }

    public static function getbusinessno($data){
        $Businessno=json_decode($data)->Businessno;
        // echo "12312";
        return $Businessno;
    }

    public static function getestageOrderNo(){
        $estageOrderNo='test'.md5(time());
        return $estageOrderNo;
    }

    public static function getorderNo($data){
        $orderNo=json_decode($data)->pub->orderNo;
        return $orderNo;


    }

    public static function getSign($data,$businessno,$status){
        $Sign=md5("message=测试回调"."ordernum=".$businessno."status=".$status. "statusdes=订单状态tokenid=119userid=1122408895b2e-1f70-4539-97a2-3454f8986b08");
        $Sign=strtoupper($Sign);
        return $Sign;

    }

    public static function get_url($platform,$env){

        $url="http://".$env."-".$platform."-docker-".$env.".beta.saasyc.com";
        return $url;

    }
}
