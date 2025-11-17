<?php
namespace App\Services;

use App\Models\EnterpriseLogin;
use Illuminate\Support\Facades\Hash;


class EnterpriseLoginService
{
    public function checkLogin()
    {
        if (session('logadoenterprise') === true) {
            return 'EnterprisePage';
        } else {
            return 'EnterpriseLoginPage';
            session()->put('logadoenterprise', false);
        }
    }

public function login($req)
{
    $req->validate([
        'email' => 'required|string',
        'password' => 'required|string',
    ]);

    $email = EnterpriseLogin::where('email', $req->email)->first();

    if ($email && Hash::check($req->password, $email->password)) {
        session()->put('logadoenterprise', true);
        return true;
    }

    return false;
}

    }


