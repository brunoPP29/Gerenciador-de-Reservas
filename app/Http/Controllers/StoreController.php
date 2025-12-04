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

        session()->put('tbProducts', $empresa.'_products');
        session()->put('tbReservations', $empresa.'_reservations');
        $email = preg_replace('/_/', '@', $empresa, 1);
        $email = preg_replace('/_(?=[^_]*$)/', '.', $email);
        session()->put('emailEnterprise', $email);
        $databaseOrigin = $this->service->checkEnterprise($empresa, $name);
        if ($databaseOrigin === '404Page') {
            return view($databaseOrigin);
        }
        if ($databaseOrigin[0] === 'ProductsPage') {
            $dadosEmpresa = $databaseOrigin[1];
            $produtos = $databaseOrigin[2];
            return view($databaseOrigin[0], compact('dadosEmpresa', 'produtos', 'empresa'));
        }
        if ($databaseOrigin[0] === 'BookCalendarPage') {
            $productInfo = $databaseOrigin[1];
            return view($databaseOrigin[0], compact('name', 'productInfo', 'empresa'));
        }
        if ($databaseOrigin[0] === 'BookPage') {
            $productInfo = $databaseOrigin[1];
            return view($databaseOrigin[0], compact('name', 'productInfo'));
        }
    
         
         
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
        if ($saved === 'futureday') {
            return back()->with('error', 'Selecione um dia futuro!');
        }
        if ($saved === 'alreadybooked') {
            return back()->with('error', 'Este horário ja está reservado...');
        }
        if ($saved === 'minpeople') {
            return back()->with('error', 'Verifique a quantidade mínima de pessoas...');
        }
        if ($saved[0] === 'minutesblock') {
            return back()->with('error', 'Reservas só podem ser feitas em blocos de '.$saved[1].' minutos.');
        }
        if ($saved === 'error') {
            return back()->with('error', 'Aconteceu um erro, tente novamente mais tarde');
        }
        if ($saved === 'success') {
            return back()->with('success', 'Reserva concluída com sucesso!');
        }
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
            if ($reserva[0] === 'error404') {
                return redirect($reserva[1])->with('error', 'Produto não encontrado');
            }
            if ($reserva[0] === 'minpeople') {
                return redirect($reserva[1])->with('error', 'Verifique a quantidade mínima de pessoas');
            }
            if ($reserva[0] === 'success') {
                return redirect($reserva[1])->with('success', 'Reserva concluída com sucesso!');
            }
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