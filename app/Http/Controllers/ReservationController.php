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
        return $redirect;

    }

    public function deleteItem(Request $infos){
        if (session('logado')) {
            $cancel = $this->service->delete($infos);
            return $cancel;
        }else{
            return view('LoginPage');
        }
    }

}


?>