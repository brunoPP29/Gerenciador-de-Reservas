<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers; use App\Http\Controllers\Controller; use Illuminate\Http\Request; use App\Services\EnterpriseManagementService; use App\Reservas; use App\Models\EnterpriseProduct; 

class EnterpriseManagementController extends Controller
{
    protected $service;

public function __construct(EnterpriseManagementService $service)
{
    $this->service = $service;
}

    public function products(){
        $login = $this->service->checkLogin();

        if (!$login) {
            $products = $this->service->getProducts();
            return view('EnterpriseProductManagementPage', compact('products'));
        }else{
            return $login;
        }
    }

}


