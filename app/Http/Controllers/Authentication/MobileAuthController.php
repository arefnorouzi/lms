<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\MobileAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MobileAuthController extends Controller
{
    public function __construct()
    {}

    public function handle_auth(MobileAuthRequest $request): object
    {
        $request = $request->validated();
        $user = User::where('mobile', '=', $request['mobile'])->first();
        if ($user)
        {
            if (Hash::check($request['password'], $user->password))
            {
                auth()->login($user, true);
                return response()->json(['message' => 'با موفقیت وارد حساب کابری شدید']);
            }
            elseif(isset($_SESSION[$request['mobile']]) && $_SESSION[$request['mobile']] == $request['password'])
            {
                $user->password = bcrypt($request['password']);
                $user->mobile_verified = true;
                $user->update();
                auth()->login($user, true);
                unset($_SESSION[$request['mobile']]);
                return response()->json(['message' => 'با موفقیت وارد حساب کابری شدید']);
            }
            return response()->json(['message' => 'رمز عبور وارد شده نامعتبر است'], status: 404);
        }
        else{
            try {
                $user = User::create([
                    'mobile' => $request['mobile'],
                    'password' => bcrypt($request['password'])
                ]);
            }
            catch (\Exception $e)
            {
                Log::error($e->getMessage());
                return response()->json(['message' => 'لطفا اطلاعات را به درستی وارد نمایید'], status: 400);
            }
            auth()->login($user, true);
            return response()->json(['message' => 'با موفقیت وارد حساب کابری شدید']);
        }

    }
}
