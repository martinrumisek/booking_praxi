<?php

namespace App\Models;

use CodeIgniter\Model;

class Practise extends Model{
    protected $table = 'Practise';
    protected $primaryKey = 'practise_id';
    protected $allowedFields = ['practise_name','practise_description','practise_contract_file','practise_start_new_offer','practise_end_new_offer','practise_create_time','practise_edit_time', 'practise_del_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'practise_create_time'; 
    protected $updatedField = 'practise_edit_time'; 
    protected $deletedField = 'practise_del_time';
    protected $dateFormat = 'datetime';
}