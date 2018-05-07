<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Consultor'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
		
			<div class="panel panel-primary">
				
				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Consultor']['NomeConsultor'] . '</strong> - <small>Id.: ' . $_SESSION['Consultor']['idApp_Consultor'] . '</small>' ?></strong></div>
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
											<span class="glyphicon glyphicon-user"></span> Consultor <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
													<a href="<?php echo base_url() . 'consultor/prontuario/' . $_SESSION['Consultor']['idApp_Consultor']; ?>">
														<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/consultor\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
													<a href="<?php echo base_url() . 'consultor/alterar/' . $_SESSION['Consultor']['idApp_Consultor']; ?>">
														<span class="glyphicon glyphicon-edit"></span> Editar
													</a>
												</a>
											</li>
										</ul>
									</div>
									<div class="btn-group">
										<button type="button" class="btn btn-sm btn-default  dropdown-toggle" data-toggle="dropdown">
											<span class="glyphicon glyphicon-usd"></span> Or�amentos <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/orcatratacons\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
													<a href="<?php echo base_url() . 'orcatratacons/listar/' . $_SESSION['Consultor']['idApp_Consultor']; ?>">
														<span class="glyphicon glyphicon-usd"></span> Listar
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/orcatratacons\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
													<a href="<?php echo base_url() . 'orcatratacons/cadastrar/' . $_SESSION['Consultor']['idApp_Consultor']; ?>">
														<span class="glyphicon glyphicon-plus"></span> Cadastrar
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

					<?php } ?>
					<div class="row">
						<div class="col-md-12 col-lg-12">
							<div class="panel panel-primary">
								<div class="panel-heading"><strong>Or�amentos</strong></div>
								<div class="panel-body">

									<div>

										<!-- Nav tabs -->
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" class="active" ><a href="#proxima" aria-controls="proxima" role="tab" data-toggle="tab">Aprovados</a></li>
											<li role="presentation" ><a href="#anterior" aria-controls="anterior" role="tab" data-toggle="tab">N�o Aprovados</a></li>
										</ul>

										<!-- Tab panes -->
										<div class="tab-content">

											<!-- Pr�ximas Consultas -->
											<div role="tabpanel" class="tab-pane active " id="proxima">

												<?php
												if ($aprovado) {

													foreach ($aprovado->result_array() as $row) {
												?>

												<div class="bs-callout bs-callout-success" id=callout-overview-not-both>

													<a class="btn btn-success" href="<?php echo base_url() . 'orcatratacons/alterar/' . $row['idApp_OrcaTrataCons'] ?>" role="button">
														<span class="glyphicon glyphicon-edit"></span> Editar Dados
													</a>
													
														
													<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrintcons/imprimir/' . $row['idApp_OrcaTrataCons']; ?>" role="button">
														<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
													</a>
													

													<br><br>

													<h4>
														<span class="glyphicon glyphicon-tags"></span> <b>N� Or�.:</b> <?php echo $row['idApp_OrcaTrataCons']; ?>
													</h4>
													<h5>
														<span class="glyphicon glyphicon-calendar"></span> <b>Data do Or�amento:</b> <?php echo $row['DataOrca']; ?>
													</h5>

													<p>
														<?php if ($row['ProfissionalOrca']) { ?>
														<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
														<?php } if ($row['AprovadoOrca']) { ?>
														<span class="glyphicon glyphicon-thumbs-up"></span> <b>Or�. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
														<?php } ?>

													</p>
													<p>
														<?php if ($row['ServicoConcluido']) { ?>
														<span class="glyphicon glyphicon-ok"></span> <b>Or�. Conclu�do?</b> <?php echo $row['ServicoConcluido']; ?>
														<?php } ?>
													</p>
													<p>
														<?php if ($row['QuitadoOrca']) { ?>
														<span class="glyphicon glyphicon-usd"></span> <b>Or�. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
														<?php } ?>
													</p>
													<p>
														<span class="glyphicon glyphicon-pencil"></span> <b>Obs:</b> <?php echo nl2br($row['ObsOrca']); ?>
													</p>

												</div>

												<?php
													}
												} else {
													echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
												}
												?>

											</div>

											<!-- Hist�rico de Consultas -->
											<div role="tabpanel" class="tab-pane " id="anterior">

												<?php
												if ($naoaprovado) {

													foreach ($naoaprovado->result_array() as $row) {
												?>

												<div class="bs-callout bs-callout-danger" id=callout-overview-not-both>

													<a class="btn btn-danger" href="<?php echo base_url() . 'orcatratacons/alterar/' . $row['idApp_OrcaTrataCons'] ?>" role="button">
														<span class="glyphicon glyphicon-edit"></span> Editar Dados
													</a>
													
													<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrintcons/imprimir/' . $row['idApp_OrcaTrataCons']; ?>" role="button">
														<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
													</a>

													<br><br>

													<h4>
														<span class="glyphicon glyphicon-tags"></span> <b>N� Or�.:</b> <?php echo $row['idApp_OrcaTrataCons']; ?>
													</h4>
													<h5>
														<span class="glyphicon glyphicon-calendar"></span> <b>Data do Or�amento:</b> <?php echo $row['DataOrca']; ?>
													</h5>

													<p>
														<?php if ($row['ProfissionalOrca']) { ?>
														<span class="glyphicon glyphicon-user"></span> <b>Profissional:</b> <?php echo $row['ProfissionalOrca']; ?> -
														<?php } if ($row['AprovadoOrca']) { ?>
														<span class="glyphicon glyphicon-thumbs-up"></span> <b>Or�. Aprovado?</b> <?php echo $row['AprovadoOrca']; ?>
														<?php } ?>
													</p>
													<p>
														<?php if ($row['ServicoConcluido']) { ?>
														<span class="glyphicon glyphicon-ok"></span> <b>Or�. Conclu�do?</b> <?php echo $row['ServicoConcluido']; ?>
														<?php } ?>
													</p>
													<p>
														<?php if ($row['QuitadoOrca']) { ?>
														<span class="glyphicon glyphicon-usd"></span> <b>Or�. Quitado?</b> <?php echo $row['QuitadoOrca']; ?>
														<?php } ?>
													</p>
													<p>
														<span class="glyphicon glyphicon-pencil"></span> <b>Obs:</b> <?php echo nl2br($row['ObsOrca']); ?>
													</p>

												</div>

												<?php
													}
												} else {
													echo '<br><div class="alert alert-info text-center" role="alert"><b>Nenhum registro</b></div>';
												}
												?>

											</div>

										</div>

									</div>
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
