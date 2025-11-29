<?php

namespace App\Services;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileService{

    

    public function checkLogin(){
        if (session('logado')) {
            return view('EditProfilePage');
        }else{
            session()->put('urlAfter', url()->current());
            return redirect('https://localhost/reservas/public/');
        }
    }

    public function editUserName($newUser){
    $oldUser = session('userName');

    Users::query()
        ->where('user', $oldUser)
        ->update(['user' => $newUser]);

    $tables = DB::select("SHOW TABLES LIKE '%_reservations'");

    foreach ($tables as $t) {
        $table = array_values((array)$t)[0];

        DB::table($table)
            ->where('client_name', $oldUser)
            ->update(['client_name' => $newUser]);
    }

    session(['userName' => $newUser]);
    return back()->with('success', 'Usuário alterado com sucesso!');
    }


    public function updatePassword($req)
    {
        $userName = session('userName');
        $newPassword = $req->password;
        $confirm = $req->confpassword;

        $user = Users::where('user', $userName)->first();

        if (!$user) {
            return back()->with('error', 'Usuário não encontrado');
        }

        if (!Hash::check($confirm, $user->password)) {
            return back()->with('error', 'Senha incorreta');
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return back()->with('success', 'Senha alterada com sucesso!');
    }

}

?>