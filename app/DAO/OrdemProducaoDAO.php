<?php



namespace App\DAO;

use App\Entities\OrdemProducao;


class OrdemProducaoDAO extends GenericDAO {
    
    public function __construct() {
        parent::__construct();
        $this->className = OrdemProducao::class;
    }
}
