<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8 ">
		
			<div class="panel panel-primary">
				
				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Cliente']['Nome'] . '</strong> - <small>Id.: ' . $_SESSION['Cliente']['idSis_Usuario'] . '</small>' ?></strong></div>
				<div class="panel-body">
				
					<div class="form-group">
						<div class="row">
							<div class="col-md-2 "></div>
							<div class="col-md-8 col-lg-8">
								<!--
								<div class="col-md-3 text-left">
									<label for=""></label><br />
									<a class="btn btn-md btn-info" target="_blank" href="<?php echo base_url() . 'OrcatrataPrint/imprimir/' . $orcatrata['idApp_OrcaTrata']; ?>">
										<span class="glyphicon glyphicon-print"></span> Vers�o para Impress�o
									</a>
								</div>
								-->
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
								<!--
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
								-->
								<div class="col-md-3 text-left">
									<label for="">Or�amentos:</label>
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
								<div class="col-md-3 text-left">
									<label for="">Devolu��es:</label>
									<div class="form-group ">
										<div class="row">
											<a <?php if (preg_match("/orcatratadevcli\/listar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-md btn-success" href="<?php echo base_url() . 'orcatratadevcli/listar/' . $_SESSION['Cliente']['idSis_Usuario']; ?>">
													<span class="glyphicon glyphicon-usd"></span> List.
												</a>
											</a>
											<a <?php if (preg_match("/orcatratadevcli\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
												<a class="btn btn-md btn-warning" href="<?php echo base_url() . 'orcatratadevcli/cadastrar/' . $_SESSION['Cliente']['idSis_Usuario']; ?>">
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
					<!--
					<div class="form-group">		
						<div class="row">
							<div class="text-center t">
								<h3><?php echo '<strong>' . $_SESSION['Cliente']['NomeCliente'] . '</strong> - <small>Id.: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?></h3>
							</div>
						</div>
					</div>
					-->
					<?php } ?>
					<div class="row">
					
						<div class="col-md-12 col-lg-12">

							<div class="panel panel-primary">

								<div class="panel-heading"><strong>Or�amentos</strong></div>
								<div class="panel-body">				
								
									<?php
									if (!$list) {
									?>
										<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>orcatrata/cadastrar" role="button">
											<span class="glyphicon glyphicon-plus"></span> Cadastrar Novo Or�amento
										</a>
										<br><br>
										<div class="alert alert-info" role="alert"><b>Nenhum or�amento cadastrado</b></div>
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