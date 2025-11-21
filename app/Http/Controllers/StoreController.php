<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Services\StoreService;
use Illuminate\Http\Request;
use App\Reservas;
use App\Models\Store;


class StoreController extends Controller
{
    protected $service;

    public function __construct(StoreService $service)
    {
        $this->service = $service;
    }

    public function index($empresa, $name = null)
    {
        
        $databaseOrigin = $this->service->checkEnterprise($empresa);
        $dadosEmpresa = $this->service->getEnterprise($empresa);
        if ($databaseOrigin) {
            //se tiver parametros
            if ($name != null) {
                return view('BookPage');
            }else{
                return view('ProductsPage', compact('databaseOrigin', 'dadosEmpresa'));
            }
            }else{
                return view('404Page');
         }    
         
         
    }


}


?>