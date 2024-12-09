<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Autoload;

class Skill_OfferPractise extends Model{
    protected $table = 'skill_has_offer_practise';
    protected $primaryKey = 'id';
    protected $allowedFields = ['Skill_id','Offer_practise','create_time','edit_time'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $deletedField = 'del_time';
    protected $dateFormat = 'datetime';
}