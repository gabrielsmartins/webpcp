<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="requisicao_material")
 * * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="dataEmissao",column=@ORM\Column(name = "rm_dt_emi",type = "datetime")),
 *      @ORM\AttributeOverride(name="prazo",column=@ORM\Column(name= "rm_prazo",type = "date")),
 *      @ORM\AttributeOverride(name="dataConclusao",column=@ORM\Column(name= "rm_dt_concl",type = "datetime"))
 * })
 * 
 * @ORM\AssociationOverrides({
 *      @ORM\AssociationOverride(name="responsavel",
 *          joinColumns=@ORM\JoinColumn(name="rm_usr_id", referencedColumnName="usr_id")
 *      )
 * })
 */
class RequisicaoMaterial extends Documento  {
   
     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="rm_id")
     */
    private $id;
    
    
    /**
     * @ORM\OneToMany(targetEntity="ItemRequisicao", mappedBy="requisicao",cascade={"persist"},fetch="EAGER")
     */
    private $itens;
    
    /**
     * @ORM\Column(type="string",name="rm_status")
     */
    private $status = "EMITIDA";
    
    function __construct($prazo,$responsavel) {
        $this->prazo = $prazo;
        $this->responsavel = $responsavel;
        $this->itens = new ArrayCollection();
        $this->dataEmissao = new DateTime('now');
    }
    
    
    function getId() {
        return $this->id;
    }


    function getItens() {
        return $this->itens;
    }

    function getStatus() {
        return $this->status;
    }

    function setId($id) {
        $this->id = $id;
    }
   

    function setItens($itens) {
        $this->itens = $itens;
    }
    
    
    function setStatus($status) {
        $this->status = $status;
    }


    function adicionarItem(ItemRequisicao $item){
        $this->itens->add($item);
    }
    
    function removeItem(ItemRequisicao $item){
        if ($this->itens->contains($item)){
           $this->itens->remove($item);
        }
    }
    
    
    
    
}
