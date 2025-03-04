<?php

namespace App\Controllers;
require 'vendor/autoload.php';

use mikehaertl\pdftk\Pdf;
use App\Models\OfferPractise;
use App\Models\PractiseManager;
use App\Models\UserModel;
use App\Models\CompanyModel;
use App\Models\RepresentativeCompanyModel;
use App\Models\DatePractise;
use App\Models\ClassModel;
use App\Models\FieldStudy;
use App\Models\User_OfferPractise;
use App\Models\Practise;

class Export extends BaseController
{
    var $session;
    var $userModel;
    var $datePractiseModel;
    var $classModel;
    var $fieldStudy;
    var $companyModel;
    var $representativeCompanyModel;
    var $user_practiseModel;
    var $offerPractise;
    var $userSession;
    var $practiseManagerModel;
    var $practiseModel;
    public function __construct(){
        $this->session = session();
        $this->userSession = $this->session->get('user');
        $this->userModel = new UserModel();
        $this->datePractiseModel = new DatePractise();
        $this->classModel = new ClassModel();
        $this->fieldStudy = new FieldStudy();
        $this->companyModel = new CompanyModel();
        $this->representativeCompanyModel = new RepresentativeCompanyModel();
        $this->user_practiseModel = new User_OfferPractise();
        $this->practiseManagerModel = new PractiseManager();
        $this->offerPractise = new OfferPractise();
        $this->practiseModel = new Practise();
    }
    private function backUrl($url){
        $previousUrl = $this->request->getServer('HTTP_REFERER');
            if ($previousUrl) {
                return redirect()->to($previousUrl);
            } else {
                return redirect()->to($url);
            }
    }
    public function contractFileUser(){
        $userId = $this->userSession['id'];
        if(empty($userId)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, vyzkoušejte akci zopakovat.');
            return $this->backUrl('home-student');
        }
        $user = $this->userModel->where('user_id', $userId)->join('Class', 'User.Class_class_id = Class.class_id AND Class.class_del_time IS NULL', 'left')->join('Field_study', 'Class.Field_study_field_id = Field_study.field_id AND Field_study.field_del_time IS NULL', 'left')->first();
        $userName = $user['user_name'] . ' ' . $user['user_surname'];
        $userClass = $user['class_class'] . '.' . $user['class_letter_class'];
        $userField = $user['field_name'];
        $offer = $this->user_practiseModel->where('User_user_id', $userId)->where('user_offer_accepted', 1)->join('Offer_practise', 'User_has_Offer_practise.Offer_practise_offer_id = Offer_practise.offer_id AND Offer_practise.offer_del_time IS NULL', 'left')
        ->join('Practise_manager', 'Offer_practise.Practise_manager_manager_id = Practise_manager.manager_id AND Practise_manager.manager_del_time IS NULL', 'left')
        ->join('Company', 'Practise_manager.Company_company_id = Company.company_id AND Company.company_del_time IS NULL', 'left')
        ->join('Practise', 'Offer_practise.Practise_practise_id = Practise.practise_id AND Practise.practise_del_time IS NULL', 'left')
        ->first();
        if(empty($offer)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, vyzkoušejte akci zopakovat.');
            return $this->backUrl('home-student');
        }
        $dates = $this->datePractiseModel->where('Practise_practise_id', $offer['practise_id'])->find();
        if(empty($dates)){
            $this->session->setFlashdata('err_message', 'Nastala nečekaná chyba, vyzkoušejte akci zopakovat.');
            return $this->backUrl('home-student');
        }
        $practiseDates = [];

        foreach ($dates as $date) {
            $from = date('d.m.Y', strtotime($date['date_date_from']));
            $to = date('d.m.Y', strtotime($date['date_date_to']));
            $practiseDates[] = $from . ' - ' . $to;
        }
        $datePractise = implode(' / ', $practiseDates);
        $legalForm = '';
        if($offer['company_subject'] == 1){
            $legalForm = 'Fyzická osoba';
        }
        if($offer['company_subject'] == 2){
            $legalForm = 'Pravnická osoba';
        }
        $companyAdress = $offer['company_post_code'] . '  ' . $offer['company_city'] . ', ' . $offer['company_street'];
        $offerAdress = $offer['offer_post_code'] . '  ' . $offer['offer_city'] . ', ' . $offer['offer_street'];
        $managerDegreeBefore = '';
        if(!empty($offer['manager_degree_before'])){
            $managerDegreeBefore = $offer['manager_degree_before']; 
        }
        $managerDegreeAfter = '';
        if(!empty($offer['manager_degree_after'])){
            $managerDegreeAfter = $offer['manager_degree_after']; 
        }
        $managerName = $managerDegreeBefore . ' ' . $offer['manager_name'] . ' ' . $offer['manager_surname'] . ' ' . $managerDegreeAfter;
        $representativeCompany = $this->representativeCompanyModel->where('Company_company_id', $offer['company_id'])->first();
        if(!empty($representativeCompany)){
           $representativeDegreeBefore = '';
           if(!empty($representativeCompany['representative_degree_before'])){
                $representativeDegreeBefore = $representativeCompany['representative_degree_before'];
           }
           $representativeDegreeAfter = '';
           if(!empty($representativeCompany['representative_degree_after'])){
                $representativeDegreeAfter = $representativeCompany['representative_after_before'];
           }
           $representativeName = $representativeDegreeBefore . ' ' . $representativeCompany['representative_name'] . ' ' . $representativeCompany['representative_surname'] . ' ' . $representativeDegreeAfter;
        }else{
            $representativeName = $managerName;
        }
        $data = [
            'legal_form' => $legalForm,
            'name_company' => $offer['company_name'],
            'adress_company' => $companyAdress,
            'ico_company' => $offer['company_ico'],
            'representative_company' => $representativeName,
            'name_student' => $userName,
            'class_student' => $userClass,
            'field_study' => $userField,
            'adress_practise' => $offerAdress,
            'adress_practise_concrete' => $offerAdress,
            'date_practise' => $datePractise,
            'name_manager' => $managerName,
            'contact_manager' => $offer['manager_phone'] . ', ' . $offer['manager_mail'],
            'offer_name' => $offer['offer_name'],
        ];
        $pdfPath = FCPATH . 'assets/document/'. $offer['practise_contract_file'] .''; //!Provést změnu na smlouvu, která jsem patří
        $pdf = new Pdf($pdfPath);
        $pdf->fillForm($data, 'UTF-8', true, 'xfdf')->needAppearances();
        $file = $pdf->toString();
        return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Disposition', 'attachment; filename=' . $userName . ' - ' . $userClass.'.pdf'.'')
        ->setBody($file);
    }
    public function userInPractisePdf(){

    }
    public function userInPractiseExcel(){

    }
    public function logCompanyUserExcel(){

    }
    public function logUserExcel(){

    }
    
}
