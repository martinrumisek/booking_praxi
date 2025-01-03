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
    public function __construct()
    {
        $this->companyModel = new CompanyModel();
        $this->userModel = new UserModel();
        $this->representativeCompanyModel = new RepresentativeCompanyModel();
        $this->logCompany = new LogCompany();
        $this->logUser = new LogUser();
        $this->resetPassword = new ResetPassword();
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
        $user = $this->representativeCompanyModel->where('mail', $mail)->first();
        if(!$user || !password_verify($passwd, $user['password'])){
            //když uživatel neexistuje nebo nesprávné heslo
            //!!Je potřeba dodělat hlášku
            return redirect()->to(base_url('/login'));
        }
        $this->session->set('companyUser',[
            'idUser' => $user['id'],
            'idCompany' => $user['Company_id'],
        ]);
        $ipAdrese = $this->request->getIPAddress();
        $data = [
            'name' => 'Přihlášení',
            'ip_adrese' => $ipAdrese,
            'Representative_company_id' => $user['id'],
        ];
        $this->logCompany->insert($data);
        $this->session->set('role',['company']);
        return redirect()->to(base_url('/home')); //!!Je potřeba dodat správnou url
    }
    public function logOutCompany(){
        $ipAdrese = $this->request->getIPAddress();
        $user = $this->session->get('companyUser');
        $data = [
            'name'=> 'Odhlášení',
            'ip_adrese' => $ipAdrese,
            'Representative_company_id' => $user['idUser'],
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
            return redirect()->to(base_url('/registration'));
            //!Je potřeba doplnit chybějící hlášku
        }
        $representativeUser = $this->representativeCompanyModel->where('mail', $mail)->first();
        $companyExist = $this->companyModel->where('ico', $ico)->first();
        if($representativeUser || $companyExist){
            return redirect()->to(base_url('/registration'));
            //!JE potřeba doplnit chybějící hlášku, co se stalo.
        }
        if(empty($ico && $mail && $passwd1)){
            return redirect()->to(base_url('/registration'));
            //!Je potřeba doplnit chybějící hlášku
        }
        $isValid = $this->verifyCompany($ico);
        if (!$isValid) {
            return redirect()->to(base_url('/registration'));
            //!Je potřeba přidat hlášku, když to přesměruje zpět na registrační stránku, tak aby uživatel věděl důvod
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
        $namePerson = $this->request->getPost('name');
        $surnamePerson = $this->request->getPost('surname');
        $phonePerson = $this->request->getPost('phone');
        $functionPerson = $this->request->getPost('function');
        $mail = $this->request->getPost('mail');
        if($namePerson == null){
            return redirect()->to(base_url('/next-step-register'));
        }
        if($surnamePerson == null){
            return redirect()->to(base_url('/next-step-register'));
        }
        if($phonePerson == null){
            return redirect()->to(base_url('/next-step-register'));
        }
        if($functionPerson == null){
            return redirect()->to(base_url('/next-step-register'));
        }
        if($mail == null){
            return redirect()->to(base_url('/next-step-register'));
        }
        if($legalForm == 0){
            return redirect()->to(base_url('/next-step-register'));
        }
        if($agreeDocument == null){
            return redirect()->to(base_url('/next-step-register'));
        }
        $dataCompany = [
            'name' => $nameCompany,	
            'ico' => $ico,
            'subject' => $legalForm,
            'legal_form' => $legalFormNumber,
            'city' => $placeCompany,
            'agree_document' => $agreeDocument,
            'street' => $streetCompany,
            'post_code' => $postCode,    
        ];
        $this->companyModel->insert($dataCompany);
        $lastIdInsert = $this->companyModel->getInsertID();
        $dataPerson = [
            'name' => $namePerson,
            'surname' => $surnamePerson,
            'mail' => $mail,
            'password' => $password,
            'phone' => $phonePerson,
            'function' => $functionPerson,
            'Company_id' => $lastIdInsert,
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
            throw new \Exception('Autorizační kód nebyl poskytnut.'); // !!!!Je potřeba ještě změnit. Tak aby se kdyžtak chyba úkládala do sesion.
        }
        $state = $this->request->getVar('state');
        if (empty($state) || $state !== $this->session->get('oauth2state')) {
            $this->session->remove('oauth2state');
            throw new \Exception('Neplatný stav.'); //!Je potřeba změnit
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
        $user = $this->userModel->where('mail', $email)->first();
        // Zjistím, zda stávající uživatel již není uveden v databázi, a když není, tak ho tam napíší.
        if (!$user) {
            $data = [
                'name' => $userData['givenName']??'',
                'surname' => $userData['surname']??'',
                'mail' => $email,
                'department' => $userData['department'] ?? '',
                'job_title' => $userData['jobTitle'] ?? '',
            ];
            $this->userModel->insert($data);
            $user = $this->userModel->where('mail', $email)->first();
        }
        $dataLog = [
            'name' => 'Přihlášení',
            'ip' => $ipAdrese,
            'User_id' =>$user['id'],
        ];
        $this->logUser->insert($dataLog);
        // Potřebná data ukládám do session pro další práci s nimi
        $admin = $user['admin'];
        $spravce = $user['spravce'];
        if($admin == 1){
            $role = 'admin';
        }elseif($spravce == 1){
            $role = 'spravce';
        }else{
            $role = null;
        }
        if($role == null){
            $this->session->set('role', [$user['role']]);
        }else{
            $this->session->set('role', [$user['role'], $role]);
        }
        $this->session->set('user', [
            'id' => $user['id'],
            'jmeno' => $user['name'],
            'prijmeni' => $user['surname'],
            'email' => $user['mail'],
            'class' => $user['Class_id'],
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
            'name' => 'Odhlášení',
            'ip_adrese' => $ipAdrese,
            'User_id' => $user['id'],
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
            log_message('info', 'Chyba v získání údajů');
            return redirect()->to(base_url('/login'));
        }
        $user = $this->representativeCompanyModel->find($id);
        if(empty($user)){
            return redirect()->to(base_url('/login'));
        }
        if(!password_verify($user['mail'], $idCode)){
            log_message('info', 'Chyba mail');
            return redirect()->to(base_url('/login'));
        }
        $resetPasswd = $this->resetPassword->where('Representative_company_id', $user['id'])->find();
        if(empty($resetPasswd)){
            return redirect()->to(base_url('/login'));
        }
        foreach($resetPasswd as $resetPassword){
            if(!password_verify($secretCode, $resetPassword['token'])){
                log_message('info', 'Chyba TOKEN');
                return redirect()->to(base_url('/login'));
            }
            $experied = $resetPassword['expires_at'];
            $nowTime = Time::now();
            if($experied < $nowTime){
                log_message('info', 'Chyba čas'. $experied . '    '. $nowTime);
                return redirect()->to(base_url('/login'));
            }
        }
        $data = [
            'title' => 'Nové heslo',
            'user' => $user,
        ];

        return view('reset_password', $data);
    }
    public function newPassword(){
        $id = $this->request->getPost('id');
        $passwd1 = $this->request->getPost('passwd1');
        $passwd2 = $this->request->getPost('passwd2');
        if(empty($id && $passwd1 && $passwd2)){
            return redirect()->back();
        }
        if($passwd1 !== $passwd2){
            return redirect()->back();
        }
        $passwordHash = password_hash($passwd1, PASSWORD_DEFAULT);
        $data = [
            'password' => $passwordHash,
        ];
        $this->representativeCompanyModel->update($id, $data);
        $dataUse = [
            'use' => 1,
        ];
        $resetPasswd = $this->resetPassword->where('Representative_company_id', $id)->first();
        $this->resetPassword->update($resetPasswd['id'], $dataUse);
        $this->resetPassword->delete($resetPasswd['id']);
        return redirect()->to(base_url('/login'));
    }
    public function forgotPassword(){
        $mail = $this->request->getPost('mail');
        $user = $this->representativeCompanyModel->where('mail', $mail)->first();
        $resetPasswd = $this->resetPassword->where('Representative_company_id', $user['id'])->find();
        $nowTime = Time::now();
        $expire = $nowTime->addHours(1);
        foreach($resetPasswd as $resetPassword){
            if($resetPassword['expires_at'] > $nowTime){
                return redirect()->to(base_url('/login'));
            }
        }
        if(empty($user && $mail)){
            return redirect()->to(base_url('/login'));
        }
        $secretCode = bin2hex(random_bytes(16));
        $hashMail = password_hash($mail, PASSWORD_DEFAULT);
        $linkReset = base_url('/reset-password?code='.urlencode($secretCode).'&idcode='.urlencode($hashMail).'&id='.$user['id']);
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
        $this->sentEmail($mail, $messageHtml, $subjectEmail);
        $hashSecretCode = password_hash($secretCode, PASSWORD_DEFAULT);
        $dataResetPass = [
                'token' => $hashSecretCode,
                'expires_at' => $expire,
                'use' => 0,
                'Representative_company_id' => $user['id'],
            ] ;
        $this->resetPassword->insert($dataResetPass);
        return redirect()->to(base_url('/login'));
    }
    private function sentEmail($mail, $messageHtml, $subjectEmail){
        $email = service('email');
        $email->setTo($mail);
        $email->setSubject($subjectEmail);
        $email->setMailType('html');
        $logoUrl = 'https://www.oauh.cz/www/web/images/logo.png';
        $htmlMessage = $messageHtml . '
        <br>
        <br>
        <br>
        <div style="text-align: center; font-family: Arial, sans-serif; color: #555; border-top: 1px solid #ddd; padding-top: 20px;">
        <img src="'. $logoUrl .'" alt="Logo OAUH" style="max-width: 150px; margin-bottom: 10px;">
        <h6 style="margin: 5px 0; font-size: 16px; color: #333;">OAUH - Booking praxí</h6>
        <p style="margin: 5px 0; font-size: 14px; color: #666;">Web: <a href="https://www.oauh.cz" style="color: #007BFF; text-decoration: none;">www.oauh.cz</a></p>
        <p style="margin: 5px 0; font-size: 14px; color: #666;">Tel.: +420 572 433 011</p>
        <p style="margin: 5px 0; font-size: 14px; color: #666;">E-mail: <a href="mailto:info@oauh.cz" style="color: #007BFF; text-decoration: none;">info@oauh.cz</a></p>
        <p style="margin: 5px 0; font-size: 14px; color: #666;">IČO: 60371731 | DIČ: CZ60371731</p>
        <p style="margin: 15px 0 0; font-size: 12px; color: #999;">&copy; ' . date('Y') . ' OAUH. Všechna práva vyhrazena.</p>
        </div>
        ';
        $email->setMessage($htmlMessage);
        if ($email->send()) {

        } else {

        }
    }
}