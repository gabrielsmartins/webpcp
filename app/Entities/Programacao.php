<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="programacao")
 */
class Programacao {

    /**
     * @ORM\Id 
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="prog_id")
     * */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="OrdemProducao")
     * @ORM\JoinColumn(name="prog_ord_id", referencedColumnName="ord_id")
     * */
    private $ordemProducao;

    /**
     * @ORM\Column(type="datetime",name="prog_dt_ini_prev")
     */
    private $dataInicioPrevista;

    /**
     * @ORM\Column(type="datetime",name="prog_dt_fim_prev")
     */
    private $dataFimPrevista;

    /**
     * @ORM\Column(type="time",name="prog_tot_hrs")
     */
    private $totalHorasPrevista;
    
    
     /**
     * @ORM\OneToMany(targetEntity="Apontamento", mappedBy="programacao",cascade={"all"})
     */
    private $apontamentos;

    /**
     * @ORM\ManyToOne(targetEntity="Operacao")
     * @ORM\JoinColumn(name="prog_oper_id", referencedColumnName="oper_id")
     * */
    private $operacao;

    /**
     * @ORM\ManyToOne(targetEntity="Recurso")
     * @ORM\JoinColumn(name="prog_rec_id", referencedColumnName="recr_id")
     * */
    private $recurso;

    function __construct($ordemProducao, $operacao, $recurso, $dataInicioPrevista, $dataFimPrevista) {
        $this->ordemProducao = $ordemProducao;
        $this->operacao = $operacao;
        $this->recurso = $recurso;
        $this->dataInicioPrevista = $dataInicioPrevista;
        $this->dataFimPrevista = $dataFimPrevista;
        $this->apontamentos = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getDataInicioPrevista() {
        return $this->dataInicioPrevista;
    }

    function getDataFimPrevista() {
        return $this->dataFimPrevista;
    }

    function getTotalHorasPrevista() {
        return $this->totalHorasPrevista;
    }

    function getApontamentos() {
        return $this->apontamentos;
    }

    function getOperacao() {
        return $this->operacao;
    }

    function getRecurso() {
        return $this->recurso;
    }

    function getOrdemProducao() {
        return $this->ordemProducao;
    }

    function setDataInicioPrevista($dataInicioPrevista) {
        $this->dataInicioPrevista = $dataInicioPrevista;
    }

    function setDataFimPrevista($dataFimPrevista) {
        $this->dataFimPrevista = $dataFimPrevista;
    }

    function setTotalHorasPrevista($totalHorasPrevista) {
        $this->totalHorasPrevista = $totalHorasPrevista;
    }

    function setApontamentos($apontamentos) {
        $this->apontamentos = $apontamentos;
    }

    function setOperacao($operacao) {
        $this->operacao = $operacao;
    }

    function setRecurso($recurso) {
        $this->recurso = $recurso;
    }

    function setOrdemProducao($ordemProducao) {
        $this->ordemProducao = $ordemProducao;
    }

    function adicionarApontamento(Programacao $programacao) {
        if (!$this->programacoes->contains($programacao)) {
            $this->programacoes->add($programacao);
        }

        return $this->programacoes;
    }

    function removerApontamento(Programacao $programacao) {
        $this->programacoes->removeElement($programacao);
        return $this->programacoes;
    }

}
