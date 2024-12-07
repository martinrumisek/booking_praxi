<?php

namespace App\Models;

use CodeIgniter\Model;

class OfferPractise extends Model{
    protected $table = 'offer_practise';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','requirements','description','city','street','post_code','copy_next_year','create_time','edit_time','Practise_id','Practise_manager_id'];
    protected $useTimestamps = true;
    protected $createdField = 'create_time'; 
    protected $updatedField = 'edit_time'; 
    protected $dateFormat = 'datetime';
}