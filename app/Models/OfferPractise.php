<?php

namespace App\Models;

use CodeIgniter\Model;

class OfferPractise extends Model{
    protected $table = 'Offer_practise';
    protected $primaryKey = 'offer_id';
    protected $allowedFields = ['offer_name','offer_requirements','offer_description','offer_city','offer_street','offer_post_code','offer_copy_next_year','offer_create_time','offer_edit_time', 'offer_del_time','Practise_practise_id','Practise_manager_manager_id'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'offer_create_time'; 
    protected $updatedField = 'offer_edit_time'; 
    protected $deletedField = 'offer_del_time';
    protected $dateFormat = 'datetime';
}