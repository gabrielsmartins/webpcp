<?php



namespace App\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ordem_producao")
 * * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="dataEmissao",column=@ORM\Column(name = "ord_dt_emi",type = "datetime")),
 *      @ORM\AttributeOverride(name="prazo",column=@ORM\Column(name= "ord_prazo",type = "date")),
 *      @ORM\AttributeOverride(name="dataConclusao",column=@ORM\Column(name= "ord_dt_concl",type = "datetime"))
 * })
 * 
 * @ORM\AssociationOverrides({
 *      @ORM\AssociationOverride(name="responsavel",
 *          joinColumns=@ORM\JoinColumn(name="ord_usr_id", referencedColumnName="usr_id")
 *      )
 * })
 */
class OrdemProducao extends Documento {
    
      /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="ord_id")
     */
    private $id;
    
    /**
     *@ORM\ManyToOne(targetEntity="Produto")
     *@ORM\JoinColumn(name="ord_prod_id", referencedColumnName="prod_id")
     */
    private $produto;
    
    
     /**
     * @ORM\Column(type="integer",name="ord_prod_qntd")
     */
    private $quantidade;
    
    
    function __construct($produto,$quantidade,$prazo,$responsavel) {
        $this->produto = $produto;
        $this->quantidade = $quantidade;
        $this->prazo = $prazo;
        $this->responsavel = $responsavel;
        $this->dataEmissao = new DateTime('now');
    }

    function getId() {
        return $this->id;
    }

    function getProduto() {
        return $this->produto;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProduto($produto) {
        $this->produto = $produto;
    }
    
    function getQuantidade() {
        return $this->quantidade;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }





}
