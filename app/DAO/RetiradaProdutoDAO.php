<?php


namespace App\DAO;

use App\Entities\RetiradaProduto;


class RetiradaProdutoDAO extends GenericDAO {
    
    public function __construct() {
        parent::__construct();
         $this->className = RetiradaProduto::class;
    }
    
    public function salvar($retirada) {
        
        $produtoDAO = new ProdutoDAO();
        foreach ($retirada->getItens() as $item){
            $produto = $item->getProduto();
            $quantidadeEstoque = $produto->getQuantidadeEstoque();
            $quantidadeRetirada = $item->getQuantidade();
            $saldo = $quantidadeEstoque-$quantidadeRetirada;
            $produto->setQuantidadeEstoque($saldo);
            $produtoDAO->salvar($produto);
        }
        
        $this->em->persist($retirada);
        $this->em->flush();
        return $retirada;
    }

}
