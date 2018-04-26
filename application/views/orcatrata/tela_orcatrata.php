<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
		
			<div class="panel panel-primary">
				
				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Cliente']['Nome'] . '</strong> - <small>Id.: ' . $_SESSION['Cliente']['idSis_Usuario'] . '</small>' ?></strong></div>
				<div class="panel-body">
				
					<nav class="navbar navbar-inverse">
					  <div class="container-fluid">
						<div class="navbar-header">
						  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span> 
						  </button>
						  <a class="navbar-brand" href="#">Menu </a>
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-center">
						
								<li class="btn-toolbar navbar-form" role="toolbar" aria-label="...">

									<div class="btn-group">
										<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-user"></span> Cliente <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
													<a href="<?php echo base_url() . 'clienteusuario/prontuario/' . $_SESSION['Cliente']['idSis_Usuario']; ?>">
														<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/clienteusuario\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a href="<?php echo base_url() . 'clienteusuario/alterar/' . $_SESSION['Cliente']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Edit.
												</a>
											</a>
											</li>
										</ul>
									</div>
									<div class="btn-group">
										<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-usd"></span> Orçamentos <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
													<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idSis_Usuario']; ?>">
														<span class="glyphicon glyphicon-usd"></span> List.
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
													<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idSis_Usuario']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Cad.
													</a>
												</a>
											</li>
										</ul>
									</div>

									<div class="btn-group" role="group" aria-label="..."> </div>
								</li>
							</ul>
							<!--
							<ul class="nav navbar-nav navbar-right">
								<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
								<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
							</ul>
							-->
						</div>
					  </div>
					</nav>
					<!--				
					<div class="form-group">
						<div class="row">
							<div class="col-md-2 "></div>
							<div class="col-md-8 col-lg-10">
								<div class="col-md-3 text-left">
									<label for="">Cliente:</label>
									<div class="form-group">
										<div class="row">
											<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
												<a class="btn btn-md btn-success" href="<?php echo base_url() . 'clienteusuario/prontuario/' . $_SESSION['Cliente']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
												</a>
											</a>
											<a <?php if (preg_match("/clienteusuario\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'clienteusuario/alterar/' . $_SESSION['Cliente']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Edit.
												</a>
											</a>
										</div>
									</div>									
								</div>
								
								<div class="col-md-3 text-left">
									<label for="">Agendamentos:</label>
									<div class="form-group">
										<div class="row">
											<a <?php if (preg_match("/consulta\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-md btn-success" href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-calendar"></span> List.
												</a>
											</a>
											<a <?php if (preg_match("/consulta\/(cadastrar|alterar)\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'consulta/cadastrar/' . $_SESSION['Cliente']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-plus"></span> Cad.
												</a>
											</a>
										</div>	
									</div>	
								</div>
								
								<div class="col-md-3 text-left">
									<label for="">Orçamentos:</label>
									<div class="form-group ">
										<div class="row">
											<a <?php if (preg_match("/orcatrata\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-md btn-success" href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-usd"></span> List.
												</a>
											</a>
											<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-plus"></span> Cad.
												</a>
											</a>
										</div>		
									</div>	
								</div>
							</div>
							<div class="col-md-2"></div>
						</div>
					</div>
					-->

					<?php } ?>
					<div class="row">
					
						<div class="col-md-12 col-lg-12">

							<div class="panel panel-primary">

								<div class="panel-heading"><strong>Orçamentos</strong></div>
								<div class="panel-body">				
								
									<?php
									if (!$list) {
									?>
										<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>orcatrata/cadastrar" role="button">
											<span class="glyphicon glyphicon-plus"></span> Cadastrar Novo Orçamento
										</a>
										<br><br>
										<div class="alert alert-info" role="alert"><b>Nenhum orçamento cadastrado</b></div>
									<?php
									} else {
										echo $list;
									}
									?>

								</div>
							</div>		
						</div>
					</div>									
				</div>	
			</div>

		</div>
		<div class="col-md-2"></div>
	</div>	
</div>