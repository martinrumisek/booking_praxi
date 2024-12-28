<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use League\OAuth2\Client\Provider\GenericProvider;
use App\Models\UserModel;
use App\Models\CompanyModel;
use App\Models\RepresentativeCompanyModel;
use App\Models\LogCompany;
use App\Models\LogUser;

class Auth extends Controller
{
    protected $provider;
    var $session;
    var $companyModel;
    var $userModel;
    var $representativeCompanyModel;
    var $logCompany;
    var $logUser;

    public function __construct()
    {
        $this->companyModel = new CompanyModel();
        $this->userModel = new UserModel();
        $this->representativeCompanyModel = new RepresentativeCompanyModel();
        $this->logCompany = new LogCompany();
        $this->logUser = new LogUser();
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
}