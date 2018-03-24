<?php

namespace Tests\Unit;

use App\DAO\MaterialDAO;
use App\DAO\OperacaoDAO;
use App\DAO\ProdutoDAO;
use App\DAO\SetorDAO;
use App\DAO\UnidadeMedidaDAO;
use App\Entities\ItemEstrutura;
use App\Entities\Material;
use App\Entities\Operacao;
use App\Entities\Produto;
use App\Entities\Roteiro;
use App\Entities\Setor;
use App\Entities\UnidadeMedida;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

class ProdutoDAOTest extends TestCase {

    public static function reset() {
        $sql = "SET FOREIGN_KEY_CHECKS = 0;
                                    TRUNCATE TABLE estrutura_produto;
                                    TRUNCATE TABLE roteiro;
                                    TRUNCATE TABLE produto;
                                    TRUNCATE TABLE unidade;
                                    TRUNCATE TABLE operacao;
                                    TRUNCATE TABLE setor;
                                    SET FOREIGN_KEY_CHECKS = 1;";
        EntityManager::getConnection()->prepare($sql)->execute();
    }

    public function testInserirProduto() {
        self::reset();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        $produtoDAO = new ProdutoDAO();
        $setorDAO = new SetorDAO();
        $operacaoDAO = new OperacaoDAO();
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $unidadeMedidaDAO->salvar($unidadeMedida);

        $material = new Material("CHAPA ACO INOX #20", $unidadeMedida, 75.00, 5, 100.00, 85.00);

        $material->setPeso(0.35);
        $material->setAltura(0.2);
        $material->setComprimento(300.00);
        $material->setLargura(250.00);

        $materialDAO->salvar($material);

        $produto = new Produto("Refrigerador", $unidadeMedida, 1750.00, 20, 5.00, 2.00);

        $produto->setCodigoInterno("RFR-50");
        $produto->setPeso(10.00);
        $produto->setAltura(1750.00);
        $produto->setComprimento(500.00);
        $produto->setLargura(450.00);

        $item = new ItemEstrutura($produto,$material, 2.00);

        $produto->adicionarComponente($item);

        $setor1 = new Setor("CORTE A LASER");
        $setor2 = new Setor("DOBRA");


        $setorDAO->salvar($setor1);
        $setorDAO->salvar($setor2);

        $operacao1 = new Operacao("CORTE A LASER", "CORTAR CONFORME DESENHO", $setor1);
        $operacao2 = new Operacao("DOBRA", "DOBRAR 90º", $setor2);

        $operacaoDAO->salvar($operacao1);
        $operacaoDAO->salvar($operacao2);




        $roteiro1 = new Roteiro($produto,1, $operacao1, "01:10:05", "05:10:05","00:50:05");
        $roteiro2 = new Roteiro($produto,2, $operacao2, "00:05:15", "04:10:30", "00:40:05");

        $produto->adicionarRoteiro($roteiro1);
        $produto->adicionarRoteiro($roteiro2);

        $this->assertNotNull($produtoDAO->salvar($produto));
    }

    public function testAlterarProduto() {
        self::reset();
       $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        $produtoDAO = new ProdutoDAO();
        $setorDAO = new SetorDAO();
        $operacaoDAO = new OperacaoDAO();
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $unidadeMedidaDAO->salvar($unidadeMedida);

        $material = new Material("CHAPA ACO INOX #20", $unidadeMedida, 75.00, 5, 100.00, 85.00);

        $material->setPeso(0.35);
        $material->setAltura(0.2);
        $material->setComprimento(300.00);
        $material->setLargura(250.00);

        $materialDAO->salvar($material);

        $produto = new Produto("Refrigerador", $unidadeMedida, 1750.00, 20, 5.00, 2.00);

        $produto->setCodigoInterno("RFR-50");
        $produto->setPeso(10.00);
        $produto->setAltura(1750.00);
        $produto->setComprimento(500.00);
        $produto->setLargura(450.00);

        $item = new ItemEstrutura($produto,$material, 2.00);

        $produto->adicionarComponente($item);

        $setor1 = new Setor("CORTE A LASER");
        $setor2 = new Setor("DOBRA");


        $setorDAO->salvar($setor1);
        $setorDAO->salvar($setor2);

        $operacao1 = new Operacao("CORTE A LASER", "CORTAR CONFORME DESENHO", $setor1);
        $operacao2 = new Operacao("DOBRA", "DOBRAR 90º", $setor2);

        $operacaoDAO->salvar($operacao1);
        $operacaoDAO->salvar($operacao2);




        $roteiro1 = new Roteiro($produto,1, $operacao1, "01:10:05", "05:10:05","00:50:05");
        $roteiro2 = new Roteiro($produto,2, $operacao2, "00:05:15", "04:10:30", "00:40:05");

        $produto->adicionarRoteiro($roteiro1);
        $produto->adicionarRoteiro($roteiro2);

        $produtoDAO->salvar($produto);
        
        $produto->setDescricao("Refrigerador 2");
        
        $this->assertNotNull($produtoDAO->alterar($produto));
    }

    
    public function testRemoverProduto() {
        self::reset();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();

        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $unidadeMedidaDAO->salvar($unidadeMedida);

        $material = new Material("PARAFUSO 3/8 \"\" x 100mm", $unidadeMedida, 95.00, 3, 15.00, 5.00);
        $materialDAO->salvar($material);
        $materialDAO->remover($material);
    }

    public function testListarProduto() {
        self::reset();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();

        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $unidadeMedidaDAO->salvar($unidadeMedida);

        $material = new Material("PARAFUSO 3/8 \"\" x 100mm", $unidadeMedida, 95.00, 3, 15.00, 5.00);
        $materialDAO->salvar($material);
        $materiais = $materialDAO->listar();
        $this->assertNotNull($materiais);
    }

    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
    }

}
