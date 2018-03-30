<?php



namespace App\DAO;

use App\Entities\Recurso;
use Illuminate\Pagination\LengthAwarePaginator;


class RecursoDAO extends GenericDAO{
    
    public function __construct() {
        parent::__construct();
        $this->className = Recurso::class;
    }
    
    
    public function pesquisarPorCriterio($criterio, $valor,int $limit = 10, int $page = 1) : LengthAwarePaginator {
  
        if ($criterio != 'setor') {
            return parent::pesquisarPorCriterio($criterio, $valor, $limit, $page);
        }

        try{

        
         $query = $this->em->getRepository($this->className)->createQueryBuilder('r')
                ->innerJoin('r.setor', 's')
                ->where('UPPER(s.descricao) LIKE UPPER(:descricao)')
                ->setParameter('descricao',$valor.'%')
                ->getQuery();


   
         return $this->paginate($query, $limit, $page);
        
        
        } catch (QueryException $ex) {
             return $ex->getMessage() . $ex->getTrace();
        }
        
        
    }
    
   
   
}
