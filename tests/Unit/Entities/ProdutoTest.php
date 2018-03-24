<?php

namespace Tests\Unit;

use App\Entities\ItemEstrutura;
use App\Entities\Material;
use App\Entities\Produto;
use App\Entities\UnidadeMedida;
use Tests\TestCase;

class ProdutoTest extends TestCase {

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testProdutoPossuiDados() {
          $unidadeMedida = new UnidadeMedida("Unidade","UN");
		$material1 = new Material("TUBO DE ACO 20X20X100", $unidadeMedida, 8.00, 5, 100.00, 75.00);
		$material1->setPeso(0.2);
		$material1->setAltura(20.00);
		$material1->setComprimento(100.00);
		$material1->setLargura(20.00);
		
		$material2 = new Material("TAMPO DE MADEIRA", $unidadeMedida, 8.00, 5, 100.00, 75.00);
		
		$material2->setPeso(1.00);
		$material2->setAltura(35.00);
		$material2->setComprimento(500.00);
		$material2->setLargura(500.00);

		
		$produto = new Produto("Mesa",$unidadeMedida,150.00,2,10.00,5.00);
		$produto->setPeso(1.5);
		$produto->setCodigoInterno("MI-005");
		$produto->setAltura(300.0);
		$produto->setComprimento(500.00);
		$produto->setLargura(200.00);

		
		
		 $item1 = new ItemEstrutura($material1, 2.00);
		 $item2 = new ItemEstrutura($material2, 1.00);
		$produto->adicionarComponente($item1);
		$produto->adicionarComponente($item2);
		
		$this->assertEquals("Mesa", $produto->getDescricao());
		$this->assertEquals("MI-005", $produto->getCodigoInterno());
		$this->assertEquals("Unidade", $produto->getUnidadeMedida()->getDescricao());
		$this->assertEquals("UN", $produto->getUnidadeMedida()->getSigla());
		$this->assertEquals(150.00, $produto->getValorUnitario(),0);
		$this->assertEquals(2, $produto->getLeadTime(),0);
		$this->assertEquals(10.00, $produto->getQuantidadeEstoque(),0);
		$this->assertEquals(5.00, $produto->getQuantidadeMinima(),0);
		$this->assertEquals(2.00, $produto->getItens()->count(),0);
		$this->assertEquals(1.5, $produto->getPeso(),0);
		$this->assertEquals(300.0, $produto->getAltura(),0);
		$this->assertEquals(500.0, $produto->getComprimento(),0);
		$this->assertEquals(200.0, $produto->getLargura(),0);
		$this->assertEquals("ATIVO", $produto->getSituacao());
    }

    

	public function testAdicionarComponentesEstrutura() {
		$unidadeMedida = new UnidadeMedida("Unidade","UN");
		$material1 = new Material("TUBO DE ACO 20X20X100", $unidadeMedida, 8.00, 5, 100.00, 75.00);
		$material1->setPeso(0.2);
		$material1->setAltura(20.00);
		$material1->setComprimento(100.00);
		$material1->setLargura(20.00);
		
		$material2 = new Material("TAMPO DE MADEIRA",$unidadeMedida, 8.00, 5, 100.00, 75.00);
		
		$material2->setPeso(1.00);
		$material2->setAltura(35.00);
		$material2->setComprimento(500.00);
		$material2->setLargura(500.00);

		
		$produto = new Produto("Mesa",$unidadeMedida,150.00,2,10.00,5.00);
		$produto->setPeso(1.5);
		$produto->setCodigoInterno("MI-005");
		$produto->setAltura(300.0);
		$produto->setComprimento(500.00);
		$produto->setLargura(200.00);
		
		
		$item1 = new ItemEstrutura($material1, 2.00);
		$item2 = new ItemEstrutura($material2, 1.00);
		$item3 = new ItemEstrutura($material2, 3.00);
		$produto->adicionarComponente($item1);
		$produto->adicionarComponente($item2);
		$produto->adicionarComponente($item3);
		
		
		
		$this->assertEquals(2.00, $produto->getItens()->get(0)->getQuantidade(),0);
		$this->assertEquals(1.00, $produto->getItens()->get(1)->getQuantidade(),0);
		$this->assertEquals(3.00, $produto->getItens()->get(2)->getQuantidade(),0);
		
	}
	

	public function testRemoverComponentesEstrutura() {
		$unidadeMedida = new UnidadeMedida("Unidade","UN");
		$material1 = new Material("TUBO DE ACO 20X20X100",$unidadeMedida, 8.00, 5, 100.00, 75.00);
		$material1->setPeso(0.2);
		$material1->setAltura(20.00);
		$material1->setComprimento(100.00);
		$material1->setLargura(20.00);
		
		$material2 = new Material("TAMPO DE MADEIRA",$unidadeMedida, 8.00, 5, 100.00, 75.00);
		
		$material2->setPeso(1.00);
		$material2->setAltura(35.00);
		$material2->setComprimento(500.00);
		$material2->setLargura(500.00);

		
		$produto = new Produto("Mesa",$unidadeMedida,150.00,2,10.00,5.00);
		$produto->setPeso(1.5);
		$produto->setCodigoInterno("MI-005");
		$produto->setAltura(300.0);
		$produto->setComprimento(500.00);
		$produto->setLargura(200.00);

		
		
		$item1 = new ItemEstrutura($material1, 2.00);
		$item2 = new ItemEstrutura($material2, 1.00);
		$produto->adicionarComponente($item1);
		$produto->adicionarComponente($item2);

		

		$produto->removerComponente(1);
		
		$this->assertEquals(1, $produto->getItens()->count());
	}
}
