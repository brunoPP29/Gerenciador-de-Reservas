<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnValue;

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

    public function deleteProduct($id){
        $delete = DB::table(session('tbProducts'))
            ->where('id', $id)
            ->delete();
        if ($delete) {
            return true;
        }else{
            return false;
        }
    }


    }


