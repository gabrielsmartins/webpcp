<?php

namespace Tests\Unit;

use App\Entities\Setor;
use Tests\TestCase;

class SetorTest extends TestCase {

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSetorPossuiDados() {
        $setor = new Setor("USINAGEM");
        $this->assertEquals("USINAGEM", $setor->getDescricao());
    }

}
