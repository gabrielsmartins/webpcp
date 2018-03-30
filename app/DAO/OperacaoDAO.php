<?php



namespace App\DAO;

use App\Entities\Operacao;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;


class OperacaoDAO extends GenericDAO{
    
    public function __construct() {
        parent::__construct();
        $this->className = Operacao::class;
    }
    
    
    public function pesquisarPorCriterio($criterio, $valor,int $limit = 10, int $page = 1) : LengthAwarePaginator {
  
        if ($criterio != 'setor') {
            return parent::pesquisarPorCriterio($criterio, $valor, $limit, $page);
        }

        try{

        
         $query = $this->em->getRepository($this->className)->createQueryBuilder('o')
                ->innerJoin('o.setor', 's')
                ->where('UPPER(s.descricao) LIKE UPPER(:descricao)')
                ->setParameter('descricao',$valor.'%')
                ->getQuery();


   
         return $this->paginate($query, $limit, $page);
        
        
        } catch (QueryException $ex) {
             return $ex->getMessage() . $ex->getTrace();
        }
        
        
    }
   
}
