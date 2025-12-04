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
        $enterpriseName = $infos->name;
        //tem que ter de qualquer maneira se passa no HASH check
        session()->put('logadoenterprise', true);
        session()->put('userEnterprise', $enterpriseName);
        session()->put('urlLink', preg_replace('/[^a-zA-z0-9]/', '_', $infos->name));
        session()->put('tbProducts', preg_replace('/[^a-zA-z0-9]/', '_', $infos->name) . '_products');
        session()->put('tbReservations', preg_replace('/[^a-zA-z0-9]/', '_', $infos->name) . '_reservations');
        if (session('urlAfter') == true) {
            $urlAfter = session('urlAfter');
            session()->put('urlAfter', null);
            return [$urlAfter, 'redirectUrlAfter'];
        }else{
            return 'EnterprisePage';
        }
    }

    return redirect()->back()->withInput()->with('error', 'Usuário ou senha incorretos!');
    }

    }


