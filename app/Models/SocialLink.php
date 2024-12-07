<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialLink extends Model{
    protected $table = 'social_link';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','icon','create_time','edit_time'];
    protected $useTimestamps = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $dateFormat = 'datetime';
}