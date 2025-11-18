<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EnterpriseProductService;
use App\Reservas;
use App\Models\EnterpriseProduct;

use function PHPUnit\Framework\isString;

class EnterpriseProductController extends Controller{

    protected $service;

    public function __construct(EnterpriseProductService $service)
    {
        $this->service = $service;
    }

    public function index(){
        $redirect = $this->service->checkLogin();
        if ($redirect === false) {
            return view('404Page');
        }else{
            return view($redirect);
        }
    }


}