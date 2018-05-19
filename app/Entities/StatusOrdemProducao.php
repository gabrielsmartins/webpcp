<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entities;

/**
 * Description of StatusOrdemProducao
 *
 * @author HOME-PC
 */
abstract class StatusOrdemProducao {

    const EMITIDA = 'EMITIDA';
    const INICIADA = 'INICIADA';
    const ENCERRADA = 'ENCERRADA';
    const CANCELADA = 'CANCELADA';

}
