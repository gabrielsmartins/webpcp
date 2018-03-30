<?php


namespace App\DAO;

use App\Entities\Material;


class MaterialDAO extends GenericDAO {

    public function __construct() {
        parent::__construct();
        $this->className = Material::class;
    }
    
    
   
}
