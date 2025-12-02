<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Services\StoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StoreController extends Controller
{
    protected $service;

    public function __construct(StoreService $service)
    {
        $this->service = $service;
    }

    public function index($empresa, $name = null)
    {

        session()->put('tbProducts', $empresa.'_products');
        session()->put('tbReservations', $empresa.'_reservations');
        $databaseOrigin = $this->service->checkEnterprise($empresa, $name);
        return $databaseOrigin;
         
         
    }


    public function reserve(Request $request){
    // checar login
    $check = $this->service->checkLogin();
        if (!$check) {}else{return $check;}

    // nome da tabela onde salvar (ex: admin_admin_com_reservations)
    $table = $request->input('where_to');
    // pega os dados sem lixo do form
    $data = $request->except(['where_to', '_token', 'Products', 'product']);
    // tentar salvar
    $saved = $this->service->saveReservation($table, $data);
    return $saved;
}

public function checkHours(Request $req)
    {


        if(isset($req->hora)){
            if (!session('logado')) {
                $plainUrl = request()->url();
                $baseUrl = dirname($plainUrl);
                session()->put('urlAfter', $baseUrl);
                return redirect('/');
            }
            $reserva = $this->service->createCalendarReserva($req);
            return $reserva;
        }

        $data = $req->date;
        $tbReservations = $req->where_to; // tabela de reservas
        $tbProducts = $req->Products;     // tabela de produtos


        // Pega informações do produto (duração, abertura/fechamento)
        $infosProduct = $this->service->getHours($req, $tbProducts);
        if (!$infosProduct) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        // Gera todos os horários possíveis
        $horarios = $this->service->getAvailableTimes($infosProduct);

        // Pega reservas existentes
        $reservasHorarios = $this->service->getReservationsTime($req->product_id, $tbReservations, $data);

        // Filtra horários já ocupados
        $horariosDisponiveis = $this->service->filterTimes($horarios, $reservasHorarios);
        // Retorna horários disponíveis
        return view('horariosBookPage', compact('req', 'horariosDisponiveis'));
    }


}


?>