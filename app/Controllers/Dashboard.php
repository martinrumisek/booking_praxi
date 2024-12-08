<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\CompanyModel;
use App\Models\RepresentativeCompanyModel;
use App\Models\DatePractise;
use App\Models\Practise;
use App\Models\Class_Practise;
use App\Models\ClassModel;

class Dashboard extends Controller
{
    var $practiseModel;
    var $datePractiseModel;
    var $class_practiseModel;
    var $classModel;
    public function __construct(){
        $this->practiseModel = new Practise();
        $this->class_practiseModel = new Class_Practise();
        $this->datePractiseModel = new DatePractise();
        $this->classModel = new ClassModel();
    }
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
        
        $practises = $this->practiseModel->findAll();
        foreach($practises as &$practise){
            $practise['dates'] = $this->datePractiseModel->where('Practise_id', $practise['id'])->findAll();
            $practise['class'] = [];
            $classIds = $this->class_practiseModel->where('Practise_id', $practise['id'])->findAll();
            foreach($classIds as $classId){
                $class = $this->classModel->find($classId['Class_id']);
                $practise['class'][] = $class;
            }
        }
        $data= [
            'title' => 'Administrace',
            'practises' => $practises,
        ];
        return view('dashboard/dash_calendar', $data);
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