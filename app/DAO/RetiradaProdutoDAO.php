<?php


namespace App\DAO;

use App\Entities\RetiradaProduto;


class RetiradaProdutoDAO extends GenericDAO {
    
    public function __construct() {
        parent::__construct();
         $this->className = RetiradaProduto::class;
    }
    
    

}
