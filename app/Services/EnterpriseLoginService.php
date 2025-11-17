<?php
namespace App\Services;

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

}
