<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\CompanyModel;
use App\Models\RepresentativeCompanyModel;

class Dashboard extends Controller
{
    public function homeView(){
        $data= [
            'title' => 'Administrace'
        ];
        return view('dashboard/dash_home', $data);
    }
    public function companyView(){
        $data= [
            'title' => 'Administrace'
        ];
        return view('dashboard/dash_company', $data);
    }
    public function deadlinesView(){
        $data= [
            'title' => 'Administrace'
        ];
        return view('dashboard/dash_deadlines', $data);
    }
    public function peopleView(){
        $data= [
            'title' => 'Administrace'
        ];
        return view('dashboard/dash_people', $data);
    }
    public function skillView(){
        $data= [
            'title' => 'Administrace'
        ];
        return view('dashboard/dash_skill', $data);
    }
}