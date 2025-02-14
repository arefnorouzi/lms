<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    protected string $name;
    protected string $username;
    protected string $password;
    public function __construct(string $name, string $username, string $password)
    {
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
    }

    public function register(): object | null
    {
        try {
            $user = User::where('mobile', '=', $this->username)->first();
            if(!$user){
                $user = User::create([
                    'mobile' => $this->username,
                    'password' => Hash::make($this->password),
                    'name' => $this->name,
                ]);
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
