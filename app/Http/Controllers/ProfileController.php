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
        return $this->service->updatePassword($req);
        }

        return back();

        }
    }

