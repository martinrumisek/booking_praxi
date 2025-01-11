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
    }
    //Metody pro zobrazení viewček
    public function homeView(){
        $data= [
            'title' => 'Administrace'
        ];
        return view('dashboard/dash_home', $data);
    }
    public function companyView(){
        $companyes = $this->companyModel->paginate(10);
        $pager = $this->companyModel->pager;
        foreach ($companyes as &$company){
            $company['representative'] = $this->representativeCompanyModel->where('Company_company_id', $company['company_id'])->findAll();
            $company['practiseManager'] = $this->practiseManager->where('Company_company_id', $company['company_id'])->findAll();
        }
        $data= [
            'title' => 'Administrace',
            'companyes' => $companyes,
            'pager' => $pager,
        ];
        return view('dashboard/dash_company', $data);
    }
    public function deadlinesView(){
        
        $practises = $this->practiseModel->orderBy('practise_create_time', 'DESC')->findAll();
        $schoolClass = $this->classModel->findAll();
        foreach($practises as &$practise){
            $practise['dates'] = $this->datePractiseModel->where('Practise_practise_id', $practise['practise_id'])->findAll();
            $practise['class'] = [];
            $classIds = $this->class_practiseModel->where('Practise_practise_id', $practise['practise_id'])->findAll();
            foreach($classIds as $classId){
                $class = $this->classModel->find($classId['Class_class_id']);
                $practise['class'][] = $class;
            }
        }
        $data= [
            'title' => 'Administrace',
            'practises' => $practises,
            'schoolClass' => $schoolClass,
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
        $search = $this->request->getGet('search');
        $search = urldecode($search);
        $oder = $this->request->getGet('oder');
        if(empty($search || $oder)){
            $users = $this->userModel->orderBy('user_surname, user_name', 'ASC')->paginate(20);
        }else{
            if($oder == 1 || empty($oder) || $oder > 5 || $oder < 1){
                $users = $this->userModel->join('Class', 'User.Class_id = Class.id', 'left')->select('User.*, Class.*, User.id AS user_id')->orderBy('surname, name', 'ASC')->groupStart()->like("CONCAT(name, ' ', surname)", $search)->orLike("CONCAT(class, '.', letter_class)", $search)->groupEnd()->paginate(20);
            }
            if($oder == 2){
                $users = $this->userModel->join('Class', 'User.Class_id = Class.id', 'left')->select('User.*, Class.*, User.id AS user_id')->orderBy('surname, name', 'DESC')->groupStart()->like("CONCAT(name, ' ', surname)", $search)->orLike("CONCAT(class, '.', letter_class)", $search)->groupEnd()->paginate(20);
            }
            if($oder == 3){
                $users = $this->userModel->join('Class', 'User.Class_id = Class.id', 'left')->select('User.*, Class.*, User.id AS user_id')->orderBy('Class.class, Class.letter_class', 'ASC')->groupStart()->like("CONCAT(name, ' ', surname)", $search)->orLike("CONCAT(class, '.', letter_class)", $search)->groupEnd()->paginate(20);
            }
            if($oder == 4){
                $users = $this->userModel->join('Class', 'User.Class_id = Class.id', 'left')->select('User.*, Class.*, User.id AS user_id')->orderBy('Class.class, Class.letter_class', 'DESC')->groupStart()->like("CONCAT(name, ' ', surname)", $search)->orLike("CONCAT(class, '.', letter_class)", $search)->groupEnd()->paginate(20);
            }
            if($oder == 5){
                $users = $this->userModel->join('Class', 'User.Class_id = Class.id', 'left')->select('User.*, Class.*, User.id AS user_id')->orderBy('admin, spravce', 'DESC')->groupStart()->like("CONCAT(name, ' ', surname)", $search)->orLike("CONCAT(class, '.', letter_class)", $search)->groupEnd()->paginate(20);
            }
        }
        $pager = $this->userModel->pager;
        foreach($users as &$user){
            $class = $this->classModel->where('class_id', $user['Class_class_id'])->first();
            if(!empty($class)){
                $user['class'] = $class;
                $fieldStudy = $this->fieldStudy->where('field_id', $class['Field_study_field_id'])->first();
               if(!empty($fieldStudy)){
                $user['field'] = $fieldStudy;
                $typeSchool = $this->typeSchool->where('type_id', $fieldStudy['Type_school_type_id'])->first();
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
            'oder' => $oder,
            'search' => $search,
        ];
        return view('dashboard/dash_people', $data);
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
        $categoryes = $this->categorySkill->orderBy('category_create_time', 'DESC')->groupStart()->like('category_name', $search)->groupEnd()->paginate(10);
        $pager = $this->categorySkill->pager;
        foreach($categoryes as &$category){
            $category['skill'] = $this->skill->where('Category_skill_category_id', $category['category_id'])->findAll();
        }
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
        $userLogs = $this->logUser->orderBy('log_user_create_time', 'DESC')->paginate(20);
        $pager = $this->logUser->pager;
        foreach($userLogs as &$userLog){
            $userLog['user'] = $this->userModel->where('user_id', $userLog['User_user_id'])->first();
        }
        $data = [
            'title' => 'Administrace',
            'logs' => $userLogs,
            'pager' => $pager,
        ];

        return view('dashboard/dash_log', $data);
    }
    public function logViewCompany(){
        $companyLogs = $this->logCompany->orderBy('log_company_create_time', 'DESC')->paginate(20);
        $pager = $this->logCompany->pager;
        foreach($companyLogs as &$companyLog){
            $companyLog['user'] = $this->representativeCompanyModel->where('representative_id', $companyLog['Representative_company_representative_id'])->first();
            $companyLog['company'] = $this->companyModel->where('company_id', $companyLog['user']['Company_company_id'])->first();
        }
        $data = [
            'title' => 'Administrace',
            'logs' => $companyLogs,
            'pager' => $pager,
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
        if(empty($file)){
            log_message('info','chyba v souboru1');
            return redirect()->to(base_url('dashboard-calendar'));
        }
        if($file->getClientMimeType() !== 'application/pdf'){
            log_message('info','chyba v souboru2');
            return redirect()->to(base_url('dashboard-calendar'));
        }
        $fileName = $file->getName();
        $dataPractise = [
            'practise_name' => $name,
            'practise_description'=> $description,
            'practise_end_new_offer' => $dateEndNewOffer,
            'practise_contract_file' => $fileName,
        ];
        $id = $this->practiseModel->insert($dataPractise);
        foreach($dates as $date){
            $dataDate = [
                'date_date_from' => $date['date-from'],
                'date_date_to' => $date['date-to'],
                'Practise_practise_id' => $id,
            ];
            $this->datePractiseModel->insert($dataDate);
        }
        if(!empty($classes)){
            foreach ($classes as $class) {
                $dataClass = [
                    'Class_class_id' => $class,
                    'Practise_practise_id' => $id,
                ];
                $this->class_practiseModel->insert($dataClass);
            }
        }
        $path = FCPATH . 'assets/document';
        $file->move($path, $fileName);
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
            $logs = $this->logCompany->where('Representative_company_representative_id', $representativeCompany['representative_id'])->find();
            foreach($logs as $log){
                $this->logCompany->delete($log['log_company_id']);
            }
            $resets = $this->resetPassword->where('Representative_company_representative_id', $representativeCompany['representative_id'])->find();
            foreach($resets as $reset){
                $this->resetPassword->delete($reset['reset_id']);
            }
            $this->representativeCompanyModel->delete($representativeCompany['representative_id']);
        }
        $this->companyModel->delete($id);
        return redirect()->to(base_url('dashboard-company'));
    }
    public function deleteRepresentativeCompany($id){
        $representativeCompany = $this->representativeCompanyModel->find($id);
        if(empty($representativeCompany)){
            return redirect()->to(base_url('dashboard-company'));
        }
        $logs = $this->logCompany->where('Representative_company_representative_id', $id)->find();
        foreach($logs as $log){
            $this->logCompany->delete($log['log_company_id']);
        }
        $resets = $this->resetPassword->where('Representative_company_representative_id', $id)->find();
        foreach($resets as $reset){
            $this->resetPassword->delete($reset['reset_id']);
        }
        $this->representativeCompanyModel->delete($id);
        return redirect()->to(base_url('dashboard-company'));
    }
    public function deletePractiseManager($id){
        $practiseManager = $this->practiseManager->find($id);
        if(empty($practiseManager)){
            return redirect()->to(base_url('dashboard-company'));
        }
        $this->practiseManager->delete($id);
        return redirect()->to(base_url('dashboard-company'));
    }
}