<?php

namespace App\Services;
use App\Models\Store;
use App\Models\EnterpriseProduct;
use App\Models\EnterpriseLogin;
use App\Models\DynamicTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class StoreService{

    public function checkLogin(){
        $url = url()->current();

        if (session('logado') === true) {
            session()->put('urlAfter', false);
            return true;
        }else{
            session()->put('urlAfter', $url);
            return false;

        }
    }

    public function checkEnterprise($empresa){
        $tbprodutos = $empresa.'_products';;
        if (Schema::hasTable($tbprodutos)) {
            $produtos = DB::table($tbprodutos)->get();
            return $produtos;
        } else {
            $empresa = collect(); // retorna coleção vazia
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

    public function hasConflict($table, $date, $start, $end)
        {
            return DB::table($table)
                ->where('date', $date)
                ->where(function($q) use ($start, $end) {
                    $q->where('start_time', '<', $end)
                    ->where('end_time', '>', $start);
                })
                ->exists();
        }

    public function saveReservation($table, $data){
            // checar conflito
            if ($this->hasConflict($table, $data['date'], $data['start_time'], $data['end_time'])) {
                return false; // conflito detectado
            }

            // garante timestamps
            $data['created_at'] = now();
            $data['updated_at'] = now();

            return DB::table($table)->insert($data);
        }



}

?>