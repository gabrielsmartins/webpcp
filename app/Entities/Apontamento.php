<?php



namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="apontamento")
 */
class Apontamento {
  
    /**
     * @ORM\Id 
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="prog_id")
     * */
    private $id;
    
    

   
    /**
     * @ORM\ManyToOne(targetEntity="Programacao")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="apont_prog_ord_id", referencedColumnName="prog_ord_id"),
     * @ORM\JoinColumn(name="apont_prog_seq", referencedColumnName="prog_seq")
     * })
     * */
    private $programacao;
    
    /**
     * @ORM\Column(type="string",name="apont_tipo")
     */
    private $tipo;
    
    /**
     * @ORM\Column(type="decimal",name="apont_qntd")
     */
    private $quantidade;
    
    
    /**
     * @ORM\Column(type="datetime",name="apont_dt_ini")
     */
    private $dataInicio;
    
    /**
     * @ORM\Column(type="datetime",name="apont_dt_fim")
     */
    private $dataFim;
    
    
    function __construct($programacao, $tipo, $quantidade, $dataInicio, $dataFim) {
        $this->programacao = $programacao;
        $this->tipo = $tipo;
        $this->quantidade = $quantidade;
        $this->dataInicio = $dataInicio;
        $this->dataFim = $dataFim;
    }
    
    
    function getId() {
        return $this->id;
    }

    function getProgramacao() {
        return $this->programacao;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getQuantidade() {
        return $this->quantidade;
    }

    function getDataInicio() {
        return $this->dataInicio;
    }

    function getDataFim() {
        return $this->dataFim;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProgramacao($programacao) {
        $this->programacao = $programacao;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    

}
