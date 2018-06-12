<nav class="navbar navbar-inverse navbar-fixed-top " role="banner">
	<div class="container-fluid">
		<div class="row">

			<div class="col-md-3"></div>
			<div class="col-md-9 ">
				<div class="navbar-header ">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar1">
						<span class="sr-only">MENU</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo base_url() ?>acessofuncionario/index"> <?php echo $_SESSION['log']['NomeEmpresa2']; ?>/<?php echo $_SESSION['log']['Nome2']; ?></a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar1">

					<ul class="nav navbar-nav navbar-center">
						<!--
						<li>
							<?php echo form_open(base_url() . 'consultor/pesquisar', 'class="navbar-form navbar-left"'); ?>
							<div class="input-group">
								<span class="input-group-btn">
									<button class="btn btn-info" type="submit">
										<span class="glyphicon glyphicon-search"></span>
									</button>
								</span>
								<input type="text" placeholder="Pesquisar Cliente" class="form-control" name="Pesquisa" value="">
							</div>
							</form>
						</li>
						-->
						<!--
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-md btn-warning dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-book"></span> Agendas <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo base_url(); ?>agendafuncionario"><span class="glyphicon glyphicon-calendar"></span> Calendário</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/tarefa"><span class="glyphicon glyphicon-pencil"></span> Anotações</a></li>
								</ul>
							</div>
							<div class="btn-group" role="group" aria-label="..."> </div>
						</li>
						-->
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-md btn-success dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-user"></span> Consultores <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/consultores"><span class="glyphicon glyphicon-user"></span> Consultores</a></li>							
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/aniversariantes"><span class="glyphicon glyphicon-gift"></span> Aniversariantes</a></li>
								</ul>
							</div>
							<div class="btn-group" role="group" aria-label="..."> </div>
						</li>
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-md btn-warning dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-usd"></span> Transações <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">							
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/receitas"><span class="glyphicon glyphicon-pencil"></span> Receitas</a></li>
									<li role="separator" class="divider"></li>							
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/despesaspag"><span class="glyphicon glyphicon-pencil"></span> Despesas</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/balanco"><span class="glyphicon glyphicon-usd"></span> Balanço</a></li>
									<!--<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>consumo/cadastrar"><span class="glyphicon glyphicon-pencil"></span> Consumos</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/admin"><span class="glyphicon glyphicon-pencil"></span> Outros</a></li>
									<li role="separator" class="divider"></li>-->
								</ul>
							</div>
							<div class="btn-group" role="group" aria-label="..."> </div>
						</li>
						<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">
							<div class="btn-group">
								<button type="button" class="btn btn-md btn-primary  dropdown-toggle" data-toggle="dropdown">
									<span class="glyphicon glyphicon-list"></span> Relatórios <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/orcamento"><span class="glyphicon glyphicon-list"></span> Orçamentos</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/produtosvend"><span class="glyphicon glyphicon-list"></span> Prd. X Ent.</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/produtosdevol1"><span class="glyphicon glyphicon-list"></span> Prd. X Dev.</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/procedimento"><span class="glyphicon glyphicon-pencil"></span> Procedimentos</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/produtosempresa"><span class="glyphicon glyphicon-pencil"></span> Produtos</a></li>
									<!--<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/produtoscomp"><span class="glyphicon glyphicon-list"></span> Despesas X Prd.</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatorio/produtosdevol"><span class="glyphicon glyphicon-list"></span> Devol. X Cl. X Prd.(Desp)</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/consumo"><span class="glyphicon glyphicon-list"></span> Consumos</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/estoque"><span class="glyphicon glyphicon-list"></span> Estoque</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo base_url() ?>relatoriofuncionario/rankingvendas"><span class="glyphicon glyphicon-list"></span> RankigVendas</a></li>
									-->
								</ul>
							</div>
							<div class="btn-group" role="group" aria-label="..."> </div>
						</li>						

						<li class="btn-toolbar navbar-form navbar-right" role="toolbar" aria-label="...">

							<div class="btn-group" role="group" aria-label="...">
								<a href="<?php echo base_url(); ?>loginfuncionario/sair">
									<button type="button" class="btn btn-md btn-danger ">
										<span class="glyphicon glyphicon-log-out"></span> Sair
									</button>
								</a>
							</div>

							<div class="btn-group" role="group" aria-label="..."> </div>
						</li>

					</ul>

				</div>
			</div>
		</div>	
	</div>
</nav>
<br>
