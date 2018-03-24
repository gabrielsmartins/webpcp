<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tests\Unit;

use App\DAO\PerfilDAO;
use App\Model\Perfil;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

/**
 * Description of PerfilTest
 *
 * @author HOME-PC
 */
class GenericDAOTest extends TestCase {
    
  
    
 
    public function testObterEntityManager() {
        $entityManager = App::make('Doctrine\ORM\EntityManagerInterface');
        $perfilDAO = new PerfilDAO($entityManager);
        $this->assertNotNull($perfilDAO);
    }

    

}
