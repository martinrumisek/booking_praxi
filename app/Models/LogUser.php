<?php

namespace App\Models;

use CodeIgniter\Model;

class LogUser extends Model{
    protected $table = 'log_user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','ip_adrese','create_time','User_id'];
    protected $useTimestamps = true;
    protected $createdField = 'create_time'; 
    protected $dateFormat = 'datetime';
}