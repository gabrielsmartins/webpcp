<?php

namespace Tests\Unit;

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

class ProgramacaoTest extends TestCase {

    public function testProgramacaoPossuiDados() {
        $perfil = new Perfil("PCP");
        $responsavel = new Usuario("Admin", "admin", "12345", $perfil);
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $material1 = new Material("BARRA A�O INOX" , $unidadeMedida, 500.50, 2, 20.00, 15.00);
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
        
        $ordemProducao = new OrdemProducao($produto,10.00,"26/02/2018", $responsavel);
        

            
        $programacao1 = new Programacao($ordemProducao,1, $roteiro1, $recurso1);
        $programacao2 = new Programacao($ordemProducao,2, $roteiro2, $recurso2);
        $ordemProducao->adicionarProgramacao($programacao1); 
        $ordemProducao->adicionarProgramacao($programacao2); 
       
       

        $date = new DateTime('now');
        $date->format("Y-m-d");
        $this->assertEquals("26/02/2018", $ordemProducao->getPrazo());
        $this->assertEquals($responsavel->getLogin(), $ordemProducao->getResponsavel()->getLogin());
        $this->assertEquals(2,$ordemProducao->getProgramacoes()->count());
        echo "\nTempo Total" . $programacao1->getTempoTotal();
        $this->assertEquals("38:28:20",$programacao1->getTempoTotal());
    }

}
