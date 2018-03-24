<?php


namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="requisicao_material_detalhe")
 */
class ItemRequisicao {
    
    /**
     * @ORM\Id 
     * @ORM\ManyToOne(targetEntity="RequisicaoMaterial")
     * @ORM\JoinColumn(name="rm_id", referencedColumnName="rm_id")
     **/
    private $requisicao;
    
    /** 
      * @ORM\Id 
      * @ORM\ManyToOne(targetEntity="Material") 
      * @ORM\JoinColumn(name="rm_prod_id", referencedColumnName="prod_id")
      */
    private $material;
    
    /**
     * @ORM\Column(type="decimal",name="rm_prod_qntd")
     */
    private $quantidade;
    
    function __construct($requisicao, $material, $quantidade) {
        $this->requisicao = $requisicao;
        $this->material = $material;
        $this->quantidade = $quantidade;
    }
    
    function getRequisicao() {
        return $this->requisicao;
    }

    function getMaterial() {
        return $this->material;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function setRequisicao($requisicao) {
        $this->requisicao = $requisicao;
    }

    function setMaterial($material) {
        $this->material = $material;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }



   
}
