<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entities;

/**
 * Description of PerfilEnum
 *
 * @author HOME-PC
 */
abstract class PerfilEnum {

    const ADMIN = 'ADMINISTRADOR';
    const PROGRAMADOR_PCP = 'PROGRAMADOR PCP';
    const GERENTE_PCP = 'GERENTE PCP';
    const PRODUCAO = 'PRODUCAO';
    const ALMOXARIFADO = 'ALMOXARIFADO';
    const EXPEDICAO = 'EXPEDICAO';
    const ENGENHARIA = 'ENGENHARIA';
}
