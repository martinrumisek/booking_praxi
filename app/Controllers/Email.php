<?php

namespace App\Controllers;

class Email extends BaseController
{
    public function __construct(){
        
    }
    public function sentEmail($mail, $messageHtml, $subjectEmail){
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
