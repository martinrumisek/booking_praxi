<?php

namespace App\Controllers;
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
        $this->user_practiseModel = new User_OfferPractise();
        $this->practiseManagerModel = new PractiseManager();
        $this->offerPractise = new OfferPractise();
    }
    public function index(): string
    {
        $userSession = session()->get('user');
        $user = $this->userModel->find($userSession['id']);
        $userClass = $this->classModel->find($user['Class_id']);
        $userFieldStudy = $this->fieldStudy->find($userClass['Field_study_id']);
        //$practise = $this->user_practiseModel->select('user_practise.*, practise_offer.*, practise_manager.*, company.*, practise.*, date_practise.*')->join('practise_offer', 'practise_offer.id = user_practise.Offer_practise_id')->join('practise_manager', 'practise_manager.id = practise_offer.Practise_manager_id')->join('company', 'company.id = practise_manager.Company_id')->join('practise', 'practise.id = practise_offer.Practise_id')->join('date_practise', 'date_practise.Practise_id = practise.id', 'left')->where('user_practise.User_id', $user['id'])->findAll();
        $userPractiseOffers = $this->user_practiseModel->where('User_id', $user['id'])->findAll();
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
    public function profileView(){
        $data = ['title' => 'Profil'];
        return view ('profile', $data);
    }
}
