<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'company';
    protected $primaryKey = 'company_id';
    protected $allowedFields = ['company_name', 'company_ico', 'company_subject', 'company_legal_form', 'company_description','company_city','company_agree_document','company_street','company_post_code', 'company_register_company','company_create_time','company_edit_time', 'company_del_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'company_create_time'; 
    protected $updatedField = 'company_edit_time';  
    protected $deletedField = 'company_del_time';
    protected $dateFormat = 'datetime';    
}