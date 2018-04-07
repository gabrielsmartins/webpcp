<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tests\Unit;

use App\Entities\ItemRetirada;
use App\Entities\Perfil;
use App\Entities\Produto;
use App\Entities\RetiradaProduto;
use App\Entities\UnidadeMedida;
use App\Entities\Usuario;
use App\Util\SaldoInsuficienteException;
use DateTime;
use Tests\TestCase;

class RetiradaProdutoTest extends TestCase {

    public function testRetirarProdutoEstoqueComSaldoSuficiente() {
        $perfil = new Perfil("EXPEDICAO");
        $usuario = new Usuario("User A", "usera", "12345", $perfil);
        $retirada = new RetiradaProduto($usuario);
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $produto1 = new Produto("Produto A", $unidadeMedida, 500.50, 2, 20.00, 5.00);
        $produto2 = new Produto("Produto B", $unidadeMedida, 375.50, 2, 10.00, 5.00);
        $item1 = new ItemRetirada($retirada, $produto1, 10.00);
        $item2 = new ItemRetirada($retirada, $produto2, 5.00);
        $retirada->adicionarItem($item1);
        $retirada->adicionarItem($item2);

        $this->assertEquals(2, $retirada->getItens()->count());
        $date = new DateTime('now');
        $this->assertEquals($date->format("Y-m-d"), $retirada->getData()->format("Y-m-d"));
        $this->assertEquals($usuario->getLogin(), $retirada->getResponsavel()->getLogin());
    }


    public function testRetirarProdutoEstoqueComSaldoInsuficiente() {
        $perfil = new Perfil("EXPEDICAO");
        $usuario = new Usuario("User A", "usera", "12345", $perfil);
        $retirada = new RetiradaProduto($usuario);
        $unidadeMedida = new UnidadeMedida("UNIDADE", "UN");
        $produto1 = new Produto("Produto A", $unidadeMedida, 500.50, 2, 20.00, 5.00);
        $produto2 = new Produto("Produto B", $unidadeMedida, 375.50, 2, 10.00, 5.00);
        $item1 = new ItemRetirada($retirada, $produto1, 10.00);
        $item2 = new ItemRetirada($retirada, $produto2, 15.00);

        try {
            $retirada->adicionarItem($item1);
            $retirada->adicionarItem($item2);
        } catch (SaldoInsuficienteException $ex) {
            echo $ex->getMessage();
            return;
        }
        
        $this->fail();
    }

}
