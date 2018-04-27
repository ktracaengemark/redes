<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Empresafilial'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8">
		
			<div class="panel panel-primary">
				
				<div class="panel-heading"><strong><?php echo '<strong>' . $_SESSION['Empresafilial']['Nome'] . '</strong> - <small>Id.: ' . $_SESSION['Empresafilial']['idSis_EmpresaFilial'] . '</small>' ?></strong></div>
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
											<span class="glyphicon glyphicon-home"></span> Unidade <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
													<a href="<?php echo base_url() . 'empresafilial/prontuario/' . $_SESSION['Empresafilial']['idSis_EmpresaFilial']; ?>">
														<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
													</a>
												</a>
											</li>
											<li role="separator" class="divider"></li>
											<li>	
												<a <?php if (preg_match("/empresafilial\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
													<a href="<?php echo base_url() . 'empresafilial/alterar/' . $_SESSION['Empresafilial']['idSis_EmpresaFilial']; ?>">
														<span class="glyphicon glyphicon-edit"></span> Edit.
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
							<div class="col-md-12 col-lg-12">
								<div class="col-md-4 text-left">
									<label for="">Empresa:</label>
									<div class="form-group">
										<div class="row">							
											<a <?php if (preg_match("/prontuario\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; //(.)+\/prontuario/   ?>>
												<a class="btn btn-lg btn-success" href="<?php echo base_url() . 'empresafilial/prontuario/' . $_SESSION['Empresafilial']['idSis_EmpresaFilial']; ?>">
													<span class="glyphicon glyphicon-file"> </span> Ver <span class="sr-only">(current)</span>
												</a>
											</a>
											<a <?php if (preg_match("/empresafilial\/alterar\b/", $_SERVER['REQUEST_URI'])) echo 'class=active'; ///(.)+\/alterar/    ?>>
												<a class="btn btn-lg btn-warning" href="<?php echo base_url() . 'empresafilial/alterar/' . $_SESSION['Empresafilial']['idSis_EmpresaFilial']; ?>">
													<span class="glyphicon glyphicon-edit"></span> Edit.
												</a>
											</a>
										</div>
									</div>	
								</div>
							</div>	
						</div>
					</div>					
					-->
					
					<?php } ?>
					
					<div class="row">
						<div class="col-md-12 col-lg-12">	
							
							<?php echo validation_errors(); ?>

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading"><strong>Dados da Unidade</strong></div>
								<div class="panel-body">
									<div class="panel panel-info">
										<div class="panel-heading">

											<?php echo form_open_multipart($form_open_path); ?>
																											
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
														<label for="Nome">Nome da Unidade/Filial:</label>
														<input type="text" class="form-control" id="Nome" maxlength="45" 
																name="Nome" autofocus value="<?php echo $query['Nome']; ?>">
													</div>																		
													<div class="col-md-3">
														<label for="Celular">Tel. </label>
														<input type="text" class="form-control Celular CelularVariavel" id="Celular" maxlength="11" <?php echo $readonly; ?>
															   name="Celular" placeholder="(XX)999999999" value="<?php echo $query['Celular']; ?>">
													</div>
													<div class="col-md-3">
														<label for="Email">E-mail:</label>
														<input type="text" class="form-control" id="Bairro" maxlength="100" <?php echo $readonly; ?>
															   name="Email" value="<?php echo $query['Email']; ?>">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row">										
													<div class="col-md-3">
														<label for="CnpjFilial">Cnpj:</label>
														<input type="text" class="form-control Cnpj" maxlength="18" <?php echo $readonly; ?>
															   name="CnpjFilial" placeholder="99.999.999/9999-98" value="<?php echo $query['CnpjFilial']; ?>">
													</div>
													<div class="col-md-3">
														<label for="InscEstadualFilial">Insc.Estadual:</label>
														<input type="text" class="form-control" maxlength="11" <?php echo $readonly; ?>
															   name="InscEstadualFilial" value="<?php echo $query['InscEstadualFilial']; ?>">
													</div>
													<div class="col-md-3">
														<label for="TelefoneFilial">Tel.Empresa:</label>
														<input type="text" class="form-control Celular CelularVariavel" id="TelefoneFilial" maxlength="11" <?php echo $readonly; ?>
															   name="TelefoneFilial" placeholder="(XX)999999999" value="<?php echo $query['TelefoneFilial']; ?>">
													</div>																				
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
														<label for="EnderecoFilial">Endre�o:</label>
														<input type="text" class="form-control" maxlength="200" <?php echo $readonly; ?>
															   name="EnderecoFilial" value="<?php echo $query['EnderecoFilial']; ?>">
													</div>
													<div class="col-md-3">
														<label for="BairroFilial">Bairro:</label>
														<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
															   name="BairroFilial" value="<?php echo $query['BairroFilial']; ?>">
													</div>
													<div class="col-md-3">
														<label for="MunicipioFilial">Municipio:</label>
														<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
															   name="MunicipioFilial" value="<?php echo $query['MunicipioFilial']; ?>">
													</div>												
													<div class="col-md-1">
														<label for="EstadoFilial">Estado:</label>
														<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
															   name="EstadoFilial" value="<?php echo $query['EstadoFilial']; ?>">
													</div>
													<div class="col-md-2">
														<label for="CepFilial">Cep:</label>
														<input type="text" class="form-control" maxlength="8" <?php echo $readonly; ?>
															   name="CepFilial" value="<?php echo $query['CepFilial']; ?>">
													</div>
												</div>
											</div>																		
											<br>
											<div class="form-group">
												<div class="row">
													<input type="hidden" name="idSis_EmpresaFilial" value="<?php echo $query['idSis_EmpresaFilial']; ?>">
													<?php if ($metodo == 2) { ?>

														<div class="col-md-6">
															<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
																<span class="glyphicon glyphicon-save"></span> Salvar
															</button>
														</div>
														<!--
														<div class="col-md-6 text-right">
															<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
																<span class="glyphicon glyphicon-trash"></span> Excluir
															</button>
														</div>
														-->
														<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<div class="modal-header bg-danger">
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																		<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
																	</div>
																	<div class="modal-body">
																		<p>Ao confirmar esta opera��o todos os dados ser�o exclu�dos permanentemente do sistema.
																			Esta opera��o � irrevers�vel.</p>
																	</div>
																	<div class="modal-footer">
																		<div class="col-md-6 text-left">
																			<button type="button" class="btn btn-warning" data-dismiss="modal">
																				<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																			</button>
																		</div>
																		<div class="col-md-6 text-right">
																			<a class="btn btn-danger" href="<?php echo base_url() . 'empresafilial/excluir/' . $query['idSis_EmpresaFilial'] ?>" role="button">
																				<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
																			</a>
																		</div>
																	</div>
																</div>
															</div>
														</div>

													<?php } elseif ($metodo == 3) { ?>
														<div class="col-md-12 text-center">
															<!--
															<button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
																<span class="glyphicon glyphicon-trash"></span> Excluir
															</button>
															-->
															<button class="btn btn-lg btn-warning" id="inputDb" onClick="history.go(-1);
																	return true;">
																<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
															</button>
														</div>
													<?php } else { ?>
														<div class="col-md-6">
															<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
																<span class="glyphicon glyphicon-save"></span> Salvar
															</button>
														</div>
													<?php } ?>
												</div>
											</div>

											</form>
																					
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
