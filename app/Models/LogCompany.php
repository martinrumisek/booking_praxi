<?php

namespace App\Models;

use CodeIgniter\Model;

class LogCompany extends Model{
    protected $table = 'Log_company';
    protected $primaryKey = 'log_company_id';
    protected $allowedFields = ['log_company_name','log_company_ip_adrese','log_company_create_time','log_company_edit_time', 'log_company_del_time','Representative_company_representative_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'log_company_create_time'; 
    protected $updatedField = 'log_company_edit_time'; 
    protected $deletedField = 'log_company_del_time';
    protected $dateFormat = 'datetime';
}