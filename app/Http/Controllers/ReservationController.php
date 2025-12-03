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
            $compact = $redirect[0];
            return view($redirect[1], compact('compact'));
        }
        if ($redirect === 'redirectUrl') {
            return redirect('/');
        }

    }

    public function deleteItem(Request $infos){
        if (session('logado')) {
            $cancel = $this->service->delete($infos);
            if ($cancel === 'comeback') {
                redirect('client/my_appointments');
            }
        }else{
            return view('LoginPage');
        }
    }

}


?>