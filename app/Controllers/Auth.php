<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use League\OAuth2\Client\Provider\GenericProvider;
use App\Models\UserModel;
use App\Models\CompanyModel;
use App\Models\RepresentativeCompanyModel;
use App\Models\LogCompany;
use App\Models\LogUser;
use App\Models\ResetPassword;
use App\Models\ClassModel;
use App\Controllers\Email;
class Auth extends Controller
{
    protected $provider;
    var $session;
    var $companyModel;
    var $userModel;
    var $representativeCompanyModel;
    var $logCompany;
    var $logUser;
    var $resetPassword;
    var $email;
    var $classModel;
    public function __construct()
    {
        $this->companyModel = new CompanyModel();
        $this->userModel = new UserModel();
        $this->representativeCompanyModel = new RepresentativeCompanyModel();
        $this->logCompany = new LogCompany();
        $this->logUser = new LogUser();
        $this->resetPassword = new ResetPassword();
        $this->classModel = new ClassModel();
        $this->email = new Email();
        $this->session = session();
        $this->session->keepFlashdata('err');
        // Načítání hodnot z .env souboru přímo v kontroleru
        $clientId = env('CLIENT_ID');
        $clientSecret = env('CLIENT_SECRET');
        $tenantId = env('TENANT_ID');
        $redirectUrl = env('REDIRECT_URL');
        
        // Nastavení provideru (http požadavku) pro OAuth2
        $this->provider = new GenericProvider([
            'clientId'                => $clientId,
            'clientSecret'            => $clientSecret,
            'redirectUri'             => $redirectUrl,
            'urlAuthorize'            => "https://login.microsoftonline.com/{$tenantId}/oauth2/v2.0/authorize?scope=openid profile email User.Read",
            'urlAccessToken'          => "https://login.microsoftonline.com/{$tenantId}/oauth2/v2.0/token",
            'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me?$select=displayName,givenName,surname,jobTitle,department,mail,userPrincipalName',
        ]);
    }

    public function loginCompany(){
        $mail = $this->request->getPost('email');
        $passwd = $this->request->getPost('password');
        $user = $this->representativeCompanyModel->where('representative_mail', $mail)->first();
        if(!$user || !password_verify($passwd, $user['representative_password'])){
            $this->session->setFlashdata('err_message', 'Zadali jste špatné přihlašovací údaje.');
            return redirect()->to(base_url('/login'));
        }
        $this->session->set('companyUser',[
            'idUser' => $user['representative_id'],
            'idCompany' => $user['Company_company_id'],
        ]);
        $ipAdrese = $this->request->getIPAddress();
        $data = [
            'log_company_name' => 'Přihlášení',
            'log_company_ip_adrese' => $ipAdrese,
            'Representative_company_representative_id' => $user['representative_id'],
        ];
        $this->logCompany->insert($data);
        $this->session->set('role',['company']);
        return redirect()->to(base_url('/home-company')); //!!Je potřeba dodat správnou url
    }
    public function logOutCompany(){
        $ipAdrese = $this->request->getIPAddress();
        $user = $this->session->get('companyUser');
        $data = [
            'log_company_name'=> 'Odhlášení',
            'log_company_ip_adrese' => $ipAdrese,
            'Representative_company_representative_id' => $user['idUser'],
        ];
        $this->logCompany->insert($data);
        $this->session->destroy();
        return redirect()->to(base_url('/login'));
    }
    public function registerCompany(){
        $ico = $this->request->getPost('ico');
        $mail = $this->request->getPost('email');
        $passwd1 = $this->request->getPost('passwd1');
        $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/';
        if(!preg_match($pattern, $passwd1)){
            $this->session->setFlashdata('err_message', 'V registraci firmy nemůžete pokračovat, protože nebyli dodrženy podmínky pro obsah hesla.');
            return redirect()->to(base_url('/registration'));
        }
        $representativeUser = $this->representativeCompanyModel->where('representative_mail', $mail)->first();
        $companyExist = $this->companyModel->where('company_ico', $ico)->first();
        if($representativeUser || $companyExist){
            $this->session->setFlashdata('err_message', 'Firma/e-mail je v systému již existuje.');
            return redirect()->to(base_url('/registration'));
        }
        if(empty($ico && $mail && $passwd1)){
            $this->session->setFlashdata('err_message', 'Všechny potřebná políčka nebyli vyplněny. Nemůžete pokračovat v registraci.');
            return redirect()->to(base_url('/registration'));
        }
        $isValid = $this->verifyCompany($ico);
        if (!$isValid) {
            $this->session->setFlashdata('err_message', 'Danou firmu nemůže v našem systému vytvořit.');
            return redirect()->to(base_url('/registration'));
        }
        $hashPasswd = password_hash($passwd1, PASSWORD_DEFAULT);
        $nameCompany = $isValid['obchodniJmeno'];
        $town = $isValid['sidlo']['nazevObce'];
        if(empty($isValid['sidlo']['nazevUlice'])){
            $street = $isValid['sidlo']['nazevObce'] . ' ' . $isValid['sidlo']['cisloDomovni'];
        }else{
            $street = $isValid['sidlo']['nazevUlice'].' '.$isValid['sidlo']['cisloDomovni'];
        }
        $postCode = $isValid['sidlo']['psc'];
        $legalForm = $isValid['pravniForma'];
        $this->session->set('company',[
            'name_company' => $nameCompany,
            'ico' => $ico,
            'mail'=> $mail,
            'town' => $town,
            'street' => $street,
            'postCode' => $postCode,
            'legal_form' => $legalForm,
        ]);
        $this->session->set('passwdPerson', [
            'hashPasswd' => $hashPasswd
        ]);
        $this->session->set('registration_start', true);
        return redirect()->to(base_url('/next-step-register'));
    }
    //Ověření, zda ičo, které uživatel zadal do formuláře, zda existuje.
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
    public function continuationRegister(){
        $session = session();
        if (!$session->has('registration_start') || $session->get('registration_start') !== true) {
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste registraci znovu.');
            return redirect()->to(base_url('/registration'));
        }
        $companyData = $session->get('company');
        $data = [
            'title'=> 'Dokončení registrace',
            'name_company' => $companyData['name_company'],
            'ico' => $companyData['ico'],
            'mail' => $companyData['mail'],
            'town' => $companyData['town'],
            'street' => $companyData['street'],
            'postCode' => $companyData['postCode'],
            'legal_form' => $companyData['legal_form'],
        ];
        return view('continuation_register', $data);
    }
    public function completionRegister(){
        $passwordSession = $this->session->get('passwdPerson');
        $companySession = $this->session->get('company');
        $password = $passwordSession['hashPasswd'];
        $legalFormNumber = $companySession['legal_form'];
        $nameCompany = $companySession['name_company'];
        $ico = $companySession['ico'];
        $placeCompany = $companySession['town'];
        $streetCompany = $companySession['street'];
        $postCode = $companySession['postCode'];
        $legalForm = $this->request->getPost('select_subject');
        $agreeDocument = $this->request->getPost('agree_person');
        $degreeBefore = $this->request->getPost('degree_before');
        $namePerson = $this->request->getPost('name');
        $surnamePerson = $this->request->getPost('surname');
        $degreeAfter = $this->request->getPost('degree_after');
        $phonePerson = $this->request->getPost('phone');
        $functionPerson = $this->request->getPost('function');
        $mail = $this->request->getPost('mail');
        if($namePerson == null){
            $this->session->setFlashdata('err_message', 'Políčko jméno zastupující osoby je povinné.');
            return redirect()->to(base_url('/next-step-register'));
        }
        if($surnamePerson == null){
            $this->session->setFlashdata('err_message', 'Políčko příjmení zastupující osoby je povinné.');
            return redirect()->to(base_url('/next-step-register'));
        }
        if($phonePerson == null){
            $this->session->setFlashdata('err_message', 'Políčko tel. číslo je povinné.');
            return redirect()->to(base_url('/next-step-register'));
        }
        if($functionPerson == null){
            $this->session->setFlashdata('err_message', 'Políčko funkce zastupující osoby je povinné.');
            return redirect()->to(base_url('/next-step-register'));
        }
        if($mail == null){
            $this->session->setFlashdata('err_message', 'Políčko e-mail zastupující osoby je povinné.');
            return redirect()->to(base_url('/next-step-register'));
        }
        if($legalForm == 0){
            $this->session->setFlashdata('err_message', 'Musíte vybrat právní formu.');
            return redirect()->to(base_url('/next-step-register'));
        }
        if($agreeDocument == null){
            $this->session->setFlashdata('err_message', 'Pokud nebude souhlasit s našími podmínkami, tak Vás nemůžeme registrovat v našem systému.');
            return redirect()->to(base_url('/next-step-register'));
        }
        $dataCompany = [
            'company_name' => $nameCompany,	
            'company_ico' => $ico,
            'company_subject' => $legalForm,
            'company_legal_form' => $legalFormNumber,
            'company_city' => $placeCompany,
            'company_agree_document' => $agreeDocument,
            'company_street' => $streetCompany,
            'company_post_code' => $postCode,    
        ];
        $lastIdInsert = $this->companyModel->insert($dataCompany); 
        $dataPerson = [
            'representative_degree_before' => $degreeBefore,
            'representative_name' => $namePerson,
            'representative_surname' => $surnamePerson,
            'representative_degree_after' => $degreeAfter,
            'representative_mail' => $mail,
            'representative_password' => $password,
            'representative_phone' => $phonePerson,
            'representative_function' => $functionPerson,
            'Company_company_id' => $lastIdInsert,
        ];
        $this->representativeCompanyModel->insert($dataPerson);
        $this->session->remove('company');
        $this->session->remove('passwdPerson');
        $this->session->set('registration_start', false);
        return redirect()->to(base_url('/login'));
    }
    public function changePassCompany(){

    }
    public function loginOAUH(){
        //Získaní url a přesměrovaní na stránku microsoft
        $authUrl = $this->provider->getAuthorizationUrl();
        $this->session->set('oauth2state', $this->provider->getState());
        $ipAddress = $this->request->getIPAddress();
        $this->session->set('ip_user', $ipAddress);
        return redirect()->to($authUrl);
    }
    public function callback()
    {
        //state a code se odešle při přihlášení na danou redirect_url, kterou jsme si zvolili a od url se to musí zpracovat a získat token pomocí které získám informace o uživatelích.
        $code = $this->request->getVar('code');
        if (empty($code)) {
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci opakovat.');
            return redirect()->to('/login');
        }
        $state = $this->request->getVar('state');
        if (empty($state) || $state !== $this->session->get('oauth2state')) {
            $this->session->remove('oauth2state');
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci opakovat.');
            return redirect()->to('/login');
        }
        //Získá token pomoci code, který si vezme z url
            $token = $this->provider->getAccessToken('authorization_code', [
                'code' => $code,
            ]);
        // Získání informace o uživateli a uložení do pole
        $ownerDetails = $this->provider->getResourceOwner($token);
        $userData = $ownerDetails->toArray();
        //log_message('debug', print_r($userData, true)); Při vývoji, abych věděl co se všechno vypisuje k uživateli.

        // Získání $emailu
        $email = $userData['mail'] ?? $userData['userPrincipalName'];

        $ipAdrese = $this->session->get('ip_user');
        $user = $this->userModel->where('user_mail', $email)->first();
        // Zjistím, zda stávající uživatel již není uveden v databázi, a když není, tak ho tam napíší.
        if (!$user) {
            $department = $userData['department'];
            $users = $this->userModel->findAll();
            if(empty($users)){
                $admin = 1;
            }
            $data = [
                'user_name' => $userData['givenName']??'',
                'user_surname' => $userData['surname']??'',
                'user_mail' => $email,
                'user_department' => $userData['department'] ?? '',
                'user_job_title' => $userData['jobTitle'] ?? '',
                'user_admin' => $admin ?? '0',
            ];
            $idUser = $this->userModel->insert($data);
            if(strpos($department, '-') !== false){
                [$yearGraduation, $letterClass] = explode('-', $department, 2);
                $yearGraduation = intval($yearGraduation);
                $letterClass = strtoupper(trim($letterClass));
                $class = $this->classModel->where('class_year_graduation', $yearGraduation)->where('class_letter_class', $letterClass)->first();
                if($class){
                    $dataUser = [
                        'user_role' => 'student',
                        'Class_class_id' => $class['class_id'],
                    ];
                    $this->userModel->update($idUser, $dataUser);
                }
            }else{
                $dataUser = [
                    'user_role' => 'teacher',
                ];
                $this->userModel->update($idUser, $dataUser);
            }
            $user = $this->userModel->where('user_mail', $email)->first();
        }
        $dataLog = [
            'log_user_name' => 'Přihlášení',
            'log_user_ip_adrese' => $ipAdrese,
            'User_user_id' => $user['user_id'],
        ];
        $this->logUser->insert($dataLog);
        // Potřebná data ukládám do session pro další práci s nimi
        $admin = $user['user_admin'];
        $spravce = $user['user_spravce'];
        if($admin == 1){
            $role = 'admin';
        }elseif($spravce == 1){
            $role = 'spravce';
        }else{
            $role = null;
        }
        if($role == null){
            $this->session->set('role', [$user['user_role']]);
        }else{
            $this->session->set('role', [$user['user_role'], $role]);
        }
        $this->session->set('user', [
            'id' => $user['user_id'],
            'jmeno' => $user['user_name'],
            'prijmeni' => $user['user_surname'],
            'email' => $user['user_mail'],
            'class' => $user['Class_class_id'],
        ]);
        $this->session->remove('ip_user');
        //Vracím na stránku /routu
        return redirect()->to(base_url('/home-student'));
    }
    //metoda pro odhlašovaní uživatelů přihlášených přes ms office.
    public function logOut(){
        $user = $this->session->get('user');
        $ipAdrese = $this->request->getIPAddress();
        $data = [
            'log_user_name' => 'Odhlášení',
            'log_user_ip_adrese' => $ipAdrese,
            'User_user_id' => $user['id'],
        ];
        $this->logUser->insert($data);
        $this->session->destroy();
        $logoutUrl = 'https://login.microsoftonline.com/common/oauth2/v2.0/logout';
        return redirect()->to($logoutUrl . '?post_logout_redirect_uri=' . urlencode(base_url('/login')));
    }
    public function resetPassword(){
        $secretCode = $this->request->getGet('code');
        $idCode = $this->request->getGet('idcode');
        $id = $this->request->getGet('id');
        if(empty($secretCode && $idCode && $id)){
            return redirect()->to(base_url('/login'));
        }
        $user = $this->representativeCompanyModel->find($id);
        if(empty($user)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci opakovat.');
            return redirect()->to(base_url('/login'));
        }
        if(!password_verify($user['representative_mail'], $idCode)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba.');
            return redirect()->to(base_url('/login'));
        }
        $resetPasswd = $this->resetPassword->where('Representative_company_representative_id', $user['representative_id'])->find();
        if(empty($resetPasswd)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci opakovat.');
            return redirect()->to(base_url('/login'));
        }
        foreach($resetPasswd as $resetPassword){
            $experied = $resetPassword['reset_expires_at'];
            $nowTime = Time::now();
            if($experied > $nowTime){
                if(password_verify($secretCode, $resetPassword['reset_token'])){
                    $data = [
                        'title' => 'Nové heslo',
                        'user' => $user,
                    ];
            
                    return view('reset_password', $data);
                }
            }
        }
        $this->session->setFlashdata('err_message', 'Nové heslo si nemůžete nastavit, expirační doba vypršela.');
        return redirect()->to(base_url('/login'));
    }
    public function newPassword(){
        $id = $this->request->getPost('id');
        $passwd1 = $this->request->getPost('passwd1');
        $passwd2 = $this->request->getPost('passwd2');
        if(empty($id && $passwd1 && $passwd2)){
            $this->session->setFlashdata('err_message', 'Nevyplnili jste potřebná povinná políčka.');
            return redirect()->back();
        }
        if($passwd1 !== $passwd2){
            $this->session->setFlashdata('err_message', 'Hesla se neshodují.');
            return redirect()->back();
        }
        $passwordHash = password_hash($passwd1, PASSWORD_DEFAULT);
        $data = [
            'representative_password' => $passwordHash,
        ];
        $this->representativeCompanyModel->update($id, $data);
        $dataUse = [
            'reset_use' => 1,
        ];
        $resetPasswd = $this->resetPassword->where('Representative_company_representative_id', $id)->first();
        $this->resetPassword->update($resetPasswd['reset_id'], $dataUse);
        $this->resetPassword->delete($resetPasswd['reset_id']);
        return redirect()->to(base_url('/login'));
    }
    public function forgotPassword(){
        $mail = $this->request->getPost('mail');
        $user = $this->representativeCompanyModel->where('representative_mail', $mail)->first();
        $resetPasswd = $this->resetPassword->where('Representative_company_representative_id', $user['representative_id'])->find();
        $nowTime = Time::now();
        $expire = $nowTime->addHours(1);
        foreach($resetPasswd as $resetPassword){
            if($resetPassword['reset_expires_at'] > $nowTime){
                $this->session->setFlashdata('err_message', 'Vypršel expirační čas.');
                return redirect()->to(base_url('/login'));
            }
        }
        if(empty($user && $mail)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, zkuste akci opakovat.');
            return redirect()->to(base_url('/login'));
        }
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
        return redirect()->to(base_url('/login'));
    }
}