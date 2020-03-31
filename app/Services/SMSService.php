<?php


namespace App\Services;


use App\Exceptions\ApiException;
use App\Helper\Util;
use App\Models\SapiConfig;
use App\Models\SmsCode;
use App\Models\SmsTemplateConfig;
use App\Models\YcyUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Sentiger\AliDy\SMSDy;

class SMSService
{
    /**
     * 发送短信
     * @param $mobile
     * @param $type
     * @param $project
     * @param int $len
     * @return int
     * @throws ApiException
     */
    public function sendSMSCode($mobile, $type, $project, $len = 6)
    {
        if (!Util::checkMobile($mobile)) {
            throw new ApiException('手机号格式错误');
        }
        $this->_checkSendSMS($mobile, $type, $project);
        $code = Util::generateCode($len);
        switch ($project) {
            // 车商项目发送短信
            case SmsCode::YCS_PROJECT:
                switch ($type) {
                    // 注册
                    case SmsCode::REG:
                        $existUser = YcyUsers::where('mobile', $mobile)->first();
                        // 多项目共享注册
//                        if (!empty($existUser->ycs_user)) {
                        if (!empty($existUser->ycs_user)) {
                            throw new ApiException('该手机号已经注册');
                        }
                        $this->_recordSendSMS($mobile, $code, $type, SmsTemplateConfig::REG_NAME,
                            SmsCode::YCS_PROJECT);
                        break;
                    case SmsCode::LOGIN:
                        $existUser = YcyUsers::where('mobile', $mobile)->first();
                        if (empty($existUser)) {
                            throw new ApiException('该手机号还未注册');
                        }
                        $this->_recordSendSMS($mobile, $code, $type, SmsTemplateConfig::LOGIN_NAME,
                            SmsCode::YCS_PROJECT);
                        break;
                    default:
                        throw new ApiException('发送类型错误');
                        break;
                }
                return $code;
                break;
            default:
                throw new ApiException('配置项目不存在');
        }

    }

    /**
     * 检测短信发送
     * @param $mobile
     * @param $type
     * @param $project
     * @throws ApiException
     */
    private function _checkSendSMS($mobile, $type, $project)
    {
        $waitTime = 60;
        $data     = SmsCode::select('id', 'send_time')
            ->where([
                'type'    => $type,
                'mobile'  => $mobile,
                'project' => $project,
            ])
            ->orderBy('id', 'desc')
            ->first();
        if ($data && (time() - strtotime($data->send_time) < $waitTime)) {
            throw new ApiException('发送间隔时间小于' . $waitTime . '秒');
        }
    }

    private function _recordSendSMS($mobile, $code, $type, $use, $project)
    {
        $config = SmsTemplateConfig::getConfig($use, $project);
        if (empty($config)) {
            throw new ApiException('短信模板还未配置');
        }
        // $config = config('services.ALIDY')[$use];
        $time      = date('Y-m-d H:i:s', time());
        $smsConfig = [
            'accessKeyId'     => $config->access_key_id,
            'accessKeySecret' => $config->access_key_secret,
            'signName'        => $config->sign_name,
            'templateCode'    => $config->template_code
        ];

        $sms_on_of = SapiConfig::getConfigValue('ALIDY.SMS_ON_OFF');
        if (strtolower($sms_on_of) == 'off') {
            $code = '123456';
        } else {
            try {
                $client = new SMSDy($smsConfig);
                $client->sendSMS($mobile, [
                    'TemplateParam' => [
                        'code' => $code
                    ]
                ]);
            } catch (\Throwable $e) {
                Log::error("短信发送异常", [$e->getMessage() . '|' . $e->getFile() . '|' . $e->getLine()]);
                throw new ApiException('短信发送频繁' . $e->getMessage());
            }
        }
        SmsCode::insert([
            'ycy_user_id' => Auth::user()->ycy_user_id ?? 0,
            'project'     => $project,
            'type'        => $type,
            'mobile'      => $mobile,
            'code'        => $code,
            'send_time'   => $time,
            'expire_time' => date('Y-m-d H:i:s', (time() + $config['expireTime'])),
            'message'     => sprintf($config['template'], $code),
        ]);
    }
}