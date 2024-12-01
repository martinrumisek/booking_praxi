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
        $session = session();
        if (!$session->has('registration_start') || $session->get('registration_start') !== true) {
            return redirect()->to(base_url('/registration'));
        }
        $companyData = $session->get('company');
        $data = [
            'title'=> 'Dokončení registrace',
            'name_company' => $companyData['name_company'],
            'ico' => $companyData['ico'],
            'mail' => $companyData['mail'],
            'town' => $companyData['town'],
            'street' => $companyData['street'],
            'postCode' => $companyData['postCode'],
            'legal_form' => $companyData['legal_form'],
        ];
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
