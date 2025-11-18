<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EnterpriseRegisterService;
use App\Reservas;
use App\Models\EnterpriseRegister;

class EnterpriseRegisterController extends Controller{

    protected $service;

    public function __construct(EnterpriseRegisterService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return view('EnterpriseRegisterPage');
    }

    public function register(Request $req){
        $validationFields = $this->service->checkFields($req);
        $insert = $this->service->register($req);
        $database = $this->service->databaseCheck($req->email);
        session()->put('logadoenterprise', true);
        return redirect()->back()->with('success', 'Enterprise registered successfully!');
        

    }
}