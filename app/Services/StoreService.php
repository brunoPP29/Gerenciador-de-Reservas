<?php

namespace App\Services;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class StoreService{

    public function checkEnterprise($empresa){
        $empresa = $empresa.'_products';;
        if (Schema::hasTable($empresa)) {
            $produtos = DB::table($empresa)->get();
            return $produtos;
        } else {
            $empresa = collect(); // retorna coleção vazia
        }
    }

}

?>