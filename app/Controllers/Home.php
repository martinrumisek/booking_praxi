<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $user = session()->get('user');
        $data = ['title' => 'Hlavní stránka', 'user' => $user];
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
    public function continuationRegister(){
        $data = ['title'=> 'Dokončení registrace'];
        return view('continuation_register', $data);
    }
    public function offerView(){
        $data = ['title' => 'Nabídky praxe'];
        return view ('practise_offer', $data);
    }
    public function people(){
        $data = ['title' => 'Žáci'];
        return view ('people', $data);
    }
    public function companyView(){
        $data = ['title' => 'Firmy'];
        return view ('company', $data);
    }
    public function profileView(){
        $data = ['title' => 'Profil'];
        return view ('profile', $data);
    }
}
