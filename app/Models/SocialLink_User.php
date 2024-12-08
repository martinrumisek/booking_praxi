<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialLink_User extends Model{
    protected $table = 'social_link_has_user';
    protected $primaryKey = ['Social_link_id','User_id'];
    protected $useAutoIncrement = false;
    protected $allowedFields = ['Social_link_id','User_id','url','create_time','edit_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time';  
    protected $deletedField = 'del_time';
    protected $dateFormat = 'datetime';
}