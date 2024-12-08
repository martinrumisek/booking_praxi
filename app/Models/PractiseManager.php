<?php

namespace App\Models;

use CodeIgniter\Model;

class PractiseManager extends Model{
    protected $table = 'practise_manager';
    protected $primaryKey = 'id';
    protected $allowedFields = ['degree_before','name','surname','degree_after','mail','phone','position_works','create_time','edit_time','Company_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $deletedField = 'del_time';
    protected $dateFormat = 'datetime';
}