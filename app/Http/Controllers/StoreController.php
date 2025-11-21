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
                $tbReservation = $empresa.'_reservations';
                $tbProducts = $empresa.'_products';
                $idProduct = $this->service->getIdProduct($name);
                return view('BookPage', compact('tbReservation', 'tbProducts', 'name', 'idProduct'));
            }else{
                return view('ProductsPage', compact('databaseOrigin', 'dadosEmpresa', 'empresa'));
            }
            }else{
                return view('404Page');
         }    
         
         
    }


}


?>