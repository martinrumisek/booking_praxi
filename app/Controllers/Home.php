<?php

namespace App\Controllers;
use App\Models\Skill_OfferPractise;
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
use App\Models\SocialLink;
use App\Models\SocialLink_User;
use App\Models\ResetPassword;
use App\Controllers\Email;
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
    var $socialLink;
    var $socialLink_user;
    var $skill_offerPractise;
    var $mail;
    var $resetPassword;
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
        $this->socialLink = new SocialLink();
        $this->socialLink_user = new SocialLink_User();
        $this->user_skill = new User_Skill();
        $this->skill_offerPractise = new Skill_OfferPractise();
        $this->mail = new Email();
        $this->resetPassword = new ResetPassword();
    }
    public function index(){
        return redirect()->to('/login');
    }
    private function backUrl($url){
        $previousUrl = $this->request->getServer('HTTP_REFERER');
            if ($previousUrl) {
                return redirect()->to($previousUrl);
            } else {
                return redirect()->to($url);
            }
    }
    public function homeStudent(){
        $idUser = $this->userSession['id'];
        $user = $this->userModel->where('user_id', $idUser)->join('Class', 'Class.class_id = User.Class_class_id AND Class.class_del_time IS NULL', 'left')->join('Field_study', 'Field_study.field_id = Class.Field_study_field_id AND Field_study.field_del_time IS NULL', 'left')->first();
        $userPractiseOffer = $this->user_practiseModel->where('User_user_id', $user['user_id'])->where('user_offer_accepted != ', null)->where('user_offer_accepted', 1)->join('Offer_practise', 'User_has_Offer_practise.Offer_practise_offer_id = Offer_practise.offer_id AND Offer_practise.offer_del_time IS NULL', 'left')->join('Practise_manager', 'Offer_practise.Practise_manager_manager_id = Practise_manager.manager_id AND Practise_manager.manager_del_time IS NULL', 'left')->join('Company', 'Practise_manager.Company_company_id = Company.company_id AND Company.company_del_time IS NULL', 'left')->first();
        $practiseDate = $this->class_practiseModel->where('Class_class_id', $user['class_id'])->where('class_practise_del_time', null)->join('Practise', 'Class_has_Practise.Practise_practise_id = Practise.practise_id AND Practise.practise_del_time IS NULL', 'left')->first();
        $dates = '';
        $userOffer = '';
        if(!empty($practiseDate)){
            $dates = $this->datePractiseModel->where('Practise_practise_id', $practiseDate['practise_id'])->find();
            $userOffer = $this->user_practiseModel->where('user_offer_del_time', null)->where('User_user_id', $idUser)->groupStart()->where('user_offer_like', 1)->orWhere('user_offer_select', 1)->groupEnd()->join('Offer_practise', 'User_has_Offer_Practise.Offer_practise_offer_id = Offer_practise.offer_id AND Offer_practise.offer_del_time IS NULL', 'left')
            ->join('Practise_manager', 'Offer_practise.Practise_manager_manager_id = Practise_manager.manager_id AND Practise_manager.manager_del_time IS NULL', 'left')
            ->join('Company', 'Practise_manager.Company_company_id = Company.company_id AND Company.company_del_time IS NULL', 'left')->find();
        }
        $data = [
            'title' => 'Hlavní stránka',
            'user' => $user,
            'practise' => $userPractiseOffer,
            'dates' => $dates,
            'practiseDate' => $practiseDate,
            'userOffers' => $userOffer,
        ];
        return view('home_student', $data);
    }
    public function informationApp(){
        $data = [
            'title' => 'Informace o aplikaci',
        ];
        return view('info', $data);
    }
    public function writeStudentOfferPractise(){
        $idUser = $this->userSession['id'];
        $offerName = $this->request->getPost('name_offer');
        $offerCity = $this->request->getPost('city_offer');
        $offerStreet = $this->request->getPost('street_offer');
        $offerPostCode = $this->request->getPost('post_code_offer');
        $managerDegreeBefore = $this->request->getPost('degree_before_manager');
        $managerName = $this->request->getPost('name_manager');
        $managerSurname = $this->request->getPost('surname_manager');
        $managerDegreeAfter = $this->request->getPost('degree_after_manager');
        $managerMail = $this->request->getPost('mail_manager');
        $managerPhone = $this->request->getPost('phone_manager');
        $managerPosition = $this->request->getPost('position_manager');
        $companyIco = $this->request->getPost('ico_company');
        $companyLegalForm = $this->request->getPost('legal_form_company');
        $idPractise = $this->request->getPost('id_practise');
        if(empty($idUser && $offerName && $offerCity && $offerStreet && $offerPostCode && $managerName && $managerSurname && $managerMail && $managerPhone && $managerPosition && $companyLegalForm && $idPractise)){
            $this->session->setFlashdata('err_message', 'Akce se nemohla provést, protože nebyly vyplněny všechna políčka!');
            return redirect()->to(base_url('home-student'));
        }
        $isValid = $this->verifyCompany($companyIco);
        if(empty($isValid)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci provést ještě jednou.');
            return redirect()->to(base_url('home-student'));
        }
        $companyName = $isValid['obchodniJmeno'];
        $companyTown = $isValid['sidlo']['nazevObce'];
        if(empty($isValid['sidlo']['nazevUlice'])){
            $companyStreet = $isValid['sidlo']['nazevObce'] . ' ' . $isValid['sidlo']['cisloDomovni'];
        }else{
            $companyStreet = $isValid['sidlo']['nazevUlice'].' '.$isValid['sidlo']['cisloDomovni'];
        }
        $companyPostCode = $isValid['sidlo']['psc'];
        $companyLegalNumberForm = $isValid['pravniForma'];
        $companyData = [
            'company_name' => $companyName,
            'company_ico' => $companyIco,
            'company_subject' => $companyLegalForm,
            'company_legal_form' => $companyLegalNumberForm,
            'company_city' => $companyTown,
            'company_street' => $companyStreet,
            'company_post_code' => $companyPostCode,
            'company_agree_document' => 0,
            'company_register_company' => 0,
        ];
        $idInsertCompany = $this->companyModel->insert($companyData);
        $managerData = [
            'manager_degree_before' => $managerDegreeBefore,
            'manager_name' => $managerName,
            'manager_surname' => $managerSurname,
            'manager_degree_after' => $managerDegreeAfter,
            'manager_mail' => $managerMail,
            'manager_phone' => $managerPhone,
            'manager_position_works' => $managerPosition,
            'Company_company_id' => $idInsertCompany,
        ];
        $idInsertManager = $this->practiseManagerModel->insert($managerData);
        $offerData = [
            'offer_name' => $offerName,
            'offer_city' => $offerCity,
            'offer_street' => $offerStreet,
            'offer_post_code' => $offerPostCode,
            'Practise_practise_id' => $idPractise,
            'Practise_manager_manager_id' => $idInsertManager,
        ];
        $idInsertOffer = $this->offerPractise->insert($offerData);
        $acceptedOfferData = [
            'User_user_id' => $idUser,
            'Offer_practise_offer_id' => $idInsertOffer,
            'user_offer_accepted' => 1,
            'user_offer_select' => 1,
        ];
        $idAcceptedOffer = $this->user_practiseModel->insert($acceptedOfferData);
        $user_offers = $this->user_practiseModel->where('User_user_id', $idUser)->where('user_offer_id !=', $idAcceptedOffer)->find();
        foreach($user_offers as $offer){
            $this->user_practiseModel->delete($offer['user_offer_id']);
        }
        return $this->backUrl('home-student');
    }
    private function verifyCompany($ico){
        $url = "http://ares.gov.cz/ekonomicke-subjekty-v-be/rest/ekonomicke-subjekty/$ico";
        $header = get_headers($url, 1);
        if(strpos($header[0],"404") !== false){
            return null;
        }
        $response = @file_get_contents($url);
        if($response === false){
            return null;
        }
        $data = json_decode($response, true);
        if(isset($data["ico"]) && $data["ico"] === $ico){
            return $data;
        }else{return null;}
    }
    public function homeCompany(){
        $nowDate = date('Y-m-d');
        $representativeCompany = $this->representativeCompanyModel->find($this->companyUser['idUser']);
        $company = $this->companyModel->find($this->companyUser['idCompany']);
        $practises = $this->practiseModel->findAll();
        $count['practise'] = 0;
        foreach($practises as $practise){
            if($nowDate <= $practise['practise_end_new_offer']){
                $count['practise'] = $count['practise'] + 1;
            }
        }
        $users = $this->userModel->findAll();
        $count['userStudent'] = 0;
        foreach($users as $user){
            if($user['Class_class_id'] !== null){
                $count['userStudent'] = $count['userStudent'] + 1;
            }
        }
        $count['companyCount'] = 0;
        $allCompanyes = $this->companyModel->where('company_register_company', 1)->findAll();
        foreach($allCompanyes as $allCompany){
            if($allCompany['company_register_company'] == 1){
                $count['companyCount'] = $count['companyCount'] + 1;
            }
        }
        $selectStudent = $this->practiseManagerModel->where('Company_company_id', $this->companyUser['idCompany'])->join('Offer_practise', 'Practise_manager.manager_id = Offer_practise.Practise_manager_manager_id AND Offer_practise.offer_del_time IS NULL')
        ->join('User_has_Offer_practise', 'Offer_practise.offer_id = User_has_Offer_practise.Offer_practise_offer_id AND User_has_Offer_practise.user_offer_select = 1 AND User_has_Offer_practise.user_offer_accepted IS NULL AND User_has_Offer_practise.user_offer_del_time IS NULL')
        ->join('User', 'User_has_Offer_practise.User_user_id = User.user_id AND User.user_del_time IS NULL')
        ->join('Class', 'User.Class_class_id = Class.class_id AND Class.class_del_time IS NULL')
        ->join('Field_study', 'Class.Field_study_field_id = Field_study.field_id AND Field_study.field_del_time IS NULL')->OrderBy('User_has_Offer_practise.user_offer_edit_time', 'DESC')->findAll(5);
        $resultNewPractises = $this->practiseModel->where('practise_end_new_offer >=', $nowDate)->join('Date_practise', 'Practise.practise_id = Date_practise.Practise_practise_id AND Date_practise.date_del_time IS NULL')->findAll();
        $newPractises = [];
        foreach($resultNewPractises as $practise){
            $idPractise = $practise['practise_id'];
            if(!isset($newPractises[$idPractise])){
                $newPractises[$idPractise] = [
                    'practise_name' => $practise['practise_name'],
                    'practise_end_new_offer' => $practise['practise_end_new_offer'],
                    'dates' => [],
                ];
            }
            $idDate = $practise['date_id'];
            if(!isset($newPractises[$idPractise]['dates'][$idDate])){
                $newPractises[$idPractise]['dates'][$idDate] = [
                    'date_date_from' => $practise['date_date_from'],
                    'date_date_to' => $practise['date_date_to'],
                ];
            }
        }
        $actualPractises = $this->datePractiseModel->where('date_date_from <=', $nowDate)->where('date_date_to >=', $nowDate)->join('Practise', 'Date_practise.Practise_practise_id = Practise.practise_id AND Practise.practise_del_time IS NULL')
        ->join('Offer_practise', 'Practise.practise_id = Offer_practise.Practise_practise_id AND Offer_practise.offer_del_time IS NULL')->join('Practise_manager', 'Offer_practise.Practise_manager_manager_id = Practise_manager.manager_id AND Practise_manager.manager_del_time IS NULL')
        ->join('User_has_Offer_practise', 'Offer_practise.offer_id = User_has_Offer_practise.Offer_practise_offer_id AND User_has_Offer_practise.user_offer_accepted = 1 AND User_has_Offer_practise.user_offer_del_time IS NULL')
        ->join('User', 'User_has_Offer_practise.User_user_id = User.user_id AND User.user_del_time IS NULL')->join('Class', 'User.Class_class_id = Class.class_id AND Class.class_del_time IS NULL')->find();
        $data = [
            'title' => 'Hlavní stránka',
            'company' => $company,
            'user' => $representativeCompany,
            'count' => $count,
            'practises' => $practises,
            'selectStudents' => $selectStudent,
            'newPractises' => $newPractises,
            'actualPractises' => $actualPractises,
        ];
        return view('company/home_company', $data);
    }
    public function homeTeacher(){
        $userId = $this->userSession['id'];
        $user = $this->userModel->find($userId);
        $data = [
            'title' => 'Hlavní stránka',
            'user' => $user,
        ];
        return view('teacher/home_teacher', $data);
    }
    public function classOnPractise(){
        $resultClassOnPractises = $this->class_practiseModel->join('Practise', 'Class_has_Practise.Practise_practise_id = Practise.practise_id AND Practise.practise_del_time IS NULL', 'left')
        ->join('Date_practise', 'Practise.practise_id = Date_practise.Practise_practise_id AND Date_practise.date_del_time IS NULL', 'left')
        ->join('Class', 'Class_has_Practise.Class_class_id = Class.class_id AND Class.class_del_time IS NULL', 'left')->orderBy('Class.class_class, Class.class_letter_class', 'ASC')->find();
        $classOnPractises = [];
        foreach($resultClassOnPractises as $classPractise){
            $idClass = $classPractise['class_id'];
            if(!isset($classOnPractises[$idClass])){
                $classOnPractises[$idClass] = [
                    'class_id' => $idClass,
                    'class_class' => $classPractise['class_class'],
                    'class_letter_class' => $classPractise['class_letter_class'],
                    'practise_name' => $classPractise['practise_name'],
                    'practise_description' => $classPractise['practise_description'],
                    'dates' => [],
                ];
            }
            $idDate = $classPractise['date_id'];
            if(!isset($classOnPractises[$idClass]['dates'][$idDate])){
                $classOnPractises[$idClass]['dates'][$idDate] = [
                    'date_date_from' => $classPractise['date_date_from'],
                    'date_date_to' => $classPractise['date_date_to'],
                ];
            }
        }
        $data = [
            'title' => 'Třídy na praxi',
            'practiseClasses' => $classOnPractises,
        ];
        return view ('teacher/class_on_practise', $data);
    }
    public function peopleOnPractise($idClass){
        $existClassPractise = $this->class_practiseModel->where('Class_class_id', $idClass)->first();
        if(!empty($existClassPractise)){
            $this->backUrl('/class-on-practise');
        }
        $class = $this->classModel->find($idClass);
        $users = $this->userModel->where('Class_class_id', $idClass)//->find();
        ->join('User_has_Offer_practise', 'User.user_id = User_has_Offer_practise.User_user_id AND User_has_Offer_practise.user_offer_accepted = 1 AND User_has_Offer_practise.user_offer_del_time IS NULL', 'left')
        ->join('Offer_practise', 'User_has_Offer_practise.Offer_practise_offer_id = Offer_practise.offer_id AND Offer_practise.offer_del_time IS NULL', 'left')
        ->join('Practise_manager', 'Offer_practise.Practise_manager_manager_id = Practise_manager.manager_id AND Practise_manager.manager_del_time IS NULL', 'left')
        ->join('Company', 'Practise_manager.Company_company_id = Company.company_id AND Company.company_del_time IS NULL', 'left')
        ->orderBy('User.user_surname, User.user_name', 'ASC')
        ->find();
        $data = [
            'title' => 'Praxe třídy (' . $class['class_class'] . '.' . $class['class_letter_class'] . ')',
            'class' => $class,
            'users' => $users,
        ];
        return view('teacher/people-on-practise', $data);
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
        $userClassId = $this->userSession['class'];
        $userId = $this->userSession['id'];
        $search = $this->request->getGet('search');
        $search = urldecode($search);
        $order = $this->request->getGet('order');
        //$this->class_practiseModel->where('Class_class_id', $userClassId)->join('Practise', 'Class_has_Practise.Class_class_id = Practise.practise_id AND Practise.practise_del_time IS NULL', 'right');//->join('Date_practise', 'Practise.practise_id = Date_practise.Practise_practise_id AND Date_practise.date_del_time IS NULL')->join('Offer_practise', 'Practise.practise_id = Offer_practise.Practise_practise_id AND Offer_practise.offer_del_time IS NULL')->join('Skill_has_Offer_practise', 'Offer_practise.offer_id = Skill_has_Offer_practise.Offer_practise_offer_id AND Skill_has_Offer_practise.skill_offer_del_time IS NULL')->join('User_has_Offer_practise', 'Offer_practise.offer_id = User_has_Offer_practise.Offer_practise_offer_id AND User_has_Offer_practise.User_user_id = ' . $userId .' AND User_has_Offer_practise.user_offer_del_time IS NULL')->join('Practise_manager', 'Offer_practise.Practise_manager_manager_id = Practise_manager.manager_id AND Practise_manager.manager_del_time IS NULL')->join('Company', 'Practise_manager.Company_company_id = Company.company_id AND Company.company_del_time IS NULL');
        $this->offerPractise
        //->select('Offer_practise.*, Practise.*, Practise_manager.*, Company.*, User_has_Offer_practise.*, date.*, ClassPractise.*, Skill_has_Offer_practise.*, User_has_Offer_practise.*, User_has_Skill.*')
        ->join('Class_has_Practise AS ClassPractise', 'Offer_practise.Practise_practise_id = ClassPractise.Practise_practise_id AND ClassPractise.Class_class_id = ' . $userClassId . ' AND ClassPractise.class_practise_del_time IS NULL')
        ->join('Practise', 'ClassPractise.Practise_practise_id = Practise.practise_id AND Practise.practise_del_time IS NULL')
        ->join('Date_practise AS date', 'Practise.practise_id = date.Practise_practise_id AND date.date_del_time IS NULL')
        ->join('Practise_manager', 'Offer_practise.Practise_manager_manager_id = Practise_manager.manager_id AND Practise_manager.manager_del_time IS NULL', 'left')
        ->join('Company', 'Practise_manager.Company_company_id = Company.company_id AND Company.company_del_time IS NULL', 'left')
        ->join('Skill_has_Offer_practise', 'Offer_practise.offer_id = Skill_has_Offer_practise.Offer_practise_offer_id AND Skill_has_Offer_practise.skill_offer_del_time IS NULL', 'left')
        ->join('User_has_Offer_practise AS active_user_offer', 'Offer_practise.offer_id = active_user_offer.Offer_practise_offer_id AND active_user_offer.user_offer_accepted = 1 AND active_user_offer.User_user_id != '. $userId . ' AND active_user_offer.user_offer_del_time IS NULL', 'left')
        ->join('User_has_Offer_practise', 'Offer_practise.offer_id = User_has_Offer_practise.Offer_practise_offer_id AND User_has_Offer_practise.User_user_id = '. $userId .' AND User_has_Offer_practise.user_offer_del_time IS NULL', 'left')
        ->join('User_has_Skill', 'Skill_has_Offer_practise.Skill_skill_id = User_has_Skill.Skill_skill_id AND User_has_Skill.User_user_id =' . $userId .' AND User_has_Skill.user_skill_del_time IS NULL', 'left')
        //->groupBy('Offer_practise.offer_id, User_has_Offer_practise.user_offer_id, Practise_manager.manager_id, Company.company_id, ClassPractise.class_practise_id, Skill_has_Offer_practise.skill_offer_id, Practise.practise_id, User_has_Skill.user_skill_id, date.date_id')
        ->groupBy('Offer_practise.offer_id, Offer_practise.offer_name ,Practise.practise_id, Practise_manager.manager_id, Company.company_id, User_has_Offer_practise.user_offer_id, date.date_id, ClassPractise.class_practise_id, Skill_has_Offer_practise.skill_offer_id, User_has_Offer_practise.user_offer_id, User_has_Skill.user_skill_id, active_user_offer.user_offer_id')
        //->groupBy('Offer_practise.offer_name, Offer_practise.offer_description')
        ->having('active_user_offer.Offer_practise_offer_id IS NULL')
        //->selectCount('User_has_Skill.Skill_skill_id', 'skill_count')
        ->orderBy('User_has_Offer_practise.user_offer_select', 'DESC')
        ->orderBy('User_has_Offer_practise.user_offer_like', 'DESC')
        ->orderBy('COUNT(User_has_Skill.Skill_skill_id)', 'DESC')
        ->orderBy('User_has_Offer_practise.user_offer_accepted', 'ASC');
        if(!empty($search)){
            $this->offerPractise->groupStart()->like('offer_name', $search)->orLike("CONCAT(manager_name, ' ', manager_surname)", $search)->orLike('company_name', $search)->orLike('company_ico', $search)->orLike('offer_city', $search)->orLike('offer_street', $search)->orLike('offer_post_code', $search)->groupEnd();
        }
        $resultPractises = $this->offerPractise->find();
        $offerPractises = [];
        $userHavePractise = 0;
        foreach($resultPractises as $offer){
            $offerId = $offer['offer_id'];
            if(!isset($offerPractises[$offerId])){
                $offerPractises[$offerId] = [
                    'offer_id' => $offerId,
                    'offer_name' => $offer['offer_name'],
                    'offer_city' => $offer['offer_city'],
                    'offer_street' => $offer['offer_street'],
                    'offer_post_code' => $offer['offer_post_code'],
                    'practise_name' => $offer['practise_name'],
                    'manager_degree_before' => $offer['manager_degree_before'],
                    'manager_name' => $offer['manager_name'],
                    'manager_surname' => $offer['manager_surname'],
                    'manager_degree_after' => $offer['manager_degree_after'],
                    'manager_mail' => $offer['manager_mail'],
                    'manager_phone' => $offer['manager_phone'],
                    'company_name' => $offer['company_name'],
                    'company_ico' => $offer['company_ico'],
                    'company_logo' => $offer['company_logo'],
                    'user_offer_accepted' => $offer['user_offer_accepted'],
                    'user_offer_like' => $offer['user_offer_like'],
                    'user_offer_select' => $offer['user_offer_select'],
                    'skills' => [],
                    'dates' => [],
                ];
            }
            $dateId = $offer['date_id'];
            if(!isset($offerPractises[$offerId]['dates'][$dateId])){
                $offerPractises[$offerId]['dates'][$dateId] = [
                    'date_date_from' => $offer['date_date_from'],
                    'date_date_to' => $offer['date_date_to'],
                ];
            }
            if($offer['user_offer_accepted'] == 1){
                $userHavePractise = 1;
            }
        }
        $data = [
            'title' => 'Nabídky praxe',
            'offers' => $offerPractises,
            'accepted' => $userHavePractise,
            'search' => $search,
        ];
        return view ('practise_offer', $data);
    }
    public function completeOfferView($idOffer){
        if(!empty($this->userSession['class'])){$userClassId = $this->userSession['class'];}
        //$userId = $this->userSession['id'];
        if(!empty($this->companyUser['idCompany'])){$companyId = $this->companyUser['idCompany'];}
        if(!empty($userClassId)){
            $offers = $this->offerPractise->where('offer_id', $idOffer)->join('Class_has_Practise', 'Offer_practise.Practise_practise_id = Class_has_Practise.Practise_practise_id AND Class_has_Practise.class_practise_del_time IS NULL', 'left')->find();
            $classIds = array_column($offers, 'Class_class_id');
            if(!in_array($userClassId, $classIds)){
                $this->session->setFlashdata('err_message', 'Vyhledaná praxe neexistuje.');
                return $this->backUrl('practise-offer');
            }
        }
        if(!empty($companyId)){
            $offer = $this->offerPractise->where('offer_id', $idOffer)->join('Practise_manager', 'Offer_Practise.Practise_manager_manager_id = Practise_manager.manager_id AND Practise_manager.manager_del_time IS NULL', 'left')->first();
            if(empty($offer)){
                $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, nemůže pro Vás najít danou praxi.');
                return $this->backUrl('company-offer-practises');
            }
            if($offer['Company_company_id'] !== $companyId){
               $this->session->setFlashdata('err_message', 'Vyhledaná praxe neexistuje.');
                return $this->backUrl('company-offer-practises');
            }
        }
        $offer = $this->offerPractise
        ->where('offer_id', $idOffer)
        ->join('Practise_manager', 'Offer_practise.Practise_manager_manager_id = Practise_manager.manager_id AND Practise_manager.manager_del_time IS NULL', 'left')
        ->join('Company', 'Practise_manager.Company_company_id = Company.company_id AND Company.company_del_time IS NULL', 'left')
        ->join('Practise', 'Offer_practise.Practise_practise_id = Practise.practise_id AND Practise.practise_del_time IS NULL', 'left')->first();
        $dates = $this->offerPractise->where('offer_id', $idOffer)
        ->join('Date_practise', 'Offer_practise.Practise_practise_id = Date_practise.Practise_practise_id AND Date_practise.date_del_time IS NULL', 'left')->find();
        $classes = $this->offerPractise->where('offer_id', $idOffer)
        ->join('Class_has_Practise', 'Offer_practise.Practise_practise_id = Class_has_Practise.Practise_practise_id AND Class_has_Practise.class_practise_del_time IS NULL', 'left')
        ->join('Class', 'Class_has_Practise.Class_class_id = Class.class_id AND Class.class_del_time IS NULL', 'left')
        ->join('Field_study', 'Class.Field_study_field_id = Field_study.field_id AND Field_study.field_del_time IS NULL', 'left')->find();
        $resultSkills = $this->offerPractise->where('offer_id', $idOffer)
        ->join('Skill_has_Offer_practise', 'Offer_practise.offer_id = Skill_has_Offer_practise.Offer_practise_offer_id AND Skill_has_Offer_practise.skill_offer_del_time IS NULL', 'left')
        ->join('Skill', 'Skill_has_Offer_practise.Skill_skill_id = Skill.skill_id AND Skill.skill_del_time IS NULL', 'left')
        ->join('Category_skill', 'Skill.Category_skill_category_id = Category_skill.category_id AND Category_skill.category_del_time IS NULL', 'left')->find();
        $skills = [];
        foreach($resultSkills as $skill){
            $categoryId = $skill['category_id'];
            if(!isset($skills[$categoryId])){
                $skills[$categoryId] = [
                    'category_name' => $skill['category_name'],
                    'skills' => [],
                ];
            }
            $skillId = $skill['skill_id'];
            if(!isset($skills[$categoryId]['skills'][$skillId])){
                $skills[$categoryId]['skills'][$skillId] = [
                    'skill_name' => $skill['skill_name'],
                ];
            }
        }
        //log_message('info', 'data: ' . json_encode($skills));
        $data = [
            'title' => 'Zobrazení nabídky',
            'offer' => $offer,
            'dates' => $dates,
            'classes' => $classes,
            'skills' => $skills,
        ];
        return view('offer_view', $data);
    }
    //!Metody pro dodělání
    public function editLikeOffer(){
        $userId = $this->userSession['id'];
        $userClassId = $this->userSession['class'];
        if(empty($userId && $userClassId)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, proveďte akci znovu.');
            return $this->backUrl('/practise-offer');
        }
        $offerId = $this->request->getPost('id-offer');
        $like = $this->request->getPost('like-offer');
        $offers = $this->offerPractise->where('offer_id', $offerId)->join('Class_has_Practise', 'Offer_practise.Practise_practise_id = Class_has_Practise.Practise_practise_id AND Class_has_Practise.class_practise_del_time IS NULL', 'left')->find();
        if(empty($offers)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci znova.');
            return $this->backUrl('/practise-offer');
        }
        $classIds = array_column($offers, 'Class_class_id');
        if(!in_array($userClassId, $classIds)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci znova.');
            return $this->backUrl('/practise-offer');
        }
        $offer = $this->offerPractise->where('offer_id', $offerId)->first();
        $infoOffer = [
            'offer_name' => $offer['offer_name'],
            'offer_requirements' => $offer['offer_requirements'],
            'offer_description' => $offer['offer_description'],
            'offer_city' => $offer['offer_city'],
            'offer_street' => $offer['offer_street'],
            'offer_post_code' => $offer['offer_post_code'],
            'Practise_manager_manager_id' => $offer['Practise_manager_manager_id'],
            'Practise_practise_id' => $offer['Practise_practise_id'],
        ];
        $duplicetaOffers = $this->offerPractise->where($infoOffer)->find();
        if($like == 0 || empty($like)){
            $like = 1;
        }else{
            $like = 0;
        }
        $userOffer = $this->user_practiseModel->where('User_user_id', $userId)->where('Offer_practise_offer_id', $offerId)->first();
        //$offer = $this->offerPractise->where('offer_id', $offerId)->join('Practise_manager', '')first();
        //$offers = $this->offerPractise->where('offer_name', $offer['offer_name'])->where('')
        if(empty($userOffer)){
            $data = [
                'User_user_id' => $userId,
                'Offer_practise_offer_id' => $offerId,
                'user_offer_like' => $like,
                'user_offer_select' => 0,
                'user_offer_accepted' => null,
            ];
            $this->user_practiseModel->insert($data);
        }else{
            $userOfferId = $userOffer['user_offer_id'];
            $data = [
                'user_offer_like' => $like,
            ];
            $this->user_practiseModel->update($userOfferId, $data);
        }
        if(!empty($duplicetaOffers)){
            foreach($duplicetaOffers as $offer){
                $userOffer = $this->user_practiseModel->where('User_user_id', $userId)->where('Offer_practise_offer_id', $offer['offer_id'])->first();
                if(empty($userOffer)){
                    $data = [
                        'User_user_id' => $userId,
                        'Offer_practise_offer_id' => $offer['offer_id'],
                        'user_offer_like' => $like,
                        'user_offer_select' => 0,
                        'user_offer_accepted' => null,
                    ];
                    $this->user_practiseModel->insert($data);
                }else{
                    $userOfferId = $userOffer['user_offer_id'];
                    $data = [
                        'user_offer_like' => $like,
                    ];
                    $this->user_practiseModel->update($userOfferId, $data);
                }
            }
        }
        return $this->backUrl('/practise-offer');
    }
    public function editSelectOffer(){
        $userId = $this->userSession['id'];
        $userClassId = $this->userSession['class'];
        if(empty($userId && $userClassId)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci znova.');
            return $this->backUrl('/practise-offer');
        }
        $offerId = $this->request->getPost('id-offer');
        $select = $this->request->getPost('select-offer');
        $offers = $this->offerPractise->where('offer_id', $offerId)->join('Class_has_Practise', 'Offer_practise.Practise_practise_id = Class_has_Practise.Practise_practise_id AND Class_has_Practise.class_practise_del_time IS NULL', 'left')->find();
        if(empty($offers)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci znova.');
            return $this->backUrl('/practise-offer');
        }
        $classIds = array_column($offers, 'Class_class_id');
        if(!in_array($userClassId, $classIds)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci znova.');
            return $this->backUrl('/practise-offer');
        }
        $offer = $this->offerPractise->where('offer_id', $offerId)->first();
        $infoOffer = [
            'offer_name' => $offer['offer_name'],
            'offer_requirements' => $offer['offer_requirements'],
            'offer_description' => $offer['offer_description'],
            'offer_city' => $offer['offer_city'],
            'offer_street' => $offer['offer_street'],
            'offer_post_code' => $offer['offer_post_code'],
            'Practise_manager_manager_id' => $offer['Practise_manager_manager_id'],
            'Practise_practise_id' => $offer['Practise_practise_id'],
        ];
        $duplicetaOffers = $this->offerPractise->where($infoOffer)->find();
        if($select == 0 || empty($select)){
            $select = 1;
        }else{
            $select = 0;
        }
        $userOffer = $this->user_practiseModel->where('User_user_id', $userId)->where('Offer_practise_offer_id', $offerId)->first();
        if(empty($userOffer)){
            $data = [
                'User_user_id' => $userId,
                'Offer_practise_offer_id' => $offerId,
                'user_offer_like' => 0,
                'user_offer_select' => $select,
                'user_offer_accepted' => null,
            ];
            $this->user_practiseModel->insert($data);
        }else{
            $userOfferId = $userOffer['user_offer_id'];
            $data = [
                'user_offer_select' => $select,
            ];
            $this->user_practiseModel->update($userOfferId, $data);
        }
        if(!empty($duplicetaOffers)){
            foreach($duplicetaOffers as $offer){
                $userOffer = $this->user_practiseModel->where('User_user_id', $userId)->where('Offer_practise_offer_id', $offer['offer_id'])->first();
                if(empty($userOffer)){
                    $data = [
                        'User_user_id' => $userId,
                        'Offer_practise_offer_id' => $offer['offer_id'],
                        'user_offer_like' => 0,
                        'user_offer_select' => $select,
                        'user_offer_accepted' => null,
                    ];
                    $this->user_practiseModel->insert($data);
                }else{
                    $userOfferId = $userOffer['user_offer_id'];
                    $data = [
                        'user_offer_select' => $select,
                    ];
                    $this->user_practiseModel->update($userOfferId, $data);
                }
            }
        }
        return $this->backUrl('/practise-offer');
    }

    public function addNewOfferPractiseView($idCompany = null, $idPractise = null){
        $practiseIdAdmin = '';
        if($idCompany == null){
            $id = $this->companyUser['idCompany'];
        }else{
            $id = $idCompany;
        }
        if($idPractise !== null){
            $practiseIdAdmin = $idPractise;
        }
        $company = $this->companyModel->find($id);
        $today = date('Y-m-d');
        $resultPractise = $this->practiseModel->where('practise_end_new_offer >=', $today)->join('Date_practise', 'Practise.practise_id = Date_practise.Practise_practise_id', 'left')->join('Class_has_Practise', 'Practise.practise_id = Class_has_Practise.Practise_practise_id', 'left')->join('Class', 'Class_has_Practise.Class_class_id = Class.class_id', 'left')->join('Field_study', 'Class.Field_study_field_id = Field_study.field_id', 'left')->find();
        $practises = [];
        foreach($resultPractise as $practise){
            $practiseId = $practise['practise_id'];
            if(!isset($practises[$practiseId])){
                $practises[$practiseId] = [
                    'practise_id' => $practiseId,
                    'practise_name' => $practise['practise_name'],
                    'practise_contract_file' => $practise['practise_contract_file'],
                    'dates' => [],
                    'classes' => [],
                ];
            }
            $practises[$practiseId]['dates'][] = [
                'date_date_from' => $practise['date_date_from'],
                'date_date_to' => $practise['date_date_to'],
            ];
            $practises[$practiseId]['classes'][] = [
                'class_class' => $practise['class_class'],
                'class_letter_class' => $practise['class_letter_class'],
                'field_shortcut' => $practise['field_shortcut'],
            ];
        }
        $resultCategoryes = $this->categorySkill->join('Skill', 'Category_skill.category_id = Skill.Category_skill_category_id')->find();
        $categoryes = [];
        foreach($resultCategoryes as $category){
            $categoryId = $category['category_id'];
            if(!isset($categoryes[$categoryId])){
                $categoryes[$categoryId] = [
                    'category_name' => $category['category_name'],
                ];
            }
            $categoryes[$categoryId]['skills'][] = [
                'skill_id' => $category['skill_id'],
                'skill_name' => $category['skill_name'],
            ];
        }
        $managers = $this->practiseManagerModel->where('Company_company_id', $company['company_id'])->find();
        $data = [
            'title' => 'Nová nabídka praxe',
            'company' => $company,
            'practises' => $practises,
            'categoryes' => $categoryes,
            'managers' => $managers,
            'practiseId' => $practiseIdAdmin,
        ];
        return view ('company/add_new_offer_practise', $data);
    }
    public function addNewOfferPractise(){
        $name = $this->request->getPost('name_offer_practise');
        $shortDescription = $this->request->getPost('short_description_offer_practise');
        $cityOfferPractise = $this->request->getPost('city_practise');
        $streetOfferPractise = $this->request->getPost('street_practise');
        $postCodeOfferPractise = $this->request->getPost('post_code_practise');
        $countPractise = $this->request->getPost('count_practise');
        $datePractise = $this->request->getPost('select_practise');
        $copyNextYear = $this->request->getPost('copy_next_year');
        $skills = $this->request->getPost('skills');
        $managerPractiseOffer = $this->request->getPost('practise_manager');
        $fullDescription = $this->request->getPost('full_description');
        if(empty($name && $cityOfferPractise && $streetOfferPractise && $postCodeOfferPractise && $countPractise && $datePractise && $managerPractiseOffer)){
            $this->session->setFlashdata('err_message', 'Musíte vyplnit všechna potřebná políčka (*), jako jsou (název praxe, město, psč, ulice, vybrat datum praxe a vybrat vedoucího praxe.');
            return redirect()->to(base_url('/company-add-offer-practise'));
        }
        if(empty($copyNextYear)){
            $copyNextYear = 0;
        }
        for($i=1; $i <= $countPractise; $i++){
            $dataOffer = [
                'offer_name' => $name,
                'offer_requirements' => $shortDescription,
                'offer_description' => $fullDescription,
                'offer_city' => $cityOfferPractise,
                'offer_street' => $streetOfferPractise,
                'offer_post_code' => $postCodeOfferPractise,
                'offer_copy_next_year' => $copyNextYear,
                'Practise_practise_id' => $datePractise,
                'Practise_manager_manager_id' => $managerPractiseOffer,
            ];
            $id = $this->offerPractise->insert($dataOffer);
            if(!empty($skills)){
                foreach($skills as $skill){
                    $dataSkill = [
                        'Skill_skill_id' => $skill,
                        'Offer_practise_offer_id' => $id,
                    ];
                    $this->skill_offerPractise->insert($dataSkill);
                }
            }
        }
        $role = session()->get('role');
        $isCompany = in_array('company', $role);
        $isAdmin = in_array('admin', $role);
        $isSpravce = in_array('spravce', $role);
        if($isCompany){
            return redirect()->to(base_url('/company-offer-practises'));
        }
        if($isAdmin || $isSpravce){
            return redirect()->to(base_url('/dashboard-date-practise-offer'));
        }
    }
    //!Metody pro dodělání
    public function editOfferPractiseView($idOffer){
        $offer = $this->offerPractise->where('offer_id', $idOffer)->join('Practise_manager', 'Offer_practise.Practise_manager_manager_id = Practise_manager.manager_id AND Practise_manager.manager_del_time IS NULL', 'left')
        ->join('Company', 'Practise_manager.Company_company_id = Company.company_id AND Company.company_del_time IS NULL', 'left')
        ->join('Practise', 'Offer_practise.Practise_practise_id = Practise.practise_id AND Practise.practise_del_time IS NULL', 'left')
        ->first();
        $role = $this->session->get('role');
        if(!empty($this->companyUser['idCompany'])){
            $userSession = $this->companyUser['idCompany'];
        }
        $isAdmin = in_array('admin', $role);
        $isSpravce = in_array('spravce', $role);
        if(!$isAdmin && !$isSpravce && $userSession !== $offer['Company_company_id']){
            $this->session->setFlashdata('err_message', 'Na danou akci nemáte oprávnění.');
            return $this->backUrl('company-offer-practises');
        }
        $dates = $this->datePractiseModel->where('Practise_practise_id', $offer['practise_id'])->find();
        $offersSkill = $this->skill_offerPractise->where('Offer_practise_offer_id', $offer['offer_id'])->find();
        $managers = $this->practiseManagerModel->where('Company_company_id', $offer['company_id'])->find();
        $skillResults = $this->categorySkill->join('Skill', 'Category_skill.category_id = Skill.Category_skill_category_id AND Skill.skill_del_time IS NULL', 'inner')->find();
        $skills = [];
        foreach($skillResults as $category){
            $categoryId = $category['category_id'];
            if(!isset($skills[$categoryId])){
                $skills[$categoryId] = [
                    'category_id' => $categoryId,
                    'category_name' => $category['category_name'],
                ];
            }
            $skillId = $category['skill_id'];
            if(!isset($skills[$categoryId]['skills'][$skillId])){
                $skills[$categoryId]['skills'][$skillId] = [
                    'skill_id' => $skillId,
                    'skill_name' => $category['skill_name'],
                ];
            }
        }
        $data = [
            'title' => 'Editace nabídky praxe',
            'offer' => $offer,
            'dates' => $dates,
            'offerSkill' => $offersSkill,
            'skills' => $skills,
            'managers' => $managers,
        ];
        return view('company/edit_offer_practise', $data);
    }
    public function editOfferPractise(){
        $idOffer = $this->request->getPost('offer_id');
        $nameOffer = $this->request->getPost('name_offer_practise');
        $shortDescription = $this->request->getPost('short_description_offer_practise');
        $cityOffer = $this->request->getPost('city_practise');
        $streetOffer = $this->request->getPost('street_practise');
        $postCodeOffer = $this->request->getPost('post_code_practise');
        $copyOffer = $this->request->getPost('copy_next_year');
        $skills = $this->request->getPost('skills');
        $managerIdOffer = $this->request->getPost('practise_manager');
        $description = $this->request->getPost('full_description');
        $idCompany = $this->request->getPost('company_id');
        if(empty($idOffer && $nameOffer && $cityOffer && $streetOffer && $postCodeOffer && $managerIdOffer && $idCompany)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci znova.');
            return $this->backUrl('/company-offer-practise');
        }
        $managerCompany = $this->practiseManagerModel->find($managerIdOffer);
        if($idCompany !== $managerCompany['Company_company_id']){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci znova.');
            return $this->backUrl('/company-offer-practise');
        }
        $dataOffer = [
            'offer_name' => $nameOffer,
            'offer_requirements' => $shortDescription,
            'offer_description' => $description,
            'offer_city' => $cityOffer,
            'offer_street' => $streetOffer,
            'offer_post_code' => $postCodeOffer,
            'offer_copy_next_year' => $copyOffer,
            'Practise_manager_manager_id' => $managerIdOffer,
        ];
        $this->offerPractise->update($idOffer, $dataOffer);
        $existingSkills = $this->skill_offerPractise->where('Offer_practise_offer_id', $idOffer)->withDeleted()->find();
        $existingIdSkill = array_column($existingSkills, 'Skill_skill_id');
        if(!empty($skills)){
            foreach($skills as $skill){
                if(in_array($skill, $existingIdSkill)){
                    $currentDelTime = $existingSkills[array_search($skill, $existingIdSkill)]['skill_offer_del_time'];
                    $currentId = $existingSkills[array_search($skill, $existingIdSkill)]['skill_offer_id'];
                    if(!empty($currentDelTime)){
                        $this->skill_offerPractise->update($currentId, ['skill_offer_del_time' => null]);
                    }
                }else{
                    $newDataSkill = [
                        'Offer_practise_offer_id' => $idOffer,
                        'Skill_skill_id' => $skill,
                    ];
                    $this->skill_offerPractise->insert($newDataSkill);
                }
            }
        }
        foreach ($existingSkills as $existingSkill) {
            if(!empty($skills)){
                if (!in_array($existingSkill['Skill_skill_id'], $skills)) {
                    $this->skill_offerPractise->delete($existingSkill['skill_offer_id']);
                }
            }else{
                $this->skill_offerPractise->delete($existingSkill['skill_offer_id']);
            }
        }
        return $this->backUrl('company-offer-practises');
    }
    public function deleteOfferPractise($offerId){
        $this->offerPractise->delete($offerId);
        $userOffers = $this->user_practiseModel->where('Offer_practise_offer_id', $offerId)->find();
        foreach($userOffers as $userOffer){
            $this->user_practiseModel->delete($userOffer['user_offer_id']);
        }
        $offerSkills = $this->skill_offerPractise->where('Offer_practise_offer_id', $offerId)->find();
        foreach($offerSkills as $offerSkill){
            $this->skill_offerPractise->delete($offerSkill['skill_offer_id']);
        }
        return $this->backUrl('/company-offer-practises');
    }
    public function acceptedUserForOfferPractise(){
        $offerId = $this->request->getPost('offer_id');
        $managerId = $this->request->getPost('manager_id');
        $studentId = $this->request->getPost('user_id');
        $userOfferId = $this->request->getPost('user_offer_id');
        $companyId = $this->companyUser['idCompany'];
        //Zjištění, zda daná praxe patří firmě.
        $existUserCompanyOffer = $this->practiseManagerModel->where('manager_id', $managerId)->where('Company_company_id', $companyId)->first();
        if(!$existUserCompanyOffer){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba. Zkuste akci provést znovu.');
            return $this->backUrl('/company-offer-practises');
        }
        $controllUser = $this->user_practiseModel->where('user_offer_id', $userOfferId)->where('Offer_practise_offer_id', $offerId)->where('User_user_id', $studentId)->first();
        if(!$controllUser){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba. Zkuste akci provést znovu.');
            return $this->backUrl('/company-offer-practises');
        }
        $offerUsers = $this->user_practiseModel->where('Offer_practise_offer_id', $offerId)->where('User_user_id !=', $studentId)->find();
        foreach($offerUsers as $offerUser){
            $this->user_practiseModel->delete($offerUser['user_offer_id']);
        }
        $userOffers = $this->user_practiseModel->where('User_user_id', $studentId)->whereNotIn('Offer_practise_offer_id', [$offerId])->find();
        foreach($userOffers as $userOffer){
            $this->user_practiseModel->delete($userOffer['user_offer_id']);
        }
        $data = [
            'user_offer_accepted' => 1,
        ];
        $this->user_practiseModel->update($userOfferId, $data);
        return $this->backUrl('/company-offer-practises');
    }
    public function noAcceptedForOfferPractise(){
        $offerId = $this->request->getPost('offer_id');
        $managerId = $this->request->getPost('manager_id');
        $studentId = $this->request->getPost('user_id');
        $userOfferId = $this->request->getPost('user_offer_id');
        $companyId = $this->companyUser['idCompany'];
        //Zjištění, zda daná praxe patří firmě.
        $existUserCompanyOffer = $this->practiseManagerModel->where('manager_id', $managerId)->where('Company_company_id', $companyId)->first();
        if(!$existUserCompanyOffer){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba. Zkuste akci provést znovu.');
            return $this->backUrl('/company-offer-practises');
        }
        $userOffers = $this->user_practiseModel->where('Offer_practise_offer_id', $offerId)->where('User_user_id', $studentId)->find();
        if(!$userOffers){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba. Zkuste akci provést znovu.');
            return $this->backUrl('/company-offer-practises');
        }
        foreach($userOffers as $userOffer){
            $data = [
                'user_offer_accepted' => 0,
            ];
            $this->user_practiseModel->update($userOffer['user_offer_id'], $data);
        }
        return $this->backUrl('/company-offer-practises');
    }
    public function people(){
        $search = $this->request->getGet('search');
        $search = urldecode($search);
        $users = $this->userModel->where('user_role', 'student')->join('Class', 'Class.class_id = User.Class_class_id AND Class.class_del_time IS NULL')->join('Field_study', 'Field_study.field_id = Class.Field_study_field_id AND Field_study.field_del_time IS NULL')->join('Type_school', 'Type_school.type_id = Field_study.Type_school_type_id AND Type_school.type_del_time IS NULL')->groupStart()->like("CONCAT(user_name, ' ', user_surname)", $search)->orLike("CONCAT(class_class, '.', class_letter_class)", $search)->orLike('field_shortcut', $search)->groupEnd()->orderBy('user_surname, user_name', 'ASC')->paginate(20);
        $pager = $this->userModel->pager;
        $data = [
            'title' => 'Žáci',
            'users' => $users,
            'pager' => $pager,
            'search' => $search,
        ];
        return view ('people', $data);
    }
    public function companyView(){
        $search = $this->request->getGet('search');
        $search = urldecode($search);
        $companyes = $this->companyModel->where('company_register_company', 1)->groupStart()->like('company_name', $search)->orLike('company_city', $search)->orLike('company_street', $search)->orLike('company_post_code', $search)->groupEnd()->paginate(8);
        $pager = $this->companyModel->pager;
        $data = [
            'title' => 'Firmy',
            'companyes' => $companyes,
            'pager' => $pager,
            'search' => $search,
        ];
        return view ('company', $data);
    }
    public function companyProfilView(){
        $id = $this->companyUser['idUser'];
        $company = $this->companyModel->find($id);
        $representatives = $this->representativeCompanyModel->where('Company_company_id', $id)->find();
        $contactCompany = $this->representativeCompanyModel->where('Company_company_id', $id)->first();
        $managers = $this->practiseManagerModel->where('Company_company_id', $id)->find();
        $data = [
            'title' => 'Profil',
            'company' => $company,
            'representatives' => $representatives,
            'contact' => $contactCompany,
            'managers' => $managers,
        ];
        return view ('company/profile_company', $data);
    }
    public function companyProfilAllView($idCompany){
        $id = $idCompany;
        $company = $this->companyModel->find($id);
        $representatives = $this->representativeCompanyModel->where('Company_company_id', $id)->find();
        $contactCompany = $this->representativeCompanyModel->where('Company_company_id', $id)->first();
        $managers = $this->practiseManagerModel->where('Company_company_id', $id)->find();
        $data = [
            'title' => 'Profil',
            'company' => $company,
            'representatives' => $representatives,
            'contact' => $contactCompany,
            'managers' => $managers,
        ];
        return view ('company/profile_company', $data);
    }
    public function editCompanyProfilView($idCompany){
        $id = $idCompany;
        $role = $this->session->get('role');
        if(!empty($this->companyUser['idCompany'])){
            $userSession = $this->companyUser['idCompany'];
        }
        $isAdmin = in_array('admin', $role);
        $isSpravce = in_array('spravce', $role);
        if(!$isAdmin && !$isSpravce && $userSession !== $id){
            $this->session->setFlashdata('err_message', 'Na danou akci nemáte oprávnění.');
            return $this->backUrl('home-student');
        }
        $company = $this->companyModel->find($id);
        $representatives = $this->representativeCompanyModel->where('Company_company_id', $id)->find();
        $contactCompany = $this->representativeCompanyModel->where('Company_company_id', $id)->first();
        $managers = $this->practiseManagerModel->where('Company_company_id', $id)->find();
        $data = [
            'title' => 'Profil',
            'company' => $company,
            'representatives' => $representatives,
            'contact' => $contactCompany,
            'managers' => $managers,
        ];
        return view ('company/edit_profile_company', $data);
    }
    public function editCompanyProfil(){
        $idCompany = $this->request->getPost('idCompany');
        if(empty($idCompany)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci opakovat.');
            return $this->backUrl('/home-student');
        }
        $role = $this->session->get('role');
        if(!empty($this->companyUser['idCompany'])){
            $userSession = $this->companyUser['idCompany'];
        }
        $isAdmin = in_array('admin', $role);
        $isSpravce = in_array('spravce', $role);
        if(!$isAdmin && !$isSpravce && $userSession !== $idCompany){
            $this->session->setFlashdata('err_message', 'Na danou akci nemáte oprávnění.');
            return $this->backUrl('/home-student');
        }
        $nameCompany = $this->request->getPost('nameCompany');
        $descriptionCompany = $this->request->getPost('description_company');
        if(empty($nameCompany)){
            $this->session->setFlashdata('err_message', 'Název firmy/instituce je povinný. Prosím, nenechávejte políčko prázdné.');
            return $this->backUrl('/home-student'); //! Potřeba projít a upravit podle potřeby na zbětnou url
        }
        $data = [
            'company_name' => $nameCompany,
            'company_description' => $descriptionCompany,
        ];
        $this->companyModel->update($idCompany, $data);
        return redirect()->to('company-profil/'.$idCompany);
    }
    public function profilAddRepresentativeCompany(){
        $companyId = $this->request->getPost('companyId');
        $degreeBefore = $this->request->getPost('degree_before');
        $name = $this->request->getPost('name');
        $surname = $this->request->getPost('surname');
        $degreeAfter = $this->request->getPost('degree_after');
        $mail = $this->request->getPost('mail');
        $phone = $this->request->getPost('phone');
        $positionWork = $this->request->getPost('position_work');
        $checkbox = $this->request->getPost('checkbox');
        $passwd1 = $this->request->getPost('passwd1');
        $passwd2 = $this->request->getPost('passwd2');
        $role = $this->session->get('role');
        if(!empty($this->companyUser['idCompany'])){
            $userSession = $this->companyUser['idCompany'];
        }
        $isAdmin = in_array('admin', $role);
        $isSpravce = in_array('spravce', $role);
        if(!$isAdmin && !$isSpravce && $userSession !== $companyId){
            $this->session->setFlashdata('err_message', 'Na danou akci nemáte oprávnění.');
            return $this->backUrl('/company-profil');
        }
        if(empty($name && $surname && $mail && $phone && $companyId)){
            $this->session->setFlashdata('err_message', 'Nejsou vyplněna všechna potřebná políčka.');
            return $this->backUrl('/company-profil');
        }
        $existUserMail = $this->representativeCompanyModel->where('representative_mail', $mail)->first();
        if(!empty($existUserMail)){
            $this->session->setFlashdata('err_message', 'Daný uživatel již existuje.');
            return $this->backUrl('/company-profil');
        }
        if(empty($checkbox)){
            if(empty($passwd1 && $passwd2)){
                $this->session->setFlashdata('err_message', 'Nejsou vyplněna všechna potřebná políčka01.');
                return $this->backUrl('/company-profil');  
            }
            if($passwd1 !== $passwd2){
                $this->session->setFlashdata('err_message', 'Hesla se neshodují');
                return $this->backUrl('/company-profil');
            }
        }
        if(!empty($checkbox)){
            $passwd1 = bin2hex(random_bytes(16));
        }
        $hashPassword = password_hash($passwd1, PASSWORD_DEFAULT);
        $data = [
            'representative_degree_before' => $degreeBefore,
            'representative_name' => $name,
            'representative_surname' => $surname,
            'representative_degree_after' => $degreeAfter,
            'representative_mail' => $mail,
            'representative_password' => $hashPassword,
            'representative_phone' => $phone,
            'representative_function' => $positionWork,
            'Company_company_id' => $companyId, 
        ];
        $idInsert = $this->representativeCompanyModel->insert($data);
        if(!empty($checkbox)){
            $secretCode = bin2hex(random_bytes(16));
            $hashMail = password_hash($mail, PASSWORD_DEFAULT);
            $linkReset = base_url('/reset-password?code='.urlencode($secretCode).'&idcode='.urlencode($hashMail).'&id='.$idInsert);
            $messageHtml = '
            <h1>Vytvoření účtu v aplikaci Booking praxí</h1>
            <p>Vážený uživateli,</p>
            <p>byl Vám vytvořen účet v aplikaci Booking praxí. Pro jeho aktivaci je potřeba si nastavit heslo. Odkaz pro vytvoření hesla je platný jednu hodinu od doručení tohoto e-mailu.</p>
            <p>Pokud se Vám heslo nepodaří nastavit včas, obraťte se prosím na správce aplikace Booking praxí.</p>
            <br>
            <a href="' . $linkReset . '" style="background-color: #007BFF; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-family: Arial, sans-serif;">Obnovit heslo</a>
            <br>
            <p>Děkujeme za spolupráci.</p>
            ';
            $subjectEmail = 'Informace o vytvoření účtu - Booking praxí';
            $this->mail->sentEmail($mail, $messageHtml, $subjectEmail);
        }
        if(!empty($checkbox)){
            $nowTime = Time::now();
            $expire = $nowTime->addHours(1);
            $hashSecretCode = password_hash($secretCode, PASSWORD_DEFAULT);
            $dataResetPass = [
                'reset_token' => $hashSecretCode,
                'reset_expires_at' => $expire,
                'reset_use' => 0,
                'Representative_company_representative_id' => $idInsert,
            ] ;
            $this->resetPassword->insert($dataResetPass);
        }
        return $this->backUrl('/company-profil');
    }
    public function profilEditRepresentativeCompany(){
        $id = $this->request->getPost('id');
        $idCompany = $this->request->getPost('companyId');
        $degreeBefore = $this->request->getPost('degree_before');
        $name = $this->request->getPost('name');
        $surname = $this->request->getPost('surname');
        $degreeAfter = $this->request->getPost('degree_after');
        $mail = $this->request->getPost('mail');
        $phone = $this->request->getPost('phone');
        $positionWork = $this->request->getPost('position_work');
        if(empty($id && $name && $surname && $mail && $phone && $positionWork)){
            $this->session->setFlashdata('err_message', 'Nemáte vyplněné všechna potřebná políčka.');
            return $this->backUrl('/company-profil');
        }
        $role = $this->session->get('role');
        if(!empty($this->companyUser['idCompany'])){
            $userSession = $this->companyUser['idCompany'];
        }
        $isAdmin = in_array('admin', $role);
        $isSpravce = in_array('spravce', $role);
        if(!$isAdmin && !$isSpravce && $userSession !== $idCompany){
            $this->session->setFlashdata('err_message', 'Na danou akci nemáte oprávnění.');
            return $this->backUrl('/company-profil'); 
        }
        if(empty($name && $surname && $mail && $phone && $idCompany)){
            $this->session->setFlashdata('err_message', 'Nejsou vyplněna všechna potřebná políčka.');
            return $this->backUrl('/company-profil');
        }
        $user = $this->representativeCompanyModel->find($id);
        if($mail !== $user['representative_mail']){
            $existUserMail = $this->representativeCompanyModel->where('representative_mail', $mail)->first();
            if(!empty($existUserMail)){
                $this->session->setFlashdata('err_message', 'Daný uživatel již existuje.');
                return $this->backUrl('/company-profil');
            }
        }
        $existUser = $this->representativeCompanyModel->where('representative_id', $id)->where('Company_company_id', $idCompany)->first();
        if(empty($existUser)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci opakovat znova.');
            return $this->backUrl('/company-profil');
        }
        $data = [
            'representative_degree_before' => $degreeBefore,
            'representative_name' => $name,
            'representative_surname' => $surname,
            'representative_degree_after' => $degreeAfter,
            'representative_mail' => $mail,
            'representative_phone' => $phone,
            'representative_function' => $positionWork,
        ];
        $this->representativeCompanyModel->update($id, $data);
        return $this->backUrl('/company-profil');
    }
    public function profilDeleteRepresentativeCompany($idUser){
        $user = $this->representativeCompanyModel->find($idUser);
        $userSession = $this->companyUser['idCompany'];
        if($user['Company_company_id'] !== $userSession){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci opakovat znova.');
            return $this->backUrl('/company-profil');
        }
        $logsUser = $this->logCompany->where('Representative_company_representative_id', $idUser)->find();
        foreach($logsUser as $log){
            $this->logCompany->delete($log['log_company_id']);
        }
        $resetPasswords = $this->resetPassword->where('Representative_company_representative_id', $idUser)->find();
        foreach($resetPasswords as $reset){
            $this->resetPassword->delete($reset['reset_id']);
        }
        $this->representativeCompanyModel->delete($idUser);
        return $this->backUrl('/company-profil');
    }
    public function profilAddPractiseManager(){
        $idCompany = $this->request->getPost('companyId');
        $degreeBefore = $this->request->getPost('degree_before');
        $name = $this->request->getPost('name');
        $surname = $this->request->getPost('surname');
        $degreeAfter = $this->request->getPost('degree_after');
        $mail = $this->request->getPost('mail');
        $phone = $this->request->getPost('phone');
        $positionWork = $this->request->getPost('position_work');
        if(empty($idCompany && $name && $surname && $phone && $positionWork && $mail)){
            $this->session->setFlashdata('err_message', 'Nevyplnili jste všechny povinná políčka, proto jsme nemohli vedoucího praxe přidat.');
            return $this->backUrl('/company-profil');
        }
        $role = $this->session->get('role');
        if(!empty($this->companyUser['idCompany'])){
            $userSession = $this->companyUser['idCompany'];
        }
        $isAdmin = in_array('admin', $role);
        $isSpravce = in_array('spravce', $role);
        if(!$isAdmin && !$isSpravce && $userSession !== $idCompany){
            $this->session->setFlashdata('err_message', 'Na danou akci nemáte oprávnění.');
            return $this->backUrl('/company-profil');
        }
        $data = [
            'manager_degree_before' => $degreeBefore,
            'manager_name' => $name,
            'manager_surname' => $surname,
            'manager_degree_after' => $degreeAfter,
            'manager_mail' => $mail,
            'manager_phone' => $phone,
            'manager_position_works' => $positionWork,
            'Company_company_id' => $idCompany,
        ];
        $this->practiseManagerModel->insert($data);
        return $this->backUrl('/company-profil');
    }
    public function profilEditPractiseManager(){
        $id = $this->request->getPost('id');
        $degreeBefore = $this->request->getPost('degree_before');
        $name = $this->request->getPost('name');
        $surname = $this->request->getPost('surname');
        $degreeAfter = $this->request->getPost('degree_after');
        $mail = $this->request->getPost('mail');
        $phone = $this->request->getPost('phone');
        $positionWork = $this->request->getPost('position_work');
        if(empty($id && $name && $surname && $phone && $positionWork && $mail)){
            $this->session->setFlashdata('err_message', 'Nevyplnili jste všechny povinná políčka, proto jsme nemohli vedoucího praxí upravit.');
            return $this->backUrl('/company-profil');
        }
        $role = $this->session->get('role');
        if(!empty($this->companyUser['idCompany'])){
            $userSession = $this->companyUser['idCompany'];
        }
        $manager = $this->practiseManagerModel->find($id);
        $isAdmin = in_array('admin', $role);
        $isSpravce = in_array('spravce', $role);
        if(!$isAdmin && !$isSpravce && $userSession !== $manager['Company_company_id']){
            $this->session->setFlashdata('err_message', 'Na danou akci nemáte oprávnění.');
            return $this->backUrl('/company-profil');
        }
        $data = [
            'manager_degree_before' => $degreeBefore,
            'manager_name' => $name,
            'manager_surname' => $surname,
            'manager_degree_after' => $degreeAfter,
            'manager_mail' => $mail,
            'manager_phone' => $phone,
            'manager_position_works' => $positionWork,
        ];
        $this->practiseManagerModel->update($id,$data);
        return $this->backUrl('/company-profil');
    }
    public function profilDeletePractiseManager($id){
        $manager = $this->practiseManagerModel->find($id);
        $role = $this->session->get('role');
        if(!empty($this->companyUser['idCompany'])){
            $userSession = $this->companyUser['idCompany'];
        }
        $manager = $this->practiseManagerModel->find($id);
        $isAdmin = in_array('admin', $role);
        $isSpravce = in_array('spravce', $role);
        if(!$isAdmin && !$isSpravce && $userSession !== $manager['Company_company_id']){
            $this->session->setFlashdata('err_message', 'Na danou akci nemáte oprávnění.');
            return $this->backUrl('/profil-company');
        }
        $offers = $this->offerPractise->where('Practise_manager_manager_id', $id)->find();
        foreach($offers as $offer){
            $this->skill_offerPractise->where('Offer_practise_offer_id', $offer['offer_id'])->delete();
            $this->user_practiseModel->where('Offer_practise_offer_id', $offer['offer_id'])->delete();
        }
        $this->offerPractise->where('Practise_manager_manager_id', $id)->delete();
        $this->practiseManagerModel->delete($id);
        return $this->backUrl('/profil-company');
    }
    public function companyOfferPractiseView(){
        $companyIdSession = $this->companyUser['idCompany'];
        $allCompanyManagers = $this->practiseManagerModel
        ->where('Company_company_id', $companyIdSession)
        ->join('Offer_practise', 'Practise_manager.manager_id = Offer_practise.Practise_manager_manager_id AND Offer_practise.offer_del_time IS NULL', 'left')
        ->join('Practise', 'Offer_practise.Practise_practise_id = Practise.practise_id AND Practise.practise_del_time IS NULL')
        ->join('Date_practise', 'Practise.practise_id = Date_practise.Practise_practise_id AND Date_practise.date_del_time IS NULL')
        ->join('User_has_Offer_practise', 'Offer_practise.offer_id = User_has_Offer_practise.Offer_practise_offer_id AND User_has_Offer_practise.user_offer_select = 1 AND (User_has_Offer_practise.user_offer_accepted = 1 OR User_has_Offer_practise.user_offer_accepted IS NULL) AND User_has_Offer_practise.user_offer_del_time IS NULL', 'left')
        ->join('User', 'User_has_Offer_practise.User_user_id = User.user_id AND User.user_del_time IS NULL', 'left')
        ->join('Class', 'User.Class_class_id = Class.class_id AND Class.class_del_time IS NULL', 'left')
        ->join('Field_study', 'Class.Field_study_field_id = Field_study.field_id AND Field_study.field_del_time IS NULL', 'left')->find();
        $resultOfferPractise = [];
        foreach($allCompanyManagers as $result){
            $idOffer = $result['offer_id'];
            if(!isset($resultOfferPractise[$idOffer])){
                $resultOfferPractise[$idOffer] = [
                    'offer_id' => $idOffer,
                    'offer_name' => $result['offer_name'],
                    'offer_requirements' => $result['offer_requirements'],
                    'offer_copy_next_year' => $result['offer_copy_next_year'],
                    'offer_edit_time' => $result['offer_edit_time'],
                    'manager_id' => $result['manager_id'],
                    'manager_degree_before' => $result['manager_degree_before'],
                    'manager_name' => $result['manager_name'],
                    'manager_surname' => $result['manager_surname'],
                    'manager_degree_after' => $result['manager_degree_after'],
                    'manager_mail' => $result['manager_mail'],
                    'manager_phone' => $result['manager_phone'],
                    'practise_name' => $result['practise_name'],
                    'dates' => [],
                    'users' => [],
                ];
            }
            $dateId = $result['date_id'];
            if(!isset($resultOfferPractise[$idOffer]['dates'][$dateId])){
                $resultOfferPractise[$idOffer]['dates'][$dateId] = [
                    'date_date_from' => $result['date_date_from'],
                    'date_date_to' => $result['date_date_to'],
                ];
            }
            $userId = $result['user_id'];
            if(!isset($resultOfferPractise[$idOffer]['users'][$userId])){
                $resultOfferPractise[$idOffer]['users'][$userId] = [
                    'user_offer_id' => $result['user_offer_id'],
                    'user_offer_accepted' => $result['user_offer_accepted'],
                    'user_offer_select' => $result['user_offer_select'],
                    'user_id' => $result['user_id'],
                    'user_name' => $result['user_name'],
                    'user_surname' => $result['user_surname'],
                    'user_mail' => $result['user_mail'],
                    'class_class' => $result['class_class'],
                    'class_letter_class' => $result['class_letter_class'],
                    'field_name' => $result['field_name'],
                ];
            }
        }
        $data = [
            'title' => 'Nabídky praxí',
            'offerPractises' => $resultOfferPractise,
        ];
        return view('company/our_practise_offer', $data);
    }
    public function profileView(){
        $id = $this->userSession['id'];
        $user = $this->userModel->where('User.user_id', $id)->join('Class', 'User.Class_class_id = Class.class_id AND Class.class_del_time IS NULL')->join('Field_study', 'Class.Field_study_field_id = Field_study.field_id AND Field_study.field_del_time IS NULL')->first();
        $resultCategoryes = $this->categorySkill->join('Skill', 'Category_skill.category_id = Skill.Category_skill_category_id AND Skill.skill_del_time IS NULL')->join('User_has_Skill', 'Skill.skill_id = User_has_Skill.Skill_skill_id AND User_has_Skill.user_skill_del_time IS NULL')->where('User_has_Skill.User_user_id', $id)->find();
        $socialLinks = $this->socialLink_user->where('User_user_id', $id)->join('Social_link', 'Social_link_has_User.Social_link_social_id = Social_link.social_id AND Social_link.social_del_time IS NULL')->find();
        $categoryes = [];
        foreach ($resultCategoryes as $result){
            $categoryId = $result['category_id'];
            if(!isset($categoryes[$categoryId])){
                $categoryes[$categoryId] = [
                    'category_id' => $categoryId,
                    'category_name' => $result['category_name'],
                    'category_description' => $result['category_description'],
                    'skills' => [],
                ];
            }
            $categoryes[$categoryId]['skills'][] = [
                'skill_id' => $result['skill_id'],
                'skill_name' => $result['skill_name'],
                'skill_description' => $result['skill_description'],
            ];

        }
        $data = [
            'title' => 'Profil',
            'user' => $user,
            'categoryes' => $categoryes,
            'socialLinks' => $socialLinks,
        ];
        return view ('profile', $data);
    }
    public function allProfileView($idUser){
        $id = $idUser;
        $user = $this->userModel->where('User.user_id', $id)->join('Class', 'User.Class_class_id = Class.class_id AND Class.class_del_time IS NULL')->join('Field_study', 'Class.Field_study_field_id = Field_study.field_id AND Field_study.field_del_time IS NULL')->first();
        $resultCategoryes = $this->categorySkill->join('Skill', 'Category_skill.category_id = Skill.Category_skill_category_id AND Skill.skill_del_time IS NULL')->join('User_has_Skill', 'Skill.skill_id = User_has_Skill.Skill_skill_id AND User_has_Skill.user_skill_del_time IS NULL')->where('User_has_Skill.User_user_id', $id)->find();
        $socialLinks = $this->socialLink_user->where('User_user_id', $id)->join('Social_link', 'Social_link_has_User.Social_link_social_id = Social_link.social_id AND Social_link.social_del_time IS NULL')->find();
        $categoryes = [];
        foreach ($resultCategoryes as $result){
            $categoryId = $result['category_id'];
            if(!isset($categoryes[$categoryId])){
                $categoryes[$categoryId] = [
                    'category_id' => $categoryId,
                    'category_name' => $result['category_name'],
                    'category_description' => $result['category_description'],
                    'skills' => [],
                ];
            }
            $categoryes[$categoryId]['skills'][] = [
                'skill_id' => $result['skill_id'],
                'skill_name' => $result['skill_name'],
                'skill_description' => $result['skill_description'],
            ];

        }
        $data = [
            'title' => 'Profil',
            'user' => $user,
            'categoryes' => $categoryes,
            'socialLinks' => $socialLinks,
        ];
        return view ('profile', $data);
    }
    public function editProfileView($idUser){
        $id = $idUser;
        $role = $this->session->get('role');
        $userSession = $this->session->get('user');
        $isAdmin = in_array('admin', $role);
        $isSpravce = in_array('spravce', $role);
        if(!$isAdmin && !$isSpravce && $userSession['id'] !== $id){
            $this->session->setFlashdata('err_message', 'Na danou akci nemáte oprávnění.');
            return $this->backUrl('/home-student'); //! Potřeba projít a upravit podle potřeby na zbětnou url
        }
        $user = $this->userModel->where('User.user_id', $id)->join('Class', 'User.Class_class_id = Class.class_id AND Class.class_del_time IS NULL')->join('Field_study', 'Class.Field_study_field_id = Field_study.field_id AND Field_study.field_del_time IS NULL')->first();
        $socialLinks = $this->socialLink->join('Social_link_has_User', 'Social_link.social_id = Social_link_has_User.Social_link_social_id AND Social_link_has_User.user_social_del_time IS NULL AND Social_link_has_User.User_user_id = '. $id, 'left')->find();
        $resultCategoryes = $this->categorySkill->join('Skill', 'Category_skill.category_id = Skill.Category_skill_category_id AND Skill.skill_del_time IS NULL')->join('User_has_Skill', 'Skill.skill_id = User_has_Skill.Skill_skill_id AND User_has_Skill.User_user_id = '. $id. ' AND User_has_Skill.user_skill_del_time IS NULL', 'left')->find();
        $categoryes = [];
        foreach ($resultCategoryes as $result){
            $categoryId = $result['category_id'];
            if(!isset($categoryes[$categoryId])){
                $categoryes[$categoryId] = [
                    'category_id' => $categoryId,
                    'category_name' => $result['category_name'],
                    'category_description' => $result['category_description'],
                    'skills' => [],
                ];
            }
            if(empty($result['user_skill_id'])){$checkUserSkill = 0;}else{$checkUserSkill = 1;}
            $categoryes[$categoryId]['skills'][] = [
                'skill_id' => $result['skill_id'],
                'skill_name' => $result['skill_name'],
                'skill_description' => $result['skill_description'],
                'check_user_skill' => $checkUserSkill,
            ];

        }
        $data = [
            'title' => 'Profil',
            'user' => $user,
            'categoryes' => $categoryes,
            'socialLinks' => $socialLinks,
        ];
        return view ('edit_profile', $data);
    }
    public function editProfile(){
        $id = $this->request->getPost('idUser');
        $phone = $this->request->getPost('phone');
        $birthday = $this->request->getPost('birthday');
        $socialLinks = $this->request->getPost('socialLinks');
        $skills = $this->request->getPost('skills');
        $description = $this->request->getPost('description');
        if(empty($birthday)){
            $birthday = null;
        }
        $infoUser = [
            'user_phone' => $phone,
            'user_date_birthday' => $birthday,
            'user_description' => $description,
        ];
        $this->userModel->update($id, $infoUser);
        $existingLinks = $this->socialLink_user->where('User_user_id', $id)->withDeleted()->find();
        $existingId = array_column($existingLinks, 'Social_link_social_id');
        foreach($socialLinks as $idLink => $link){
            if(empty($link)){
                if(in_array($idLink, $existingId)){
                    $currentId = $existingLinks[array_search($idLink, $existingId)]['user_social_id'];
                    $updateData = [
                        'user_social_url' => '',
                    ];
                    $this->socialLink_user->update($currentId, $updateData);
                    $this->socialLink_user->delete($currentId);
                    continue;
                }
            }
            if(in_array($idLink, $existingId)){
                $currentUrl = $existingLinks[array_search($idLink, $existingId)]['user_social_url'];
                if($currentUrl !== $link){
                    $currentId = $existingLinks[array_search($idLink, $existingId)]['user_social_id'];
                    $updateData = [
                        'Social_link_social_id' => $idLink,
                        'User_user_id' => $id,
                        'user_social_url' => $link,
                        'user_social_del_time' => null,
                    ];
                    $this->socialLink_user->update($currentId, $updateData);
                }
            }else{
                if(!empty($link)){
                    $newData = [
                        'Social_link_social_id' => $idLink,
                        'User_user_id' => $id,
                        'user_social_url' => $link,
                        'user_social_del_time' => null,
                    ];
                    $this->socialLink_user->insert( $newData);
                }
            }
        }   
        $existingSkills = $this->user_skill->where('User_user_id', $id)->withDeleted()->find();
        $existingIdSkill = array_column($existingSkills, 'Skill_skill_id');
        if(!empty($skills)){
            foreach($skills as $skill){
                if(in_array($skill, $existingIdSkill)){
                    $currentDelTime = $existingSkills[array_search($skill, $existingIdSkill)]['user_skill_del_time'];
                    $currentId = $existingSkills[array_search($skill, $existingIdSkill)]['user_skill_id'];
                    if(!empty($currentDelTime)){
                        $this->user_skill->update($currentId, ['user_skill_del_time' => null]);
                    }
                }else{
                    $newDataSkill = [
                        'User_user_id' => $id,
                        'Skill_skill_id' => $skill,
                    ];
                    $this->user_skill->insert($newDataSkill);
                }
            }
        }
        foreach ($existingSkills as $existingSkill) {
            if(!empty($skills)){
                if (!in_array($existingSkill['Skill_skill_id'], $skills)) {
                    $this->user_skill->delete($existingSkill['user_skill_id']);
                }
            }else{
                $this->user_skill->delete($existingSkill['user_skill_id']);
            }
        }
        return redirect()->to('/profile/'. $id);
    }
}
