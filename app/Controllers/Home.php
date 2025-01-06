<?php

namespace App\Controllers;
use App\Models\User_Skill;
use CodeIgniter\I18n\Time;
use App\Models\OfferPractise;
use App\Models\PractiseManager;
use App\Models\TypeSchool;
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
use App\Models\User_OfferPractise;
class Home extends BaseController
{
    var $session;
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
    var $user_practiseModel;
    var $practiseManagerModel;
    var $offerPractise;
    var $userSession;
    var $companyUser;
    var $user_skill;
    public function __construct(){
        $this->session = session();
        $this->userSession = $this->session->get('user');
        $this->companyUser = $this->session->get('companyUser');
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
        $this->user_practiseModel = new User_OfferPractise();
        $this->practiseManagerModel = new PractiseManager();
        $this->offerPractise = new OfferPractise();
        $this->user_skill = new User_Skill();
    }
    public function homeStudent(){
        $user = $this->userModel->find($this->userSession['id']);
        $userClass = $this->classModel->find($user['Class_id']);
        $userFieldStudy = $this->fieldStudy->find($userClass['Field_study_id']);
        //$practise = $this->user_practiseModel->select('user_practise.*, practise_offer.*, practise_manager.*, company.*, practise.*, date_practise.*')->join('practise_offer', 'practise_offer.id = user_practise.Offer_practise_id')->join('practise_manager', 'practise_manager.id = practise_offer.Practise_manager_id')->join('company', 'company.id = practise_manager.Company_id')->join('practise', 'practise.id = practise_offer.Practise_id')->join('date_practise', 'date_practise.Practise_id = practise.id', 'left')->where('user_practise.User_id', $user['id'])->findAll();
        $userPractiseOffers = $this->user_practiseModel->where('User_id', value: $user['id'])->findAll();
        foreach($userPractiseOffers as &$userPractiseOffer){
            $userPractiseOffer['practiseOffer'] = $this->offerPractise->find($userPractiseOffer['Offer_practise_id']);
            $userPractiseOffer['practiseManager'] = $this->practiseManagerModel->find($userPractiseOffer['practiseOffer']['Practise_manager_id']);
            $userPractiseOffer['company'] = $this->companyModel->find($userPractiseOffer['practiseManager']['Company_id']);
            $userPractiseOffer['practise'] = $this->practiseModel->find($userPractiseOffer['practiseOffer']['Practise_id']);
            $userPractiseOffer['datePractise'] = $this->datePractiseModel->where('Practise_id', $userPractiseOffer['practise']['id'])->findAll();
        }
        $data = ['title' => 'Hlavní stránka', 'user' => $user, 'class' => $userClass, 'fieldStudy' => $userFieldStudy, 'practise' => $userPractiseOffers,];
        return view('home_student', $data);
    }
    public function homeCompany(){
        $nowDate = date('Y-m-d');
        $representativeCompany = $this->representativeCompanyModel->find($this->userSession['idUser']);
        $company = $this->companyModel->find($this->userSession['idCompany']);
        $practises = $this->practiseModel->findAll();
        $count['practise'] = 0;
        foreach($practises as $practise){
            if($nowDate <= $practise['end_new_offer']){
                $count['practise'] = $count['practise'] + 1;
            }
        }
        $users = $this->userModel->findAll();
        $count['userStudent'] = 0;
        foreach($users as $user){
            if($user['Class_id'] !== null){
                $count['userStudent'] = $count['userStudent'] + 1;
            }
        }
        $count['companyCount'] = 0;
        $allCompanyes = $this->companyModel->findAll();
        foreach($allCompanyes as $allCompany){
            if($allCompany['register_company'] == 1){
                $count['companyCount'] = $count['companyCount'] + 1;
            }
        }
        $data = [
            'title' => 'Hlavní stránka',
            'company' => $company,
            'user' => $representativeCompany,
            'count' => $count,
        ];
        return view('company/home_company', $data);
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
        $search = $this->request->getGet('search');
        if(empty($search)){
            $users = $this->userModel->where('role', 'student')->paginate(20);
        }else{
            $users = $this->userModel->where('role', 'student')->groupStart()->like('name', $search)->orLike('surname', $search)->groupEnd()->paginate(20);
        }
        $pager = $this->userModel->pager;
        foreach($users as &$user){
            $user['class'] = $this->classModel->where('id', $user['Class_id'])->first();
            $user['fieldStudy'] = $this->fieldStudy->where('id', $user['class']['Field_study_id'])->first();
        }   
        $data = [
            'title' => 'Žáci',
            'users' => $users,
            'pager' => $pager,
        ];
        return view ('people', $data);
    }
    public function companyView(){
        $search = $this->request->getGet('search');
        if(empty($search)){
            $companyes = $this->companyModel->where('register_company', 1)->paginate(8);
        }else{
            $companyes = $this->companyModel->where('register_company', 1)->groupStart()->like('name', $search)->orLike('city', $search)->orLike('street', $search)->orLike('post_code', $search)->groupEnd()->paginate(8);
        }
        $pager = $this->companyModel->pager;
        $data = [
            'title' => 'Firmy',
            'companyes' => $companyes,
            'pager' => $pager,
        ];
        return view ('company', $data);
    }
    public function profileView(){
        $id = $this->userSession['id'];
        $user = $this->userModel->find($id);
        $userClass = $this->classModel->find($user['Class_id']);
        $userFieldStudy = $this->fieldStudy->find($userClass['Field_study_id']);
        $categoryes = $this->categorySkill->findAll();
        foreach($categoryes as &$category){
            $category['skill'] = $this->skill->join('User_has_Skill', 'Skill.id = User_has_Skill.Skill_id')->where('User_has_Skill.User_id', $id)->where('Skill.Category_skill_id', $category['id'])->find();
        }
        $data = [
            'title' => 'Profil',
            'user' => $user,
            'class' => $userClass,
            'fieldStudy' => $userFieldStudy,
            'categoryes' => $categoryes,
        ];
        return view ('profile', $data);
    }
    public function allProfileView($idUser){
        $id = $idUser;
        $user = $this->userModel->find($id);
        $userClass = $this->classModel->find($user['Class_id']);
        $userFieldStudy = $this->fieldStudy->find($userClass['Field_study_id']);
        $categoryes = $this->categorySkill->findAll();
        foreach($categoryes as &$category){
            $category['skill'] = $this->skill->join('User_has_Skill', 'Skill.id = User_has_Skill.Skill_id')->where('User_has_Skill.User_id', $id)->where('Skill.Category_skill_id', $category['id'])->find();
        }
        $data = [
            'title' => 'Profil',
            'user' => $user,
            'class' => $userClass,
            'fieldStudy' => $userFieldStudy,
            'categoryes' => $categoryes,
        ];
        return view ('profile', $data);
    }
}
