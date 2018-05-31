<?php

namespace App\Http\Controllers;

use App\DAO\PerfilDAO;
use App\DAO\UsuarioDAO;
use App\Entities\Usuario;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use function redirect;
use function view;

class UsuarioController extends Controller {

    private $usuarioDAO;
    private $perfilDAO;
    
    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
        $this->perfilDAO = new PerfilDAO();
    }

    public function login(Request $request) {
        $login = $request->input('login');
        $senha = md5($request->input('senha'));

        $usuario = $this->usuarioDAO->autenticarUsuario($login, $senha);

        if ($usuario != null) {
            $request->session()->put('usuarioLogado', $usuario->getNome());
            $request->session()->put('usuarioLogadoPerfil', $usuario->getPerfil()->getDescricao());
            $request->session()->put('idUsuarioLogado', $usuario->getId());
            
            return redirect('home');
        } else {
            return redirect("/")->with('error', 'Usuario ou Senha Inválidos !!!')->withInput($request->except('senha'));
        }
    }

    public function logout(Request $request) {
        $request->session()->forget('usuarioLogado');
        $request->session()->flush();
         return redirect("/")->with('success', 'Obrigado por utilizar o PCPWeb !!!');
    }
    
    
    
     public function form() {
        $perfis = $this->perfilDAO->listar();
        return view('usuario.cadastro')->with(array('perfis'=>$perfis));
    }
    

    public function store(Request $request) {
        $nome = mb_strtoupper($request->input('nome'),'UTF-8');
        $login = $request->input('login');
        $perfil = $this->perfilDAO->pesquisar($request->input('perfil'));
        $senha = md5($request->input('senha'));
        $confirmacaoSenha = md5($request->input('confirmacao_senha'));
        
        if($senha != $confirmacaoSenha){
            return redirect('usuario/form')->with('error', 'Senha e Confirmação de Senha Não Conferem !!!');
        }
        

        $usuario = new Usuario($nome, $login, $senha, $perfil);

        try{
             $this->usuarioDAO->salvar($usuario);
             return redirect('usuario/form')->with('success', 'Usuário Salvo com Sucesso !!!');
        } catch (Exception $ex) {
              return redirect('usuario/form')->with('error', 'Usuário Já Cadastrado !!!')->withInput($request->except(['senha','confirmacao_senha']));
        }
    }
    
    
    public function update(Request $request) {
        $id = $request->input('id');
        $nome = mb_strtoupper($request->input('nome'),'UTF-8');
        $login = $request->input('login');
        $perfil = $this->perfilDAO->pesquisar($request->input('perfil'));
        $senha = md5($request->input('senha'));
        $confirmacaoSenha = md5($request->input('confirmacao_senha'));
        
        $usuario = new Usuario($nome, $login, $senha, $perfil);
        $usuario->setId($id);
        
        if($senha != $confirmacaoSenha){
           return redirect()->action('UsuarioController@edit', ['id' => $usuario->getId()])->with('error', 'Senha e Confirmação de Senha Não Conferem !!!');
        }

        

        try{
             $this->usuarioDAO->alterar($usuario);
             return redirect()->action('UsuarioController@edit', ['id' => $usuario->getId()])->with('success', 'Usuário Alterado com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('UsuarioController@edit', ['id' => $usuario->getId()])->with('error', 'Falha Ao Alterar Usuário !!!' . $ex->getMessage());
        }
    }
    
    public function edit($id){
        $usuario = $this->usuarioDAO->pesquisar($id);
        $perfis = $this->perfilDAO->listar();
        $data = array('usuario'=>$usuario,'perfis'=>$perfis);
        return view('usuario.editar')->with($data);
    }
    
    
    public function show(Request $request){
        $page = (int)  $request->input('page');
        if($page!=0){
            $usuarios = $this->usuarioDAO->listarComPaginacao(10,$page);
        }else{
            $usuarios = $this->usuarioDAO->listarComPaginacao();
        }
        return view('usuario.lista')->with('usuarios', $usuarios);
    }
    
    
    public function enable(Request $request){
        $usuario = $this->usuarioDAO->pesquisar($request->input('id'));
        
        $usuario->setAtivo(true);

       try{
             $this->usuarioDAO->alterar($usuario);
             return redirect()->action('UsuarioController@show')->with('success', 'Usuário Ativado com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('UsuarioController@show')->with('error', 'Falha Ao Ativar Usuário');
        }
    }
    
    public function disable(Request $request){
        $usuario = $this->usuarioDAO->pesquisar($request->input('id'));
        
        $usuario->setAtivo(false);

       try{
             $this->usuarioDAO->alterar($usuario);
             return redirect()->action('UsuarioController@show')->with('success', 'Usuário Desativado com Sucesso !!!');
        } catch (Exception $ex) {
             return redirect()->action('UsuarioController@show')->with('error', 'Falha Ao Desativar Usuário');
        }
    }
    
     
    
    public function pesquisarPorCriterio(Request $request){
        $criterio = $request->input('criterio');
        $valor = $request->input('valor');
        $limit = (int) $request->input('limit');
        $page = (int) $request->input('page');
        $usuarios = $this->usuarioDAO->pesquisarPorCriterio($criterio,$valor,$limit,$page);
        
        $data = array('usuarios'=>$usuarios,'criterio'=>$criterio,'valor'=>$valor,'limit'=>$limit,'page'=>$page);
        return view('usuario.lista')->with($data);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

}
