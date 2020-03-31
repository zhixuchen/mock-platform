<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/22
 * Time: 14:29
 */

namespace Sentiger\AliDy;

use Sentiger\AliDy\Exceptions\HttpException;
use Sentiger\AliDy\Exceptions\InvalidArgumentException;
use Sentiger\AliDy\Exceptions\ResponseException;

class SMSDy
{
    private $accessKeyId;
    private $accessKeySecret;
    private $signName;
    private $templateCode;

    /**
     * SMSDy constructor.
     * @param array $config 配置
     * @throws InvalidArgumentException
     */
    public function __construct(array $config)
    {
        if (empty($config['accessKeyId'])) {
            throw new InvalidArgumentException('【accessKeyId】参数不能为空');
        }
        if (empty($config['accessKeySecret'])) {
            throw new InvalidArgumentException('【accessKeySecret】参数不能为空');
        }
        if (empty($config['signName'])) {
            throw new InvalidArgumentException('【signName】参数不能为空');
        }
        if (empty($config['signName'])) {
            throw new InvalidArgumentException('【signName】参数不能为空');
        }
        $this->accessKeyId     = $config['accessKeyId'];
        $this->accessKeySecret = $config['accessKeySecret'];
        $this->signName        = $config['signName'];
        $this->templateCode    = $config['templateCode'];

    }

    /**
     * 发送内容
     * @param string $mobile
     * @param array $param
     * @return bool
     * @throws HttpException
     */
    public function sendSMS(string $mobile, array $param = [])
    {
        $params                 = [];
        $params["PhoneNumbers"] = $mobile;
        $params["SignName"]     = $this->signName;
        $params["TemplateCode"] = $this->templateCode;

//        $params['TemplateParam'] = Array(
//            "code"      => $content,
//            "companyid" => $code,
//        );
        if (isset($param['TemplateParam']) && !empty($param['TemplateParam'])) {
            $params['TemplateParam'] = $param['TemplateParam'];
        }

        // 流水号
        if (isset($param['OutId']) && !empty($param['OutId'])) {
            $params['OutId'] = $param['OutId'];
        }

        // 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        if (isset($param['OutId']) && !empty($param['OutId'])) {
            $params['SmsUpExtendCode'] = $param['SmsUpExtendCode'];
        }

        if (!empty($param["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }
        $helper = new SignatureHelper();
        try {
            $content = $helper->request(
                $this->accessKeyId,
                $this->accessKeySecret,
                "dysmsapi.aliyuncs.com",
                array_merge($params, array(
                    "RegionId" => "cn-hangzhou",
                    "Action"   => "SendSms",
                    "Version"  => "2017-05-25",
                ))
                // fixme 选填: 启用https
                , true
            );
            if (!isset($content->Code) || $content->Code != 'OK') {
                throw new ResponseException(isset($content->Message) ? $content->Message : '发送失败');
            }
            return true;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }

    }
}