<?php


namespace App\DAO;

use App\Entities\Produto;


class ProdutoDAO extends GenericDAO {

    public function __construct() {
        parent::__construct();
        $this->className = Produto::class;
    }
}
