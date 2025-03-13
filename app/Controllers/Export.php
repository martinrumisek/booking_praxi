<?php

namespace App\Controllers;
require 'vendor/autoload.php';

use CodeIgniter\I18n\Time;
use mikehaertl\pdftk\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
use App\Models\LogCompany;
use App\Models\LogUser;

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
    var $logCompany;
    var $logUser;
    var $offerPractiseModel;
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
        $this->logCompany = new LogCompany();
        $this->logUser = new LogUser();
        $this->offerPractiseModel = new OfferPractise();
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
    public function userInPractiseExcel($idPractise){
        $offers = $this->offerPractiseModel->where('Practise_practise_id', $idPractise)
        ->join('Practise', 'Practise.practise_id = ' . $idPractise . ' AND Practise.practise_del_time IS NULL')
        ->join('Practise_manager', 'Offer_practise.Practise_manager_manager_id = Practise_manager.manager_id AND Practise_manager.manager_del_time IS NULL', 'left')
        ->join('Company', 'Practise_manager.Company_company_id = Company.company_id AND Company.company_del_time IS NULL', 'left')
        ->join('User_has_Offer_practise', 'User_has_Offer_practise.Offer_practise_offer_id = Offer_practise.offer_id AND User_has_Offer_practise.user_offer_accepted = 1 AND User_has_Offer_practise.user_offer_del_time IS NULL', 'left')
        ->join('User', 'User_has_Offer_practise.User_user_id = User.user_id AND User.user_del_time IS NULL', 'left')
        ->join('Class', 'User.Class_class_id = Class.class_id AND Class.class_del_time IS NULL', 'left')
        ->join('Field_study', 'Class.Field_study_field_id = Field_study.field_id AND Field_study.field_del_time IS NULL', 'left')->find();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Název praxe');
        $sheet->setCellValue('B1', 'Vedoucí praxe');
        $sheet->setCellValue('C1', 'Tel. číslo na vedoucího');
        $sheet->setCellValue('D1', 'E-mail na vedoucího');
        $sheet->setCellValue('E1', 'Název firmy');
        $sheet->setCellValue('F1', 'Přijatý žák');
        $sheet->setCellValue('G1', 'Poslední úprava');
        $row = 2;
        foreach($offers as $offer){
            $degreeBefore = '';
            $degreeAfter = '';
            if(!empty($offer['manager_degree_before'])){
                $degreeBefore = $offer['manager_degree_before'] . ' ';
            }
            if(!empty($offer['manager_degree_after'])){
                $degreeAfter = ' ' . $offer['manager_degree_after'];
            }
            $name = $degreeBefore . $offer['manager_name'] . ' ' . $offer['manager_surname'] . $degreeAfter;
            $practiseName = $offer['practise_name'];
            $sheet->setCellValue('A' . $row, $offer['offer_name']);
            $sheet->setCellValue('B' . $row, $name);
            $sheet->setCellValue('C' . $row, $offer['manager_phone']);
            $sheet->setCellValue('D' . $row, $offer['manager_mail']);
            $sheet->setCellValue('E' . $row, $offer['company_name'] . ' (' . $offer['company_ico'] . ')');
            $sheet->setCellValue('F' . $row, $offer['user_name'] . ' ' . $offer['user_surname'] . ' (' . $offer['class_class'] . '.' . $offer['class_letter_class'] . ', ' . $offer['field_shortcut'] );
            $sheet->setCellValue('G' . $row, date('d.m.Y H:i:s', strtotime($offer['offer_edit_time'])));
            $row++;
        }
        $nowTime = Time::now();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$practiseName . '-' . $nowTime .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    public function allUserExcel(){
        $users = $this->userModel->join('Class', 'User.Class_class_id = Class.class_id AND Class.class_del_time IS NULL', 'left')->join('Field_study', 'Class.Field_study_field_id = Field_study.field_id AND Field_study.field_del_time IS NULL', 'left')->join('Type_school', 'Field_study.Type_school_type_id = Type_school.type_id AND Type_school.type_del_time IS NULL', 'left')->find();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Jméno a příjmení');
        $sheet->setCellValue('B1', 'E-mail');
        $sheet->setCellValue('C1', 'Třída');
        $sheet->setCellValue('D1', 'Obor');
        $sheet->setCellValue('E1', 'Škola');
        $sheet->setCellValue('F1', 'Oddělení');
        $sheet->setCellValue('G1', 'Vytvořeno');
        $row = 2;
        foreach($users as $user){
            $sheet->setCellValue('A' . $row, $user['user_name'] . ' ' . $user['user_surname']);
            $sheet->setCellValue('B' . $row, $user['user_mail']);
            $sheet->setCellValue('C' . $row, $user['class_class'] . '.' . $user['class_letter_class']);
            $sheet->setCellValue('D' . $row, $user['field_name']);
            $sheet->setCellValue('E' . $row, $user['type_name']);
            $sheet->setCellValue('F' . $row, $user['user_department']);
            $sheet->setCellValue('G' . $row, date('d.m.Y H:i:s', strtotime($user['user_create_time'])));
            $row++;
        }
        $nowTime = Time::now();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="uzivatele'. $nowTime .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    public function allCompanyExcel(){
        $companyes = $this->companyModel->where('company_register_company', 1)->find();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Název firmy');
        $sheet->setCellValue('B1', 'IČO');
        $sheet->setCellValue('C1', 'Adresa');
        $sheet->setCellValue('D1', 'Vytvořena');
        $sheet->setCellValue('E1', 'Zástupce firmy');
        $sheet->setCellValue('F1', 'E-mail na zástupce');
        $sheet->setCellValue('G1', 'Tel. číslo na zástupce');
        $sheet->setCellValue('H1', 'Funkce zástupce');
        $row = 2;
        foreach($companyes as $company){
            $repreCompany = $this->representativeCompanyModel->where('Company_company_id', $company['company_id'])->first();
            $degreeBefore = '';
            $degreeAfter = '';
            if(!empty($repreCompany['representative_degree_before'])){
                $degreeBefore = $repreCompany['representative_degree_before'] . ' ';
            }
            if(!empty($repreCompany['representative_degree_after'])){
                $degreeAfter = ' ' . $repreCompany['representative_degree_after'];
            }
            $name = $degreeBefore . $repreCompany['representative_name'] . ' ' . $repreCompany['representative_surname'] . $degreeAfter;
            $sheet->setCellValue('A' . $row, $company['company_name']);
            $sheet->setCellValue('B' . $row, $company['company_ico']);
            $sheet->setCellValue('C' . $row, $company['company_post_code'] . '  ' . $company['company_city']. ', ' . $company['company_street']);
            $sheet->setCellValue('D' . $row, date('d.m.Y H:i:s', strtotime($company['company_create_time'])));
            $sheet->setCellValue('E' . $row, $name);
            $sheet->setCellValue('F' . $row, $repreCompany['representative_mail']);
            $sheet->setCellValue('G' . $row, $repreCompany['representative_phone']);
            $sheet->setCellValue('H' . $row, $repreCompany['representative_function']);
            $row++;
        }
        $nowTime = Time::now();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="firmy'. $nowTime .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    public function logCompanyUserExcel(){
        $logs = $this->logCompany->join('Representative_company', 'Log_company.Representative_company_representative_id = Representative_company.representative_id AND Representative_company.representative_del_time IS NULL')->find();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Akce');
        $sheet->setCellValue('B1', 'IP adresa');
        $sheet->setCellValue('C1', 'Čas/provedeno');
        $sheet->setCellValue('D1', 'Uživatel');
        $row = 2;
        foreach($logs as $log){
            $degreeBefore = '';
            $degreeAfter = '';
            if(!empty($log['representative_degree_before'])){
                $degreeBefore = $log['representative_degree_before'] . ' ';
            }
            if(!empty($log['representative_degree_after'])){
                $degreeAfter = ' ' . $log['representative_degree_after'];
            }
            $name = $degreeBefore . $log['representative_name'] . ' ' . $log['representative_surname'] . $degreeAfter;
            $sheet->setCellValue('A' . $row, $log['log_company_name']);
            $sheet->setCellValue('B' . $row, $log['log_company_ip_adrese']);
            $sheet->setCellValue('C' . $row, date('d.m.Y H:i:s', strtotime($log['log_company_create_time'])));
            $sheet->setCellValue('D' . $row, $name);
            $row++;
        }
        $nowTime = Time::now();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="log_firmy'. $nowTime .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    public function logUserExcel(){
        $logs = $this->logUser->join('User', 'Log_user.User_user_id = User.user_id AND User.user_del_time IS NULL')->find();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Akce');
        $sheet->setCellValue('B1', 'IP adresa');
        $sheet->setCellValue('C1', 'Čas/provedeno');
        $sheet->setCellValue('D1', 'Uživatel');
        $row = 2;
        foreach($logs as $log){
            $sheet->setCellValue('A' . $row, $log['log_user_name']);
            $sheet->setCellValue('B' . $row, $log['log_user_ip_adrese']);
            $sheet->setCellValue('C' . $row, date('d.m.Y H:i:s', strtotime($log['log_user_create_time'])));
            $sheet->setCellValue('D' . $row, $log['user_name'] . ' ' . $log['user_surname']);
            $row++;
        }
        $nowTime = Time::now();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="log_uzivatel'. $nowTime .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    
}
