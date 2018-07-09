<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Consultor'])) { ?>

<div class="container-fluid">
	<div class="row">

		<div class="col-md-2"></div>
		<div class="col-md-8">

			

				

				
					<nav class="navbar navbar-inverse">
					  <div class="container-fluid">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<a class="navbar-brand" href="<?php echo base_url() . 'consultor/prontuario/' . $_SESSION['Consultor']['idApp_Consultor']; ?>">
								<?php echo '<small>' . $_SESSION['Consultor']['NomeConsultor'] . '</small> - <small>' . $_SESSION['Consultor']['idApp_Consultor'] . '</small>' ?> 
							</a>
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">

							<ul class="nav navbar-nav navbar-center">
								<li>
									<a href="<?php echo base_url() . 'consultor/alterar/' . $_SESSION['Consultor']['idApp_Consultor']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Edit. Consultor
									</a>
								</li>
								<li>
									<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Consultor']['idApp_Consultor']; ?>">
										<span class="glyphicon glyphicon-usd"></span> Listar Orçams.
									</a>
								</li>
								<li>
									<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Consultor']['idApp_Consultor']; ?>">
										<span class="glyphicon glyphicon-plus"></span> Cad. Orçam.
									</a>
								</li>
							</ul>

						</div>
					  </div>
					</nav>

					<?php } ?>

					<div class="row">

						<div class="col-md-12 col-lg-12">

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading"><strong>Usuário</strong></div>
								<div class="panel-body">
									<table class="table table-user-information">
										<tbody>

											<?php

											if ($query['NomeConsultor']) {

											echo '
											<tr>
												<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Consultor:</td>
												<td>' . $query['NomeConsultor'] . '</td>
											</tr>
											';

											}

											if ($query['DataNascimento']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-gift"></span> Data de Nascimento:</td>
													<td>' . $query['DataNascimento'] . '</td>
											</tr>
											<tr>
												<td><span class="glyphicon glyphicon-gift"></span> Idade:</td>
													<td>' . $query['Idade'] . ' anos</td>
											</tr>
											';

											}

											if ($query['Celular']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-phone-alt"></span> Celular:</td>
												<td>' . $query['Celular'] . '</td>
											</tr>
											';

											}

											if ($query['Sexo']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-heart"></span> Sexo:</td>
												<td>' . $query['Sexo'] . '</td>
											</tr>
											';

											}

											if ($query['Email']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-envelope"></span> E-mail:</td>
												<td>' . $query['Email'] . '</td>
											</tr>
											';

											}
											
											if ($query['Endereco']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-home"></span> Endereço:</td>
												<td>' . $query['Endereco'] . '</td>
											</tr>
											';

											}
											
											if ($query['Bairro']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-home"></span> Bairro:</td>
												<td>' . $query['Bairro'] . '</td>
											</tr>
											';

											}
											
											if ($query['Municipio']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-home"></span> Município:</td>
												<td>' . $query['Municipio'] . '</td>
											</tr>
											';

											}
											
											if ($query['Estado']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-home"></span> UF:</td>
												<td>' . $query['Estado'] . '</td>
											</tr>
											';

											}
											
											if ($query['Cep']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-home"></span> Cep:</td>
												<td>' . $query['Cep'] . '</td>
											</tr>
											';

											}

											/*
											if ($query['Permissao']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-alert"></span> Nível:</td>
												<td>' . $query['Permissao'] . '</td>
											</tr>
											';

											}
											
											if ($query['Funcao']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-alert"></span> Função:</td>
												<td>' . $query['Funcao'] . '</td>
											</tr>
											';

											}
											*/
											if ($query['Inativo']) {

											echo '
											<tr>
												<td><span class="glyphicon glyphicon-alert"></span> Ativo?:</td>
												<td>' . $query['Inativo'] . '</td>
											</tr>
											';

											}

											?>

										</tbody>
									</table>

									<div class="row">

										<div class="col-md-12 col-lg-12">

											<div class="panel panel-primary">

												<div class="panel-heading"><strong>Contatos</strong></div>
												<div class="panel-body">

													<?php
													if (!$list) {
													?>
														<a class="btn btn-lg btn-warning" href="<?php echo base_url() ?>contatoconsultor/cadastrar" role="button">
															<span class="glyphicon glyphicon-plus"></span> Cad.
														</a>
														<br><br>
														<div class="alert alert-info" role="alert"><b>Nenhum Cad.</b></div>
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
					</div>

			
		</div>
		<div class="col-md-2"></div>
	</div>
</div>
