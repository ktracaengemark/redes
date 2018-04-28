<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
	<div class="container-fluid">
		<div class="row">

			<div class="col-md-3"></div>
			<div class="col-md-9 ">
				<div class="navbar-header ">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar1">
						<span class="sr-only">MENU</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
					</button>
					<a class="navbar-brand"> <?php echo $_SESSION['log']['NomeEmpresa2']; ?></a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar1">

					<ul class="nav navbar-nav navbar-center">

						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">

							<div class="btn-group">
								<button type="button" class="btn btn-md btn-primary  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['log']['Nome2']; ?> <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo base_url() ?>acessoconsultor/index"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['log']['Nome2']; ?></a></li>
									<li role="separator" class="divider"></li>
									<!--
									<li><a href="<?php echo base_url(); ?>agenda"><span class="glyphicon glyphicon-calendar"></span> Agendas</a></li>
									<li role="separator" class="divider"></li>
									
									<li><a href="<?php echo base_url() ?>relatorioconsultor/tarefa"><span class="glyphicon glyphicon-pencil"></span> Tarefas</a></li>
									<li role="separator" class="divider"></li>
									-->
									<!--
									<li><a href="<?php echo base_url() ?>tipobanco/cadastrar"><span class="glyphicon glyphicon-pencil"></span> Cad - Conta Corrente</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/empresaassociado"><span class="glyphicon glyphicon-pencil"></span> Cad - Associados</a></li>
									<li role="separator" class="divider"></li>
									-->
									<li><a href="<?php echo base_url(); ?>loginconsultor/sair"><span class="glyphicon glyphicon-log-out"></span> Sair</a></li>
								</ul>
							</div>

							<div class="btn-group" role="group" aria-label="..."> </div>
						</li>
						
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group" role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>relatorioconsultor/clientesusuario">
									<button type="button" class="btn btn-md btn-success ">
										<span class="glyphicon glyphicon-user"></span> Clientes
									</button>
								</a>
							</div>
							<div class="btn-group" role="group" aria-label="..."> </div>
						</li>
						
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-md btn-primary dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-pencil"></span> Cadastros <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<li><a href="<?php echo base_url() ?>orcatrata/cadastrarcli"><span class="glyphicon glyphicon-usd"></span> Vendas</a></li>
									<li role="separator" class="divider"></li>
									<!--<li><a href="<?php echo base_url(); ?>relatorioconsultor/clientesusuario"><span class="glyphicon glyphicon-pencil"></span> Vendas</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/clientes"><span class="glyphicon glyphicon-usd"></span> Clientes</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>agenda"><span class="glyphicon glyphicon-usd"></span> Consultas</a></li>
									<li role="separator" class="divider"></li>-->
																
									<li><a href="<?php echo base_url() ?>despesascons/cadastrar"><span class="glyphicon glyphicon-usd"></span> Despesas</a></li>
									<li role="separator" class="divider"></li>
									<!--<li><a href="<?php echo base_url() ?>orcatrata3/cadastrar"><span class="glyphicon glyphicon-usd"></span> Devoluções</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>devolucao/cadastrar"><span class="glyphicon glyphicon-pencil"></span> Devol(Desp)</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>consumoconsultor/cadastrar"><span class="glyphicon glyphicon-pencil"></span> Consumos</a></li>
									<li role="separator" class="divider"></li>-->
									<li><a href="<?php echo base_url() ?>relatorioconsultor/produtosconsultor"><span class="glyphicon glyphicon-pencil"></span> Produtos</a></li>
									<!--<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/admin"><span class="glyphicon glyphicon-pencil"></span> Outros</a></li>
									<li role="separator" class="divider"></li>-->
								</ul>
							</div>
							<div class="btn-group">
								<button type="button" class="btn btn-md btn-primary  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-list"></span> Relatórios <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo base_url() ?>relatorioconsultor/orcamento"><span class="glyphicon glyphicon-list"></span> Orçamentos</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorioconsultor/receitas"><span class="glyphicon glyphicon-list"></span> Orçam. X Pag.</a></li>							
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorioconsultor/produtosvend"><span class="glyphicon glyphicon-list"></span> Prd. X Ent.</a></li>
									<li role="separator" class="divider"></li>																		
									<li><a href="<?php echo base_url() ?>relatorioconsultor/despesas"><span class="glyphicon glyphicon-list"></span> Despesas</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorioconsultor/despesaspag"><span class="glyphicon glyphicon-list"></span> Despesas X Pag.</a></li>							
									<li role="separator" class="divider"></li>
									<!--<li><a href="<?php echo base_url() ?>relatorioconsultor/produtoscomp"><span class="glyphicon glyphicon-list"></span> Despesas X Prd.</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorioconsultor/devolucao1"><span class="glyphicon glyphicon-list"></span> Devoluções</a></li>
									<li role="separator" class="divider"></li>-->
									<!--<li><a href="<?php echo base_url() ?>relatorio/devolucao"><span class="glyphicon glyphicon-list"></span> Devol(Desp)</a></li>
									<li role="separator" class="divider"></li>-->							
									<li><a href="<?php echo base_url() ?>relatorioconsultor/produtosdevol1"><span class="glyphicon glyphicon-list"></span> Prd. X Dev.</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorioconsultor/orcamentorede"><span class="glyphicon glyphicon-list"></span> Orçam. Rede</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorioconsultor/despesasrede"><span class="glyphicon glyphicon-list"></span> Desp. Rede</a></li>
									<!--<li><a href="<?php echo base_url() ?>relatorioconsultor/devolucaorede"><span class="glyphicon glyphicon-list"></span> Devol. Rede</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/produtosdevol"><span class="glyphicon glyphicon-list"></span> Devol. X Cl. X Prd.(Desp)</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorioconsultor/consumo"><span class="glyphicon glyphicon-list"></span> Consumos</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorioconsultor/balanco"><span class="glyphicon glyphicon-usd"></span> Balanço</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorioconsultor/estoque"><span class="glyphicon glyphicon-list"></span> Estoque</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorioconsultor/rankingvendas"><span class="glyphicon glyphicon-list"></span> RankigVendas</a></li>
									-->
								</ul>
							</div>
							<!--
							<div class="btn-group" role="group" aria-label="...">
								<a href="<?php echo base_url() ?>loginempresafilial/index">
									<button type="button" class="btn btn-md active " id="countdowndiv">
										<span class="glyphicon glyphicon-hourglass" id="clock"></span>
									</button>
								</a>
							</div>
							-->
							<div class="btn-group" role="group" aria-label="..."> </div>
						</li>
						<!--
						<li class="btn-toolbar navbar-form navbar-right" role="toolbar" aria-label="...">

							<div class="btn-group" role="group" aria-label="...">
								<a href="<?php echo base_url() ?>loginempresafilial/index">
									<button type="button" class="btn btn-md active " id="countdowndiv">
										<span class="glyphicon glyphicon-hourglass" id="clock"></span>
									</button>
								</a>
							</div>

							<div class="btn-group" role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>relatorio/sistema">
									<button type="button" class="btn btn-md btn-primary ">
										<span class="glyphicon glyphicon-cog"></span> Indicar
									</button>
								</a>
							</div>

							<div class="btn-group" role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>login/sair">
									<button type="button" class="btn btn-md btn-danger ">
										<span class="glyphicon glyphicon-log-out"></span> Sair
									</button>
								</a>
							</div>

							<div class="btn-group" role="group" aria-label="..."> </div>
						</li>
						-->
					</ul>

				</div>
			</div>
		</div>	
	</div>
</nav>
<br>
