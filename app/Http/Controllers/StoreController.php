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

    public function index($empresa)
    {
        
        $databaseOrigin = $this->service->checkEnterprise($empresa);
        if ($databaseOrigin) {
                return view('ProductsPage', compact('databaseOrigin'));
                }else{
                    return view('404Page');
                }       
    }


}


?>