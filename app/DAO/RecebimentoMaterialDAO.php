<?php



namespace App\DAO;

use App\Entities\RecebimentoMaterial;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;


class RecebimentoMaterialDAO extends GenericDAO {
 
    public function __construct() {
        parent::__construct();
        $this->className = RecebimentoMaterial::class;
    }
    
    
    public function pesquisarPorCriterio($criterio, $valor,int $limit = 10, int $page = 1) : LengthAwarePaginator {
  
        if ($criterio != 'requisicao') {
            return parent::pesquisarPorCriterio($criterio, $valor, $limit, $page);
        }

        try{
         $query = $this->em->getRepository($this->className)->createQueryBuilder('rp')
                ->innerJoin('rp.itens', 'it')
                 ->innerJoin('it.itemRequisicao', 'itreq')
                 ->innerJoin('itreq.requisicao', 'req')
                ->where('req.id LIKE :requisicao')
                ->setParameter('requisicao',$valor.'%')
                ->getQuery();

         return $this->paginate($query, $limit, $page);

        } catch (QueryException $ex) {
             return $ex->getMessage() . $ex->getTrace();
        }

    }
}
