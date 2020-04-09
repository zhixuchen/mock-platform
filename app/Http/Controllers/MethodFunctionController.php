<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\MockFunction;
use App\Models\MockProjectMethod;
use App\Models\MockRequestLog;
use Illuminate\Http\Request;
use App\Models\MockProject;

class MethodFunctionController extends Controller
{

    public static function method_callback($project, $platform, $env, $status, $businessno)
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
                    if ($pragram == "Sign") {
                        $replace = MethodFunctionController::getSign($data, $businessno, $status);
                    } else {
                        $replace = $businessno;
                    }
                    $data = str_replace("{{" . $pragram . "}}", $replace, $data);
                }
                $callback_id = $callback->id;
                $callback_name = $callback->name;
                $uri = $callback->request_uri;
                break;
            }
        }
        $url = MethodFunctionController::get_url($platform, $env);
        $type = "callback";
        if ($project == "renbao") {
            $url = $url . $uri;

            $result = MethodFunctionController::encryption($url, $data, $callback_id, $callback_name);
            $url = $result["url"];
            $data = $result["data"];
            $uri = $result["uri"];
        }
        $response = MethodFunctionController::post($url, $data, $uri);
        MethodFunctionController::set_request_log($type, $callback_id, $callback_name, $url . $uri, $data, "POST", $response);
        if ($project == "efq") {
            $url = "http://callback-beta.saasyc.com/time.php?name=" . $env;
            $time_response = MethodFunctionController::get($url);
            MethodFunctionController::set_request_log($type, 0, "定时回调", $url, "", "GET", $time_response);
        }
        return $response;
    }

    public static function method_request($method_id, $data, $error_result)
    {
        $methodRes = MockProjectMethod::where('id', $method_id)->first();
        $response = $methodRes->result ?? $error_result;
        $methodPragram = $methodRes->pragram ?? '';
        $pragrams = explode(',', $methodPragram);
        foreach ($pragrams as $pragram) {
            if($pragram!=null) {
                $function = "get" . $pragram;
                $replace = MethodFunctionController::getpragram($function, $data);
                $response = str_replace("{{" . $pragram . "}}", $replace, $response);
            }
        }
        return $response;
    }

    public static function set_request_log($type, $method_id, $name, $request_url, $request_body, $request_method, $response)
    {
        $creat_time = date('Y-m-d h:i:s', time());
        $log = array(
            "id" => "",
            "type" => $type,
            "method_id" => $method_id,
            "name" => $name,
            "request_url" => $request_url,
            "request_body" => $request_body,
            "request_method" => $request_method,
            "response" => $response,
            "creat_time" => $creat_time
        );
        try {
            $id = MockRequestLog::insertGetId($log);
            return $id;
        }catch (Exception $e){

            echo "新记录插入失败";
        }
    }

    public  static  function  updata_request_log($id,$response){
        $log=array(
            "response"=>$response
        );
        MockRequestLog::where("id",$id)->update($log);
        
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
                $value = eval($rule);
                if ($route == $value) {
                    $method_id = $methodRe->id;
                    $name = $methodRe->name;
                    $result = array(
                        "method_id" => $method_id,
                        "name" => $name
                    );

                    return $result;
                }
            } else {
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

    public static function getpragram($function_name, $data)
    {
        $function_code = MockFunction::where('function_name', $function_name)->first();
        $result = eval($function_code->value);
        return $result;

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

    public static function get($url)
    {
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

    public static function post($url, $data, $uri)
    {

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

    public static function encryption($url, $data)
    {
        $AES_KEY = '4964cbbcbd7511e9';
        $MD5_KEY = '339c989fbd7511e89d0700155d99c30b';
        $agentcode = 'LR201909';
        $projectcode = 'UBDXLR00HX1909A';
        $timestamp = time() . "000";
        $nonce = '12345678';
        $str_signature = "agentcode=$agentcode&projectcode=$projectcode&timestamp=$timestamp&nonce=$nonce&data=$data&key=$MD5_KEY";
        $signature = md5($str_signature);
        $aes_str = openssl_encrypt($data, 'AES-128-ECB', $AES_KEY, OPENSSL_RAW_DATA);
        $base64_data = base64_encode($aes_str);
        $uri = "agentcode=$agentcode&projectcode=$projectcode&timestamp=$timestamp&nonce=$nonce&signature=$signature";
        $result = array(
            "url" => $url,
            "data" => $base64_data,
            "uri" => $uri
        );

        return $result;


    }

}
