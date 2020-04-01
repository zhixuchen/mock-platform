<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\MockProjectMethod;
use App\Models\MockRequestLog;
use Illuminate\Http\Request;
use App\Models\MockProject;

class MethodFunctionController extends Controller
{

    public static function  method_callback($project,$platform,$env,$status,$businessno)
    {
        $callbackRes = MockProject::select(
            'mock_callback.pragram',
            'mock_callback.project_id',
            'mock_callback.request_uri',
            'mock_callback.id',
            'mock_callback.name',
            'mock_callback.status',
            'mock_callback.request_body'
        )->leftJoin('mock_callback', 'mock_project.id', 'mock_callback.project_id')
            ->where('mock_project.project', $project)
            ->get();
        foreach ($callbackRes as $callback) {
            if ($status == $callback->status) {
                $data = $callback->request_body;
                $pragrams = explode(',', $callback->pragram);
                foreach ($pragrams as $pragram) {
                    if ($pragram == "OrderNum") {
                        $OrderNum = $businessno;
                        $data = str_replace("{{OrderNum}}", $OrderNum, $data);
                    } elseif ($pragram == "Sign") {
                        $Sign = MethodFunctionController::getSign($data, $businessno, $status);
                        $data = str_replace("{{Sign}}", $Sign, $data);
                    } elseif ($pragram == "businessno") {
                        $data = str_replace("{{businessno}}", $businessno, $data);
                    } elseif ($pragram == "orderNo") {
                        $data = str_replace("{{orderNo}}", $businessno, $data);
                    } elseif ($pragram == "ontractUniqueId") {
                        $data = str_replace("{{ontractUniqueId}}", $businessno, $data);

                    }
                }

                $callback_id = $callback->id;
                $callback_name = $callback->name;
                $uri = $callback->request_uri;
                break;
            }
        }
        $url = MethodFunctionController::get_url($platform, $env);
        if ($project=="renbao"){
            $url=$url.$uri;
            $response=MethodFunctionController::encryption($url,$data,$callback_id,$callback_name);}
        elseif($project=="jingzhengu" or $project=="efq" or $project=="zhongjin"){
            $response=MethodFunctionController::post($url,$data,$uri);
            MethodFunctionController::set_request_log("callback",$callback_id,$callback_name,$url.$uri,$data,"POST",$response);
            if ($project=="efq"){
                $time_response=exe_time($env);
                MethodFunctionController::set_request_log("callback",0,"定时回调",$url,"","GET",$time_response);
            }}
        return $response;
    }
    public static function method_request($method_id,$data,$error_result){
        $methodRes = MockProjectMethod::where('id', $method_id)->first();
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
        return $response;
    }

    public static function set_request_log($type,$method_id,$name,$request_url,$request_body,$request_method,$response){
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

    public static function get($url){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;


    }

    public static function post($url,$data, $uri){

        $url = $url . $uri;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public static function encryption($url,$data,$method_id,$method_name){
        $AES_KEY = '4964cbbcbd7511e9';
        $MD5_KEY = '339c989fbd7511e89d0700155d99c30b';
        $agentcode = 'LR201909';
        $projectcode = 'UBDXLR00HX1909A';
        $timestamp = time() . "000";
        $nonce = '12345678';
        $str_signature = "agentcode=$agentcode&projectcode=$projectcode&timestamp=$timestamp&nonce=$nonce&data=$data&key=$MD5_KEY";
        $signature = md5($str_signature);
        $aes_str = MethodFunctionController::encrypt($data, $AES_KEY);
        $base64_data = base64_encode($aes_str);
        $uri = "agentcode=$agentcode&projectcode=$projectcode&timestamp=$timestamp&nonce=$nonce&signature=$signature";
        $response=MethodFunctionController::post($url,$base64_data, $uri);
        MethodFunctionController::set_request_log("callback",$method_id,$method_name,$url.$uri,$data,"POST",$response);
        return $response;
    }
    /**
     *
     * @param string $string 需要加密的字符串
     * @param string $key 密钥
     * @return string
     */
    public static function encrypt($string, $key)
    {

        // openssl_encrypt 加密不同Mcrypt，对秘钥长度要求，超出16加密结果不变
        $data = openssl_encrypt($string, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

        return $data;
    }


    /**
     * @param string $string 需要解密的字符串
     * @param string $key 密钥
     * @return string
     */
    public static function decrypt($string, $key)
    {
        $decrypted = openssl_decrypt($string, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

        return $decrypted;
    }

    public static function exe_time($env){
        $command1="/www/server/php/72/bin/php /www/code/saasyc/server/".$env."/artisan yiche:DealICBCCallback";
        $command2="/www/server/php/72/bin/php /www/code/saasyc/server/".$env."/artisan yiche:AccordICBCCallbackAffectTradeCommand";
        $command3="/www/server/php/72/bin/php /www/code/saasyc/server/".$env."/artisan yiche:DealNotifyTradeCallbackInfoToThirdClientCommand";
        $command4="/www/server/php/72/bin/php /www/code/saasyc/api/".$env."/artisan yiche:DealGenerateCompressedZip";
        $command5="/www/server/php/72/bin/php /www/code/saasyc/server/".$env."/artisan overdue:deadline";
        $command6="/www/server/php/72/bin/php /www/code/saasyc/server/".$env."/artisan schedule:run";
        exec($command1);#对E分期回调进行解析
        exec($command2);#对E分期解析后的数据推送给yiche-api
        exec($command3);#对E分期解析后的数据推送给yiche-open
//exec($command4);#对下载打包
//exec($command5);#贷后定时处理件
        exec($command6);
        $result=array(
            "code"=>0,
            "msg"=>"success",
            "platform"=>$env,
            "command1"=>$command1,
            "command2"=>$command2,
            "command3"=>$command3,
            "command6"=>$command6,
//    "command4"=>$command4,
//    "command5"=>$command5,
        );
        $result=json_encode($result);
        return $result;


    }
}
