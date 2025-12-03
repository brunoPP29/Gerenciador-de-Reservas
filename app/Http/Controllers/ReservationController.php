<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReservationService;
use Illuminate\View\View;


class ReservationController extends Controller
{
    protected $service;

    public function __construct(ReservationService $service)
    {
        $this->service = $service;
    }

    public function index()
    {   
        $redirect = $this->service->checkLogin();
        if (isset($redirect[1]) && $redirect[1] === 'AppointmentsPage') {
            $reservations = $redirect[0];
            return view($redirect[1], compact('reservations'));
        }
        if ($redirect === 'redirectUrl') {
            return redirect('/');
        }

    }

    public function deleteItem(Request $infos){
        if (session('logado')) {
            $cancel = $this->service->delete($infos);
            if ($cancel === 'comeback') {
                return redirect('client/my_appointments');
            }
            if ($cancel === 'expired') {
                return redirect('client/my_appointments')->with('error', 'O tempo máximo de espera para cancelamento foi execedido');
            }
            if ('notfound') {
                return redirect('client/my_appointments')->with('error', 'A reserva não foi encontrada');

            }
        }else{
            return view('LoginPage');
        }
    }

}


?>