<?php


namespace App\Http\Controllers\App\V1;


use App\Http\Controllers\Controller;
use App\Models\SmsCode;
use App\Models\YcyUsers;
use App\Services\App\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request, UserService $userService)
    {
        $request->validate([
            'mobile'   => 'string|required',
            'sms_code' => 'string|required',
        ]);
        $mobile = $request->input('mobile');
        $code   = $request->input('sms_code');

        $loginInfo = $userService->ycsLogin($userService->ycyLogin($mobile,
            function (YcyUsers $ycyUser) use ($mobile, $code) {
                SmsCode::checkSMSCode($code, $mobile, SmsCode::LOGIN, SmsCode::YCS_PROJECT);
            })
        );
        SmsCode::useSMSCode($code, $mobile, SmsCode::LOGIN, SmsCode::YCS_PROJECT);
        return $this->success($loginInfo);
    }


    public function reg(Request $request, UserService $service)
    {
        $request->validate([
            'mobile'           => 'string|required',
            'sms_code'         => 'string|required',
            'recommend_mobile' => 'string',
        ]);

        $mobile       = $request->input('mobile');
        $code         = $request->input('sms_code');
        $inviteMobile = $request->input('recommend_mobile');

        SmsCode::checkSMSCode($code, $mobile, SmsCode::REG, SmsCode::YCS_PROJECT);
        $ycsModel = $service->ycsReg($service->ycyReg($mobile), [
            'invite_mobile' => $inviteMobile
        ]);

        SmsCode::useSMSCode($code, $mobile, SmsCode::REG, SmsCode::YCS_PROJECT);


        return $this->success(true);

    }

    // todo
    public function info()
    {
        return Auth::user();
    }

}
