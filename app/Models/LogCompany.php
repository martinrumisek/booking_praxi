<?php

namespace App\Models;

use CodeIgniter\Model;

class LogCompany extends Model{
    protected $table = 'log_company';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','ip_adrese','create_time','Representative_company_id'];
    protected $useTimestamps = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $dateFormat = 'datetime';
}