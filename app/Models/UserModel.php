<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'User';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['user_name', 'user_surname', 'user_date_birthday', 'user_job_title', 'user_department','user_mail','user_phone','user_role','user_admin','user_spravce','user_description','user_img','user_create_time','user_edit_time', 'user_del_time','Class_class_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'user_create_time'; 
    protected $updatedField = 'user_edit_time';  
    protected $deletedField = 'user_del_time';
    protected $dateFormat = 'datetime';    
}