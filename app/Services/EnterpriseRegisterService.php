<?php

namespace App\Services;
use App\Models\EnterpriseRegister;
use Illuminate\Support\Facades\Hash;

class EnterpriseRegisterService{

    

    public function checkFields($req){
    $req->validate([
        'name' => ['required', 'string', 'min:3', 'max:50'],
        'email' => ['required', 'email', 'max:255', 'unique:enterprise,email'],
        'password' => [
            'required',
            'string',
            'min:8',
            'regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/'],
        'phone' => [
            'required',
            'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/',
            'unique:enterprise,phone'
]
    ]);

    return true;
}
 

    public function register($req){

    $user = EnterpriseRegister::create([
        'name' => $req->name,
        'phone' => $req->phone,
        'email' => $req->email,
        'password' => Hash::make($req->password),
    ]);
    }

}

?>