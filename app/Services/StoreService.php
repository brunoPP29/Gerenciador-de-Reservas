<?php

namespace App\Services;
use App\Models\EnterpriseLogin;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;



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
        if (Schema::hasTable(session('tbProducts'))) {
            $produtos = DB::table(session('tbProducts'))->get();
            //
                                //se tiver DENTRO DO ITEM PARA RESERVAR
                                if ($name != null) {
                                $productInfo = $this->getProduct($name);
                                if ($productInfo->type === 'calendar') {
                                    return ['BookCalendarPage', $productInfo];
                                }
                                return ['BookPage', $productInfo];
                                ///
                            }else{
                                //GET PRODUCTS
                                $dadosEmpresa = $this->getEnterprise($empresa);
                                return ['ProductsPage', $dadosEmpresa, $produtos];
                            }
            } else {
                //se não tiver a tabela/empresa
                return '404Page';
            }
    }

    public function getEnterprise($empresa){
        $parts = explode('_', $empresa);
        $email =  strtolower($parts[0].'@'.implode('.', array_slice($parts, 1)));
        $emailChecked = EnterpriseLogin::where('email', $email)->first();

        if ($emailChecked != '') {
            return $emailChecked;
        }


    }

    public function getProduct($nameItem){
    //$nameItem = str_replace('-', ' ', $nameItem);
    return DB::table(session('tbProducts'))
        ->where('name', $nameItem)
        ->first();



    }

    public function hasConflict($table, $date, $start, $end, $id, $pessoas)
        {
            $product = DB::table(session('tbProducts'))->where('id', $id)->first();
            $minutos = Carbon::parse($start)->diffInMinutes($end);
            if ($minutos >= $product->duration_minutes) {
                $date = Carbon::parse($date);
                $hoje = Carbon::today();
                if ($date->lt($hoje)) {
                    return 'futureday';

                } else {
                //continua
                }
            }else{
                return ['minutesblock', $product->duration_minutes];
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
                        return 'alreadybooked';
                    }
                }

                if (isset($pessoas)) {
                    if ($pessoas < $product->min_people) {
                        return 'minpeople';
                    }
                }
        }

    public function saveReservation($table, $data){
            $conflict = $this->hasConflict($table, $data['date'], $data['start_time'], $data['end_time'], $data['product_id'], $data['peoples'] ?? null);
            if($conflict) {
                return $conflict;
            }else{
                    //continua
                    $data['created_at'] = now();
                    $data['updated_at'] = now();
                    if (isset($data['peoples'])) {
                        
                    }else{
                        $data['peoples'] = null;
                    }
                    $data = Arr::except($data, ['duration_minutes', 'min_people']);
                if(DB::table($table)->insert($data)){
                    session()->regenerate();
                    //send email
                    $this->sendEmails($data, $table);
                    return 'success';
                }else{
                    return 'error';
                }
            }


        }

    public function sendEmails($data){
        $emailClient = Users::where('user', $data['client_name'])
                        ->select('email')
                        ->get();
        
        $reservaInfo = [
            'date'       => $data['date'],
            'start_time' => $data['start_time'],
            'end_time'   => $data['end_time'],
            'product_id' => $data['product_id'],
            'peoples'    => $data['peoples'],
        ];

        $mensagemHTML = "
        <html>
        <head>
        <style>
            body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            }
            .reserva-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 8px;
            background-color: #f9f9f9;
            }
            .reserva-container h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            }
            .reserva-item {
            margin-bottom: 10px;
            }
            .label {
            font-weight: bold;
            }
        </style>
        </head>
        <body>
        <div class='reserva-container'>
            <h2>Nova Reserva</h2>
            <div class='reserva-item'><span class='label'>Data:</span> {$reservaInfo['date']}</div>
            <div class='reserva-item'><span class='label'>Início:</span> {$reservaInfo['start_time']}</div>
            <div class='reserva-item'><span class='label'>Fim:</span> {$reservaInfo['end_time']}</div>
            <div class='reserva-item'><span class='label'>Produto ID:</span> {$reservaInfo['product_id']}</div>
            <div class='reserva-item'><span class='label'>Pessoas:</span> {$reservaInfo['peoples']}</div>
        </div>
        </body>
        </html>
        ";

        $this->enviarEmailReserva($emailClient[0]['email'], $mensagemHTML);
        $this->enviarEmailReserva(session('emailEnterprise'), $mensagemHTML);

    }

    public function enviarEmailReserva($email, $mensagemHTML) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Mail::html($mensagemHTML, function ($msg) use ($email) {
                $msg->to($email)
                    ->subject('Reserva confirmada!');
            });
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
        return ['error404', $baseUrl];
    }

    // Calcula end_time baseado no start_time + duração
    $start = Carbon::parse($req->hora);
    $end = $start->copy()->addMinutes($product->duration_minutes);

    // Data enviada no request (provavelmente vem como input hidden)
    $date = $req->date ?? date('Y-m-d'); // ajuste se necessário

    if ($req->peoples >= $product->min_people) {

    }else{
         return ['minpeople', $baseUrl];
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


    return ['success', $baseUrl];


}


}


?>