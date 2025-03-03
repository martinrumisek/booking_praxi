<?php

namespace App\Controllers;
require 'vendor/autoload.php';

use mikehaertl\pdftk\Pdf;

class Export extends BaseController
{
    public function __construct(){
        
    }

    public function contractFileUser(){
        
        /*$data = [
            'legal_form' => 'Fyzická osoba',
            'name_company' => 'Obchodní akademie a vyšší odborná škola OAUH',
            'adress_company' => 'Uherské Hradištěs 887 99, Nádražní 22',
            'ico_company' => '975678998',
            'representative_company' => 'Marek Machalík',
            'name_student' => 'Martin Rumíšek',
            'class_student' => '4.B',
            'field_study' => 'Informační technologie',
            'adress_practise' => 'Veselí nad Moravou, U Kajetánka 2332, 756 87',
            'adress_practise_concrete' => 'Veselí nad Moravou, U Kajetánka 2332, 756 87',
            'date_practise' => '2.3.2024 - 2.4.2024 / 5.5.2024 - 5.6.2024',
            'name_manager' => 'Ing. Jakub Plachý',
            'contact_manager' => 'jakub.plachy@oauh.cz, +420233424234'
        ];*/
        $companyName = "Uherské Hradištěešeěeě, která je Obchní akad. Martin Rumíšek";
        $data = [
            'company_name' => $companyName,
        ];
        foreach ($data as $key => $value) {
            $data[$key] = mb_convert_encoding($value, 'UTF-8', 'auto');  // 'auto' zaručuje automatické zjištění vstupního kódování
        }
        $pdfPath = FCPATH . 'assets/document/zk.pdf';
        $pdf = new Pdf($pdfPath);
       // $pdf->replacementFont('Arial', '', 10);
        $pdf->fillForm($data, 'UTF-8', true, 'fdf')->flatten();
        $file = $pdf->toString();
        return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Disposition', 'attachment; filename="VyplnenyFormular.pdf"')
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
