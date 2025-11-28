<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers; use App\Http\Controllers\Controller; use Illuminate\Http\Request; use App\Services\EnterpriseProductService; use App\Reservas; use App\Models\EnterpriseProduct; 

class EnterpriseProductController extends Controller
{
    protected $service;

public function __construct(EnterpriseProductService $service)
{
    $this->service = $service;
}


    public function index()
    {
        $redirect = $this->service->checkLogin();
        if ($redirect === false) {
            return view('404Page');
        } else {
            $getTypes = $this->service->getTypes();
            return view($redirect, compact('getTypes'));
        }
    }

    public function register(Request $req){
        $register = $this->service->register($req);
        if ($register->exists) {
            return back()->with('success', 'Product succesfully registered - Product ID:'.$register->id);
        }
            }
        }


