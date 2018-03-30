<?php


namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="retirada_produto_detalhe")
 */
class ItemRetirada {
    
    /**
     * @ORM\Id 
     * @ORM\ManyToOne(targetEntity="RetiradaProduto")
     * @ORM\JoinColumn(name="retr_id", referencedColumnName="retr_id")
     **/
    private $retirada;
    
    /** 
      * @ORM\Id 
      * @ORM\ManyToOne(targetEntity="Produto") 
      * @ORM\JoinColumn(name="retr_prod_id", referencedColumnName="prod_id")
      */
    private $produto;
    
    /**
     * @ORM\Column(type="decimal",name="retr_prod_qntd")
     */
    private $quantidade;
    
    function __construct($retirada, Produto $produto, $quantidade) {
        $this->retirada = $retirada;
        $this->produto = $produto;
        $this->quantidade = $quantidade;
    }
    
    function getRetirada() {
        return $this->retirada;
    }

    function getProduto() {
        return $this->material;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function setRetirada($retirada) {
        $this->retirada = $retirada;
    }

    function setProduto($produto) {
        $this->produto = $produto;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }



   
}
