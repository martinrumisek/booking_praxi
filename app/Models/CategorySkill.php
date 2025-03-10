<?php

namespace App\Models;

use CodeIgniter\Model;

class CategorySkill extends Model{
    protected $table = 'Category_skill';
    protected $primaryKey = 'category_id';
    protected $allowedFields = ['category_name','category_description','category_create_time','category_edit_time','category_del_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'category_create_time'; 
    protected $updatedField = 'category_edit_time'; 
    protected $deletedField = 'category_del_time';
    protected $dateFormat = 'datetime';
}