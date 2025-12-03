<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EnterpriseLoginService;


class EnterpriseLoginController extends Controller{

    protected $service;

    public function __construct(EnterpriseLoginService $service)
    {
        $this->service = $service;
    }

    public function index(){
        $redirect = $this->service->checkLogin();
        return view($redirect);
    }

    public function login(Request $req){
        $login = $this->service->login($req);
        if (isset($login[1]) && $login[1] === 'redirectUrlAfter') {
            return redirect($login[0]);
        }else{
            return view($login);
        }



    }



}