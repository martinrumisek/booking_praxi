<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\ClassModel;

class UserAzureSync extends Controller
{
    protected $provider;

    public function getAllUsers()
    {
        $accessToken = $this->getAccessToken();
        $usersData = $this->getUsers($accessToken);
        $this->saveUsers($usersData);
        $this->userToCLass();
        return redirect()->to(base_url('/dashboard-people'));
    }
    public function upUsersClass(){
        $this->updateClassYearGraduationPlus();
        $this->userToClass();
        return redirect()->to(base_url('/dashboard-class'));
    }
    public function downUsersClass(){
        $this->updateClassYearGraduationMinus();
        $this->userToClass();
        return redirect()->to(base_url('/dashboard-class'));
    }
    public function newSchoolYear(){
        $accessToken = $this->getAccessToken();
        $usersData = $this->getUsers($accessToken);
        $this->saveUsers($usersData);
        $this->updateClassYearGraduationPlus();
        $this->userToCLass();
    }
    // Získní přístupové tokenu, tak abych mohl pracovat s daty uživatelů
    private function getAccessToken()
    {
        $tenantId = env('TENANT_ID');
        $clientId = env('CLIENT_ID');
        $clientSecret = env('CLIENT_SECRET');
        $scopes = 'https://graph.microsoft.com/.default';
        $tokenUrl = "https://login.microsoftonline.com/$tenantId/oauth2/v2.0/token";

        // Inicializace cURL (reprezentuje http požadavek)
        $http = curl_init();
        curl_setopt($http, CURLOPT_URL, $tokenUrl); //nastavuje cílovou url adresu, kam bude požadavek odeslán
        curl_setopt($http, CURLOPT_RETURNTRANSFER, true); // Zajistí, aby odpověděť byla v návratové hodnotě, jinak by se mohla vypsat na obrazovku
        curl_setopt($http, CURLOPT_POST, true); //nastavuje požadavek http na post
        //data - součást požadavku
        curl_setopt($http, CURLOPT_POSTFIELDS, [ 
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'scope' => $scopes,
            'grant_type' => 'client_credentials'
        ]);

        // Provedení požadavku
        $response = curl_exec($http);
        if (curl_errno($http)) {
            throw new \Exception('cURL Error: ' . curl_error($http));
        }
        curl_close($http);
        $responseData = json_decode($response, true);
        return $responseData['access_token'];
    }

    // Funkce pro načtení uživatelů z Microsoft Graph API
    private function getUsers($accessToken)
    {
        //chci načíst uživatele + určité paramentry
        $usersUrl = 'https://graph.microsoft.com/v1.0/users?$select=displayName,givenName,surname,jobTitle,department,mail,userPrincipalName';
        $usersData = [];
        
        // Načítání uživatelů po stránkách, protože max. počet načtených uživatelů je 100
        do {
            // Inicializace cURL
            $http = curl_init();

            // Nastavení parametrů požadavku
            curl_setopt($http, CURLOPT_URL, $usersUrl);
            curl_setopt($http, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($http, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $accessToken
            ]);

            // Provedení požadavku
            $response = curl_exec($http);
            if (curl_errno($http)) {
                throw new \Exception('cURL Error: ' . curl_error($http));
            }
            curl_close($http);

            // Zpracování odpovědi
            $responseData = json_decode($response, true);
            $usersData = array_merge($usersData, $responseData['value']);  // Přidání uživatelů na aktuální stránce
            
            // Pokud existuje další stránka, nastaví URL pro další požadavek
            $usersUrl = $responseData['@odata.nextLink'] ?? null;
            
        } while ($usersUrl);  // Pokračuj, dokud jsou další stránky

        return $usersData;
    }

    // Funkce pro uložení uživatelů do databáze
    private function saveUsers($usersData)
    {
        $userModel = new UserModel();

        foreach ($usersData as $user) {
            $mail = $user['mail'] ?? $user['userPrincipalName'];
            $name = $user['givenName'] ?? '';
            $surname = $user['surname'] ?? '';
            $jobTitle = $user['jobTitle'] ?? '';
            $department = $user['department'] ?? 'neurčeno';
            if (empty($name) || empty($surname) || empty($jobTitle)) {
                // Pokud některý z požadovaných údajů chybí, tento uživatel se přeskočí
                continue;
            }
            if (strpos($department, '-') === false) {
                $role = 'teacher';  
            }else{
                //[$yearGraduation, $classLetter] = explode('-', $department, 2);
                $role = 'student';
            }
            // Uložení do databáze
            $dataUser = [
                'user_mail' => $mail,
                'user_name' => $name,
                'user_surname' => $surname,
                'user_job_title' => $jobTitle,
                'user_department' => $department,
                'user_role' => $role,
            ];
            $userExist = $userModel->where('user_mail', $mail)->first();
            if ($userExist) {
                $userModel->update($userExist['user_id'], $dataUser);
            } else {
                $userModel->insert($dataUser);
            }
        }
    }
    private function userToCLass(){
        $userModel = new UserModel();
        $classModel = new ClassModel();
        $users = $userModel->where('user_role', 'student')->findAll();
        foreach( $users as $user ){
            $department = $user['user_department'];

            if(strpos($department, '-') !== false){
                [$yearGraduation, $letterClass] = explode('-', $department, 2);
                $yearGraduation = intval($yearGraduation);
                $letterClass = strtoupper(trim($letterClass));
                $class = $classModel->where('class_year_graduation', $yearGraduation)->where('class_letter_class', $letterClass)->first();
                if($class){
                    $userModel->update($user['user_id'], ['Class_class_id' => $class['class_id']]);
                }else{
                    $userModel->delete($user['user_id']);
                }
            }
        }
    }
    private function updateClassYearGraduationPlus(){
        $classModel = new ClassModel();
        $classModel->db->table('class')->set('class_year_graduation', 'class_year_graduation + 1', false)->update();
    }
    private function updateClassYearGraduationMinus(){
        $classModel = new ClassModel();
        $classModel->db->table('class')->set('class_year_graduation', 'class_year_graduation - 1', false)->update();
    }
}