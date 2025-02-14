<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginService
{
    protected string $username;
    protected string $password;
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function login(): object | null
    {
        try {
            $user = User::where('mobile', '=', $this->username)->firstOrFail();
            if(Hash::check($this->password, $user->password)){
                auth()->login($user, true);
                return $user;
            }
        }
        catch (\Exception $e)
        {
            return null;
        }
        return null;
    }
}
