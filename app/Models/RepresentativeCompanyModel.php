<?php

namespace App\Models;

use CodeIgniter\Model;

class RepresentativeCompanyModel extends Model
{
    protected $table = 'Representative_company';
    protected $primaryKey = 'representative_id';
    protected $allowedFields = ['representative_degree_before','representative_name', 'representative_surname','representative_degree_after', 'representative_mail', 'representative_password', 'representative_phone','representative_function','representative_create_time','representative_edit_time', 'representative_del_time', 'Company_company_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'representative_create_time'; 
    protected $updatedField = 'representative_edit_time';  
    protected $deletedField = 'representative_del_time';
    protected $dateFormat = 'datetime';    
}