<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                
                <img src="{{ asset('adminlte/img/user.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">


                @if(Session::has('usuarioLogado'))
                <p>{{Session::get('usuarioLogado')}}</p>
                @endif

                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <!-- ENGENHARIA -->
            <li class="header">ENGENHARIA</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="treeview">
                <a href="#"><i class="fa fa-cubes"></i> <span>Produtos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('produto/form')}}">Novo</a></li>
                    <li><a href="{{url('produto/show')}}">Consulta</a></li>
                    <li><a href="#">Relatórios</a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="#"><i class="fa fa-cube"></i> <span>Materiais</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('material/form')}}">Novo</a></li>
                    <li><a href="{{url('material/show')}}">Consulta</a></li>
                    <li><a href="#">Relatórios</a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="#"><i class="fa fa-calculator"></i> <span>Unidades de Medida</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('unidade/form')}}">Novo</a></li>
                    <li><a href="{{url('unidade/show')}}">Consulta</a></li>
                    <li><a href="#">Relatórios</a></li>
                </ul>
            </li>



            <li class="treeview">
                <a href="#"><i class="fa fa-square-o"></i> <span>Operações</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('operacao/form')}}">Novo</a></li>
                    <li><a href="{{url('operacao/show')}}">Consulta</a></li>
                    <li><a href="#">Relatórios</a></li>
                </ul>
            </li>


            <!-- PCP -->
            <li class="header">PCP</li>


            <li class="treeview">
                <a href="#"><i class="fa fa-pencil-square-o"></i> <span>Ordem de Produção</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#">Emitir</a></li>
                    <li><a href="#">Consulta</a></li>
                    <li><a href="#">Relatórios</a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="#"><i class="fa fa-file-text-o"></i> <span>Requisição de Material</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#">Emitir</a></li>
                    <li><a href="#">Consulta</a></li>
                    <li><a href="#">Relatórios</a></li>
                </ul>
            </li>


            <!-- PRODUÇÃO -->
            <li class="header">PRODUÇÃO</li>

            <li class="treeview">
                <a href="#"><i class="fa fa-wrench"></i> <span>Recursos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<c:url value='/recursos/form'/>">Novo</a></li>
                    <li><a href="<c:url value='/recursos'/>">Consulta</a></li>
                    <li><a href="#">Relatórios</a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="#"><i class="fa fa-sitemap"></i> <span>Setores</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('setor/form')}}">Novo</a></li>
                    <li><a href="{{url('setor/show')}}">Consulta</a></li>
                    <li><a href="#">Relatórios</a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="#"><i class="fa fa-clock-o"></i> <span>Apontamentos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#">Registrar</a></li>
                    <li><a href="#">Consulta</a></li>
                    <li><a href="#">Relatórios</a></li>
                </ul>
            </li>



            <!-- EXPEDIÇÃO -->
            <li class="header">EXPEDIÇÃO</li>

            <li class="treeview">
                <a href="#"><i class="fa fa-arrow-circle-left "></i> <span>Saídas</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#">Registrar</a></li>
                    <li><a href="#">Consulta</a></li>
                    <li><a href="#">Relatórios</a></li>
                </ul>
            </li>


            <!-- ALMOXARIFADO -->
            <li class="header">ALMOXARIFADO</li>

            <li class="treeview">
                <a href="#"><i class="fa fa-arrow-circle-right"></i> <span>Entradas</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#">Registrar</a></li>
                    <li><a href="#">Consulta</a></li>
                    <li><a href="#">Relatórios</a></li>
                </ul>
            </li>


            <!-- ADMIN -->
            <li class="header">ADMINISTRADOR</li>

            <li class="treeview">
                <a href="#"><i class="fa fa-user"></i> <span>Usuários</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#">Novo</a></li>
                    <li><a href="#">Consulta</a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="#"><i class="fa fa-users"></i> <span>Perfis</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#">Novo</a></li>
                    <li><a href="#">Consulta</a></li>
                </ul>
            </li>

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>