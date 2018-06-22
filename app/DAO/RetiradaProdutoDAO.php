<?php


namespace App\DAO;

use App\Entities\RetiradaProduto;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;


class RetiradaProdutoDAO extends GenericDAO {
    
    public function __construct() {
        parent::__construct();
         $this->className = RetiradaProduto::class;
    }
    
    
  
    

}
