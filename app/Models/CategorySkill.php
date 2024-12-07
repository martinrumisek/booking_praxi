<?php

namespace App\Models;

use CodeIgniter\Model;

class CategorySkill extends Model{
    protected $table = 'category_skill';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','description','create_time','edit_time'];
    protected $useTimestamps = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $dateFormat = 'datetime';
}