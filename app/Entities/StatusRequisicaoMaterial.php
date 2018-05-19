<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entities;

/**
 * Description of StatusRequisicaoMaterial
 *
 * @author HOME-PC
 */
abstract class StatusRequisicaoMaterial {
    const EMITIDA = 'EMITIDA';
    const CONCLUIDA_PARCIAL = 'CONCLUIDA PARCIAL';
    const CONCLUIDA_TOTAL = 'CONCLUIDA TOTAL';
    const CANCELADA = 'CANCELADA';
}
