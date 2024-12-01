<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use League\OAuth2\Client\Provider\GenericProvider;
use App\Models\UserModel;
use App\Models\CompanyModel;
use App\Models\RepresentativeCompanyModel;

class Auth extends Controller
{
    protected $provider;
    var $session;

    public function __construct()
    {
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

    }
    public function registerCompany(){
        $nameCompany = $this->request->getPost('name_company');
        $ico = $this->request->getPost('ico');
        $mail = $this->request->getPost('email');
        $passwd1 = $this->request->getPost('passwd1');
        $passwd2 = $this->request->getPost('passwd2');

        $isValid = $this->verifyCompany($ico, $nameCompany);
        if (!$isValid) {
            return redirect()->to(base_url('/registration'));
        }
        $hashPasswd = password_hash($passwd1, PASSWORD_DEFAULT);
        $town = $isValid['sidlo']['nazevObce'];
        $street = $isValid['sidlo']['nazevUlice'].' '.$isValid['sidlo']['cisloDomovni'];
        $postCode = $isValid['sidlo']['psc'];
        $legalForm = $isValid['pravniForma'];
        $this->session = session();
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
    private function verifyCompany($ico, $nameCompany){
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
            if(isset($data["obchodniJmeno"]) && $data["obchodniJmeno"] === $nameCompany){
                return $data;
            }else{return null;}
        }else{return null;}
    }
    public function completionRegister(){
        $this->session = session();
        $companyModel = new CompanyModel();
        $representativeCompanyModel = new RepresentativeCompanyModel();
        $passwordSession = $this->session->get('passwdPerson');
        $companySession = $this->session->get('company');
        $password = $passwordSession['hashPasswd'];
        $legalFormNumber = $companySession['legal_form'];
        $nameCompany = $companySession['name_company'];
        $ico = $companySession['ico'];
        $placeCompany = $this->request->getPost('place_company');
        $streetCompany = $this->request->getPost('street_company');
        $postCode = $this->request->getPost('post_code_company');
        $legalForm = $this->request->getPost('select_subject');
        $agreeDocument = $this->request->getPost('agree_person');
        $namePerson = $this->request->getPost('name');
        $surnamePerson = $this->request->getPost('surname');
        $phonePerson = $this->request->getPost('phone');
        $functionPerson = $this->request->getPost('function');
        $mail = $this->request->getPost('mail');

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
        $companyModel->insert($dataCompany);
        $lastIdInsert = $companyModel->getInsertID();
        $dataPerson = [
            'name' => $namePerson,
            'surname' => $surnamePerson,
            'mail' => $mail,
            'password' => $password,
            'phone' => $phonePerson,
            'function' => $functionPerson,
            'Company_id' => $lastIdInsert,
        ];
        $representativeCompanyModel->insert($dataPerson);
        $this->session->remove('company');
        $this->session->remove('passwdPerson');
        return redirect()->to(base_url('/login'));
    }
    public function changePassCompany(){

    }
    public function loginOAUH(){
        //Získaní url a přesměrovaní na stránku microsoft
        $authUrl = $this->provider->getAuthorizationUrl();
        session()->set('oauth2state', $this->provider->getState());
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
        if (empty($state) || $state !== session()->get('oauth2state')) {
            session()->remove('oauth2state');
            throw new \Exception('Neplatný stav.');
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
        $userModel = new UserModel();

        $user = $userModel->where('mail', $email)->first();
        // Zjistím, zda stávající uživatel již není uveden v databázi, a když není, tak ho tam napíší.
        if (!$user) {
            $data = [
                'name' => $userData['givenName']??'',
                'surname' => $userData['surname']??'',
                'mail' => $email,
                'department' => $userData['department'] ?? '',
                'job_title' => $userData['jobTitle'] ?? '',
            ];
            $userModel->insert($data);
            $user = $userModel->where('mail', $email)->first();
        }

        // Potřebná data ukládám do session pro další práci s nimi
        session()->set('user', [
            'id' => $user['id'],
            'jmeno' => $user['name'],
            'prijmeni' => $user['surname'],
            'email' => $user['mail'],
            'class' => $user['Class_id'],
        ]);
        //Vracím na stránku /routu
        return redirect()->to(base_url('/home'));
    }
    //metoda pro odhlašovaní uživatelů přihlášených přes ms office.
    public function logOut(){
        session()->destroy();
        $logoutUrl = 'https://login.microsoftonline.com/common/oauth2/v2.0/logout';
        return redirect()->to($logoutUrl . '?post_logout_redirect_uri=' . urlencode(base_url('/login')));
    }
}