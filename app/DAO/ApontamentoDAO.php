<?php



namespace App\DAO;

use App\Entities\Apontamento;


class ApontamentoDAO extends GenericDAO {
    
    public function __construct() {
        parent::__construct();
        $this->className = Apontamento::class;
    }
}
