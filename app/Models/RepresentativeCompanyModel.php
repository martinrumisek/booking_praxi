<?php

namespace App\Models;

use CodeIgniter\Model;

class RepresentativeCompanyModel extends Model
{
    protected $table = 'representative_company';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'surname', 'mail', 'password', 'phone','function','create_time','edit_time', 'Company_id'];
    protected $useTimestamps = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time';  
    protected $dateFormat = 'datetime';    
}