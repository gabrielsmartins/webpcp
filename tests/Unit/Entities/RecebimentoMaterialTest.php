<?php



namespace Tests\Unit;

use App\Entities\ItemRecebimento;
use App\Entities\ItemRequisicao;
use App\Entities\Material;
use App\Entities\Perfil;
use App\Entities\RecebimentoMaterial;
use App\Entities\RequisicaoMaterial;
use App\Entities\UnidadeMedida;
use App\Entities\Usuario;
use DateTime;
use Tests\TestCase;


class RecebimentoMaterialTest extends TestCase {
   
    public function testRecebimentoDeMaterial() {
        $perfil = new Perfil("ALMOXARIFADO");
        $responsavel = new Usuario("User A", "usera", "12345", $perfil);
        $requisicao = new RequisicaoMaterial("26/02/2018", $responsavel);
        $recebimento = new RecebimentoMaterial($responsavel);
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $material1 = new Material("TUBO DE ACO INOX", $unidadeMedida, 500.50, 2, 20.00, 5.00);
        $material2 = new Material("BARRA DE ALUMINIO", $unidadeMedida, 375.50, 2, 10.00, 5.00);
        
        
        
        
        $itemRequisicao1 = new ItemRequisicao($requisicao, $material1, 25.00);
        $itemRequisicao2 = new ItemRequisicao($requisicao, $material2, 30.00);
        
        $requisicao->adicionarItem($itemRequisicao1);
        $requisicao->adicionarItem($itemRequisicao2);
        
        $item1 = new ItemRecebimento($recebimento, $itemRequisicao1, 10.00);
        $item2 = new ItemRecebimento($recebimento, $itemRequisicao2, 5.00);
        $recebimento->adicionarItem($item1);
        $recebimento->adicionarItem($item2);

        $this->assertEquals(2, $recebimento->getItens()->count());
        $date = new DateTime('now');
        $this->assertEquals($date->format("Y-m-d"), $recebimento->getData()->format("Y-m-d"));
        $this->assertEquals($responsavel->getLogin(), $recebimento->getResponsavel()->getLogin());
    }

}
