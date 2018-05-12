<?php



namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="estrutura_produto")
 */
class ItemEstrutura implements JsonSerializable {
    
    
    /**
     * @ORM\Id 
     * @ORM\ManyToOne(targetEntity="Produto")
     * @ORM\JoinColumn(name="prod_id", referencedColumnName="prod_id")
     **/
    private $produto;

   
     /** 
      * @ORM\Id 
      * @ORM\ManyToOne(targetEntity="Componente") 
      * @ORM\JoinColumn(name="prod_sub_id", referencedColumnName="prod_id")
      */
    private $componente;
    
    /**
     * @ORM\Column(type="decimal",name="prod_sub_qntd")
     */
    private $quantidade;
    
    
    function __construct($produto, $componente, $quantidade) {
        $this->produto = $produto;
        $this->componente = $componente;
        $this->quantidade = $quantidade;
    }

    
    function getProduto() {
        return $this->produto;
    }

    function setProduto($produto) {
        $this->produto = $produto;
    }

        
    function getComponente() {
        return $this->componente;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function setComponente($componente) {
        $this->componente = $componente;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }


     public function jsonSerialize() {
        return array(
            'produto' => $this->produto->getDescricao(),
            'id' => $this->componente->getId(),
            'codigo' => $this->componente->getCodigoInterno(),
            'componente' => $this->componente->getDescricao(),
            'situacao' => $this->componente->getSituacao(),
            'quantidadeEstoque' => $this->componente->getQuantidadeEstoque(),
            'quantidade' => $this->quantidade,
        );
    }
    
    
}
