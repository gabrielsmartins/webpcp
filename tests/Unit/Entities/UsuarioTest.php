<?php

namespace Tests\Unit;

use App\Entities\Perfil;
use App\Entities\Usuario;
use Tests\TestCase;

class UsuarioTest extends TestCase {

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUsuarioPossuiDados() {
        $perfil = new Perfil("PCP");
        $usuario = new Usuario("Usuario 1", "usuario", "12345", $perfil);
        $this->assertEquals("Usuario 1", $usuario->getNome());
        $this->assertEquals("usuario", $usuario->getLogin());
        $this->assertEquals("12345", $usuario->getSenha());
        $this->assertEquals("PCP", $usuario->getPerfil()->getDescricao());
    }

}
