<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\MobilePasswordRequest;
use App\Http\Requests\Authentication\MobilePasswordResetRequest;
use App\Models\User;
use App\Services\sms\Melipayamak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MobilePasswordController extends Controller
{
    public function forget_password(MobilePasswordRequest $request): object
    {
        $request = $request->validated();
        $user = User::where('mobile', '=', $request['mobile'])->first();
        if (!$user)
        {
            return response()->json(status: 404);
        }
        $cookie_name = "$user->id";
        if(isset($_COOKIE[$cookie_name])) {
            return response()->json(status: 400);
        }
        $cookie_value = str(rand(1024, 9876));
        setcookie($cookie_name, $cookie_value, time() + (300), "/");
        // send sms
        try {
            $sms_service = new Melipayamak(
                body_id: 305070,
                to: $user->mobile,
                args: array($cookie_value)
            );
            $sms_service->send_sms();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(status: 400);
        }

        return response()->json(['message' => 'پیامک بازیابی رمز برای شما ارسال شد']);
    }

    public function reset_password(MobilePasswordResetRequest $request): object
    {
        $request = $request->validated();
        $user = User::where('mobile', '=', $request['mobile'])->first();
        if (!$user)
        {
            return response()->json(status: 404);
        }
        $cookie_name = "$user->id";
        if(!isset($_COOKIE[$cookie_name]) || $_COOKIE[$cookie_name] != $request['code']) {
            return response()->json(status: 400);
        }

        $user->password = bcrypt($request['password']);
        $user->mobile_verified = true;
        $user->update();
        return response()->json(['message' => 'رمز عبور شما با موفقیت بروزرسانی شد']);
    }
}
