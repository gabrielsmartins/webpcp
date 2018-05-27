<nav class="side-navbar">
    <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
            <!-- User Info-->

            <div class="sidenav-header-inner text-center"><img src=" {{ asset('dashboard/img/avatar-1.jpg') }}" alt="person" class="img-fluid rounded-circle">
                <h2 class="h5">@if(Session::has('usuarioLogado')){{Session::get('usuarioLogado')}} @endif</h2><span>@if(Session::has('usuarioLogadoPerfil')){{Session::get('usuarioLogadoPerfil')}} @endif</span>
            </div>
            <!-- Small Brand information, appears on minimized sidebar-->
            <div class="sidenav-header-logo"><a href="{{url('/')}}" class="brand-small text-center"> <strong>P</strong><strong class="text-primary">W</strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->


        <!--ENGENHARIA INICIO -->
        <div class="main-menu">
            <h5 class="sidenav-heading">ENGENHARIA</h5>
            <ul id="side-main-menu" class="side-menu list-unstyled">                  
                <li><a href="#produtos" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Produtos </a>
                    <ul id="produtos" class="collapse list-unstyled ">
                        <li><a href="{{url('produto/form')}}">Novo</a></li>
                    <li><a href="{{url('produto/show')}}">Consulta</a></li>
                    </ul>
                </li>
                
                <li><a href="#materiais" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Materiais </a>
                    <ul id="materiais" class="collapse list-unstyled ">
                        <li><a href="{{url('material/form')}}">Novo</a></li>
                    <li><a href="{{url('material/show')}}">Consulta</a></li>
                    </ul>
                </li>
                
                
                
                <li><a href="#unidades" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Unidades </a>
                    <ul id="unidades" class="collapse list-unstyled ">
                         <li><a href="{{url('unidade/form')}}">Novo</a></li>
                    <li><a href="{{url('unidade/show')}}">Consulta</a></li>
                    </ul>
                </li>
                
                
                
                <li><a href="#operacoes" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Operações </a>
                    <ul id="operacoes" class="collapse list-unstyled ">
                        <li><a href="{{url('operacao/form')}}">Novo</a></li>
                    <li><a href="{{url('operacao/show')}}">Consulta</a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- ENGENHARIA FIM-->

        <!--PCP INICIO -->
        <div class="admin-menu">
            <h5 class="sidenav-heading">PCP</h5>
            <ul id="side-main-menu" class="side-menu list-unstyled">                  
                <li><a href="#op" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Ordem de Produção </a>
                    <ul id="op" class="collapse list-unstyled ">
                         <li><a href="{{url('ordem/form')}}">Novo</a></li>
                    <li><a href="{{url('ordem/show')}}">Consulta</a></li>
                    </ul>
                </li>
                
                <li><a href="#rm" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Requisição Material </a>
                    <ul id="rm" class="collapse list-unstyled ">
                         <li><a href="{{url('requisicao/form')}}">Novo</a></li>
                    <li><a href="{{url('requisicao/show')}}">Consulta</a></li>
                    </ul>
                </li>
                
                
                 <li><a href="#report" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Relatórios </a>
                    <ul id="report" class="collapse list-unstyled ">
                         <li><a href="{{url('report/filter_reportstock')}}">Estoque</a></li>
                    <li><a href="{{url('requisicao/filter_reportproduction')}}">Produção</a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!--PCP FIM -->


        <!--PRODUÇÃO INICIO -->
        <div class="admin-menu">
            <h5 class="sidenav-heading">PRODUÇÃO</h5>
            <ul id="side-main-menu" class="side-menu list-unstyled">                  
                <li><a href="#recursos" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Recursos </a>
                    <ul id="recursos" class="collapse list-unstyled ">
                         <li><a href="{{url('recurso/form')}}">Novo</a></li>
                    <li><a href="{{url('recurso/show')}}">Consulta</a></li>
                    </ul>
                </li>
                
                <li><a href="#setores" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Setores </a>
                    <ul id="setores" class="collapse list-unstyled ">
                          <li><a href="{{url('setor/form')}}">Novo</a></li>
                    <li><a href="{{url('setor/show')}}">Consulta</a></li>
                    </ul>
                </li>
                
                
                
                <li><a href="#apontamentos" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Apontamentos </a>
                    <ul id="apontamentos" class="collapse list-unstyled ">
                          <li><a href="{{url('ordem/show')}}">Registrar</a></li>
                    <li><a href="{{url('apontamento/show')}}">Consulta</a></li>
                    </ul>
                </li>
               

            </ul>
        </div>
        <!--PRODUÇÃO FIM -->


        <!--EXPEDIÇÃO INICIO -->
        <div class="admin-menu">
            <h5 class="sidenav-heading">EXPEDIÇÃO</h5>
             <ul id="side-main-menu" class="side-menu list-unstyled">                  
                <li><a href="#saidas" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Saídas </a>
                    <ul id="saidas" class="collapse list-unstyled ">
                      <li><a href="{{url('retirada/form')}}">Registrar</a></li>
                    <li><a href="{{url('retirada/show')}}">Consulta</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--EXPEDIÇÃO FIM -->


        <!--ALMOXARIFADO INICIO -->
        <div class="admin-menu">
            <h5 class="sidenav-heading">ALMOXARIFADO</h5>
           <ul id="side-main-menu" class="side-menu list-unstyled">                  
                <li><a href="#entradas" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Entradas </a>
                    <ul id="entradas" class="collapse list-unstyled ">
                       <li><a href="{{url('recebimento/form')}}">Registrar</a></li>
                    <li><a href="{{url('recebimento/show')}}">Consulta</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--ALMOXARIFADO FIM -->



        <!--ADMINISTRADOR INICIO -->
        <div class="admin-menu">
            <h5 class="sidenav-heading">ADMINISTRADOR</h5>
            <ul id="side-main-menu" class="side-menu list-unstyled">                  
                <li><a href="#usuarios" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Usuários </a>
                    <ul id="usuarios" class="collapse list-unstyled ">
                          <li><a href="{{url('usuario/form')}}">Novo</a></li>
                    <li><a href="{{url('usuario/show')}}">Consulta</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--ADMINISTRADOR FIM -->


    </div>
</nav>