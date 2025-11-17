<?php
namespace App\Services;

class LoginService
{
    public function checkLogin()
    {
        if (session('logado') === true) {
            return 'HomePage';
        } else {
            return 'LoginPage';
            session()->put('logado', false);
        }
    }

    public function checkFields($req){
        if ($req->input('user') && $req->input('password')) {
            return true;
        }else{
            return false;
        }
    }
}
