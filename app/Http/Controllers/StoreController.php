<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Services\StoreService;
use Illuminate\Http\Request;
use App\Reservas;
use Illuminate\Support\Facades\DB;
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
        $customerName = session('userName');
        if ($databaseOrigin) {
            //se tiver parametros
            if ($name != null) {
                $tbReservation = $empresa.'_reservations';
                $tbProducts = $empresa.'_products';
                $productInfo = $this->service->getProduct($name, $tbProducts);
                return view('BookPage', compact('tbReservation', 'tbProducts', 'name', 'productInfo'));
            }else{
                return view('ProductsPage', compact('databaseOrigin', 'dadosEmpresa', 'empresa'));
            }
            }else{
                return view('404Page');
         }    
         
         
    }


    public function reserve(Request $request){

        $checkLogin = $this->service->checkLogin();

        if ($checkLogin !== true) {
            return redirect('/');
        }

        // tabela onde salvar (ex: empresa123_reservations)
        $table = $request->input('where_to');

        // todos os dados do formulário, exceto o campo da tabela
        $data = $request->except(['where_to', '_token', 'Products', 'product']);

        // salva no banco
        $this->service->saveReservation($table, $data);

        return back()->with('success', 'Reserva salva com sucesso!',);
    }


}


?>