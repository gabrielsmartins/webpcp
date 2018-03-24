<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DAO;

use App\Entities\Setor;
use Doctrine\ORM\NoResultException;


class SetorDAO extends GenericDAO {
   
    public function __construct() {
        parent::__construct();
        $this->className = Setor::class;
    }
    
    public function pesquisarPorCriterio($criterio, $valor) {
        try{
        $setores = $this->em->getRepository($this->className)->createQueryBuilder('u')
                ->where('UPPER(u.'.$criterio .') LIKE UPPER(:'.$criterio.')')
                ->setParameter($criterio, $valor.'%')
                ->getQuery()
                ->getResult();
        return $setores;
        } catch (NoResultException $ex) {
             return null;
        }
    }
}
