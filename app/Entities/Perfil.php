<?php

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="perfil")
 */
class Perfil{
    
     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="perf_id")
     */
    private $id;

    /**
     * @ORM\Column(type="string",name="perf_desc")
     */
    private $descricao;
    
    public function __construct($descricao) {
        $this->descricao = $descricao;
    }

    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }


   
}
