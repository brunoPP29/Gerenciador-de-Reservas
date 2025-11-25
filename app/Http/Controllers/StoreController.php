<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Services\StoreService;
use Illuminate\Http\Request;


class StoreController extends Controller
{
    protected $service;

    public function __construct(StoreService $service)
    {
        $this->service = $service;
    }

    public function index($empresa, $name = null)
    {

        $databaseOrigin = $this->service->checkEnterprise($empresa, $name);

        return $databaseOrigin;
         
         
    }


    public function reserve(Request $request){
    // checar login
    $check = $this->service->checkLogin();
        if ($check) {}else{return $check;}

    // nome da tabela onde salvar (ex: admin_admin_com_reservations)
    $table = $request->input('where_to');
    // pega os dados sem lixo do form
    $data = $request->except(['where_to', '_token', 'Products', 'product']);
    // tentar salvar
    $saved = $this->service->saveReservation($table, $data);

    return $saved;
}


}


?>