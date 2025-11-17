<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RegisterService;
use App\Reservas;
use App\Models\Register;

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
        $insert = $this->service->register($req);
        return redirect()->back()->with('success', 'Criado com sucesso!');
        

    }
}