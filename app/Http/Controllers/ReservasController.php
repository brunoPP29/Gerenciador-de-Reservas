<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Services\LoginService;
use Illuminate\Http\Request;
use App\Reservas;
use App\Models\Login;


class ReservasController extends Controller
{
    protected $service;

    public function __construct(LoginService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $redirect = $this->service->checkLogin();
        return view($redirect); // renderiza a view correta
    }

    public function login(Request $req){
        $checked = $this->service->checkFields($req);
        if ($checked) {
            $user = $req->input('user');
            $pass = $req->input('password');
            $login = Login::where('user',$user)
                            ->where('password', $pass)
                            ->first();


            if ($login) {
                session()->put('logado', true);
                return view('HomePage');
            }else{
                $data['message'] = 'Verifique todos os Campos';
                return view('LoginPage', $data);
            }
        }else{
            $data['message'] = 'Verifique todos os Campos';
            return view('LoginPage', $data);
        }
    }
    public function loggout(){
        session()->put('logado', false);
        return redirect('/');
    }
}


?>