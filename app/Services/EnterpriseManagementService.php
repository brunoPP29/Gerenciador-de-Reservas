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

    public function getReservations(){
        return DB::table(session('tbReservations'))
        ->get();
    }

    public function getReservationStatus($id){
        return DB::table(session('tbReservations'))
            ->where('id', $id)
            ->select('status')
            ->get();
    }

    public function changeStatus($statusAtual, $idChange){
        $statusChange = $statusAtual[0]->status === 'confirmed'
            ? 'canceled'
            : 'confirmed';
        $change = DB::table(session('tbReservations'))
                    ->where('id', $idChange)
                    ->update(array(
                        'status' => $statusChange
                    ));
        if ($change) {
            return true;
        }else{
            return false;
        }
    }

    public function deleteReservation($id){
        DB::table(session('tbReservations'))
            ->where('id', $id)
            ->delete();
    }


    }


