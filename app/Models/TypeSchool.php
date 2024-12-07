<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeSchool extends Model{
    protected $table = 'type_school';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','shortcut','description','create_time','edit_time'];
    protected $useTimestamps = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $dateFormat = 'datetime';
}