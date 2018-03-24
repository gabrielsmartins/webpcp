<?php

namespace Tests\Unit;

use App\Entities\Material;
use App\Entities\UnidadeMedida;
use Tests\TestCase;

class MaterialTest extends TestCase {

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMaterialPossuiDados() {
        $unidadeMedida = new UnidadeMedida("Unidade", "UN");
        $material = new Material("Chapa ACO #20", $unidadeMedida, 50.00, 2, 50.00, 25.00);
        $material->setCodigoInterno("CHA-50");
        $material->setPeso(0.5);
        $material->setAltura(2.0);
        $material->setComprimento(500.00);
        $material->setLargura(200.00);
        $this->assertEquals("Chapa ACO #20", $material->getDescricao());
        $this->assertEquals("CHA-50", $material->getCodigoInterno());
        $this->assertEquals("Unidade", $material->getUnidadeMedida()->getDescricao());
        $this->assertEquals("UN", $material->getUnidadeMedida()->getSigla());
        $this->assertEquals(50.00, $material->getValorUnitario(), 0);
        $this->assertEquals(2, $material->getLeadTime(), 0);
        $this->assertEquals(50.00, $material->getQuantidadeEstoque(), 0);
        $this->assertEquals(25.00, $material->getQuantidadeMinima(), 0);
        $this->assertEquals(0.5, $material->getPeso(), 0);
        $this->assertEquals(2.0, $material->getAltura(), 0);
        $this->assertEquals(500.0, $material->getComprimento(), 0);
        $this->assertEquals(200.0, $material->getLargura(), 0);
        $this->assertEquals("ATIVO", $material->getSituacao());
    }

}
