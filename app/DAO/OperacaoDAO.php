<?php



namespace App\DAO;

use App\Entities\Operacao;


class OperacaoDAO extends GenericDAO{
    
    public function __construct() {
        parent::__construct();
        $this->className = Operacao::class;
    }
   
}
