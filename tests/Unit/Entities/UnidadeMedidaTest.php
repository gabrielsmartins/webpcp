<?php

namespace Tests\Unit;

use App\Entities\UnidadeMedida;
use Tests\TestCase;

class UnidadeMedidaTest extends TestCase {

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUnidadeMedidaPossuiDados() {
        $unidadeMedida = new UnidadeMedida("Unidade", "UN");
        $this->assertEquals("Unidade", $unidadeMedida->getDescricao());
        $this->assertEquals("UN", $unidadeMedida->getSigla());
    }

}
