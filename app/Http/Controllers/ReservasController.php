<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Services\LoginService;
use Illuminate\Http\Request;


class ReservasController extends Controller
{
    protected $service;

    public function __construct(LoginService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $redirect = $this->service->checkLogin();
        $statusReservations = $this->service->getStatus();
        $userName = session('userName');
        return view($redirect, compact('statusReservations', 'userName')); // renderiza a view correta
    }

    public function login(Request $req)
    {
        return $this->service->login($req);

    }


    public function loggout(){
        return $this->service->loggout();
    }
}


?>