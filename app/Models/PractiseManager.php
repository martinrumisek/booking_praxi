<?php

namespace App\Models;

use CodeIgniter\Model;

class PractiseManager extends Model{
    protected $table = 'Practise_manager';
    protected $primaryKey = 'manager_id';
    protected $allowedFields = ['manager_degree_before','manager_name','manager_surname','manager_degree_after','manager_mail','manager_phone','manager_position_works','manager_create_time','manager_edit_time', 'manager_del_time','Company_company_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'manager_create_time'; 
    protected $updatedField = 'manager_edit_time'; 
    protected $deletedField = 'manager_del_time';
    protected $dateFormat = 'datetime';
}