<?php

namespace App\Models;

use CodeIgniter\Model;

class ResetPassword extends Model{
    protected $table = 'reset_password';
    protected $primaryKey = 'id';
    protected $allowedFields = ['token','expires_at','create_time','edit_time','use','Representative_company_id'];
    protected $useTimestamps = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $dateFormat = 'datetime';
}