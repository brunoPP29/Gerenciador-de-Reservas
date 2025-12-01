<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;



class EnterpriseManagementService
{
    public function checkLogin()
    {
        if (session('logadoenterprise')) {
            return false;
        }else{
            $url = url()->current();;
            session()->put('urlAfter', $url);
            return redirect('enterprise');
        }
    }   

    public function getProducts(){
        return DB::table(session('tbProducts'))
        ->get();


    }


    }


