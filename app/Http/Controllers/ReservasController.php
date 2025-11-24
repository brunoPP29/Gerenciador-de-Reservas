<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
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

public function login(Request $req)
{
    // Validação
    $req->validate([
        'user' => 'required|string',
        'password' => 'required|string',
    ]);

    $userInput = $req->input('user');
    $passInput = $req->input('password');

    $user = Login::where('user', $userInput)->first();

    if ($user && Hash::check($passInput, $user->password)) {
        if (session('urlAfter') == true) {
            return redirect((string) session('urlAfter'));
            session()->put('logado', true);
            session()->put('urlAfter', false);
            session()->put('logado', $req->input('user'));
        }
        session()->put('logado', true);
        return view('HomePage');
    }

    // Se falhar login
    return redirect()->back()->withInput()->with('error', 'Usuário ou senha incorretos!');
}


    public function loggout(){
        session()->put('logado', false);
        session()->put('logadoenterprise', false);

        return redirect('/');
    }
}


?>