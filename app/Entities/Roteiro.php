<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="roteiro")
 */
class Roteiro implements JsonSerializable {

    /**
     * @ORM\Id 
     * @ORM\ManyToOne(targetEntity="Produto",inversedBy="roteiros")
     * @ORM\JoinColumn(name="rot_prod_id", referencedColumnName="prod_id")
     * */
    private $produto;

    /**
     * @ORM\Id 
     * @ORM\Column(type="integer",name="rot_seq")
     */
    private $sequencia;

    /**
     * @ORM\Id 
     * @ORM\ManyToOne(targetEntity="Operacao") 
     * @ORM\JoinColumn(name="rot_oper_id", referencedColumnName="oper_id")
     */
    private $operacao;

    /**
     * @ORM\Column(type="decimal",name="rot_tmp_stp")
     */
    private $tempoSetup;

    /**
     * @ORM\Column(type="decimal",name="rot_tmp_prd")
     */
    private $tempoProducao;

    /**
     * @ORM\Column(type="decimal",name="rot_tmp_fnl")
     */
    private $tempoFinalizacao;

    function __construct(Produto $produto, $sequencia, $operacao, $tempoSetup, $tempoProducao, $tempoFinalizacao) {
        $this->produto = $produto;
        $this->sequencia = $sequencia;
        $this->operacao = $operacao;
        $this->tempoSetup = $tempoSetup;
        $this->tempoProducao = $tempoProducao;
        $this->tempoFinalizacao = $tempoFinalizacao;
    }

    function getProduto() {
        return $this->produto;
    }

    function setProduto($produto) {
        $this->produto = $produto;
    }

    function getSequencia() {
        return $this->sequencia;
    }

    function getOperacao() {
        return $this->operacao;
    }

    function getTempoSetup() {
        return $this->tempoSetup;
    }

    function getTempoProducao() {
        return $this->tempoProducao;
    }

    function getTempoFinalizacao() {
        return $this->tempoFinalizacao;
    }

    function setSequencia($sequencia) {
        $this->sequencia = $sequencia;
    }

    function setOperacao($operacao) {
        $this->operacao = $operacao;
    }

    function setTempoSetup($tempoSetup) {
        $this->tempoSetup = $tempoSetup;
    }

    function setTempoProducao($tempoProducao) {
        $this->tempoProducao = $tempoProducao;
    }

    function setTempoFinalizacao($tempoFinalizacao) {
        $this->tempoFinalizacao = $tempoFinalizacao;
    }

    public function jsonSerialize() {
        return array(
            'produto' => $this->produto->getDescricao(),
            'sequencia' => $this->sequencia,
            'operacaoID' => $this->operacao->getId(),
            'operacao' => $this->operacao->getDescricao(),
            'setorID' => $this->operacao->getSetor()->getId(),
            'setor' => $this->operacao->getSetor()->getDescricao(),
            'tempoSetup' => $this->tempoSetup,
            'tempoProducao' => $this->tempoProducao,
            'tempoFinalizacao' => $this->tempoFinalizacao,
        );
    }

}
