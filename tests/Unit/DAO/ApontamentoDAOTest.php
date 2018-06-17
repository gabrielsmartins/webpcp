<?php

namespace Tests\Unit;

use App\DAO\ApontamentoDAO;
use App\DAO\MaterialDAO;
use App\DAO\OperacaoDAO;
use App\DAO\OrdemProducaoDAO;
use App\DAO\PerfilDAO;
use App\DAO\ProdutoDAO;
use App\DAO\RecursoDAO;
use App\DAO\SetorDAO;
use App\DAO\UnidadeMedidaDAO;
use App\DAO\UsuarioDAO;
use App\Entities\Apontamento;
use App\Entities\ItemEstrutura;
use App\Entities\Material;
use App\Entities\Operacao;
use App\Entities\OrdemProducao;
use App\Entities\Perfil;
use App\Entities\Produto;
use App\Entities\Programacao;
use App\Entities\Recurso;
use App\Entities\Roteiro;
use App\Entities\Setor;
use App\Entities\StatusOrdemProducao;
use App\Entities\UnidadeMedida;
use App\Entities\Usuario;
use DateTime;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

class ApontamentoDAOTest extends TestCase {

    public static function reset() {
        $sql = "SET FOREIGN_KEY_CHECKS = 0;
                                    TRUNCATE TABLE apontamento;
                                    TRUNCATE TABLE programacao;
                                    TRUNCATE TABLE ordem_producao;
                                    TRUNCATE TABLE produto;
                                    TRUNCATE TABLE estrutura_produto;
                                    TRUNCATE TABLE roteiro;
                                    TRUNCATE TABLE programacao;
                                    TRUNCATE TABLE apontamento;
                                    TRUNCATE TABLE setor;
                                    TRUNCATE TABLE recurso;
                                    TRUNCATE TABLE operacao;
                                    TRUNCATE TABLE unidade;
                                    TRUNCATE TABLE usuario;
                                    TRUNCATE TABLE perfil;
                                    SET FOREIGN_KEY_CHECKS = 1;";
        EntityManager::getConnection()->prepare($sql)->execute();
    }

    public function testRegistrarApontamentoOrdemIniciada() {
        self::reset();
        $perfilDAO = new PerfilDAO();
        $usuarioDAO = new UsuarioDAO();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        $produtoDAO = new ProdutoDAO();
        $ordemProducaoDAO = new OrdemProducaoDAO();
        $setorDAO = new SetorDAO();
        $operacaDAO = new OperacaoDAO();
        $recursoDAO = new RecursoDAO();
        $apontamentoDAO = new ApontamentoDAO();


        $perfil = new Perfil("PCP");
        $perfilDAO->salvar($perfil);


        $responsavel = new Usuario("Admin", "admin", "12345", $perfil);
        $usuarioDAO->salvar($responsavel);


        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $unidadeMedidaDAO->salvar($unidadeMedida);


        $material1 = new Material("BARRA ACO INOX", $unidadeMedida, 500.50, 2, 20.00, 15.00);
        $material2 = new Material("TUBO ALUMINIO", $unidadeMedida, 475.25, 10, 30.00, 2.00);

        $materialDAO->salvar($material1);
        $materialDAO->salvar($material2);



        $setor1 = new Setor("USINAGEM");
        $setor2 = new Setor("MONTAGEM");

        $setorDAO->salvar($setor1);
        $setorDAO->salvar($setor2);


        $operacao1 = new Operacao("TORNEAR", "TORNEAR CONFORME DESENHO", $setor1);
        $operacao2 = new Operacao("MONTAGEM", "MONTAGEM CONFORME DESENHO", $setor2);

        $operacaDAO->salvar($operacao1);
        $operacaDAO->salvar($operacao2);


        $recurso1 = new Recurso("TORNO HORIZONTAL", $setor1);
        $recurso2 = new Recurso("OPERADOR 1", $setor2);

        $recursoDAO->salvar($recurso1);
        $recursoDAO->salvar($recurso2);



        $produto = new Produto("BICICLETA", $unidadeMedida, 500.00, 2, 10.00, 5.00);

        $produto->adicionarComponente(new ItemEstrutura($produto, $material1, 2.00));
        $produto->adicionarComponente(new ItemEstrutura($produto, $material2, 5.00));



        $roteiro1 = new Roteiro($produto, 1, $operacao1, "00:00:00", "03:50:50", "00:00:00");
        $roteiro2 = new Roteiro($produto, 2, $operacao2, "00:00:00", "02:20:00", "00:00:00");


        $produto->adicionarRoteiro($roteiro1);
        $produto->adicionarRoteiro($roteiro2);



        $produtoDAO->salvar($produto);


        $ordemProducao = new OrdemProducao($produto, 10.00, new DateTime('2018-03-01'), $responsavel);
        $programacao1 = new Programacao($ordemProducao, 1, $roteiro1, $recurso1);
        $programacao2 = new Programacao($ordemProducao, 2, $roteiro2, $recurso2);
        $ordemProducao->adicionarProgramacao($programacao1);
        $ordemProducao->adicionarProgramacao($programacao2);


        $ordemProducaoDAO->salvar($ordemProducao);


        $apontamento1 = new Apontamento($programacao1, "PRODUCAO", 5.00, new DateTime("2018-02-27 14:30:00"), new DateTime("2018-02-27 16:30:00"), true);
        $apontamento2 = new Apontamento($programacao1, "DESCARTE", 5.00, new DateTime("2018-02-27 17:00:00"), new DateTime("2018-02-27 17:15:00"), true);



        $this->assertNotNull($apontamentoDAO->salvar($apontamento1));
        $this->assertNotNull($apontamentoDAO->salvar($apontamento2));
        $this->assertEquals(StatusOrdemProducao::INICIADA, $ordemProducao->getStatus());
        $this->assertEquals(10.00, $material1->getQuantidadeEstoque());
        $this->assertEquals(20.00, $material2->getQuantidadeEstoque());
    }

    public function testRegistrarApontamentoOrdemEncerrada() {
        self::reset();
        $perfilDAO = new PerfilDAO();
        $usuarioDAO = new UsuarioDAO();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        $produtoDAO = new ProdutoDAO();
        $ordemProducaoDAO = new OrdemProducaoDAO();
        $setorDAO = new SetorDAO();
        $operacaDAO = new OperacaoDAO();
        $recursoDAO = new RecursoDAO();
        $apontamentoDAO = new ApontamentoDAO();


        $perfil = new Perfil("PCP");
        $perfilDAO->salvar($perfil);


        $responsavel = new Usuario("Admin", "admin", "12345", $perfil);
        $usuarioDAO->salvar($responsavel);


        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $unidadeMedidaDAO->salvar($unidadeMedida);


        $material1 = new Material("BARRA ACO INOX", $unidadeMedida, 500.50, 2, 20.00, 15.00);
        $material2 = new Material("TUBO ALUMINIO", $unidadeMedida, 475.25, 10, 30.00, 2.00);

        $materialDAO->salvar($material1);
        $materialDAO->salvar($material2);



        $setor1 = new Setor("USINAGEM");
        $setor2 = new Setor("MONTAGEM");

        $setorDAO->salvar($setor1);
        $setorDAO->salvar($setor2);


        $operacao1 = new Operacao("TORNEAR", "TORNEAR CONFORME DESENHO", $setor1);
        $operacao2 = new Operacao("MONTAGEM", "MONTAGEM CONFORME DESENHO", $setor2);

        $operacaDAO->salvar($operacao1);
        $operacaDAO->salvar($operacao2);


        $recurso1 = new Recurso("TORNO HORIZONTAL", $setor1);
        $recurso2 = new Recurso("OPERADOR 1", $setor2);

        $recursoDAO->salvar($recurso1);
        $recursoDAO->salvar($recurso2);



        $produto = new Produto("BICICLETA", $unidadeMedida, 500.00, 2, 10.00, 5.00);

        $produto->adicionarComponente(new ItemEstrutura($produto, $material1, 2.00));
        $produto->adicionarComponente(new ItemEstrutura($produto, $material2, 5.00));



        $roteiro1 = new Roteiro($produto, 1, $operacao1, "00:00:00", "03:50:50", "00:00:00");
        $roteiro2 = new Roteiro($produto, 2, $operacao2, "00:00:00", "02:20:00", "00:00:00");


        $produto->adicionarRoteiro($roteiro1);
        $produto->adicionarRoteiro($roteiro2);



        $produtoDAO->salvar($produto);


        $ordemProducao = new OrdemProducao($produto, 10.00, new DateTime('2018-03-01'), $responsavel);
        $programacao1 = new Programacao($ordemProducao, 1, $roteiro1, $recurso1);
        $programacao2 = new Programacao($ordemProducao, 2, $roteiro2, $recurso2);
        $ordemProducao->adicionarProgramacao($programacao1);
        $ordemProducao->adicionarProgramacao($programacao2);


        $ordemProducaoDAO->salvar($ordemProducao);


        $apontamento1 = new Apontamento($programacao1, "PRODUCAO", 5.00, new DateTime("2018-02-27 14:30:00"), new DateTime("2018-02-27 16:30:00"), true);
        $apontamento2 = new Apontamento($programacao1, "DESCARTE", 5.00, new DateTime("2018-02-27 17:00:00"), new DateTime("2018-02-27 17:15:00"), true);
        $apontamento3 = new Apontamento($programacao1, "PRODUCAO", 5.00, new DateTime("2018-03-27 14:30:00"), new DateTime("2018-03-27 16:30:00"), true);
        $apontamento4 = new Apontamento($programacao2, "PRODUCAO", 5.00, new DateTime("2018-02-27 14:30:00"), new DateTime("2018-02-27 16:30:00"), false);
        $apontamento5 = new Apontamento($programacao2, "PRODUCAO", 5.00, new DateTime("2018-03-27 14:30:00"), new DateTime("2018-03-27 16:30:00"), false);




        $this->assertNotNull($apontamentoDAO->salvar($apontamento1));
        $this->assertNotNull($apontamentoDAO->salvar($apontamento2));
        $this->assertNotNull($apontamentoDAO->salvar($apontamento3));
        $this->assertNotNull($apontamentoDAO->salvar($apontamento4));
        $this->assertNotNull($apontamentoDAO->salvar($apontamento5));




        $this->assertEquals(5.00, $material1->getQuantidadeEstoque());
        $this->assertEquals(15.00, $material2->getQuantidadeEstoque());
        $this->assertEquals(StatusOrdemProducao::ENCERRADA, $ordemProducao->getStatus());
    }

    
    public function testObterApontamentoPorPeriodo() {
        self::reset();
        $perfilDAO = new PerfilDAO();
        $usuarioDAO = new UsuarioDAO();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        $produtoDAO = new ProdutoDAO();
        $ordemProducaoDAO = new OrdemProducaoDAO();
        $setorDAO = new SetorDAO();
        $operacaDAO = new OperacaoDAO();
        $recursoDAO = new RecursoDAO();
        $apontamentoDAO = new ApontamentoDAO();


        $perfil = new Perfil("PCP");
        $perfilDAO->salvar($perfil);


        $responsavel = new Usuario("Admin", "admin", "12345", $perfil);
        $usuarioDAO->salvar($responsavel);


        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $unidadeMedidaDAO->salvar($unidadeMedida);


        $material1 = new Material("BARRA ACO INOX", $unidadeMedida, 500.50, 2, 20.00, 15.00);
        $material2 = new Material("TUBO ALUMINIO", $unidadeMedida, 475.25, 10, 30.00, 2.00);

        $materialDAO->salvar($material1);
        $materialDAO->salvar($material2);



        $setor1 = new Setor("USINAGEM");
        $setor2 = new Setor("MONTAGEM");

        $setorDAO->salvar($setor1);
        $setorDAO->salvar($setor2);


        $operacao1 = new Operacao("TORNEAR", "TORNEAR CONFORME DESENHO", $setor1);
        $operacao2 = new Operacao("MONTAGEM", "MONTAGEM CONFORME DESENHO", $setor2);

        $operacaDAO->salvar($operacao1);
        $operacaDAO->salvar($operacao2);


        $recurso1 = new Recurso("TORNO HORIZONTAL", $setor1);
        $recurso2 = new Recurso("OPERADOR 1", $setor2);

        $recursoDAO->salvar($recurso1);
        $recursoDAO->salvar($recurso2);



        $produto = new Produto("BICICLETA", $unidadeMedida, 500.00, 2, 10.00, 5.00);

        $produto->adicionarComponente(new ItemEstrutura($produto, $material1, 2.00));
        $produto->adicionarComponente(new ItemEstrutura($produto, $material2, 5.00));



        $roteiro1 = new Roteiro($produto, 1, $operacao1, "00:00:00", "03:50:50", "00:00:00");
        $roteiro2 = new Roteiro($produto, 2, $operacao2, "00:00:00", "02:20:00", "00:00:00");


        $produto->adicionarRoteiro($roteiro1);
        $produto->adicionarRoteiro($roteiro2);



        $produtoDAO->salvar($produto);


        $ordemProducao = new OrdemProducao($produto, 10.00, new DateTime('2018-03-01'), $responsavel);
        $programacao1 = new Programacao($ordemProducao, 1, $roteiro1, $recurso1);
        $programacao2 = new Programacao($ordemProducao, 2, $roteiro2, $recurso2);
        $ordemProducao->adicionarProgramacao($programacao1);
        $ordemProducao->adicionarProgramacao($programacao2);


        $ordemProducaoDAO->salvar($ordemProducao);


        $apontamento1 = new Apontamento($programacao1, "PRODUCAO", 5.00, new DateTime("2018-02-27 14:30:00"), new DateTime("2018-02-27 16:30:00"), true);
        $apontamento2 = new Apontamento($programacao1, "DESCARTE", 5.00, new DateTime("2018-02-27 17:00:00"), new DateTime("2018-02-27 17:15:00"), true);
        $apontamento3 = new Apontamento($programacao1, "PRODUCAO", 5.00, new DateTime("2018-03-27 14:30:00"), new DateTime("2018-03-27 16:30:00"), true);
        $apontamento4 = new Apontamento($programacao2, "PRODUCAO", 5.00, new DateTime("2018-02-27 14:30:00"), new DateTime("2018-02-27 16:30:00"), false);
        $apontamento5 = new Apontamento($programacao2, "PRODUCAO", 5.00, new DateTime("2018-03-27 14:30:00"), new DateTime("2018-03-27 16:30:00"), false);


        $apontamentoDAO->salvar($apontamento1);
        $apontamentoDAO->salvar($apontamento2);
        $apontamentoDAO->salvar($apontamento3);
        $apontamentoDAO->salvar($apontamento4);
        $apontamentoDAO->salvar($apontamento5);

        $apontamentos = $apontamentoDAO->obterApontamentosPorPeriodo(new DateTime("2018-02-27 00:00:00"), new DateTime("2018-03-28 00:00:00"));
        $this->assertEquals(5.00, count($apontamentos));
    }
    
    
    
    public function testObterApontamentoPorSetor() {
        self::reset();
        $perfilDAO = new PerfilDAO();
        $usuarioDAO = new UsuarioDAO();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        $produtoDAO = new ProdutoDAO();
        $ordemProducaoDAO = new OrdemProducaoDAO();
        $setorDAO = new SetorDAO();
        $operacaDAO = new OperacaoDAO();
        $recursoDAO = new RecursoDAO();
        $apontamentoDAO = new ApontamentoDAO();


        $perfil = new Perfil("PCP");
        $perfilDAO->salvar($perfil);


        $responsavel = new Usuario("Admin", "admin", "12345", $perfil);
        $usuarioDAO->salvar($responsavel);


        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $unidadeMedidaDAO->salvar($unidadeMedida);


        $material1 = new Material("BARRA ACO INOX", $unidadeMedida, 500.50, 2, 20.00, 15.00);
        $material2 = new Material("TUBO ALUMINIO", $unidadeMedida, 475.25, 10, 30.00, 2.00);

        $materialDAO->salvar($material1);
        $materialDAO->salvar($material2);



        $setor1 = new Setor("USINAGEM");
        $setor2 = new Setor("MONTAGEM");

        $setorDAO->salvar($setor1);
        $setorDAO->salvar($setor2);


        $operacao1 = new Operacao("TORNEAR", "TORNEAR CONFORME DESENHO", $setor1);
        $operacao2 = new Operacao("MONTAGEM", "MONTAGEM CONFORME DESENHO", $setor2);

        $operacaDAO->salvar($operacao1);
        $operacaDAO->salvar($operacao2);


        $recurso1 = new Recurso("TORNO HORIZONTAL", $setor1);
        $recurso2 = new Recurso("OPERADOR 1", $setor2);

        $recursoDAO->salvar($recurso1);
        $recursoDAO->salvar($recurso2);



        $produto = new Produto("BICICLETA", $unidadeMedida, 500.00, 2, 10.00, 5.00);

        $produto->adicionarComponente(new ItemEstrutura($produto, $material1, 2.00));
        $produto->adicionarComponente(new ItemEstrutura($produto, $material2, 5.00));



        $roteiro1 = new Roteiro($produto, 1, $operacao1, "00:00:00", "03:50:50", "00:00:00");
        $roteiro2 = new Roteiro($produto, 2, $operacao2, "00:00:00", "02:20:00", "00:00:00");


        $produto->adicionarRoteiro($roteiro1);
        $produto->adicionarRoteiro($roteiro2);



        $produtoDAO->salvar($produto);


        $ordemProducao = new OrdemProducao($produto, 10.00, new DateTime('2018-03-01'), $responsavel);
        $programacao1 = new Programacao($ordemProducao, 1, $roteiro1, $recurso1);
        $programacao2 = new Programacao($ordemProducao, 2, $roteiro2, $recurso2);
        $ordemProducao->adicionarProgramacao($programacao1);
        $ordemProducao->adicionarProgramacao($programacao2);


        $ordemProducaoDAO->salvar($ordemProducao);


        $apontamento1 = new Apontamento($programacao1, "PRODUCAO", 5.00, new DateTime("2018-02-27 14:30:00"), new DateTime("2018-02-27 16:30:00"), true);
        $apontamento2 = new Apontamento($programacao1, "DESCARTE", 5.00, new DateTime("2018-02-27 17:00:00"), new DateTime("2018-02-27 17:15:00"), true);
        $apontamento3 = new Apontamento($programacao1, "PRODUCAO", 5.00, new DateTime("2018-03-27 14:30:00"), new DateTime("2018-03-27 16:30:00"), true);
        $apontamento4 = new Apontamento($programacao2, "PRODUCAO", 5.00, new DateTime("2018-02-27 14:30:00"), new DateTime("2018-02-27 16:30:00"), false);
        $apontamento5 = new Apontamento($programacao2, "PRODUCAO", 5.00, new DateTime("2018-03-27 14:30:00"), new DateTime("2018-03-27 16:30:00"), false);


        $apontamentoDAO->salvar($apontamento1);
        $apontamentoDAO->salvar($apontamento2);
        $apontamentoDAO->salvar($apontamento3);
        $apontamentoDAO->salvar($apontamento4);
        $apontamentoDAO->salvar($apontamento5);

        $apontamentos = $apontamentoDAO->obterApontamentoPorSetor(new DateTime("2018-02-27 00:00:00"), new DateTime("2018-03-28 00:00:00"));
        $this->assertNotNull($apontamentos);
    }

}
