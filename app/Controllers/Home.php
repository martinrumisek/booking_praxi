<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = ['title' => 'Hlavní stránka'];
        return view('index', $data);
    }
    public function login(){
        $data = ['title' => 'Přihlášení'];
        return view('login', $data);
    }
    public function registration(){
        $data = ['title' => 'Registrace firmy'];
        return view('registration', $data);
    }
}
