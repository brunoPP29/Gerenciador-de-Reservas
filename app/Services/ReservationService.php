<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Models\Store;

class ReservationService{

public function checkLogin()
{
    if (session('logado') === true) {
        $reservations = $this->getReservations();
        return [$reservations, 'AppointmentsPage'];

    } else {
        session()->put('logado', false);
        session()->put('urlAfter', url()->current());
        return 'redirectUrl'; // indica que não está logado
    }
}


public function getReservations(){

    $userName = session('userName');
    $allReservations = new Collection();

    if (!$userName) {
        return $allReservations; 
    }

    $driver = DB::connection()->getDriverName();
    $tableList = [];

    if ($driver === 'mysql') {
        $tables = DB::select("SHOW TABLES LIKE '%_reservations'");
        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0];
            $tableList[] = $tableName;
        }
    } 

    foreach ($tableList as $tableName) {
        try {
            $reservations = DB::table($tableName)
                                ->where('client_name', $userName)
                                ->get();
            
            $reservations->each(function ($item) use ($tableName) {
                $item->source_table = $tableName;
            });

            $allReservations = $allReservations->merge($reservations);

        } catch (\Illuminate\Database\QueryException $e) {
            continue; 
        }
    }

    return $allReservations;
}


public function delete($infos) {
    $id = $infos->id;
    $table = $infos->table;

    $reserva = DB::table($table)->where('id', $id)->first();
    if (!$reserva) return 'notfound';

    $product = DB::table(session('tbProducts'))->where('id', $reserva->product_id)->first();
    if (!$product) return 'notfound';

    $now = Carbon::now();
    $reservaDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $reserva->date . ' ' . $reserva->start_time);

    if ($now->diffInHours($reservaDateTime, false) < $product->cancel_time) {
        return 'expired';
    }

        Store::query()
            ->from($table) // define tabela dinamicamente
            ->where('id', $id)
            ->update([
                'status' => 'canceled'
            ]);
            return 'comeback';
            }


}
    






?>
