<?php



namespace App\DAO;

use App\Entities\Recurso;


class RecursoDAO extends GenericDAO{
    
    public function __construct() {
        parent::__construct();
        $this->className = Recurso::class;
    }
    
    
    public function pesquisarPorCriterio($criterio, $valor) {
        try{
        $recursos = $this->em->getRepository($this->className)->createQueryBuilder('u')
                ->where('UPPER(u.'.$criterio .') LIKE UPPER(:'.$criterio.')')
                ->setParameter($criterio, $valor.'%')
                ->getQuery()
                ->getResult();
        return $recursos;
        } catch (NoResultException $ex) {
             return null;
        }
    }
   
}
