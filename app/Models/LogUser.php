<?php

namespace App\Models;

use CodeIgniter\Model;

class LogUser extends Model{
    protected $table = 'log_user';
    protected $primaryKey = 'log_user_id';
    protected $allowedFields = ['log_user_name','log_user_ip_adrese','log_user_create_time','log_user_edit_time', 'log_user_del_time','User_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'log_user_create_time';
    protected $updatedField = 'log_user_edit_time';  
    protected $deletedField = 'log_user_del_time';
    protected $dateFormat = 'datetime';
}