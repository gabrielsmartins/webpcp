<?php


namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="requisicao_material_detalhe")
 */
class ItemRequisicao {
    
      /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="rm_det_id")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="RequisicaoMaterial",inversedBy="itens")
     * @ORM\JoinColumn(name="rm_id", referencedColumnName="rm_id")
     **/
    private $requisicao;
    
    /** 
      * @ORM\ManyToOne(targetEntity="Material") 
      * @ORM\JoinColumn(name="rm_prod_id", referencedColumnName="prod_id")
      */
    private $material;
    
    /**
     * @ORM\Column(type="decimal",name="rm_prod_qntd")
     */
    private $quantidade;
    
 
    /**
     * @ORM\OneToMany(targetEntity="ItemRecebimento", mappedBy="itemRequisicao",cascade={"all"})
     */
    private $itensRecebimento;
    
    function __construct($requisicao, $material, $quantidade) {
        $this->requisicao = $requisicao;
        $this->material = $material;
        $this->quantidade = $quantidade;
        $this->itensRecebimento = new ArrayCollection();
    }
    
    
    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
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
    
    
    function getItensRecebimento() {
        return $this->itensRecebimento;
    }

        
    function adicionarItemRecebimento(ItemRecebimento $itemRecebimento){
        if (!$this->itensRecebimento->contains($itemRecebimento)) {
            $this->itensRecebimento->add($itemRecebimento);
        }

        return $this->itensRecebimento;
    }



   
}
