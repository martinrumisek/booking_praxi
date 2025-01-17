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
            'practises' => $practises,
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
    public function addNewOfferPractiseView(){
        $id = $this->companyUser['idCompany'];
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
        return redirect()->to(base_url('/company-add-offer-practise'));
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
            $previousUrl = $this->request->getServer('HTTP_REFERER');
            if ($previousUrl) {
                return redirect()->to($previousUrl);
            } else {
                return redirect()->to('/home-student');
            }
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
            $previousUrl = $this->request->getServer('HTTP_REFERER');
            log_message('info', 'Nenalezeno $idCompany');
            if ($previousUrl) {
                return redirect()->to($previousUrl);
            } else {
                return redirect()->to('/home-student');
            }
        }
        $role = $this->session->get('role');
        if(!empty($this->companyUser['idCompany'])){
            $userSession = $this->companyUser['idCompany'];
        }
        $isAdmin = in_array('admin', $role);
        $isSpravce = in_array('spravce', $role);
        if(!$isAdmin && !$isSpravce && $userSession !== $idCompany){
            log_message('info', 'Není admin, ani správce ani nesedí id company');
            $previousUrl = $this->request->getServer('HTTP_REFERER');
            if ($previousUrl) {
                return redirect()->to($previousUrl);
            } else {
                return redirect()->to('/home-student');
            }
        }
        $nameCompany = $this->request->getPost('nameCompany');
        $descriptionCompany = $this->request->getPost('description_company');
        if(empty($nameCompany)){
            log_message('info', 'prázdné jméno firmy');
            $previousUrl = $this->request->getServer('HTTP_REFERER');
            if ($previousUrl) {
                return redirect()->to($previousUrl);
            } else {
                return redirect()->to('/home-student');
            }
        }
        $data = [
            'company_name' => $nameCompany,
            'company_description' => $descriptionCompany,
        ];
        $this->companyModel->update($idCompany, $data);
        $previousUrl = $this->request->getServer('HTTP_REFERER');
            if ($previousUrl) {
                return redirect()->to($previousUrl);
            } else {
                return redirect()->to('/home-student');
            }
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
            $previousUrl = $this->request->getServer('HTTP_REFERER');
            if ($previousUrl) {
                return redirect()->to($previousUrl);
            } else {
                return redirect()->to('/home-student');
            }
        }
        $role = $this->session->get('role');
        if(!empty($this->companyUser['idCompany'])){
            $userSession = $this->companyUser['idCompany'];
        }
        $isAdmin = in_array('admin', $role);
        $isSpravce = in_array('spravce', $role);
        if(!$isAdmin && !$isSpravce && $userSession !== $idCompany){
            log_message('info', 'Není admin, ani správce ani nesedí id company');
            $previousUrl = $this->request->getServer('HTTP_REFERER');
            if ($previousUrl) {
                return redirect()->to($previousUrl);
            } else {
                return redirect()->to('/home-student');
            }
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
        $previousUrl = $this->request->getServer('HTTP_REFERER');
            if ($previousUrl) {
                return redirect()->to($previousUrl);
            } else {
                return redirect()->to('/home-student');
            }
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
            $previousUrl = $this->request->getServer('HTTP_REFERER');
            if ($previousUrl) {
                return redirect()->to($previousUrl);
            } else {
                return redirect()->to('/home-student');
            }
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



        $previousUrl = $this->request->getServer('HTTP_REFERER');
            if ($previousUrl) {
                return redirect()->to($previousUrl);
            } else {
                return redirect()->to('/home-student');
            }

    }
}
