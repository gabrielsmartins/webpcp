<?php


namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\Table(name="produto")
 * @ORM\DiscriminatorColumn(name="prod_tipo", type="string")
 */
abstract class Componente implements JsonSerializable {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="prod_id")
     */
    protected $id;

    /**
     * @ORM\Column(type="string",name="prod_cod_intr")
     */
    protected $codigoInterno;


    /**
     * @ORM\Column(type="string",name="prod_desc")
     */
    protected $descricao;


    /**
     * @ORM\Column(type="string",name="prod_sit")
     */
    protected $situacao = "ATIVO";

    /**
     * @ORM\ManyToOne(targetEntity="UnidadeMedida")
     * @ORM\JoinColumn(name="prod_unid_id", referencedColumnName="unid_id")
     */
    protected $unidadeMedida;


    /**
     * @ORM\Column(type="decimal",name="prod_vlr_unit")
     */
    protected $valorUnitario;


    /**
     * @ORM\Column(type="integer",name="prod_lead_time")
     */
    protected $leadTime;


    /**
     * @ORM\Column(type="decimal",name="prod_qntd_estq")
     */
    protected $quantidadeEstoque;


    /**
     * @ORM\Column(type="decimal",name="prod_qntd_min")
     */
    protected $quantidadeMinima;


    /**
     * @ORM\Column(type="decimal",name="prod_peso_kg")
     */
    protected $peso;

    /**
     * @ORM\Column(type="decimal",name="prod_comp_mm")
     */
    protected  $comprimento;


    /**
     * @ORM\Column(type="decimal",name="prod_larg_mm")
     */
    protected $largura;

    /**
     * @ORM\Column(type="decimal",name="prod_alt_mm")
     */
    protected $altura;
    
    
    function __construct($descricao, $unidadeMedida, $valorUnitario, $leadTime, $quantidadeEstoque, $quantidadeMinima) {
        $this->descricao = $descricao;
        $this->unidadeMedida = $unidadeMedida;
        $this->valorUnitario = $valorUnitario;
        $this->leadTime = $leadTime;
        $this->quantidadeEstoque = $quantidadeEstoque;
        $this->quantidadeMinima = $quantidadeMinima;
    }

    
    
    function getId() {
        return $this->id;
    }

    function getCodigoInterno() {
        return $this->codigoInterno;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getUnidadeMedida() {
        return $this->unidadeMedida;
    }

    function getValorUnitario() {
        return $this->valorUnitario;
    }

    function getLeadTime() {
        return $this->leadTime;
    }

    function getQuantidadeEstoque() {
        return $this->quantidadeEstoque;
    }

    function getQuantidadeMinima() {
        return $this->quantidadeMinima;
    }

    function getPeso() {
        return $this->peso;
    }

    function getComprimento() {
        return $this->comprimento;
    }

    function getLargura() {
        return $this->largura;
    }

    function getAltura() {
        return $this->altura;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCodigoInterno($codigoInterno) {
        $this->codigoInterno = $codigoInterno;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setUnidadeMedida($unidadeMedida) {
        $this->unidadeMedida = $unidadeMedida;
    }

    function setValorUnitario($valorUnitario) {
        $this->valorUnitario = $valorUnitario;
    }

    function setLeadTime($leadTime) {
        $this->leadTime = $leadTime;
    }

    function setQuantidadeEstoque($quantidadeEstoque) {
        $this->quantidadeEstoque = $quantidadeEstoque;
    }

    function setQuantidadeMinima($quantidadeMinima) {
        $this->quantidadeMinima = $quantidadeMinima;
    }

    function setPeso($peso) {
        $this->peso = $peso;
    }

    function setComprimento($comprimento) {
        $this->comprimento = $comprimento;
    }

    function setLargura($largura) {
        $this->largura = $largura;
    }

    function setAltura($altura) {
        $this->altura = $altura;
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
            
        );
    }


    
    
    
}
