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
     * @ORM\Column(type="integer",name="prog_seq")
     * */
    private $sequencia;

    /**
     * @ORM\Id 
     * @ORM\ManyToOne(targetEntity="OrdemProducao",inversedBy="programacoes")
     * @ORM\JoinColumn(name="prog_ord_id", referencedColumnName="ord_id")
     * */
    private $ordemProducao;

    /**
     * @ORM\Column(type="decimal",name="prog_tmp_tot")
     */
    private $tempoTotal;

    /**
     * @ORM\OneToMany(targetEntity="Apontamento", mappedBy="programacao",cascade={"all"})
     */
    private $apontamentos;

    /**
     * @ORM\ManyToOne(targetEntity="Roteiro")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="prog_rot_oper_id", referencedColumnName="rot_oper_id"),
     * @ORM\JoinColumn(name="prog_rot_prod_id", referencedColumnName="rot_prod_id"),
     * @ORM\JoinColumn(name="prog_rot_seq", referencedColumnName="rot_seq")
     * })
     * */
    private $roteiro;

    /**
     * @ORM\ManyToOne(targetEntity="Recurso")
     * @ORM\JoinColumn(name="prog_rec_id", referencedColumnName="recr_id")
     * */
    private $recurso;

    function __construct(OrdemProducao $ordemProducao, $sequencia,Roteiro $roteiro, Recurso $recurso) {
        $this->ordemProducao = $ordemProducao;
        $this->sequencia = $sequencia;
        $this->roteiro = $roteiro;
        $this->recurso = $recurso;
        $this->apontamentos = new ArrayCollection();
        $this->calculaTempoTotal();
    }

    function getSequencia() {
        return $this->sequencia;
    }

    function setSequencia($sequencia) {
        $this->sequencia = $sequencia;
    }

    function getApontamentos() {
        return $this->apontamentos;
    }

    function getOrdemProducao() {
        return $this->ordemProducao;
    }

    function setApontamentos($apontamentos) {
        $this->apontamentos = $apontamentos;
    }

    function setOrdemProducao($ordemProducao) {
        $this->ordemProducao = $ordemProducao;
    }

    function getTempoTotal() {
        return $this->tempoTotal;
    }

    function getRoteiro() {
        return $this->roteiro;
    }

    function getRecurso() {
        return $this->recurso;
    }

    function setTempoTotal($tempoTotal) {
        $this->tempoTotal = $tempoTotal;
    }

    function setRoteiro($roteiro) {
        $this->roteiro = $roteiro;
    }

    function setRecurso($recurso) {
        $this->recurso = $recurso;
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

    private function calculaTempoTotal() {
        $tempoSetup = explode(':', $this->roteiro->getTempoSetup());
        $tempoProducao = explode(':', $this->roteiro->getTempoProducao());
        $tempoFinalizacao = explode(':', $this->roteiro->getTempoFinalizacao());
        $hour = (intval($tempoSetup[0]) + (intval($tempoProducao[0]) * $this->ordemProducao->getQuantidade()) + intval($tempoFinalizacao[0]));
        $minute = (intval($tempoSetup[1]) + (intval($tempoProducao[1]) * $this->ordemProducao->getQuantidade()) + intval($tempoFinalizacao[1]));
        $hour = intval($hour + $minute / 60);
        $minute = $minute % 60;
        $second = (intval($tempoSetup[2]) + (intval($tempoProducao[2]) * $this->ordemProducao->getQuantidade()) + intval($tempoFinalizacao[2]));
        $minute = intval($minute + $second / 60);
        $second = intval($second % 60);
        $this->tempoTotal = $hour . ":" . $minute . ":" . $second;
    }

}
