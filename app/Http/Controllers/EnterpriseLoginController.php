<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EnterpriseLoginService;
use App\Reservas;
use App\Models\EnterpriseLogin;

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



}