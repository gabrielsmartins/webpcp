<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DAO;

use App\Entities\UnidadeMedida;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;


class UnidadeMedidaDAO extends GenericDAO{
    
   use PaginatesFromParams;

    public function __construct() {
        parent::__construct();
        $this->className = UnidadeMedida::class;        
    }
    
    
    public function listarComPaginacao() : LengthAwarePaginator{
        try{

        
         $query = $this->em->getRepository($this->className)->createQueryBuilder('u')
                ->getQuery();
        
        
        
         return $this->paginate($query, 20, 1);
        
        
        } catch (QueryException $ex) {
             return $ex->getMessage() . $ex->getTrace();
        }
    }

    
    
    public function pesquisarPorCriterio($criterio, $valor,int $limit = 10, int $page = 1) : LengthAwarePaginator {
        try{

        
        $query = $this->em->getRepository($this->className)->createQueryBuilder('u')
                ->where('UPPER(u.'.$criterio.') LIKE UPPER(:'.$criterio.')')
               ->orderBy('u.descricao', 'asc')
                ->setParameter($criterio, $valor.'%')
                ->getQuery();
        
         return $this->paginate($query, $limit, $page);
        
        
        } catch (QueryException $ex) {
             return $ex->getMessage() . $ex->getTrace();
        }
    }
    
    
    

    

}
