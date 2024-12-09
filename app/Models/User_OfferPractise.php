<?php

namespace App\Models;

use CodeIgniter\Model;

class User_OfferPractise extends Model{
    protected $table = 'user_has_offer_practise';
    protected $primaryKey = 'id';
    protected $allowedFields = ['User_id','Offer_practise_id','accepted','like','select','create_time','edit_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $deletedField = 'del_time';
    protected $dateFormat = 'datetime';
}