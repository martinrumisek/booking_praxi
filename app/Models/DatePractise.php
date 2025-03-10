<?php

namespace App\Models;

use CodeIgniter\Model;

class DatePractise extends Model{
    protected $table = 'Date_practise';
    protected $primaryKey = 'date_id';
    protected $allowedFields = ['date_date_from','date_date_to','date_create_time','date_edit_time', 'date_del_time','Practise_practise_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'date_create_time'; 
    protected $updatedField = 'date_edit_time'; 
    protected $deletedField = 'date_del_time';
    protected $dateFormat = 'datetime';
}