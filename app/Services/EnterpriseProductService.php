<?php

namespace App\Services;

use App\Models\EnterpriseProduct;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

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

}

?>
