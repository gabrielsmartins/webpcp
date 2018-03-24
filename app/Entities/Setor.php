<?php



namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="setor")
 */
class Setor {
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="setr_id")
     */
    private $id;
    /**
     * @ORM\Column(type="string",name="setr_desc")
     */
    private $descricao;
    
    /**
     * @ORM\OneToMany(targetEntity="Operacao",mappedBy="setor")
     */
    private $operacoes;
    
    /**
     * @ORM\OneToMany(targetEntity="Recurso", mappedBy="setor")
     */
    private $recursos;
    
    public function __construct($descricao) {
        $this->operacoes = new ArrayCollection();
        $this->recursos = new ArrayCollection();
        $this->descricao = $descricao;
    }
    
    
    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getOperacoes() {
        return $this->operacoes;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setOperacoes($operacoes) {
        $this->operacoes = $operacoes;
    }


}
