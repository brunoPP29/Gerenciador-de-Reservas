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
        $enterpriseName = EnterpriseLogin::where('email', $req->email)->value('name');
        session()->put('tableOrigin', $infos->email);
        session()->put('logadoenterprise', true);
        session()->put('userEnterprise', $enterpriseName);
        return view('EnterprisePage');
    }

    return redirect()->back()->withInput()->with('error', 'Usuário ou senha incorretos!');
    }

    }


