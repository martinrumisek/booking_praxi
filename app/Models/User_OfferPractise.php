<?php

namespace App\Models;

use CodeIgniter\Model;

class User_OfferPractise extends Model{
    protected $table = 'User_has_offer_Practise';
    protected $primaryKey = 'user_offer_id';
    protected $allowedFields = ['User_user_id','Offer_practise_offer_id','user_offer_accepted','user_offer_like','user_offer_select','user_offer_create_time','user_offer_edit_time', 'user_offer_del_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'user_offer_create_time'; 
    protected $updatedField = 'user_offer_edit_time'; 
    protected $deletedField = 'user_offer_del_time';
    protected $dateFormat = 'datetime';
}