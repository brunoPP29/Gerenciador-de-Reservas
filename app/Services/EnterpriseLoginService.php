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

    $infos = EnterpriseLogin::where('email', $req->email)->first();

    if ($infos && Hash::check($req->password, $infos->password)) {
        session()->put('tableOrigin', $infos->email);
        echo session('tableOrigin');
        session()->put('logadoenterprise', true);
        return true;
    }

    return false;
}

    }


