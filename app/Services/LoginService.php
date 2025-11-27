<?php
namespace App\Services;
use Illuminate\Support\Facades\Hash;
use App\Models\Login;
use Illuminate\Support\Facades\DB;


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
                session()->put('userName', $userInput);
                return redirect((string) session('urlAfter'));
            }else{
            session()->put('logado', true);
            session()->put('userName', $userInput);
            $userName = session('userName');
            $statusReservations = $this->getStatus();
            return view('HomePage', compact('userName', 'statusReservations'));
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

    public function getStatus(){
        $userName = session('userName');
        $totalR = 0;
        $totalC = 0;
        $totalF = 0;

        $tables = DB::select("SHOW TABLES LIKE '%_reservations'");

        foreach ($tables as $tableObj) {
            // Pega o nome da tabela (a chave muda conforme o banco)
            $table = array_values((array) $tableObj)[0];

            $countR = DB::table($table)
                ->where('client_name', $userName)
                ->count();

            $totalR += $countR;

            $countC = DB::table($table)
                ->where('client_name', $userName)
                ->where('status', 'confirmed')
                ->count();

            $totalC += $countC;

            $countF= DB::table($table)
                ->where('client_name', $userName)
                ->where('status', 'canceled')
                ->count();

            $totalF += $countF;

        }
        return [$totalR, $totalC, $totalF];
    }
}
