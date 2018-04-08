<?php


namespace Tests\Unit;

use App\DAO\MaterialDAO;
use App\DAO\PerfilDAO;
use App\DAO\RecebimentoMaterialDAO;
use App\DAO\RequisicaoMaterialDAO;
use App\DAO\UnidadeMedidaDAO;
use App\DAO\UsuarioDAO;
use App\Entities\ItemRecebimento;
use App\Entities\ItemRequisicao;
use App\Entities\Material;
use App\Entities\Perfil;
use App\Entities\RecebimentoMaterial;
use App\Entities\RequisicaoMaterial;
use App\Entities\UnidadeMedida;
use App\Entities\Usuario;
use DateTime;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;


class RecebimentoMaterialDAOTest extends TestCase{
    
     public static function reset(){
         $sql = "SET FOREIGN_KEY_CHECKS = 0;
                                    TRUNCATE TABLE recebimento_material_detalhe;
                                    TRUNCATE TABLE recebimento_material;
                                    TRUNCATE TABLE produto;
                                     TRUNCATE TABLE estrutura_produto;
                                    TRUNCATE TABLE unidade;
                                    TRUNCATE TABLE usuario;
                                    TRUNCATE TABLE perfil;
                                    SET FOREIGN_KEY_CHECKS = 1;";
        EntityManager::getConnection()->prepare($sql)->execute();
    }

    public function testRegistrarRecebimentoMaterial() {
        self::reset();
        $perfilDAO = new PerfilDAO();
        $usuarioDAO = new UsuarioDAO();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        $requisicaoDAO = new RequisicaoMaterialDAO();
        $recebimentoDAO = new RecebimentoMaterialDAO();
        
        $perfilPCP = new Perfil("PCP");
        $perfilExpedicao = new Perfil("EXPEDICAO");
        
        
        $perfilDAO->salvar($perfilPCP);
        $perfilDAO->salvar($perfilExpedicao);
        
        
        $responsavelPCP = new Usuario("PCP", "pcp", "12345", $perfilPCP);
        $responsavelExpedicao = new Usuario("Expedição", "expedicao", "12345", $perfilExpedicao);
        $usuarioDAO->salvar($responsavelPCP);
        $usuarioDAO->salvar($responsavelExpedicao);
        
        
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        
        $unidadeMedidaDAO->salvar($unidadeMedida);
        
        $material1 = new Material("BARRA ACO INOX", $unidadeMedida, 500.50, 2, 20.00, 15.00);
        $material2 = new Material("TUBO ALUMINIO", $unidadeMedida, 475.25, 10, 30.00, 2.00);
        
        $materialDAO->salvar($material1);
        $materialDAO->salvar($material2);
        
        
        $requisicao = new RequisicaoMaterial(new DateTime( '2018-05-10' ), $responsavelPCP);
        $itemRequisicao1 = new ItemRequisicao($requisicao, $material1, 20.00);
        $itemRequisicao2 = new ItemRequisicao($requisicao, $material2, 10.00);
        
        $requisicao->adicionarItem($itemRequisicao1);
        $requisicao->adicionarItem($itemRequisicao2);
        
        $requisicaoDAO->salvar($requisicao);
       
       
        
        $recebimento = new RecebimentoMaterial($responsavelExpedicao);
        
        
         $item1 = new ItemRecebimento($recebimento , $itemRequisicao1, 10);
         $item2 = new ItemRecebimento($recebimento , $itemRequisicao2, 5);
       
    
         $recebimento->adicionarItem($item1);
         $recebimento->adicionarItem($item2);
      
       
 
         $this->assertNotNull($recebimentoDAO->salvar($recebimento));
    }
}
