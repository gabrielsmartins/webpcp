<?php


namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recebimento_material_detalhe")
 */
class ItemRecebimento {
    
    /**
     * @ORM\Id 
     * @ORM\ManyToOne(targetEntity="RecebimentoMaterial")
     * @ORM\JoinColumn(name="receb_id", referencedColumnName="receb_id")
     **/
    private $recebimento;
    
    /** 
      * @ORM\Id 
      * @ORM\ManyToOne(targetEntity="ItemRequisicao") 
      * @ORM\JoinColumn(name="receb_rm_det_id", referencedColumnName="rm_det_id")
      */
    private $itemRequisicao;
    
    /**
     * @ORM\Column(type="decimal",name="receb_prod_qntd")
     */
    private $quantidade;
    
    function __construct(RecebimentoMaterial $recebimento, ItemRequisicao $itemRequisicao, $quantidade) {
        $this->recebimento = $recebimento;
        $this->itemRequisicao = $itemRequisicao;
        $this->quantidade = $quantidade;
    }
    
    function getRecebimento() {
        return $this->recebimento;
    }

    function getItemRequsicao() {
        return $this->itemRequisicao;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function setRecebimento($recebimeno) {
        $this->recebimento = $recebimeno;
    }

    function setItemRequisicao($itemRequisicao) {
        $this->itemRequisicao = $itemRequisicao;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }



   
}
