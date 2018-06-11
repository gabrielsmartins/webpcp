<?php

namespace Tests\Unit;

use App\DAO\MaterialDAO;
use App\DAO\OrdemProducaoDAO;
use App\DAO\PerfilDAO;
use App\DAO\ProdutoDAO;
use App\DAO\UnidadeMedidaDAO;
use App\DAO\UsuarioDAO;
use App\Entities\ItemEstrutura;
use App\Entities\Material;
use App\Entities\OrdemProducao;
use App\Entities\Perfil;
use App\Entities\Produto;
use App\Entities\StatusOrdemProducao;
use App\Entities\UnidadeMedida;
use App\Entities\Usuario;
use DateTime;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

class OrdemProducaoDAOTest extends TestCase {
    
     public static function reset(){
         $sql = "SET FOREIGN_KEY_CHECKS = 0;
                                    TRUNCATE TABLE ordem_producao;
                                    TRUNCATE TABLE produto;
                                    TRUNCATE TABLE estrutura_produto;
                                    TRUNCATE TABLE unidade;
                                    TRUNCATE TABLE usuario;
                                    TRUNCATE TABLE perfil;
                                    SET FOREIGN_KEY_CHECKS = 1;";
        EntityManager::getConnection()->prepare($sql)->execute();
    }

    public function testOrdemProducaoPossuiDados() {
        self::reset();
        $perfilDAO = new PerfilDAO();
        $usuarioDAO = new UsuarioDAO();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        $produtoDAO = new ProdutoDAO();
        $ordemProducaoDAO = new OrdemProducaoDAO();
        
        
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

        $produto = new Produto("BICICLETA", $unidadeMedida, 500.00, 2, 10.00, 5.00);
        
        $produto->adicionarComponente(new ItemEstrutura($produto, $material1, 2.00));
        $produto->adicionarComponente(new ItemEstrutura($produto, $material2, 5.00));
        
        $produtoDAO->salvar($produto);
        
        $ordemProducao = new OrdemProducao($produto,10.00,new DateTime( '2018-03-01' ), $responsavel);
        
        $this->assertNotNull($ordemProducaoDAO->salvar($ordemProducao));
        $this->assertEquals(StatusOrdemProducao::EMITIDA, $ordemProducao->getStatus());
        


        
    }

}
