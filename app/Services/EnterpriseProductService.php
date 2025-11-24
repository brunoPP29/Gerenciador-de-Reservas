<?php

namespace App\Services;

use App\Models\EnterpriseProduct;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use PHPUnit\Metadata\ExcludeGlobalVariableFromBackup;

class EnterpriseProductService{

public function checkLogin()
{
    if (session('logadoenterprise') === true) {

        return 'EnterpriseRegisterProductPage';

    } else {
        session()->put('logadoenterprise', false);
        return false; // indica que não está logado
    }
}

    public function register($req){
            // validação mínima

        // nome seguro da tabela dinâmica
        $tableName = preg_replace('/[^a-zA-Z0-9]/', '_', session('tableOrigin')) . '_products';

        // inserir produto
        DB::table($tableName)->insert([
            'name' => $req->name,
            'price_per_hour' => $req->price_per_hour ?? 0,
            'duration_minutes' => $req->duration_minutes ?? 60,
            'opens_at' => $req->opens_at,
            'closes_at' => $req->closes_at,
            'description' => $req->description ?? '',
        ]);

        return 'ok';

    }

}

?>
