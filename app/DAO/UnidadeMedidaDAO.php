<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DAO;

use App\Entities\UnidadeMedida;
use Doctrine\ORM\NoResultException;


class UnidadeMedidaDAO extends GenericDAO{

    public function __construct() {
        parent::__construct();
        $this->className = UnidadeMedida::class;        
    }
    
    
    public function pesquisarPorCriterio($criterio, $valor) {
        try{
        $unidades = $this->em->getRepository($this->className)->createQueryBuilder('u')
                ->where('UPPER(u.'.$criterio .') LIKE UPPER(:'.$criterio.')')
                ->setParameter($criterio, $valor.'%')
                ->getQuery()
                ->getResult();
        return $unidades;
        } catch (NoResultException $ex) {
             return null;
        }
    }


   

}
