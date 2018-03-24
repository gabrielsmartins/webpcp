<?php

namespace Tests\Unit;

use App\Entities\Operacao;
use App\Entities\Setor;
use Tests\TestCase;

class OperacaoTest extends TestCase {

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testOperacaoPossuiDados() {
        $setor = new Setor("Corte");
        $operacao = new Operacao("Cortar", "Cortar no comprimento", $setor);
        $this->assertEquals("Cortar", $operacao->getDescricao());
        $this->assertEquals("Cortar no comprimento", $operacao->getInstrucao());
        $this->assertEquals("Corte", $operacao->getSetor()->getDescricao());
    }

}
