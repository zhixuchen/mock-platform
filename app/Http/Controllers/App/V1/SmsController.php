<?php


namespace App\Http\Controllers\App\V1;


use App\Http\Controllers\Controller;
use App\Models\SmsCode;
use App\Services\SMSService;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function sendSms(Request $request, SMSService $SMSService)
    {
        $request->validate([
            'mobile' => 'required',
            'type'   => 'required',
        ]);

        $SMSService->sendSMSCode($request->input('mobile'), $request->input('type'), SmsCode::YCS_PROJECT);
        return $this->success(true);
    }


}
