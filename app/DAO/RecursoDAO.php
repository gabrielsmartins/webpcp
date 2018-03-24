<?php



namespace App\DAO;

use App\Entities\Recurso;


class RecursoDAO extends GenericDAO{
    
    public function __construct() {
        parent::__construct();
        $this->className = Recurso::class;
    }
   
}
