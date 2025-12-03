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
        return view($redirect, compact('statusReservations')); // renderiza a view correta
    }

    public function login(Request $req)
    {
        $login = $this->service->login($req);
        if ($login === 'incorrect') {
            return back()->with('error', 'Senha ou usuário incorretos');
        }
        if (isset($login[1])) {
            if ($login[1] === 'redirectUrl') {
                return redirect($login[0]);
            }
            if ($login[1] === 'HomePage') {
                $statusReservations = $login[0];
                return view($login[1], compact('statusReservations'));
            }
        }
    }


    public function loggout(){
        $loggout = $this->service->loggout();
        if ($loggout === 'loggedOut') {
            return redirect('/');
        }else{
            return back()->with('error', 'Não foi possível deslogar');
        }
    }
}


?>