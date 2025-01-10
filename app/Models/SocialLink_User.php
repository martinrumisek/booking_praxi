<?php

namespace App\Models;

use CodeIgniter\Model;

class SocialLink_User extends Model{
    protected $table = 'social_link_has_user';
    protected $primaryKey = 'social_user_id';
    protected $allowedFields = ['Social_link_social_id','User_user_id','social_user_url','social_user_create_time','social_user_edit_time', 'social_user_del_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'social_user_create_time'; 
    protected $updatedField = 'social_user_edit_time';  
    protected $deletedField = 'social_user_del_time';
    protected $dateFormat = 'datetime';
}