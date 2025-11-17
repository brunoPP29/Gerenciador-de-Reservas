<?php

namespace App\Services;

class RegisterService{

    

    public function checkFields($req){
       $req->validate([
            'name' => ['required', 'string', 'min:3', 'max:50'],
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

        return redirect()->back()->with('success', 'Sucess!');
    }   

}

?>