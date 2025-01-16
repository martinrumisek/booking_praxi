<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialLink_User extends Model{
    protected $table = 'social_link_has_user';
    protected $primaryKey = 'user_social_id';
    protected $allowedFields = ['Social_link_social_id','User_user_id','user_social_url','user_social_create_time','user_social_edit_time', 'user_social_del_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'user_social_create_time'; 
    protected $updatedField = 'user_social_edit_time';  
    protected $deletedField = 'user_social_del_time';
    protected $dateFormat = 'datetime';
}