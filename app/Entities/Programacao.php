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

  

    function __construct($ordemProducao, $operacao,$recurso,$totalHoras) {
        $this->ordemProducao = $ordemProducao;
        $this->operacao = $operacao;
        $this->recurso = $recurso;
        $this->totalHorasPrevista = $totalHoras;
        $this->apontamentos = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
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



    function getOrdemProducao() {
        return $this->ordemProducao;
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
