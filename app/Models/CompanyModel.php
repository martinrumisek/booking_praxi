<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'company';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'ico', 'subject', 'legal_form', 'decription','city','agree_document','street','post_code','create_time','edit_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time';  
    protected $deletedField = 'del_time';
    protected $dateFormat = 'datetime';    
}