<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers; use App\Http\Controllers\Controller; use Illuminate\Http\Request; use App\Services\EnterpriseManagementService; use App\Reservas; use App\Models\EnterpriseProduct;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class EnterpriseManagementController extends Controller
{
    protected $service;

public function __construct(EnterpriseManagementService $service)
{
    $this->service = $service;
}
    //products
    public function products(){
        $login = $this->service->checkLogin();

        if (!$login) {
            $products = $this->service->getProducts();
            return view('EnterpriseProductManagementPage', compact('products'));
        }else{
            if ($login === 'enteprise') {
                return $login;
            }
        }
    }

    public function deleteProduct(Request $req){
        $login = $this->service->checkLogin();

        if (!$login) {
            $idDelete = $req->id;
            $this->service->deleteProduct($idDelete);
            return redirect('/enterprise/manageProducts');
        }else{
            return $login;
        }
        
    }
    ////reservations


    public function reservations(){
        $login = $this->service->checkLogin();

        if (!$login) {
            //logado
            $reservations = $this->service->getReservations();
            return view('EnterpriseReservationsManagementPage', compact('reservations'));
        }else{
            return $login;
        }
    }

    public function statusChange(Request $req){
        $login = $this->service->checkLogin();

        if (!$login) {
            $idChange = $req->id;
            $statusAtual = $this->service->getReservationStatus($idChange);
            $this->service->changeStatus($statusAtual, $idChange);
            return redirect('/enterprise/reservations');         
        }else{
            return $login;
        }
        
    }

    public function deleteReservation(Request $req){
        $login = $this->service->checkLogin();
        if (!$login) {
            $idDelete = $req->id;
            $this->service->deleteReservation($idDelete);
            return redirect('/enterprise/reservations');         
        }else{
            return $login;
        }
    }

}


