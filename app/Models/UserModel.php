<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'surname', 'date_birthday', 'job_title', 'department','mail','phone','role','admin','spravce','description','img','create_time','edit_time','Class_id'];
    protected $useTimestamps = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time';  
    protected $dateFormat = 'datetime';    
}