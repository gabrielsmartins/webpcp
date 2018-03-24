<?php

namespace Tests\Unit;

use App\Entities\Recurso;
use App\Entities\Setor;
use Tests\TestCase;

class RecursoTest extends TestCase {

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRecursoPossuiDados() {
        $setor = new Setor("USINAGEM");
        $recurso = new Recurso("TORNO HORIZONTAL", $setor);
        $this->assertEquals("TORNO HORIZONTAL", $recurso->getDescricao());
        $this->assertEquals($setor->getDescricao(), $recurso->getSetor()->getDescricao());
    }

}
