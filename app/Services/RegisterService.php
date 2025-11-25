<?php

namespace App\Services;
use App\Models\Register;
use Illuminate\Support\Facades\Hash;

class RegisterService{

    

    public function checkFields($req){
    $req->validate([
        'user' => ['required', 'string', 'min:3', 'max:50', 'unique:users,user'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => [
            'required',
            'string',
            'min:8',
            'regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/',
        ],
    ]);

    return true;
}
 

    public function register($req){

    $user = Register::create([
        'user' => $req->user,
        'email' => $req->email,
        'password' => Hash::make($req->password), // nunca armazene senha sem hash
    ]);
        session()->put('logado', true);
        return redirect()->back()->with('success', 'User registered successfully!');
    }

}

?>