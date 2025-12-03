<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ProfileService;

class ProfileController extends Controller{

    protected $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }

    public function index(){
        $redirect = $this->service->checkLogin();
        return $redirect;
    }

    public function edit(Request $req){
        if (isset($req->password)) {
            $passwordEdit = $this->service->updatePassword($req);
            if ($passwordEdit === 'noUser') {
                return back()->with('error', 'Usuário não encontrado');
            }
            if ($passwordEdit === 'incorretPassword') {
                return back()->with('error', 'Senha inserida está incorreta!');
            }
            if ($passwordEdit === 'success') {
                return back()->with('success', 'Senha alterada com sucesso!');
            }
        }
        if (isset($req->username)) {
            $userEdit = $this->service->editUserName($req->username);
            if ($userEdit === 'UserEdited') {
                return back()->with('success', 'Usuário editado com sucesso');
            }else{
                return back()->with('error', 'Houve algum problema...');
            }
        }

        return back();

        }
    }

