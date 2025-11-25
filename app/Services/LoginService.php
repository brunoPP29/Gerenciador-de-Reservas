<?php
namespace App\Services;
use Illuminate\Support\Facades\Hash;
use App\Models\Login;


class LoginService
{
    public function checkLogin()
    {


        if (session('logado') === true) {
            session()->put('urlAfter', false);
            return 'HomePage';
            if (session('logadoenterprise')) {
                return 'EnterprisePage';
            }
        } else {
            session()->put('logado', false);
            return 'LoginPage';
        }
    }

   public function login($req){
        $req->validate([
            'user' => 'required|string',
            'password' => 'required|string',
        ]);

        $userInput = $req->input('user');
        $passInput = $req->input('password');

        $user = Login::where('user', $userInput)->first();

        if ($user && Hash::check($passInput, $user->password)) {
            if (session('urlAfter') == true) {
                session()->put('logado', true);
                session()->put('userName', $req->input('user'));
                return redirect((string) session('urlAfter'));
            }else{
            session()->put('logado', true);
            session()->put('userName', $req->input('user'));
            return view('HomePage');
            }
        }

        // Se falhar login
        return redirect()->back()->withInput()->with('error', 'Usuário ou senha incorretos!');

    }

    public function loggout(){
        session()->put('logado', false);
        session()->put('logadoenterprise', false);
        session()->put('userName', false);
        return redirect('/');
    }
}
