<?php if ($msg) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8">
		
			<div class="panel panel-primary">
				
				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Cliente']['NomeCliente'] . '</strong> - <small>Id.: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?></strong></div>
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
													<a href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/cliente\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
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
													<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
														<span class="glyphicon glyphicon-usd"></span> List.
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>
												<a <?php if (preg_match("/orcatrata\/cadastrar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ?>>
													<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
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

					<?php } ?>
					
					<div class="row">
					
						<div class="col-md-12 col-lg-12">

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading"><strong>Cliente</strong></div>
								<div class="panel-body">				
																																				 
									<table class="table table-user-information">
										<tbody>
											
											<?php 
											
											if ($query['Empresa']) {
												
											echo ' 
											<tr>
												<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Empresa:</td>
												<td>' . $query['Empresa'] . '</td>
											</tr>  
											';
											
											}
											
											if ($query['RegistroFicha']) {
												
											echo ' 
											<tr>
												<td class="col-md-3 col-lg-3"><span class="glyphicon glyphicon-user"></span> Ficha N°:</td>
												<td>' . $query['RegistroFicha'] . '</td>
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
											
											if ($query['Telefone']) {
												
											echo '                                                 
											<tr>
												<td><span class="glyphicon glyphicon-phone-alt"></span> Telefone:</td>
												<td>' . $query['Telefone'] . '</td>
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
											
											if ($query['Endereco'] || $query['Bairro'] || $query['Municipio']) {
												
											echo '                                                 
											<tr>
												<td><span class="glyphicon glyphicon-home"></span> Endereço:</td>
												<td>' . $query['Endereco'] . ' - ' . $query['Bairro'] . ' - ' . $query['Municipio'] . ' - ' . $query['Estado'] . '</td>
											</tr>
											';
											
											}
											
											if ($query['Cep']) {
												
											echo '                                                 
											<tr>
												<td><span class="glyphicon glyphicon-envelope"></span> Cep:</td>
												<td>' . $query['Cep'] . '</td>
											</tr>
											';
											
											}
											
											if ($query['Cpf']) {
												
											echo '                                                 
											<tr>
												<td><span class="glyphicon glyphicon-pencil"></span> Cpf:</td>
												<td>' . $query['Cpf'] . '</td>
											</tr>
											';
											
											}
											
											if ($query['Rg'] || $query['OrgaoExp'] || $query['Estado'] || $query['DataEmissao']) {
												
											echo '                                                 
											<tr>
												<td><span class="glyphicon glyphicon-pencil"></span> Rg:</td>
												<td>' . $query['Rg'] . ' - ' . $query['OrgaoExp'] . ' - ' . $query['EstadoExp'] . ' - ' . $query['DataEmissao'] . '</td>
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
											
											if ($query['Obs']) {
												
											echo '                                                 
											<tr>
												<td><span class="glyphicon glyphicon-file"></span> Obs:</td>
												<td>' . nl2br($query['Obs']) . '</td>
											</tr>
											';
											
											}
											
											if ($query['Ativo']) {
												
											echo '                                                 
											<tr>
												<td><span class="glyphicon glyphicon-alert"></span> Ativo:</td>
												<td>' . $query['Ativo'] . '</td>
											</tr>
											';
											
											}
											?>
											
										</tbody>
									</table>
	
									<div class="row">
					
										<div class="col-md-12 col-lg-12">

											<div class="panel panel-primary">

												<div class="panel-heading"><strong>Contato</strong></div>
												<div class="panel-body">
											
													
													<?php
													if (!$list) {
													?>
														<a class="btn btn-md btn-warning" href="<?php echo base_url() ?>contatocliente/cadastrar" role="button"> 
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
			</div>

		</div>
		<div class="col-md-2"></div>
	</div>	
</div>


      

