<?php
namespace App\Services;

class LoginService
{
    public function checkLogin()
    {


        if (session('logado') === true) {
            session()->put('urlAfter', false);
            return 'HomePage';
        } else {
            session()->put('logado', false);
            return 'LoginPage';
        }
    }

}
