<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entities;

/**
 * Description of TipoApontamento
 *
 * @author HOME-PC
 */
abstract class TipoApontamento {

    const PRODUCAO = 'PRODUCAO';
    const MANUTENCAO = 'MANUTENCAO';
    const PARADA = 'PARADA';
    const DESCARTE = 'DESCARTE';

}
