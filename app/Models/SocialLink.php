<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialLink extends Model{
    protected $table = 'social_link';
    protected $primaryKey = 'social_id';
    protected $allowedFields = ['social_name','social_icon','social_create_time','social_edit_time', 'social_del_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'social_create_time'; 
    protected $updatedField = 'social_edit_time'; 
    protected $deletedField = 'social_del_time';
    protected $dateFormat = 'datetime';
}