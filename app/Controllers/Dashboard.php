<?php

namespace App\Controllers;

use App\Models\TypeSchool;
use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\CompanyModel;
use App\Models\RepresentativeCompanyModel;
use App\Models\DatePractise;
use App\Models\Practise;
use App\Models\Class_Practise;
use App\Models\ClassModel;
use App\Models\FieldStudy;
use App\Models\LogCompany;
use App\Models\LogUser;
use App\Models\CategorySkill;
use App\Models\Skill;

class Dashboard extends Controller
{
    var $userModel;
    var $practiseModel;
    var $datePractiseModel;
    var $class_practiseModel;
    var $classModel;
    var $fieldStudy;
    var $typeSchool;
    var $logCompany;
    var $logUser;
    var $companyModel;
    var $representativeCompanyModel;
    var $skill;
    var $categorySkill;
    public function __construct(){
        $this->userModel = new UserModel();
        $this->practiseModel = new Practise();
        $this->class_practiseModel = new Class_Practise();
        $this->datePractiseModel = new DatePractise();
        $this->classModel = new ClassModel();
        $this->fieldStudy = new FieldStudy();
        $this->typeSchool = new TypeSchool();
        $this->logCompany = new LogCompany();
        $this->logUser = new LogUser();
        $this->companyModel = new CompanyModel;
        $this->representativeCompanyModel = new RepresentativeCompanyModel();
        $this->skill = new Skill();
        $this->categorySkill = new CategorySkill();
    }
    //Metody pro zobrazení viewček
    public function homeView(){
        $data= [
            'title' => 'Administrace'
        ];
        return view('dashboard/dash_home', $data);
    }
    public function companyView(){
        $companyes = $this->companyModel->findAll();
        foreach ($companyes as &$company){
            $company['representative'] = $this->representativeCompanyModel->select('id, degree_before, name, surname, degree_after, mail, phone, function, create_time, Company_id')->where('Company_id', $company['id'])->findAll();
        }
        $data= [
            'title' => 'Administrace',
            'companyes' => $companyes,
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
    public function formDateView(){
        $class = $this->classModel->findAll();

        $data = [
            'title' => 'Administrace',
            'class' => $class,
        ];
        return view('dashboard/dash_form_calendar', $data);
    }
    public function peopleView(){
        $users = $this->userModel->paginate(20);
        $pager = $this->userModel->pager;
        foreach($users as &$user){
            $class = $this->classModel->where('id', $user['Class_id'])->first();
            if(!empty($class)){
                $user['class'] = $class;
                $fieldStudy = $this->fieldStudy->where('id', $class['Field_study_id'])->first();
               if(!empty($fieldStudy)){
                $user['field'] = $fieldStudy;
                $typeSchool = $this->typeSchool->where('id', $fieldStudy['Type_school_id'])->first();
                if(!empty($typeSchool)){
                    $user['typeSchool'] = $typeSchool;
                }
               }
            }
        }
        //log_message('info', 'Uživatelé ' . print_r($users, true));
        $data= [
            'title' => 'Administrace',
            'users' => $users,
            'pager' => $pager,
        ];
        return view('dashboard/dash_people', $data);
    }
    public function editUserRole(){
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'error' => 'Neplatný požadavek'])->setStatusCode(400);
        }
        $data = $this->request->getJSON();
        $userId = $data->user_id;
        $role = $data->role;
        $value = $data->value;
        $user = $this->userModel->find($userId);
        $admin = $user['admin'];
        $spravce = $user['spravce'];
        if ($role === 'admin' && $value === 1) {
            $spravce = 0;
            $admin = 1;
        } elseif ($role === 'spravce' && $value === 1) {
            $admin = 0;
            $spravce = 1;
        }else{
            $admin = 0;
            $spravce = 0;
        }
        $updateUser = ['admin' => $admin, 'spravce' => $spravce];
        $this->userModel->update($userId, $updateUser);
        $user = $this->userModel->find($userId);
        return $this->response->setJSON([
            'success' => true,
            'user' => $updateUser,
        ]);
        
    }
    public function skillView(){
        $categoryes = $this->categorySkill->findAll();
        foreach($categoryes as &$category){
            $category['skill'] = $this->skill->where('Category_skill_id', $category['id'])->findAll();
        }
        $data= [
            'title' => 'Administrace',
            'categoryes' => $categoryes,
        ];
        return view('dashboard/dash_skill', $data);
    }
    public function addCategorySkill(){
        $name = $this->request->getPost('name');
        $description = $this->request->getPost('description');
        if(empty($name)){
            //! Je potřeba přidat hlášku pro vrácení, že musí být pole povíné
            return false;
        }
        $data = [
            'name' => $name,
            'description' => $description,
        ];
        $this->categorySkill->insert($data);
        return redirect()->to(base_url('/dashboard-skill'));
    }
    public function addSkill(){
        $name = $this->request->getPost('name');
        $description = $this->request->getPost('description');
        $idCategory = $this->request->getPost('category_id');
        if(empty($name && $idCategory)){
            //! Je potřeba přidat hlášku, která se zobrazí uživateli při vrácení, že nebylo něco vyplněno.
            return false;
        }
        $data = [
            'name' => $name,
            'descrtiption' => $description,
            'Category_skill_id' => $idCategory,
        ];
        $this->skill->insert($data);
        return redirect()->to(base_url('/dashboard-skill'));
    }
    public function deleteCategorySkill($id){
        $this->categorySkill->delete($id);
        $this->skill->where('Category_skill_id', $id)->delete();
        return redirect()->to(base_url('/dashboard-skill'));
    }
    public function deleteSkill($id){
        $this->skill->delete($id);
        return redirect()->to(base_url('/dashboard-skill'));
    }
    public function logView(){
        $userLog = $this->logUser->findAll();
        $userCompany = $this->logCompany->findAll();
        foreach($userLog as &$user){
            $user['user'] = $this->userModel->where('id', $user['User_id'])->first(); 
        }
        foreach($userCompany as &$company){
            $company['user'] = $this->representativeCompanyModel->where('id', $company['Representative_company_id'])->first();
        }
        if(empty($userLog)){
            $useAllData = $userCompany;
        }else if(empty($userCompany)){
            $useAllData = $userLog;
        }else{
            $useAllData = array_merge($userLog, $userCompany);
        if(!empty($useAllData)){
            usort($useAllData, function($a, $b) {
                return strtotime($b['create_time']) - strtotime($a['create_time']);
            });
        }
        }
        $data= [
            'title' => 'Administrace',
            'logs' => $useAllData,
        ];
        return view('dashboard/dash_log', $data);
    }
    //Zpracování (editace) v administraci
    public function addNewDate(){
        $name = $this->request->getPost('name');
        $description = $this->request->getPost('description');
        $dateEndNewOffer = $this->request->getPost('end-new-offer');
        $file = $this->request->getPost('contract-file');
        $dates = $this->request->getPost('dates');
        $classes = $this->request->getPost('classes');

        $dataPractise = [
            'name' => $name,
            'description'=> $description,
            'end_new_offer' => $dateEndNewOffer,
            'contract_file' => $file,
        ];
        $this->practiseModel->insert($dataPractise);
        $lastInsertId = $this->practiseModel->getInsertID();
        foreach($dates as $date){
            $dataDate = [
                'date_from' => $date['date-from'],
                'date_to' => $date['date-to'],
                'Practise_id' => $lastInsertId,
            ];
            $this->datePractiseModel->insert($dataDate);
        }
        if(!empty($classes)){
            foreach ($classes as $class) {
                $dataClass = [
                    'Class_id' => $class,
                    'Practise_id' => $lastInsertId,
                ];
                $this->class_practiseModel->insert($dataClass);
            }
        }
        return redirect()->to(base_url('dashboard-calendar'));
    }
}