<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Autoload;

class Skill_OfferPractise extends Model{
    protected $table = 'skill_has_offer_practise';
    protected $primaryKey = 'skill_offer_id';
    protected $allowedFields = ['Skill_skill_id','Offer_practise_offer_id','skill_offer_create_time','skill_offer_edit_time', 'skill_offer_del_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'skill_offer_create_time'; 
    protected $updatedField = 'skill_offer_edit_time'; 
    protected $deletedField = 'skill_offer_del_time';
    protected $dateFormat = 'datetime';
}