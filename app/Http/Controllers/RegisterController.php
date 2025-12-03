<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RegisterService;

class RegisterController extends Controller{

    protected $service;

    public function __construct(RegisterService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return view('RegisterPage');
    }

    public function register(Request $req){
        $validationFields = $this->service->checkFields($req);
        $register = $this->service->register($req);
        if ($register === 'success') {
            return back()->with('success', 'Registrado com sucesso!');
        }else{
            return back()->with('error', 'Houve algum erro no processo de registro');
        }

        

    }
}