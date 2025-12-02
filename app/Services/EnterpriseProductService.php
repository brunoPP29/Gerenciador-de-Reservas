<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\EnterpriseProduct;

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

    public function getTypes(){
        $types = DB::table('types')
        ->get();
        return $types;
    }


    public function register($req)
        {
            // nome seguro da tabela dinâmica
            $tableName = session('tbProducts');

            // criar o objeto do modelo
            $product = new EnterpriseProduct;

            // define a tabela dinamicamente
            $product->setTable($tableName);

            // preenche os dados
            $product->name = $req->name;
            $product->price_per_hour = $req->price_per_hour ?? 0;
            $product->duration_minutes = $req->duration_minutes ?? 60;
            $product->opens_at = $req->opens_at;
            $product->closes_at = $req->closes_at;
            $product->description = $req->description ?? '';
            $product->type = $req->type ?? 'interval';
            $product->min_people = $req->min_people ?? '0';

            // salva usando Eloquent
            $product->save();

            return $product;
        }


}

?>
