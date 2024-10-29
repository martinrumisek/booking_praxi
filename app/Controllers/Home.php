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
}
