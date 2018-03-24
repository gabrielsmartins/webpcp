<?php

namespace Tests\Unit;

use App\DAO\MaterialDAO;
use App\DAO\PerfilDAO;
use App\DAO\RequisicaoMaterialDAO;
use App\DAO\UnidadeMedidaDAO;
use App\DAO\UsuarioDAO;
use App\Entities\ItemRequisicao;
use App\Entities\Material;
use App\Entities\Perfil;
use App\Entities\RequisicaoMaterial;
use App\Entities\UnidadeMedida;
use App\Entities\Usuario;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Tests\TestCase;

class RequisicaoMaterialDAOTest extends TestCase {
    
    public static function reset(){
         $sql = "SET FOREIGN_KEY_CHECKS = 0;
                                    TRUNCATE TABLE requisicao_material_detalhe;
                                    TRUNCATE TABLE requisicao_material;
                                    TRUNCATE TABLE produto;
                                    TRUNCATE TABLE unidade;
                                    TRUNCATE TABLE usuario;
                                    TRUNCATE TABLE perfil;
                                    SET FOREIGN_KEY_CHECKS = 1;";
        EntityManager::getConnection()->prepare($sql)->execute();
    }

    public function testEmitirRequisicaoMaterial() {
        self::reset();
        $perfilDAO = new PerfilDAO();
        $usuarioDAO = new UsuarioDAO();
        $unidadeMedidaDAO = new UnidadeMedidaDAO();
        $materialDAO = new MaterialDAO();
        $requisicaoMaterialDAO = new RequisicaoMaterialDAO();
        
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

        $requisicaoMaterial = new RequisicaoMaterial(new \DateTime( '2018-03-01' ), $responsavel);

        $item1 = new ItemRequisicao($requisicaoMaterial, $material1, 5.00);
        $item2 = new ItemRequisicao($requisicaoMaterial, $material2, 8.00);
        $requisicaoMaterial->adicionarItem($item1) ;
        $requisicaoMaterial->adicionarItem($item2);

        
         $this->assertNotNull($requisicaoMaterialDAO->salvar($requisicaoMaterial));
    }

}
