<?php


namespace Tests\Unit;

use App\DAO\MaterialDAO;
use App\DAO\PerfilDAO;
use App\DAO\ProdutoDAO;
use App\DAO\RetiradaProdutoDAO;
use App\DAO\UnidadeMedidaDAO;
use App\DAO\UsuarioDAO;
use App\Entities\ItemEstrutura;
use App\Entities\ItemRetirada;
use App\Entities\Material;
use App\Entities\Perfil;
use App\Entities\Produto;
use App\Entities\RetiradaProduto;
use App\Entities\UnidadeMedida;
use App\Entities\Usuario;
use App\Util\SaldoInsuficienteException;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;


class RetiradaProdutoDAOTest extends TestCase{
    
     public static function reset(){
         $sql = "SET FOREIGN_KEY_CHECKS = 0;
                                    TRUNCATE TABLE retirada_produto_detalhe;
                                    TRUNCATE TABLE retirada_produto;
                                    TRUNCATE TABLE produto;
                                     TRUNCATE TABLE estrutura_produto;
                                    TRUNCATE TABLE unidade;
                                    TRUNCATE TABLE usuario;
                                    TRUNCATE TABLE perfil;
                                    SET FOREIGN_KEY_CHECKS = 1;";
        EntityManager::getConnection()->prepare($sql)->execute();
    }

    public function testRegistrarRetiradaProduto() {
        self::reset();
        $perfilDAO = new PerfilDAO();
        $usuarioDAO = new UsuarioDAO();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        $produtoDAO = new ProdutoDAO();
        $retiradaDAO = new RetiradaProdutoDAO();
        
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
        
        $produto = new Produto("Produto A", $unidadeMedida, 500.50, 2, 10.00, 5.00);
        
        $itemEstrutura1 = new ItemEstrutura($produto, $material1, 2.00);
        $itemEstrutura2 = new ItemEstrutura($produto, $material2, 1.00);
        
        $produto->adicionarComponente($itemEstrutura1);
        $produto->adicionarComponente($itemEstrutura2);
        
        $produtoDAO->salvar($produto);
        
        $retirada = new RetiradaProduto($responsavel);
        $itemRetirada = new ItemRetirada($retirada, $produto, 5.00);
        
        try{
             $retirada->adicionarItem($itemRetirada);
        } catch (SaldoInsuficienteException $ex) {
             echo $ex->getMessage();
        }
       
 
         $this->assertNotNull($retiradaDAO->salvar($retirada));
         $this->assertEquals(5.00,$produto->getQuantidadeEstoque());
    }
}
