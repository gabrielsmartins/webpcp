<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DAO;

use App\Entities\Usuario;
use Doctrine\ORM\NoResultException;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;


class UsuarioDAO extends GenericDAO {

    public function __construct() {
        parent::__construct();
        $this->className = Usuario::class;
    }
    
    
    public function autenticarUsuario($login, $senha) {
        try {
            $query = $this->em->createQuery('SELECT u FROM ' . $this->className  .' u WHERE u.login = ?1 AND u.senha=?2');
            $query->setParameter(1, $login);
            $query->setParameter(2, $senha);
            $usuario = $query->getSingleResult();
            
            return $usuario;
        } catch (NoResultException $ex) {
             return null;
        }
    }
    
    public function pesquisarPorCriterio($criterio, $valor,int $limit = 10, int $page = 1) : LengthAwarePaginator {
  
        if ($criterio != 'perfil') {
            return parent::pesquisarPorCriterio($criterio, $valor, $limit, $page);
        }

        try{
         $query = $this->em->getRepository($this->className)->createQueryBuilder('u')
                ->innerJoin('u.perfil', 'p')
                ->where('UPPER(p.descricao) LIKE UPPER(:descricao)')
                ->setParameter('descricao',$valor.'%')
                ->getQuery();

         return $this->paginate($query, $limit, $page);

        } catch (QueryException $ex) {
             return $ex->getMessage() . $ex->getTrace();
        }

    }
    
    

    
    
}




