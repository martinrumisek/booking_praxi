<?php

namespace App\Models;

use CodeIgniter\Model;

class ResetPassword extends Model{
    protected $table = 'Reset_password';
    protected $primaryKey = 'reset_id';
    protected $allowedFields = ['reset_token','reset_expires_at','reset_create_time','reset_edit_time', 'reset_del_time','reset_use','Representative_company_representative_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'reset_create_time'; 
    protected $updatedField = 'reset_edit_time';
    protected $deletedField = 'reset_del_time';
    protected $dateFormat = 'datetime';
}