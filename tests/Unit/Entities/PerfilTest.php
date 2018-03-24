<?php

namespace Tests\Unit;

use App\Entities\Perfil;
use Tests\TestCase;

class PerfilTest extends TestCase {

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPerfilPossuiDados() {
        $perfil = new Perfil("PCP");
        $this->assertEquals("PCP", $perfil->getDescricao());
    }

}
