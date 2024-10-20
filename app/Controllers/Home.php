<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    public function login(){
        $data = ['title' => 'Přihlášení'];
        return view('login', $data);
    }
}
