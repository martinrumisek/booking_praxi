<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use League\OAuth2\Client\Provider\GenericProvider;
use App\Models\UserModel;

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
            'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',
        ]);
    }

    public function loginCompany(){

    }
    public function registerCompany(){

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

        $user = $userModel->where('email', $email)->first();
        // Zjistím, zda stávající uživatel již není uveden v databázi, a když není, tak ho tam napíší.
        if (!$user) {
            $data = [
                'jmeno' => $userData['givenName']??'',
                'prijmeni' => $userData['surname']??'',
                'email' => $email,
                'oddeleni' => $userData['department'] ?? '',
                'pozice' => $userData['jobTitle'] ?? '',
            ];
            $userModel->insert($data);
            $user = $userModel->where('email', $email)->first();
        }

        // Potřebná data ukládám do session pro další práci s nimi
        session()->set('user', [
            'id' => $user['id'],
            'jmeno' => $user['jmeno'],
            'prijmeni' => $user['prijmeni'],
            'email' => $user['email']
        ]);
        //Vracím na stránku /routu
        return redirect()->to(base_url('/home'));
    }
    public function logOut(){
        
    }
}