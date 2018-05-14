<?php

namespace Tests\Unit;

use App\Entities\Apontamento;
use App\Entities\ItemEstrutura;
use App\Entities\Material;
use App\Entities\Operacao;
use App\Entities\OrdemProducao;
use App\Entities\Perfil;
use App\Entities\Produto;
use App\Entities\Programacao;
use App\Entities\Recurso;
use App\Entities\Roteiro;
use App\Entities\Setor;
use App\Entities\UnidadeMedida;
use App\Entities\Usuario;
use DateTime;
use Tests\TestCase;

class ApontamentoTest extends TestCase {

    public function testApontamentoPossuiDados() {
        $perfil = new Perfil("PCP");
        $responsavel = new Usuario("Admin", "admin", "12345", $perfil);
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $material1 = new Material("BARRA ACO INOX", $unidadeMedida, 500.50, 2, 20.00, 15.00);
        $material2 = new Material("TUBO ALUMINIO", $unidadeMedida, 475.25, 10, 30.00, 2.00);

        $produto = new Produto("BICICLETA", $unidadeMedida, 500.00, 2, 10.00, 5.00);

        $produto->adicionarComponente(new ItemEstrutura($produto, $material1, 2.00));
        $produto->adicionarComponente(new ItemEstrutura($produto, $material2, 5.00));

        $setor1 = new Setor("USINAGEM");
        $setor2 = new Setor("MONTAGEM");
        $operacao1 = new Operacao("TORNEAR", "TORNEAR CONFORME DESENHO", $setor1);
        $operacao2 = new Operacao("MONTAGEM", "MONTAGEM CONFORME DESENHO", $setor2);
        $recurso1 = new Recurso("TORNO HORIZONTAL", $setor1);
        $recurso2 = new Recurso("OPERADOR 1", $setor2);
        $roteiro1 = new Roteiro($produto, 1, $operacao1, "00:00:00", "03:50:50", "00:00:00");
        $roteiro2 = new Roteiro($produto, 2, $operacao2, "00:00:00", "02:20:00", "00:00:00");
        $produto->adicionarRoteiro($roteiro1);
        $produto->adicionarRoteiro($roteiro2);

        $ordemProducao = new OrdemProducao($produto, 10.00, "26/02/2018", $responsavel);



        $programacao1 = new Programacao($ordemProducao, 1, $roteiro1, $recurso1);
        $programacao2 = new Programacao($ordemProducao, 2, $roteiro2, $recurso2);
        $ordemProducao->adicionarProgramacao($programacao1);
        $ordemProducao->adicionarProgramacao($programacao2);

        $apontamento1 = new Apontamento($programacao1, "PRODUCAO", 5.00, new DateTime("2018-02-27 14:30:00"), new DateTime("2018-02-27 16:10:00"));
        $apontamento2 = new Apontamento($programacao1, "DESCARTE", 5.00, new DateTime("2018-02-27 17:30:00"), new DateTime("2018-02-27 18:10:00"));
        $apontamento3 = new Apontamento($programacao1, "PRODUCAO", 5.00, new DateTime("2018-02-28 14:30:00"), new DateTime("2018-02-28 16:10:00"));

        $date = new DateTime('now');
        $date->format("Y-m-d");
        $this->assertEquals("26/02/2018", $ordemProducao->getPrazo());
        $this->assertEquals($responsavel->getLogin(), $ordemProducao->getResponsavel()->getLogin());
        $this->assertEquals(2, $ordemProducao->getProgramacoes()->count());
        echo "\nTempo Total" . $programacao1->getTempoTotal();
        $this->assertEquals("38:28:20", $programacao1->getTempoTotal());
        $this->assertEquals(new DateTime("2018-02-27 14:30:00"), $apontamento1->getDataInicio());
        $this->assertEquals(new DateTime("2018-02-27 16:10:00"), $apontamento1->getDataFim());
        $this->assertEquals(new DateTime("2018-02-27 17:30:00"), $apontamento2->getDataInicio());
        $this->assertEquals(new DateTime("2018-02-27 18:10:00"), $apontamento2->getDataFim());
        $this->assertEquals(new DateTime("2018-02-28 14:30:00"), $apontamento3->getDataInicio());
        $this->assertEquals(new DateTime("2018-02-28 16:10:00"), $apontamento3->getDataFim());
    }

}
