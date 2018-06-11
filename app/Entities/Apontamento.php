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
     * @ORM\Column(type="integer",name="apont_id")
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
    
    /**
     * @ORM\Column(type="boolean",name="apont_deb_estq")
     */

    private $debitaEstoque;
    
    
    function __construct(Programacao $programacao, $tipo, $quantidade, $dataInicio, $dataFim,$debitaEstoque) {
        $this->programacao = $programacao;
        $this->tipo = $tipo;
        $this->quantidade = $quantidade;
        $this->dataInicio = $dataInicio;
        $this->dataFim = $dataFim;
        $this->debitaEstoque = $debitaEstoque;
        $this->atualizaStatusOrdem();
        $this->atualizaEstoqueMaterial();
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

    private function atualizaStatusOrdem(){
        $ordem = $this->programacao->getOrdemProducao();
        if ($ordem->getStatus() == StatusOrdemProducao::EMITIDA) {
            $ordem->setStatus(StatusOrdemProducao::INICIADA);
        }
    }
    
    private function atualizaEstoqueMaterial(){
        if($this->debitaEstoque){
            $produto = $this->getProgramacao()->getOrdemProducao()->getProduto();
            
            foreach($produto->getItens() as $item){
                $quantidadeEstoque = $item->getComponente()->getQuantidadeEstoque();
                $item->getComponente()->setQuantidadeEstoque($quantidadeEstoque-$this->getQuantidade());
            }
        }
    }
    

}
