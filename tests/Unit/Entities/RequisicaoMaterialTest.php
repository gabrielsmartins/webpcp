<?php

namespace Tests\Unit;

use App\Entities\ItemRequisicao;
use App\Entities\Material;
use App\Entities\Perfil;
use App\Entities\RequisicaoMaterial;
use App\Entities\UnidadeMedida;
use App\Entities\Usuario;
use DateTime;
use Tests\TestCase;

class RequisicaoMaterialTest extends TestCase {

    public function testRequisicaoMaterialPossuiDados() {
        $perfil = new Perfil("PCP");
        $responsavel = new Usuario("Admin", "admin", "12345", $perfil);
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $material1 = new Material("BARRA ACO INOX", "ATIVO", $unidadeMedida, 500.50, 2, 20.00, 15.00);
        $material2 = new Material("TUBO ALUMINIO", "ATIVO", $unidadeMedida, 475.25, 10, 30.00, 2.00);

        $requisicaoMaterial = new RequisicaoMaterial("26/02/2018", $responsavel);

        $item1 = new ItemRequisicao($requisicaoMaterial, $material1, 5.00);
        $item2 = new ItemRequisicao($requisicaoMaterial, $material2, 8.00);
        $requisicaoMaterial->adicionarItem($item1) ;
        $requisicaoMaterial->adicionarItem($item2);
        $date = new DateTime('now');
        $date->format("Y-m-d");
        $this->assertEquals($date, $requisicaoMaterial->getDataEmissao()->format("Y-m-d"));
        $this->assertEquals("26/02/2018", $requisicaoMaterial->getPrazo());
        $this->assertEquals(2, $requisicaoMaterial->getItens()->count());
        $this->assertEquals($responsavel->getLogin(), $requisicaoMaterial->getResponsavel()->getLogin());
    }

}
