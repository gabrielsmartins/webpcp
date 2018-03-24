<?php


namespace App\DAO;

use App\Entities\Material;


class MaterialDAO extends GenericDAO {

    public function __construct() {
        parent::__construct();
        $this->className = Material::class;
    }
    
    
    public function pesquisarPorCriterio($criterio, $valor) {
        try{
        $materiais = $this->em->getRepository($this->className)->createQueryBuilder('u')
                ->where('UPPER(u.'.$criterio .') LIKE UPPER(:'.$criterio.')')
                ->setParameter($criterio, $valor.'%')
                ->getQuery()
                ->getResult();
        return $materiais;
        } catch (NoResultException $ex) {
             return null;
        }
    }
}
