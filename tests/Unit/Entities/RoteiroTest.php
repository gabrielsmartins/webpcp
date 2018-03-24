<?php

namespace Tests\Unit;

use App\Entities\Operacao;
use App\Entities\Roteiro;
use App\Entities\Setor;
use Tests\TestCase;

class RoteiroTest extends TestCase {

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRoteiroPossuiDados() {
        $setor = new Setor("USINAGEM");
        $operacao = new Operacao("TORNEAR", "TORNEAR CONFORME DESENHO", $setor);


        $sequencia = 1;
        $tempoSetup = "00:10:00";
        $tempoProducao = "01:50:00";
        $tempoFinalizacao = "00:20:00";
        


        $roteiro = new Roteiro($sequencia, $operacao, $tempoSetup, $tempoProducao, $tempoFinalizacao);

        $this->assertEquals($tempoSetup, $roteiro->getTempoSetup());
        $this->assertEquals($tempoProducao, $roteiro->getTempoProducao());
        $this->assertEquals($tempoFinalizacao, $roteiro->getTempoFinalizacao());
    }

}
