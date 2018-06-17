<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Produto extends Componente {

    /**
     * @ORM\OneToMany(targetEntity="ItemEstrutura", mappedBy="produto",cascade={"all"})
     */
    private $itens;

    /**
     * @ORM\OneToMany(targetEntity="Roteiro", mappedBy="produto",cascade={"all"})
     * @ORM\OrderBy({"sequencia" = "ASC"})
     */
    private $roteiros;

    public function __construct($descricao, $unidadeMedida, $valorUnitario, $leadTime, $quantidadeEstoque, $quantidadeMinima) {
        parent::__construct($descricao, $unidadeMedida, $valorUnitario, $leadTime, $quantidadeEstoque, $quantidadeMinima);
        $this->itens = new ArrayCollection();
        $this->roteiros = new ArrayCollection();
    }

    public function adicionarComponente(ItemEstrutura $itemEstrutura) {
        if ($this->itens->contains($itemEstrutura)) {
            return;
        }
        $this->itens->add($itemEstrutura);
    }

    public function removerComponente($key) {
        $this->itens->remove($key);
    }

    public function adicionarRoteiro(Roteiro $roteiro) {
        if (!$this->roteiros->contains($roteiro)) {
            $this->roteiros->add($roteiro);
        }
        return $this->roteiros;
    }

    public function removerRoteiro(Roteiro $roteiro) {
        $this->roteiros->removeElement($roteiro);
    }

    function getItens() {
        return $this->itens;
    }

    function getRoteiros() {
        return $this->roteiros;
    }

    function setItens($estrutura) {
        $this->itens = $estrutura;
    }

    function setRoteiros($roteiros) {
        $this->roteiros = $roteiros;
    }

      public function jsonSerialize() {
        return array(
            'id' => $this->id,
            'codigoInterno'=> $this->codigoInterno,
            'descricao'=> $this->descricao,
            'situacao'=> $this->situacao,
            'unidadeMedida'=> $this->unidadeMedida->getSigla(),
            'valorUntiario'=> $this->valorUnitario,
            'leadTime'=> $this->leadTime,
            'quantidadeEstoque'=> $this->quantidadeEstoque,
            'quantidadeMinima'=> $this->quantidadeMinima,
            'peso'=> $this->peso,
            'comprimento'=> $this->comprimento,
            'largura'=> $this->largura,
            'altura'=> $this->altura,
            'roteiro' => json_encode($this->roteiros),
           
            
        );
    }


}
