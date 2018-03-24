<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\DAO;

use App\Entities\Perfil;

/**
 * Description of PerfilDAO
 *
 * @author HOME-PC
 */
class PerfilDAO extends GenericDAO {
    
    public function __construct() {
        parent::__construct();
        $this->className = Perfil::class;
    }
   
  
}
