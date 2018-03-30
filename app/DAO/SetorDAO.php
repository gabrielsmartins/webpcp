<?php



namespace App\DAO;

use App\Entities\Setor;


class SetorDAO extends GenericDAO {
   
    public function __construct() {
        parent::__construct();
        $this->className = Setor::class;
    }
    
    
   
    
   
}
