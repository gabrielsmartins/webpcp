<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of RetiradaProduto
 *
 * @author HOME-PC
 */
class RetiradaProduto {
    
    private $id;
    private $data;
    private $responsavel;
    private $itens;

    
    public function __construct($responsavel) {
        $this->responsavel = $responsavel;
        $this->data = new DateTime('now');
        $this->itens = new ArrayCollection();
    }
    
    function getId() {
        return $this->id;
    }

    function getData() {
        return $this->data;
    }

    function getResponsavel() {
        return $this->responsavel;
    }


    function setId($id) {
        $this->id = $id;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function getItens() {
        return $this->itens;
    }

    function setItens($itens) {
        $this->itens = $itens;
    }


    function adicionarItem(ItemRetirada $item){
        $this->itens->add($item);
    }
    
    function removerItem(ItemRetirada $item){
       if ($this->itens->contains($item)){
           $this->itens->remove($item);
        }
    }

}
