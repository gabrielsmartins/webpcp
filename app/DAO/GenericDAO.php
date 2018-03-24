<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DAO;

use Illuminate\Support\Facades\App;



abstract class GenericDAO {
    
    protected $em;
    protected $className;
    
    public function __construct() {
        $this->em = App::make('Doctrine\ORM\EntityManagerInterface');
    }
    
    public function salvar($entity){
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
    
    public function alterar($entity){
        $this->em->merge($entity);
        $this->em->flush();
        return $entity;
    }
    
    public function remover($entity){
        $this->em->remove($entity);
        $this->em->flush();
    }
    
    public function listar(){
        $lista = $this->em->getRepository($this->className)->findAll();
        return $lista;
    }
    
    public function pesquisar($id) {
        $object = $this->em->getRepository($this->className)->find($id);
        return $object;
    }
    
}
