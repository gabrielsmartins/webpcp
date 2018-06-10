<?php

namespace App\DAO;

use App\Entities\Apontamento;
use App\Entities\Produto;
use App\Entities\StatusOrdemProducao;
use App\Entities\TipoApontamento;

class ApontamentoDAO extends GenericDAO {

    public function __construct() {
        parent::__construct();
        $this->className = Apontamento::class;
    }

    public function salvar($apontamento) {
        $this->em->persist($apontamento);
        $this->em->flush();

        $this->atualizaStatusOrdem($apontamento);
        $this->atualizaSaldoMateriais($apontamento);

        return $apontamento;
    }

    private function atualizaSaldoMateriais(Apontamento $apontamento) {
        $quantidadeApontamento = $apontamento->getQuantidade();
        $produtoDAO = new ProdutoDAO();
        $materialDAO = new MaterialDAO();

        if ($apontamento->getTipo() == TipoApontamento::PRODUCAO || $apontamento->getTipo() == TipoApontamento::DESCARTE) {
            foreach ($apontamento->getProgramacao()->getOrdemProducao()->getProduto()->getItens() as $item) {
                $quantidadeEstoque = $item->getQuantidadeEstoque();
                $item->setQuantidadeEstoque($quantidadeEstoque - $quantidadeApontamento);
                if ($item instanceof Produto) {
                    $produtoDAO->salvar($item);
                } else {
                    $materialDAO->salvar($item);
                }
            }
        }
    }

    private function atualizaStatusOrdem(Apontamento $apontamento) {
        $ordem = $apontamento->getProgramacao()->getOrdemProducao();
        if ($ordem->getStatus() == StatusOrdemProducao::EMITIDA) {
            $ordem->setStatus(StatusOrdemProducao::INICIADA);
            $ordemDAO = new OrdemProducaoDAO();
            $ordemDAO->salvar($ordem);
        }
        
  
    }

}
