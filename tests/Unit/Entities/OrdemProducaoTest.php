<?php

namespace Tests\Unit;

use App\Entities\ItemEstrutura;
use App\Entities\Material;
use App\Entities\OrdemProducao;
use App\Entities\Perfil;
use App\Entities\Produto;
use App\Entities\UnidadeMedida;
use App\Entities\Usuario;
use DateTime;
use Tests\TestCase;

class OrdemProducaoTest extends TestCase {

    public function testOrdemProducaoPossuiDados() {
        $perfil = new Perfil("PCP");
        $responsavel = new Usuario("Admin", "admin", "12345", $perfil);
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $material1 = new Material("BARRA A�O INOX" , $unidadeMedida, 500.50, 2, 20.00, 15.00);
        $material2 = new Material("TUBO ALUMINIO", $unidadeMedida, 475.25, 10, 30.00, 2.00);

        $produto = new Produto("BICICLETA", $unidadeMedida, 500.00, 2, 10.00, 5.00);
        
        $produto->adicionarComponente(new ItemEstrutura($produto, $material1, 2.00));
        $produto->adicionarComponente(new ItemEstrutura($produto, $material2, 5.00));
        
        $ordemProducao = new OrdemProducao($produto,10.00,"26/02/2018", $responsavel);


        $this->assertEquals(new \DateTime('now'), $ordemProducao->getDataEmissao());
        $this->assertEquals("26/02/2018", $ordemProducao->getPrazo());
        $this->assertEquals(2, $ordemProducao->getItens()->count());
        $this->assertEquals($responsavel->getLogin(), $ordemProducao->getResponsavel()->getLogin());
    }

}
