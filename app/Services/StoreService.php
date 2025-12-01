<?php

namespace App\Services;
use App\Models\EnterpriseLogin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Arr;


class StoreService{

    public function checkLogin(){
        $url = url()->current();

        if (session('logado') === true) {
            session()->put('urlAfter', false);
            return false;
        }else{
            session()->put('urlAfter', $url);
            return redirect('/');

        }
    }

    public function checkEnterprise($empresa, $name){
        $tbprodutos = $empresa.'_products';;
        if (Schema::hasTable($tbprodutos)) {
            $produtos = DB::table($tbprodutos)->get();
                        //se tiver parametros
                        
                        if ($name != null) {
                        $clientName = session('userName');
                        session()->put('tbReservation', $empresa.'_reservations');
                        $tbReservation = session('tbReservation');
                        session()->put('tbProducts', $empresa.'_products');
                        $tbProducts = session('tbProducts');
                        $productInfo = $this->getProduct($name, $tbProducts);

                        if ($productInfo->type === 'calendar') {
                            return view('BookCalendarPage', compact('tbReservation', 'tbProducts', 'name', 'productInfo', 'empresa'));
                        }

                        return view('BookPage', compact('tbReservation', 'tbProducts', 'name', 'productInfo'));
                    }else{
                        $dadosEmpresa = $this->getEnterprise($empresa);
                        return view('ProductsPage', compact('produtos', 'dadosEmpresa', 'empresa'));
                    }
        } else {
            return view('404Page');
        }
    }

    public function getEnterprise($empresa){
        $parts = explode('_', $empresa);
        $email =  strtolower($parts[0].'@'.implode('.', array_slice($parts, 1)));
        $emailChecked = EnterpriseLogin::where('email', $email)->first();

        if ($emailChecked != '') {
            return $enterpriseInfos = $emailChecked;
        }


    }

    public function getProduct($nameItem, $tbProducts){

    return $product = DB::table($tbProducts)
        ->where('name', $nameItem)
        ->first();



    }

    public function hasConflict($table, $date, $start, $end, $id)
        {
            $product = DB::table(session('tbProducts'))->where('id', $id)->first();
            $minutos = Carbon::parse($start)->diffInMinutes($end);
            if ($minutos >= $product->duration_minutes) {
                $date = Carbon::parse($date);
                $hoje = Carbon::today();
                if ($date->lt($hoje)) {
                    return back()->with('error', 'Select a future day');

                } else {
                //continua
                }
            }else{
                return back()->with('error', 'Reservations can only be made in '.$product->duration_minutes.'-minute blocks.');
            }

                $conflict = DB::table($table)
                    ->where('date', $date)
                    ->where(function($q) use ($start, $end) {
                        $q->where('start_time', '<', $end)
                        ->where('end_time', '>', $start);
                    })
                    ->first();

                if (!$conflict) {
                    // não existe conflito — segue o fluxo
                } else {
                    if ($conflict->status === 'confirmed') {
                        return back()->with('error', 'This time slot is already booked.');
                    }
                }
        }

    public function saveReservation($table, $data){
            $conflict = $this->hasConflict($table, $data['date'], $data['start_time'], $data['end_time'], $data['product_id']);
            if($conflict) {
                return $conflict;
            }else{

            $data = Arr::except($data, ['duration_minutes']);
            // garante timestamps
            $data['created_at'] = now();
            $data['updated_at'] = now();

            if(DB::table($table)->insert($data)){
                session()->regenerate();
                return back()->with('success', 'A reserva foi concluída com sucesso');
            }else{
                return back()->with('error', 'Aconteceu um erro! Caso persista entre em contato');
            }
            }


        }


    public function getHours($req, $tbProducts)
    {
        return DB::table($tbProducts)
            ->where('id', $req->product_id)
            ->select('duration_minutes', 'opens_at', 'closes_at')
            ->first();
    }

    // Gera todos os horários possíveis com base na duração e horário de abertura/fechamento
    public function getAvailableTimes($data)
    {
        $duration = $data->duration_minutes;
        $opens = Carbon::parse($data->opens_at);
        $closes = Carbon::parse($data->closes_at);

        $times = [];
        $current = $opens->copy();

        while ($current->lt($closes)) {
            $endTime = $current->copy()->addMinutes($duration);
            if ($endTime->lte($closes)) {
                $times[] = [
                    'start' => $current->format('H:i'),
                    'end'   => $endTime->format('H:i'),
                ];
            }
            $current->addMinutes($duration);
        }

        return $times;
    }

    // Pega todas as reservas existentes de um produto em uma data específica
    public function getReservationsTime($productId, $table, $date)
    {
        return DB::table($table)
            ->where('date', $date)
            ->where('product_id', $productId)
            ->select('start_time', 'end_time')
            ->get();
    }

    // Filtra horários disponíveis removendo os que conflitam com reservas existentes
    public function filterTimes($horarios, $reservasHorarios)
    {
        if (empty($reservasHorarios) || count($reservasHorarios) === 0) {
            return $horarios;
        }

        $reservasHorarios = is_array($reservasHorarios) ? $reservasHorarios : $reservasHorarios->all();

        return array_values(array_filter($horarios, function ($bloco) use ($reservasHorarios) {
            $blocoStart = Carbon::parse($bloco['start']);
            $blocoEnd = Carbon::parse($bloco['end']);

            foreach ($reservasHorarios as $reserva) {
                if (!isset($reserva->start_time) || !isset($reserva->end_time)) {
                    continue;
                }

                $reservaStart = Carbon::parse($reserva->start_time);
                $reservaEnd = Carbon::parse($reserva->end_time);

                if ($blocoStart < $reservaEnd && $blocoEnd > $reservaStart) {
                    return false;
                }
            }
            
            return true;
        }));
    }
    
    public function createCalendarReserva($req)
    {
        $baseUrl = dirname(request()->url()); // remove a última "pasta"
    // Nome da tabela dinâmica (ex: admin_admin_com_reservations)
    $table = $req->where_to;

    // Pega duração do produto (já existe no service)
    $product = DB::table($req->Products)
        ->where('id', $req->product_id)
        ->first();

    if (!$product) {
    return redirect($baseUrl)->with('error', 'Produto não encontrado!');
    }

    // Calcula end_time baseado no start_time + duração
    $start = Carbon::parse($req->hora);
    $end = $start->copy()->addMinutes($product->duration_minutes);

    // Data enviada no request (provavelmente vem como input hidden)
    $date = $req->date ?? date('Y-m-d'); // ajuste se necessário

    if ($req->peoples >= $product->min_people) {

    }else{
         return redirect($baseUrl)->with('error', 'Selecione a quantidade de pessoas mínimas!');
    }

    // Monta a reserva
    $insert = [
        'product_id'   => $req->product_id,
        'date'         => $date,
        'start_time'   => $start->format('H:i'),
        'end_time'     => $end->format('H:i'),
        'client_name'  => $req->client_name,
        'client_phone' => $req->client_phone ?? null,
        'status'       => $req->status ?? 'pending',
        'peoples'      => $req->peoples ?? '0',
        'created_at'   => now(),
        'updated_at'   => now(),
    ];

    DB::table($table)->insert($insert);

    session()->regenerate();


    return redirect($baseUrl)->with('success', 'Reserva criada com sucesso!');


}

public function checkMinPeople($peoples, $min_people){
    if ($peoples >= $min_people) {
        return true;
    }else{
        $baseUrl = dirname(request()->url());
        return redirect($baseUrl)->with('error', 'Insira a quantidade mínima de pessoas!');

    }
}


}


?>