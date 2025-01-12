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
        $userClass = $this->classModel->find($user['Class_class_id']);
        $userFieldStudy = $this->fieldStudy->find($userClass['Field_study_field_id']);
        //$practise = $this->user_practiseModel->select('user_practise.*, practise_offer.*, practise_manager.*, company.*, practise.*, date_practise.*')->join('practise_offer', 'practise_offer.id = user_practise.Offer_practise_id')->join('practise_manager', 'practise_manager.id = practise_offer.Practise_manager_id')->join('company', 'company.id = practise_manager.Company_id')->join('practise', 'practise.id = practise_offer.Practise_id')->join('date_practise', 'date_practise.Practise_id = practise.id', 'left')->where('user_practise.User_id', $user['id'])->findAll();
        $userPractiseOffers = $this->user_practiseModel->where('User_user_id', value: $user['user_id'])->findAll();
        $data = ['title' => 'Hlavní stránka', 'user' => $user, 'class' => $userClass, 'fieldStudy' => $userFieldStudy, 'practise' => $userPractiseOffers,];
        return view('home_student', $data);
    }
    public function homeCompany(){
        $nowDate = date('Y-m-d');
        $representativeCompany = $this->representativeCompanyModel->find($this->companyUser['idUser']);
        $company = $this->companyModel->find($this->companyUser['idCompany']);
        $practises = $this->practiseModel->findAll();
        $count['practise'] = 0;
        foreach($practises as $practise){
            if($nowDate <= $practise['date_end_new_offer']){
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
        $allCompanyes = $this->companyModel->findAll();
        foreach($allCompanyes as $allCompany){
            if($allCompany['company_register_company'] == 1){
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
        $search = urldecode($search);
        $users = $this->userModel->where('user_role', 'student')->join('Class', 'Class.class_id = User.Class_class_id')->join('Field_study', 'Field_study.field_id = Class.Field_study_field_id')->join('Type_school', 'Type_school.type_id = Field_study.Type_school_type_id')->groupStart()->like("CONCAT(user_name, ' ', user_surname)", $search)->orLike("CONCAT(class_class, '.', class_letter_class)", $search)->orLike('field_shortcut', $search)->groupEnd()->paginate(20);
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
    public function profileView(){
        $id = $this->userSession['id'];
        $user = $this->userModel->where('User.user_id', $id)->join('Class', 'User.Class_class_id = Class.class_id')->join('Field_study', 'Class.Field_study_field_id = Field_study.field_id')->first();
        $resultCategoryes = $this->categorySkill->join('Skill', 'Category_skill.category_id = Skill.Category_skill_category_id')->join('User_has_Skill', 'Skill.skill_id = User_has_Skill.Skill_skill_id')->where('User_has_Skill.User_user_id', $id)->find();
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
        ];
        return view ('profile', $data);
    }
    public function allProfileView($idUser){
        $id = $idUser;
        $user = $this->userModel->where('User.user_id', $id)->join('Class', 'User.Class_class_id = Class.class_id')->join('Field_study', 'Class.Field_study_field_id = Field_study.field_id')->first();
        $resultCategoryes = $this->categorySkill->join('Skill', 'Category_skill.category_id = Skill.Category_skill_category_id')->join('User_has_Skill', 'Skill.skill_id = User_has_Skill.Skill_skill_id')->where('User_has_Skill.User_user_id', $id)->find();
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
        ];
        return view ('profile', $data);
    }
}
