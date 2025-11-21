<?php

namespace App\Services;
use App\Models\Store;
use App\Models\EnterpriseProduct;
use App\Models\EnterpriseLogin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class StoreService{

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

    public function getIdProduct($nameItem){
        $product = EnterpriseProduct::where('name', $nameItem)->first();

            if ($product) {
                return $product->id; 
            }
    }

}

?>