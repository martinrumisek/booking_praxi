<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Models\PractiseManager;
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
use App\Models\ResetPassword;
use App\Controllers\Email;
use App\Models\SocialLink;
use App\Models\SocialLink_User;

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
    var $practiseManager;
    var $resetPassword;
    var $email;
    var $socialLink_user;
    var $socialLink;
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
        $this->practiseManager = new PractiseManager();
        $this->resetPassword = new ResetPassword();
        $this->email = new Email();
        $this->socialLink = new SocialLink();
        $this->socialLink_user = new SocialLink_User();
    }
    //Metody pro zobrazení viewček
    public function homeView(){
        $data= [
            'title' => 'Administrace'
        ];
        return view('dashboard/dash_home', $data);
    }
    public function companyView(){
        $search = $this->request->getGet('search');
        $search = urldecode($search);
        $this->companyModel->join('Representative_company', 'Company.company_id = Representative_company.Company_company_id AND Representative_company.representative_del_time IS NULL', 'left')->join('Practise_manager', 'Company.company_id = Practise_manager.Company_company_id AND Practise_manager.manager_del_time IS NULL', 'left');
        if(!empty($search)){
            $this->companyModel->groupStart()->like('company_name', $search)->orLike("CONCAT(representative_name, ' ', representative_surname)", $search)->orLike('company_ico', $search)->orLike("CONCAT(manager_name, ' ', manager_surname)", $search)->groupEnd();
        }
        $results = $this->companyModel->paginate(10);
        $pager = $this->companyModel->pager;
        $companyes = [];
        foreach($results as $company){
            $companyId = $company['company_id'];
            if(!isset($companyes[$companyId])){
                $companyes[$companyId] = [
                    'company_id' => $companyId,
                    'company_name' => $company['company_name'],
                    'company_ico' => $company['company_ico'],
                    'company_subject' => $company['company_subject'],
                    'company_description' => $company['company_description'],
                    'company_city' => $company['company_city'],
                    'company_agree_document' => $company['company_agree_document'],
                    'company_post_code' => $company['company_post_code'],
                    'company_logo' => $company['company_logo'],
                    'company_create_time' => $company['company_create_time'],
                    'company_edit_time' => $company['company_edit_time'],
                    'representative' => [],
                    'practiseManager' =>[],
                ];
            }
            if(!in_array($company['representative_id'], array_column($companyes[$companyId]['representative'], 'representative_id'))){
                $companyes[$companyId]['representative'][] = [
                    'representative_id' => $company['representative_id'],
                    'representative_degree_before' => $company['representative_degree_before'],
                    'representative_name' => $company['representative_name'],
                    'representative_surname' => $company['representative_surname'],
                    'representative_degree_after' => $company['representative_degree_after'],
                    'representative_mail' => $company['representative_mail'],
                    'representative_phone' => $company['representative_phone'],
                    'representative_function' => $company['representative_function'],
                    'representative_create_time' => $company['representative_create_time'],
                    'representative_edit_time' => $company['representative_edit_time'],
                    'Company_company_id' => $company['Company_company_id'],
                ];
            }
            if(!in_array($company['manager_id'], array_column($companyes[$companyId]['practiseManager'], 'manager_id'))){
                $companyes[$companyId]['practiseManager'][] = [
                    'manager_id' => $company['manager_id'],
                    'manager_degree_before' => $company['manager_degree_before'],
                    'manager_name' => $company['manager_name'],
                    'manager_surname' => $company['manager_surname'],
                    'manager_degree_after' => $company['manager_degree_after'],
                    'manager_mail' => $company['manager_mail'],
                    'manager_phone' => $company['manager_phone'],
                    'manager_position_works' => $company['manager_position_works'],
                    'manager_create_time' => $company['manager_create_time'],
                    'manager_edit_time' => $company['manager_edit_time'],
                    'Company_company_id' => $company['Company_company_id'],
                ];
            }
        }
        $data= [
            'title' => 'Administrace',
            'companyes' => $companyes,
            'pager' => $pager,
            'search' => $search,
        ];
        return view('dashboard/dash_company', $data);
    }
    public function deadlinesView(){
        $search = $this->request->getGet('search');
        $search = urldecode($search);
        $results = $this->practiseModel->join('Date_practise', 'Practise.practise_id = Date_practise.Practise_practise_id AND Date_practise.date_del_time IS NULL')->join('Class_has_Practise', 'Practise.practise_id = Class_has_Practise.Practise_practise_id AND Class_has_Practise.class_practise_del_time IS NULL')->join('Class', 'Class.class_id = Class_has_Practise.Class_class_id AND Class.class_del_time IS NULL')->groupStart()->like('Practise.practise_name', $search)->orLike("CONCAT(Date_practise.date_date_from, ' - ', Date_practise.date_date_to)", $search)->orLike('Practise.practise_end_new_offer', $search)->orLike("CONCAT(Class.class_class, '.', Class.class_letter_class)", $search)->groupEnd()->orderBy('Practise.practise_create_time', 'DESC')->findAll();
        $practises = [];
        foreach($results as $practise){
            $practiseId = $practise['practise_id'];
            if(!isset($practises[$practiseId])){
                $practises[$practiseId] = [
                    'practise_id' => $practise['practise_id'],
                    'practise_name' => $practise['practise_name'],
                    'practise_description' => $practise['practise_description'],
                    'practise_contract_file' => $practise['practise_contract_file'],
                    'practise_end_new_offer' => $practise['practise_end_new_offer'],
                    'practise_create_time' => $practise['practise_create_time'],
                    'practise_edit_time' => $practise['practise_edit_time'],
                    'dates' => [],
                    'class' => [],
                ];
            }
            if(!in_array($practise['date_id'], array_column($practises[$practiseId]['dates'], 'date_id'))){
                $practises[$practiseId]['dates'][] = [
                    'date_id' => $practise['date_id'],
                    'date_date_from' => $practise['date_date_from'],
                    'date_date_to' => $practise['date_date_to'],
                    'date_edit_time' => $practise['date_edit_time'],
                    'Practise_practise_id' => $practise['Practise_practise_id'],
                ];
            }
            if(!in_array($practise['class_id'], array_column($practises[$practiseId]['class'], 'class_id'))){
                $practises[$practiseId]['class'][] = [
                    'class_id' => $practise['class_id'],
                    'class_class' => $practise['class_class'],
                    'class_letter_class' => $practise['class_letter_class'],
                ];
            }
        }
        $schoolClass = $this->classModel->findAll();
        $data= [
            'title' => 'Administrace',
            'practises' => $practises,
            'schoolClass' => $schoolClass,
            'search' => $search,
        ];
        return view('dashboard/dash_calendar', $data);
    }
    public function peopleView(){
        $search = $this->request->getGet('search');
        $search = urldecode($search);
        $oder = $this->request->getGet('oder') ?? 1;
        $this->userModel->join('Class', 'User.Class_class_id = Class.class_id', 'left')->join('Field_study', 'Class.Field_study_field_id = Field_study.field_id', 'left')->join('Type_school', 'Field_study.Type_school_type_id = Type_school.type_id', 'left');
        switch ($oder){
            case 2: $this->userModel->orderBy('user_surname, user_name', 'DESC'); break;
            case 3: $this->userModel->orderBy('class_class, class_letter_class', 'ASC'); break;
            case 4: $this->userModel->orderBy('class_class, class_letter_class', 'DESC'); break;
            case 5: $this->userModel->orderBy('user_admin, user_spravce', 'DESC'); break;
            default: $this->userModel->orderBy('user_surname, user_name', 'ASC');
        }
        if(!empty($search)){
            $this->userModel->groupStart()->like("CONCAT(user_name, ' ', user_surname)", $search)->orLike("CONCAT(class_class, '.', class_letter_class)", $search)->orLike('field_shortcut', $search)->groupEnd();
        }
        $users = $this->userModel->paginate(20);
        $pager = $this->userModel->pager;
        $socialLinks = $this->socialLink->findAll();
        $countLinks = count($socialLinks);
        $data= [
            'title' => 'Administrace',
            'users' => $users,
            'pager' => $pager,
            'oder' => $oder,
            'search' => $search,
            'links' => $socialLinks,
            'countLinks' => $countLinks,
        ];
        return view('dashboard/dash_people', $data);
    }
    public function viewClass(){
        $resultTypeSchools = $this->typeSchool->join('Field_study', 'Field_study.Type_school_type_id = Type_school.type_id AND Field_study.field_del_time IS NULL', 'left')->join('Class', 'Class.Field_study_field_id = Field_study.field_id AND Class.class_del_time IS NULL', 'left')->orderBy('class_year_graduation', 'DESC')->find();
        $typeSchools = [];
        foreach($resultTypeSchools as $result){
            $typeId = $result['type_id'];
            if(!isset($typeSchools[$typeId])){
                $typeSchools[$typeId] = [
                    'type_id' => $typeId,
                    'type_name' => $result['type_name'],
                    'type_shortcut' => $result['type_shortcut'],
                    'type_description' => $result['type_description'],
                    'type_edit_time' => $result['type_edit_time'],
                    'fields' => [],
                ];
            }
            $fieldId = $result['field_id'];
            if(!isset($typeSchools[$typeId]['fields'][$fieldId])){
                $typeSchools[$typeId]['fields'][$fieldId] = [
                    'field_id' => $fieldId,
                    'field_name' => $result['field_name'],
                    'field_shortcut' => $result['field_shortcut'],
                    'field_edit_time' => $result['field_edit_time'],
                    'Type_school_type_id' => $result['Type_school_type_id'],
                    'classes' => [],
                ];
            }
            $classId = $result['class_id'];
            if(!isset($typeSchools[$typeId]['fields'][$fieldId]['classes'][$classId])){
                $typeSchools[$typeId]['fields'][$fieldId]['classes'][$classId] = [
                    'class_id' => $classId,
                    'class_year_graduation' => $result['class_year_graduation'],
                    'class_class' => $result['class_class'],
                    'class_letter_class' => $result['class_letter_class'],
                    'class_edit_time' => $result['class_edit_time'],
                    'Field_study_field_id' => $result['Field_study_field_id'],
                ];
            }
        }
        $data = [
            'title' => 'Administrace',
            'typeSchools' => $typeSchools,
        ];
        return view('dashboard/dash_class', $data);
    }
    public function newTypeSchool(){
        $name = $this->request->getPost('name');
        $shortcut = $this->request->getPost('shortcut');
        $description = $this->request->getPost('description');
        if(empty($name && $shortcut)){
            return redirect()->to(base_url('dashboard-class'));
        }
        $data = [
            'type_name' => $name,
            'type_shortcut' => $shortcut,
            'type_description' => $description,
        ];
        $this->typeSchool->insert($data);
        return redirect()->to(base_url('dashboard-class'));
    }
    public function deleteTypeSchool($id){
        $fields = $this->fieldStudy->where('Type_school_type_id', $id)->find();
        foreach($fields as $field){
            $this->deleteFieldStudy($field['field_id']);
        }
        $this->typeSchool->delete($id);
        return redirect()->to(base_url('dashboard-class'));
    }
    public function editTypeSchool(){
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $shortcut = $this->request->getPost('shortcut');
        $description = $this->request->getPost('description');
        if(empty($name && $shortcut)){
            return redirect()->to(base_url('dashboard-class'));
        }
        $data = [
            'type_name' => $name,
            'type_shortcut' => $shortcut,
            'type_description' => $description,
        ];
        $this->typeSchool->update($id, $data);
        return redirect()->to(base_url('dashboard-class'));
    }
    public function newFieldSchool(){
        $name = $this->request->getPost('name');
        $shortcut = $this->request->getPost('shortcut');
        $typeSchoolId = $this->request->getPost('type_school');
        if(empty($name && $shortcut && $typeSchoolId)){
            return redirect()->to(base_url('dashboard-class'));
        }
        $data = [
            'field_name' => $name,
            'field_shortcut' => $shortcut,
            'Type_school_type_id' => $typeSchoolId,
        ];
        $this->fieldStudy->insert($data);
        return redirect()->to(base_url('dashboard-class'));
    }
    public function deleteFieldStudy($id){
        $classes = $this->classModel->where('Field_study_field_id', $id)->find();
        if(!empty($classes)){
            foreach($classes as $class){
                $this->classModel->delete($class['class_id']);
            }
        }
        $this->fieldStudy->delete($id);
        return redirect()->to(base_url('dashboard-class'));
    }
    public function editFieldSchool(){
        $name = $this->request->getPost('name');
        $shortcut = $this->request->getPost('shortcut');
        $id = $this->request->getPost('id');
        if(empty($name && $shortcut && $id)){
            return redirect()->to(base_url('dashboard-class'));
        }
        $data = [
            'field_name' => $name,
            'field_shortcut' => $shortcut,
        ];
        $this->fieldStudy->update($id, $data);
        return redirect()->to(base_url('dashboard-class'));
    }
    public function newClassSchool(){
        $numberClass = $this->request->getPost('class');
        $letterClass = $this->request->getPost('letter');
        $graduatClass = $this->request->getPost('year_graduation');
        $fieldId = $this->request->getPost('fieldId');
        if(empty($numberClass && $letterClass && $graduatClass && $fieldId)){
            return redirect()->to(base_url('dashboard-class'));
        }
        $data = [
            'class_year_graduation' => $graduatClass,
            'class_class' => $numberClass,
            'class_letter_class' => $letterClass,
            'Field_study_field_id' => $fieldId,
        ];
        $this->classModel->insert($data);
        return redirect()->to(base_url('dashboard-class'));
    }
    public function deleteClass($id){
        $this->classModel->delete($id);
        return redirect()->to(base_url('dashboard-class'));
    }
    public function editClassSchool(){
        $id = $this->request->getPost('id');
        $numberClass = $this->request->getPost('class');
        $letterClass = $this->request->getPost('letter');
        $graduatClass = $this->request->getPost('year_graduation');
        if(empty($numberClass && $letterClass && $graduatClass && $id)){
            return redirect()->to(base_url('dashboard-class'));
        }
        $data = [
            'class_year_graduation' => $graduatClass,
            'class_class' => $numberClass,
            'class_letter_class' => $letterClass,
        ];
        $this->classModel->update($id, $data);
        return redirect()->to(base_url('dashboard-class'));
    }
    public function newSocialLink(){
        $name = $this->request->getPost('name');
        $icon = $this->request->getPost('icon_name');
        if(empty($icon)){
            return redirect()->to(base_url('dashboard-people'));
        }
        $data = [
            'social_name' => $name,
            'social_icon' => $icon,
        ];
        $this->socialLink->insert($data);
        return redirect()->to(base_url('dashboard-people'));
        
    }   
    public function deleteSocialLink($id){
        $this->socialLink->delete($id);
        $this->socialLink_user->where('Social_link_social_id', $id)->delete();
        return redirect()->to(base_url('/dashboard-people'));
    }
    public function addCategorySkill(){
        $name = $this->request->getPost('name');
        $description = $this->request->getPost('description');
        if(empty($name)){
            //! Je potřeba přidat hlášku pro vrácení, že musí být pole povíné
            return false;
        }
        $data = [
            'category_name' => $name,
            'category_description' => $description,
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
            'skill_name' => $name,
            'skill_description' => $description,
            'Category_skill_category_id' => $idCategory,
        ];
        $this->skill->insert($data);
        return redirect()->to(base_url('/dashboard-skill'));
    }
    public function editCategorySkill(){
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $description = $this->request->getPost('description');
        if(empty($id && $name)){
            return redirect()->to(base_url('/dashboard-skill'));
        }
        $data = [
            'category_name' => $name,
            'category_description' => $description,
        ];
        $this->categorySkill->update($id, $data);
        return redirect()->to(base_url('/dashboard-skill'));
    }
    public function editSkill(){
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $description = $this->request->getPost('description');
        $categoryId = $this->request->getPost('category_id');
        if(empty($id && $name && $categoryId)){
            return redirect()->to(base_url('/dashboard-skill'));
        }
        $data = [
            'skill_name' => $name,
            'skill_description' => $description,
            'Category_skill_category_id' => $categoryId,
        ];
        $this->skill->update($id, $data);
        return redirect()->to(base_url('/dashboard-skill'));
    }
    public function deleteCategorySkill($id){
        $this->categorySkill->delete($id);
        $this->skill->where('Category_skill_category_id', $id)->delete();
        return redirect()->to(base_url('/dashboard-skill'));
    }
    public function deleteSkill($id){
        $this->skill->delete($id);
        return redirect()->to(base_url('/dashboard-skill'));
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
        $admin = $user['user_admin'];
        $spravce = $user['user_spravce'];
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
        $updateUser = ['user_admin' => $admin, 'user_spravce' => $spravce];
        $this->userModel->update($userId, $updateUser);
        $user = $this->userModel->find($userId);
        return $this->response->setJSON([
            'success' => true,
            'user' => $updateUser,
        ]);

    }
    public function skillView(){
        $search = $this->request->getGet('search');
        $search = urldecode($search);
        $this->categorySkill->join('Skill', 'Category_skill.category_id = Skill.Category_skill_category_id AND Skill.skill_del_time IS NULL', 'left')->orderBy('category_create_time', 'DESC');
        if(!empty($search)){
            $this->categorySkill->groupStart()->like('category_name', $search)->orLike('skill_name', $search)->groupEnd();
        }
        $results = $this->categorySkill->paginate(10);
        $pager = $this->categorySkill->pager;
        $categoryes = [];
        foreach($results as $category){
            $categoryId = $category['category_id'];
            if(!isset($categoryes[$categoryId])){   
                $categoryes[$categoryId] = [
                    'category_id' => $category['category_id'],
                    'category_name' => $category['category_name'],
                    'category_description' => $category['category_description'],
                    'category_create_time' => $category['category_create_time'],
                    'category_edit_time' => $category['category_edit_time'],
                ];
            }
            if(!empty($category['skill_name']) && $category['skill_name'] !== null){
                $categoryes[$categoryId]['skill'][] = [
                    'skill_id' => $category['skill_id'],
                    'skill_name' => $category['skill_name'],
                    'skill_description' => $category['skill_description'],
                    'skill_create_time' => $category['skill_create_time'],
                    'skill_edit_time' => $category['skill_edit_time'],
                    'Category_skill_category_id' => $category['Category_skill_category_id'],
                ];
            }
        }
        log_message('info', 'problém s načítaní prázdných položek, které neexistují:  ' . json_encode($categoryes));
        $data= [
            'title' => 'Administrace',
            'categoryes' => $categoryes,
            'pager' => $pager,
            'search' => $search,
        ];
        return view('dashboard/dash_skill', $data);
    }
    
    public function logView(){
        $search = $this->request->getGet('search');
        $search = urldecode($search);
        $order = $this->request->getGet('order');
        $this->logUser->join('User', 'Log_user.User_user_id = User.user_id');
        switch($order){
            case 2: $this->logUser->orderBy('log_user_create_time', 'ASC'); break;
            case 3: $this->logUser->orderBy('log_user_name', 'DESC'); break;
            case 4: $this->logUser->orderBy('log_user_name', 'ASC'); break;
            default: $this->logUser->orderBy('log_user_create_time', 'DESC');
        }
        if(!empty($search)){
            $this->logUser->groupStart()->like('user_name', $search)->groupEnd();
        }
        $userLogs = $this->logUser->paginate(20);
        $pager = $this->logUser->pager;
        $data = [
            'title' => 'Administrace',
            'logs' => $userLogs,
            'pager' => $pager,
            'search' => $search,
            'order' => $order,
        ];

        return view('dashboard/dash_log', $data);
    }
    public function logViewCompany(){
        $search = $this->request->getGet('search');
        $search = urldecode($search);
        $order = $this->request->getGet('order');
        $this->logCompany->join('Representative_company', 'Log_company.Representative_company_representative_id = Representative_company.representative_id')->join('Company', 'Representative_company.Company_company_id = Company.company_id');
        switch($order){
            case 2: $this->logCompany->orderBy('log_company_create_time', 'ASC'); break;
            case 3: $this->logCompany->orderBy('log_company_name', 'DESC'); break;
            case 4: $this->logCompany->orderBy('log_company_name', 'ASC'); break;
            default: $this->logCompany->orderBy('log_company_create_time', 'DESC');
        }
        if(!empty($search)){
            $this->logCompany->groupStart()->like("CONCAT(representative_name, ' ', representative_surname)", $search)->orLike('company_name', $search)->groupEnd();
        }
        $companyLogs = $this->logCompany->paginate(20);
        $pager = $this->logCompany->pager;
        $data = [
            'title' => 'Administrace',
            'logs' => $companyLogs,
            'pager' => $pager,
            'search' => $search,
            'order' => $order,
        ];
        return view('dashboard/dash_log_company', $data);
    }
    //Zpracování (editace) v administraci
    public function addNewDate(){
        $name = $this->request->getPost('name');
        $description = $this->request->getPost('description');
        $dateEndNewOffer = $this->request->getPost('end-new-offer');
        $file = $this->request->getFile('contract-file');
        $dates = $this->request->getPost('dates');
        $classes = $this->request->getPost('classes');
        if(empty($file && $name && $dates && $classes && $dateEndNewOffer)){
            return redirect()->to(base_url('dashboard-calendar'));
        }
        if($file->getClientMimeType() !== 'application/pdf'){
            return redirect()->to(base_url('dashboard-calendar'));
        }
        $fileName = bin2hex(random_bytes(10)) . '.pdf';
        $dataPractise = [
            'practise_name' => $name,
            'practise_description'=> $description,
            'practise_end_new_offer' => $dateEndNewOffer,
            'practise_contract_file' => $fileName,
        ];
        $id = $this->practiseModel->insert($dataPractise);
        $countDate = count($dates);
        foreach($dates as $date){
            if($date['date-from'] > $date['date-to']){
                if($countDate == 1 ){
                    $this->practiseModel->delete($id);
                    return redirect()->to(base_url('dashboard-calendar'));
                    //!validační hláška se musí přidat před směrováním
                }else{
                    $countDate--;
                    continue;
                }
            }
            $dataDate = [
                'date_date_from' => $date['date-from'],
                'date_date_to' => $date['date-to'],
                'Practise_practise_id' => $id,
            ];
            $countDate--;
            $this->datePractiseModel->insert($dataDate);
        }
        $classPractises = $this->class_practiseModel->findAll();
        $existingClass = array_column($classPractises, 'Class_class_id');
        $countClass = count($classes);
        if(!empty($classes)){
            foreach ($classes as $class) {
                if(in_array($class, $existingClass)){
                    if($countClass == 1){
                        $this->practiseModel->delete($id);
                        $datePractises = $this->datePractiseModel->where('Practise_practise_id', $id)->find();
                        foreach($datePractises as $date){
                            $this->datePractiseModel->delete($date['date_id']);
                        }
                        return redirect()->to(base_url('dashboard-calendar'));
                    }else{
                        $countClass--;
                        continue;
                    }
                }
                $dataClass = [
                    'Class_class_id' => $class,
                    'Practise_practise_id' => $id,
                ];
                $countClass--;
                $this->class_practiseModel->insert($dataClass);
            }
        }
        $path = FCPATH . 'assets/document';
        $file->move($path, $fileName);
        return redirect()->to(base_url('dashboard-calendar'));
    }
   /* public function sentMoreEmail(){
        $companyes = $this->representativeCompanyModel->findAll();
        $moreMails = [];
        foreach($companyes as $company){
            $moreMails[] = $company['representative_mail'];
        }
        log_message('info', 'maily: ' . json_encode($moreMails));
        $messageHtml = 'Zkouška hromadného mailu:';
        $subjectEmail = 'Zkouška hromadného mailu';
        $this->email->sentMoreEmail($moreMails, $messageHtml, $subjectEmail);
    }*/
    public function editPractise(){
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $endOffer = $this->request->getPost('end-new-offer');
        $file = $this->request->getPost('contract-file');
        $classes = $this->request->getPost('classes');
        $description = $this->request->getPost('description');
        $practise = $this->practiseModel->find($id);
        if(empty($id && $name && $endOffer && $classes)){
            return redirect()->to(base_url('dashboard-calendar'));
        }
        if(!empty($file)){
            $fileName = $file->getName();
            if($fileName !== $practise['practise_contract_file']){
                $fileName = bin2hex(random_bytes(10)) . '.pdf';
                $path = FCPATH . 'assets/document';
                if(unlink($path . $practise['practise_contract_file'])){
                    $file->move($path, $fileName);
                }else{
                    return redirect()->to(base_url('dashboard-calendar'));
                }
            }
            $data = [
                'practise_name' => $name,
                'practise_description' => $description,
                'practise_contract_file' => $fileName,
                'practise_end_new_offer' => $endOffer,
            ];
            $this->practiseModel->update($id, $data);
        }else{
            $data = [
                'practise_name' => $name,
                'practise_description' => $description,
                'practise_end_new_offer' => $endOffer,
            ];
            $this->practiseModel->update($id, $data);
        }
        $existingClasses = $this->class_practiseModel->where('Practise_practise_id')->withDeleted()->find();
        $existingId = array_column($existingClasses, 'Class_class_id');
        $classPractises = $this->class_practiseModel->findAll();
        $existingClass = array_column($classPractises, 'Class_class_id');
        $countClass = count($classes);
        foreach($classes as $class){
            if(in_array($class, $existingClass)){
                if($countClass == 1){
                    return redirect()->to(base_url('dashboard-calendar'));
                }else{
                    $countClass--;
                    continue;
                }
            }
            if(in_array($class, $existingId)){
                $currentDelTime = $existingClasses[array_search($class, $existingId)]['class_practise_del_time'];
                $currentId = $existingClasses[array_search($class, $existingId)]['class_practise_id'];
                if(!empty($currentDelTime)){
                    $this->class_practiseModel->update($currentId, ['class_practise_del_time' => null]);
                    $countClass--;
                }
            }else{
                $newDataClass = [
                    'Class_class_id' => $class,
                    'Practise_practise_id' => $id,
                ];
                $countClass--;
                $this->class_practiseModel->insert($newDataClass);
            }
        }
        $countClass = count($classes);
        foreach($existingClasses as $existingClass){
            if(in_array($class, $existingClass)){
                if($countClass == 1){
                    return redirect()->to(base_url('dashboard-calendar'));
                }else{
                    $countClass--;
                    continue;
                }
            }
            if(!empty($classes)){
                if(!in_array($existingClass['Class_class_id'], $classes)){
                    $this->class_practiseModel->delete($existingClass['class_practise_id']);
                    $countClass--;
                }
            }else{
                $this->class_practiseModel->delete($existingClass['class_practise_id']);
                $countClass--;
            }
        }
        return redirect()->to(base_url('dashboard-calendar'));
    }
    public function deletePractise($id){
        $practise = $this->practiseModel->find($id);
        $fileName = $practise['practise_contract_file'];
        if(!empty($fileName)){
            $path = FCPATH . 'assets/document/';
            unlink($path . $fileName);
        }
        $this->datePractiseModel->where('Practise_practise_id', $id)->delete();
        $this->class_practiseModel->where('Practise_practise_id', $id)->delete();
        $this->practiseModel->delete($id);
        return redirect()->to(base_url('dashboard-calendar'));
    }
    public function editDatePractise(){
        $id = $this->request->getPost('id');
        $dateFrom = $this->request->getPost('dateFrom');
        $dateTo = $this->request->getPost('dateTo');
        if(empty($id && $dateFrom && $dateTo)){
            return redirect()->to(base_url('dashboard-calendar'));
        }
        if($dateFrom > $dateTo){
            return redirect()->to(base_url('dashboard-calendar'));
        }
        $data = [
            'date_date_from' => $dateFrom,
            'date_date_to' => $dateTo,
        ];
        $this->datePractiseModel->update($id, $data);
        return redirect()->to(base_url('dashboard-calendar'));
    }
    public function deleteDatePractise($id){
        $this->datePractiseModel->delete($id);
        return redirect()->to(base_url('dashboard-calendar'));
    }
    public function addNextDate(){
        $dateFrom = $this->request->getPost('dateFrom');
        $dateTo = $this->request->getPost('dateTo');
        $practiseId = $this->request->getPost('id');
        if(empty($dateFrom && $dateTo && $practiseId)){
            return redirect()->to(base_url('dashboard-calendar'));
        }
        if($dateFrom > $dateTo){
            return redirect()->to(base_url('dashboard-calendar'));
        }
        $data = [
            'date_date_from' => $dateFrom,
            'date_date_to' => $dateTo,
            'Practise_practise_id' => $practiseId,
        ];
        $this->datePractiseModel->insert($data);
        return redirect()->to(base_url('dashboard-calendar'));
    }
    public function addPractiseManager(){
        $degreeBefore = $this->request->getPost('degree_before');
        $name = $this->request->getPost('name');
        $surname = $this->request->getPost('surname');
        $degreeAfter = $this->request->getPost('degree_after');
        $phone = $this->request->getPost('phone');
        $mail = $this->request->getPost('mail');
        $positionWork = $this->request->getPost('position_work');
        $companyId = $this->request->getPost('companyId');
        if(empty($name && $surname && $phone && $mail && $companyId)){
            return redirect()->to(base_url('dashboard-company'));
        }
        $data = [
            'manager_degree_before' => $degreeBefore,
            'manager_name' => $name,
            'manager_surname' => $surname,
            'manager_degree_after' => $degreeAfter,
            'manager_mail' => $mail,
            'manager_phone' => $phone,
            'manager_position_works' => $positionWork,
            'Company_company_id' => $companyId,
        ];
        $this->practiseManager->insert($data);
        return redirect()->to(base_url('dashboard-company'));
    }
    public function editPractiseManager(){
        $id = $this->request->getPost('id');
        $degreeBefore = $this->request->getPost('degree_before');
        $name = $this->request->getPost('name');
        $surname = $this->request->getPost('surname');
        $degreeAfter = $this->request->getPost('degree_after');
        $phone = $this->request->getPost('phone');
        $mail = $this->request->getPost('mail');
        $positionWork = $this->request->getPost('position_work');
        $companyId = $this->request->getPost('companyId');
        if(empty($name && $surname && $phone && $mail && $companyId && $id)){
            return redirect()->to(base_url('dashboard-company'));
        }
        $data = [
            'manager_degree_before' => $degreeBefore,
            'manager_name' => $name,
            'manager_surname' => $surname,
            'manager_degree_after' => $degreeAfter,
            'manager_mail' => $mail,
            'manager_phone' => $phone,
            'manager_position_works' => $positionWork,
            'Company_company_id' => $companyId,
        ];
        $this->practiseManager->update($id, $data);
        return redirect()->to(base_url('dashboard-company'));
    }
    public function addRepresentativeCompany(){
        $degreeBefore = $this->request->getPost('degree_before');
        $name = $this->request->getPost('name');
        $surname = $this->request->getPost('surname');
        $degreeAfter = $this->request->getPost('degree_after');
        $phone = $this->request->getPost('phone');
        $mail = $this->request->getPost('mail');
        $positionWork = $this->request->getPost('position_work');
        $passwd1 = $this->request->getPost('passwd1');
        $passwd2 = $this->request->getPost('passwd2');
        $checkbox = $this->request->getPost('checkbox');
        $companyId = $this->request->getPost('companyId');
        $user = $this->representativeCompanyModel->where('representative_mail',$mail)->first();
        if(!empty($user)){
            return redirect()->to(base_url('dashboard-company'));
        }
        if(empty($name && $surname && $mail && $phone && $companyId)){
            return redirect()->to(base_url('dashboard-company'));
        }
        if(empty($checkbox)){
            if($passwd1 !== $passwd2){
                return redirect()->to(base_url('dashboard-company'));
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
            $this->email->sentEmail($mail, $messageHtml, $subjectEmail);
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
        return redirect()->to(base_url('dashboard-company'));
    }
    public function editRepresentativeCompany(){
        $id = $this->request->getPost('id');
        $degreeBefore = $this->request->getPost('degree_before');
        $name = $this->request->getPost('name');
        $surname = $this->request->getPost('surname');
        $degreeAfter = $this->request->getPost('degree_after');
        $phone = $this->request->getPost('phone');
        $mail = $this->request->getPost('mail');
        $positionWork = $this->request->getPost('position_work');
        if(empty($name && $surname && $phone && $mail && $id)){
            return redirect()->to(base_url('dashboard-company'));
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
        return redirect()->to(base_url('dashboard-company'));
    }
    public function editCompany(){
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        if(empty($id && $name)){
            return redirect()->to(base_url('dashboard-company'));
        }
        $data = [
            'company_name' => $name,
        ];
        $this->companyModel->update($id, $data);
        return redirect()->to(base_url('dashboard-company'));
    }
    public function addNewCompany(){
        $nameCompany = $this->request->getPost('nameCompany');
        $ico = $this->request->getPost('ico');
        $legalForm = $this->request->getPost('category_id');
        $degreeBefore = $this->request->getPost('degree_before');
        $name = $this->request->getPost('name');
        $surname = $this->request->getPost('surname');
        $degreeAfter = $this->request->getPost('degree_after');
        $mail = $this->request->getPost('mail');
        $phone = $this->request->getPost('phone');
        $position_work = $this->request->getPost('position_work');
        $passwd1 = $this->request->getPost('passwd1');
        $passwd2 = $this->request->getPost('passwd2');
        $checkbox = $this->request->getPost('checkbox');
        if(empty($ico && $legalForm && $name && $surname && $mail && $phone && $position_work)){
            log_message('info', 'Chyba: prázdné');
            return redirect()->to(base_url('dashboard-company'));
        }
        if($passwd1 !== $passwd2){
            log_message('info', 'Chyba: Heslo');
            return redirect()->to(base_url('dashboard-company'));
        }
        $existCompany = $this->companyModel->where('company_ico', $ico)->find();
        if(!empty($existCompany)){
            log_message('info', 'Chyba: existuje firma');
            return redirect()->to(base_url('dashboard-company'));
        }
        $existUser = $this->representativeCompanyModel->where('representative_mail', $mail)->find();
        if(!empty($existUser)){
            log_message('info', 'Chyba: existuje uživatel');
            return redirect()->to(base_url('dashboard-company'));
        }
        $isValid = $this->verifyCompany($ico);
        if(empty($nameCompany)){
            $nameCompany = $isValid['obchodniJmeno'];
        }
        $town = $isValid['sidlo']['nazevObce'];
        if(empty($isValid['sidlo']['nazevUlice'])){
            $street = $isValid['sidlo']['nazevObce'] . ' ' . $isValid['sidlo']['cisloDomovni'];
        }else{
            $street = $isValid['sidlo']['nazevUlice'].' '.$isValid['sidlo']['cisloDomovni'];
        }
        $postCode = $isValid['sidlo']['psc'];
        $legalNumberForm = $isValid['pravniForma'];
        $dataCompany = [
            'company_name' => $nameCompany,	
            'company_ico' => $ico,
            'company_subject' => $legalForm,
            'company_legal_form' => $legalNumberForm,
            'company_city' => $town,
            'company_agree_document' => 1,
            'company_street' => $street,
            'company_post_code' => $postCode,    
        ];
        $id = $this->companyModel->insert($dataCompany);
        if(!empty($checkbox)){
            $passwd1 = bin2hex(random_bytes(16));
        }
        $hashPasswd = password_hash($passwd1, PASSWORD_DEFAULT);
        $dataUser = [
            'representative_degree_before' => $degreeBefore,
            'representative_name' => $name,
            'representative_surname' => $surname,
            'representative_degree_after' => $degreeAfter,
            'representative_mail' => $mail,
            'representative_password' => $hashPasswd,
            'representative_phone' => $phone,
            'representative_function' => $position_work,
            'Company_company_id' => $id,
        ];
        $idUser = $this->representativeCompanyModel->insert($dataUser);
        if(!empty($checkbox)){
            $secretCode = bin2hex(random_bytes(16));
            $hashMail = password_hash($mail, PASSWORD_DEFAULT);
            $linkReset = base_url('/reset-password?code='.urlencode($secretCode).'&idcode='.urlencode($hashMail).'&id='.$idUser);
            $messageHtml = '
            <h1>Úspěšná registrace firmy a vytvoření účtu</h1>
            <p>Vážený uživateli,</p>
            <p>Vaše firma <strong>' . htmlspecialchars($nameCompany) . '</strong> byla úspěšně zaregistrována do aplikace <strong>Booking praxí</strong>.</p>
            <p>Současně Vám byl vytvořen účet, kterým můžete spravovat firemní nabídky praxí, sledovat přihlášky studentů a komunikovat se školou.</p>
            <p>Pro aktivaci účtu je nutné nastavit heslo. Klikněte na následující odkaz, který je platný jednu hodinu od doručení tohoto e-mailu:</p>
            <br>
            <a href="' . $linkReset . '" style="background-color: #007BFF; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-family: Arial, sans-serif;">Nastavit heslo</a>
            <br>
            <br>
            <p>Pokud odkaz nefunguje, zkopírujte následující URL do svého prohlížeče:</p>
            <p>' . $linkReset . '</p>
            <br>
            <h3>Detaily registrace firmy:</h3>
            <ul>
                <li><strong>Název firmy:</strong> ' . htmlspecialchars($nameCompany) . '</li>
                <li><strong>IČO:</strong> ' . htmlspecialchars($ico) . '</li>
                <li><strong>Právní forma:</strong> ' . htmlspecialchars($legalNumberForm) . '</li>
                <li><strong>Sídlo:</strong> ' . htmlspecialchars($street) . ', ' . htmlspecialchars($postCode) . ' ' . htmlspecialchars($town) . '</li>
            </ul>
            <br>
            <h3>Detaily uživatele:</h3>
            <ul>
                <li><strong>Jméno:</strong> ' . htmlspecialchars($degreeBefore . ' ' . $name . ' ' . $surname . ' ' . $degreeAfter) . '</li>
                <li><strong>E-mail:</strong> ' . htmlspecialchars($mail) . '</li>
                <li><strong>Telefon:</strong> ' . htmlspecialchars($phone) . '</li>
                <li><strong>Pozice ve firmě:</strong> ' . htmlspecialchars($position_work) . '</li>
            </ul>
            <br>
            <p>Pokud budete mít jakékoliv otázky nebo problémy, kontaktujte prosím správce aplikace Booking praxí.</p>
            <p>Děkujeme za spolupráci.</p>
            ';
            $subjectEmail = 'Registrace firmy a vytvoření účtu - Booking praxí';
            $this->email->sentEmail($mail, $messageHtml, $subjectEmail);
            $nowTime = Time::now();
            $expire = $nowTime->addHours(1);
            $hashSecretCode = password_hash($secretCode, PASSWORD_DEFAULT);
            $dataReset = [
                'reset_token' => $hashSecretCode,
                'reset_expires_at' => $expire,
                'reset_use' => 0,
                'Representative_company_representative_id' => $idUser,
            ];
            $this->resetPassword->insert($dataReset);
        }
        return redirect()->to(base_url('dashboard-company'));
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
    public function editUserPassword(){
        $id = $this->request->getPost('id');
        $passwd1 = $this->request->getPost('passwd1');
        $passwd2 = $this->request->getPost('passwd2');
        $checkbox = $this->request->getPost('checkbox');
        if($passwd1 !== $passwd2){
            return redirect()->to(base_url('dashboard-company'));
        }
        if(empty($checkbox)){
            if(empty($passwd1 && $passwd2)){
                return redirect()->to(base_url('dashboard-company'));
            }
            $data = [
                'representative_password' => $passwd1,
            ];
            $this->representativeCompanyModel->update($id, $data);
        }
        if(!empty($checkbox)){
            $user = $this->representativeCompanyModel->find($id);
            $resetCodes = $this->resetPassword->where('Representative_company_representative_id', $user['representative_id'])->find();
            $nowTime = Time::now();
            $expire = $nowTime->addHours(1);
            foreach($resetCodes as $resetCode){
                if($resetCode['reset_expires_at'] > $nowTime){
                    return redirect()->to(base_url('dashboard-company'));
                }
            }
            $mail = $user['representative_mail'];
            $secretCode = bin2hex(random_bytes(16));
            $hashMail = password_hash($mail, PASSWORD_DEFAULT);
            $linkReset = base_url('/reset-password?code='.urlencode($secretCode).'&idcode='.urlencode($hashMail).'&id='.$user['representative_id']);
            $messageHtml = '
            <h1>Obnovení hesla k aplikaci Booking praxí</h1>
            <p>Vážený uživateli,</p>
            <p>obdrželi jsme žádost o obnovení hesla k Vašemu účtu v aplikaci Booking praxí. Pokud jste tuto žádost neodeslali, prosím ignorujte tento e-mail.</p>
            <p>Pro obnovení hesla klikněte na následující odkaz. Odkaz je platný jednu hodinu od doručení tohoto e-mailu:</p>
            <br>
            <a href="' . $linkReset . '" style="background-color: #007BFF; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-family: Arial, sans-serif;">Obnovit heslo</a>
            <br>
            <br>
            <p>Pokud odkaz nefunguje, zkopírujte následující URL do svého prohlížeče:</p>
            <p>' . $linkReset . '</p>
            <br>
            <p>V případě, že se obnovení hesla nezdaří nebo máte jakékoliv dotazy, kontaktujte prosím správce aplikace Booking praxí.</p>
            <br>
            <p>Děkujeme za Vaši spolupráci.</p>
            ';
            $subjectEmail = 'Obnovení hesla - Booking praxí';
            $this->email->sentEmail($mail, $messageHtml, $subjectEmail);
            $hashSecretCode = password_hash($secretCode, PASSWORD_DEFAULT);
            $dataResetPass = [
                    'reset_token' => $hashSecretCode,
                    'reset_expires_at' => $expire,
                    'reset_use' => 0,
                    'Representative_company_representative_id' => $user['representative_id'],
                ] ;
            $this->resetPassword->insert($dataResetPass);
        }
        return redirect()->to(base_url('dashboard-company'));
    }
    public function deleteCompany($id){
        $company = $this->companyModel->find($id);
        if(empty($company)){
            return redirect()->to(base_url('dashboard-company'));
        }
        $representativeCompanyes = $this->representativeCompanyModel->where('Company_company_id', $id)->find();
        foreach($representativeCompanyes as $representativeCompany){
            $this->logCompany->where('Representative_company_representative_id', $representativeCompany['representative_id'])->delete();
            $this->resetPassword->where('Representative_company_representative_id', $representativeCompany['representative_id'])->delete();
        }
        $representativeCompanyes = $this->representativeCompanyModel->where('Company_company_id', $id)->delete();
        $this->companyModel->delete($id);
        return redirect()->to(base_url('dashboard-company'));
    }
    public function deleteRepresentativeCompany($id){
        $representativeCompany = $this->representativeCompanyModel->find($id);
        $countCompany = $this->representativeCompanyModel->where('Company_company_id', $representativeCompany['Company_company_id'])->find();
        $count = count($countCompany);
        if($count < 2){
            return redirect()->to(base_url('dashboard-company'));
        }
        $this->logCompany->where('Representative_company_representative_id', $id)->delete();
        $this->resetPassword->where('Representative_company_representative_id', $id)->delete();
        $this->representativeCompanyModel->where('representative_id', $id)->delete();
        return redirect()->to(base_url('dashboard-company'));
    }
    public function deletePractiseManager($id){
        $this->practiseManager->delete($id);
        return redirect()->to(base_url('dashboard-company'));
    }
}