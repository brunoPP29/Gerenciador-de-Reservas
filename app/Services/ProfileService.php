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
    return 'UserEdited';
    }


    public function updatePassword($req)
    {
        $userName = session('userName');
        $newPassword = $req->password;
        $confirm = $req->confpassword;

        $user = Users::where('user', $userName)->first();

        if (!$user) {
            return 'noUser';
        }

        if (!Hash::check($confirm, $user->password)) {
            return 'incorrectPassword';
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        return 'success';
    }

}

?>