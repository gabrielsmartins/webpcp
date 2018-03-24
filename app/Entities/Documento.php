<?php


namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class Documento {
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataEmissao;
    
/**
     * @ORM\Column(type="date")
     */
    protected $prazo;
    
  
    /**
     * @ORM\Column(type="datetime")
     */
    protected $dataConclusao;
    
     /**
     *@ORM\ManyToOne(targetEntity="Usuario")
     */
    protected $responsavel;
    
    function getDataEmissao() {
        return $this->dataEmissao;
    }

    function getPrazo() {
        return $this->prazo;
    }

    function getDataConclusao() {
        return $this->dataConclusao;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function setDataEmissao($dataEmissao) {
        $this->dataEmissao = $dataEmissao;
    }

    function setPrazo($prazo) {
        $this->prazo = $prazo;
    }

    function setDataConclusao($dataConclusao) {
        $this->dataConclusao = $dataConclusao;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }


}
