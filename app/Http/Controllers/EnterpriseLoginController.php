<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EnterpriseLoginService;
use App\Reservas;


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
        if ($login === true) {
           return view('EnterprisePage');
        }else{
            return redirect()->back()->withInput()->with('error', 'Usuário ou senha incorretos!');
            
        }
    }



}