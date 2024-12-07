<?php

namespace App\Models;

use CodeIgniter\Model;

class DatePractise extends Model{
    protected $table = 'date_practise';
    protected $primaryKey = 'id';
    protected $allowedFields = ['date_from','date_to','create_time','edit_time','Practise_id'];
    protected $useTimestamps = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $dateFormat = 'datetime';
}