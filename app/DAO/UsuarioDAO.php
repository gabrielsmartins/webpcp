<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DAO;

use App\Entities\Usuario;
use Doctrine\ORM\NoResultException;


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

}
