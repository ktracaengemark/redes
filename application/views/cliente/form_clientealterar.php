<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

<div class="container-fluid">
	<div class="row">
	
		<div class="col-md-2"></div>
		<div class="col-md-8 ">

			<nav class="navbar navbar-inverse">
			  <div class="container-fluid">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				  </button>
				  <a class="navbar-brand" href="<?php echo base_url() . 'cliente/prontuario/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
					<?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>Id.: ' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?>
				  </a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">

					<ul class="nav navbar-nav navbar-center">
						<li>
							<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<span class="glyphicon glyphicon-edit"></span> Editar Cliente
							</a>
						</li>
						
						<li>
							<a href="<?php echo base_url() . 'cliente/acomp/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<span class="glyphicon glyphicon-pencil"></span> Anotações
							</a>
						</li>

						<li>
							<a href="<?php echo base_url() . 'orcatratacons/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<span class="glyphicon glyphicon-usd"></span> Ver Orçams.
							</a>
						</li>

						<li>
							<a href="<?php echo base_url() . 'orcatratacons/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
								<span class="glyphicon glyphicon-plus"></span> Cad. Orçam.
							</a>
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
					
					<?php echo validation_errors(); ?>

					<div class="panel panel-<?php echo $panel; ?>">
					
						<div class="panel-heading"><strong>Cliente</strong></div>
						<div class="panel-body">

							<?php echo form_open_multipart($form_open_path); ?>

							<div class="panel panel-info">
								<div class="panel-heading">		
									<div class="form-group">
										<div class="row">
											<div class="col-md-4">
												<label for="NomeCliente">Nome do Cliente: *</label>
												<input type="text" class="form-control" id="NomeCliente" maxlength="255" <?php echo $readonly; ?>
													   name="NomeCliente" autofocus value="<?php echo $query['NomeCliente']; ?>">
											</div>
											<div class="col-md-3">
												<label for="Telefone1">Tel.1 - Fixo ou Celular*</label>
												<input type="text" class="form-control Celular CelularVariavel" id="Telefone1" maxlength="11" <?php echo $readonly; ?>
													   name="Telefone1" placeholder="(XX)999999999" value="<?php echo $query['Telefone1']; ?>">
											</div>
											<div class="col-md-3">
												<label for="DataNascimento">Data de Nascimento:</label>
												<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
													   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
											</div>						
											<div class="col-md-2">
												<label for="Sexo">Sexo:</label>
												<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
														id="Sexo" name="Sexo">
													<option value="">--Selec. o Sexo--</option>
													<?php
													foreach ($select['Sexo'] as $key => $row) {
														if ($query['Sexo'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="panel-group">	
										<div class="panel panel-primary">		
											<div class="panel-heading text-left">
												<a class="btn btn-primary" type="button" data-toggle="collapse" data-target="#DadosComplementares" aria-expanded="false" aria-controls="DadosComplementares">
													<span class="glyphicon glyphicon-menu-down"></span> Dados Complementares
												</a>
											</div>
											<div class="panel panel-info">
												<div class="panel-heading">
													<div <?php echo $collapse; ?> id="DadosComplementares">
															
														<div class="form-group">
															<div class="row">
																<div class="col-md-3">
																	<label for="Cpf">CPF:</label>
																	<input type="text" class="form-control" maxlength="11" <?php echo $readonly; ?>
																		   name="Cpf" value="<?php echo $query['Cpf']; ?>">
																</div>
																<div class="col-md-3">
																	<label for="Telefone2">Tel.2 - Fixo ou Celular:</label>
																	<input type="text" class="form-control Celular CelularVariavel" id="Telefone2" maxlength="11" <?php echo $readonly; ?>
																		   name="Telefone2" placeholder="(XX)999999999" value="<?php echo $query['Telefone2']; ?>">
																</div>
																<div class="col-md-3">
																	<label for="Telefone3">Tel.3 - Fixo ou Celular:</label>
																	<input type="text" class="form-control Celular CelularVariavel" id="Telefone3" maxlength="11" <?php echo $readonly; ?>
																		   name="Telefone3" placeholder="(XX)999999999" value="<?php echo $query['Telefone3']; ?>">
																</div>							
																<div class="col-md-3">
																	<label for="Email">E-mail:</label>
																	<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
																		   name="Email" value="<?php echo $query['Email']; ?>">
																</div>												
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																
																<div class="col-md-3">
																	<label for="Rg">RG:</label>
																	<input type="text" class="form-control" maxlength="9" <?php echo $readonly; ?>
																		   name="Rg" value="<?php echo $query['Rg']; ?>">
																</div>
																<div class="col-md-3">
																	<label for="OrgaoExp">Orgão Exp.:</label>
																	<input type="text" class="form-control" maxlength="45" <?php echo $readonly; ?>
																		   name="OrgaoExp" value="<?php echo $query['OrgaoExp']; ?>">
																</div>
																<div class="col-md-3">
																	<label for="EstadoExp">Estado Emissor:</label>
																	<input type="text" class="form-control" maxlength="2" <?php echo $readonly; ?>
																		   name="EstadoExp" value="<?php echo $query['EstadoExp']; ?>">
																</div>
																<div class="col-md-3">
																	<label for="DataEmissao">Data de Emissão:</label>
																	<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
																		   name="DataEmissao" placeholder="DD/MM/AAAA" value="<?php echo $query['DataEmissao']; ?>">
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<div class="col-md-3">
																	<label for="Endereco">Endreço:</label>
																	<input type="text" class="form-control" id="Endereco" maxlength="100" <?php echo $readonly; ?>
																		   name="Endereco" value="<?php echo $query['Endereco']; ?>">
																</div>
																<div class="col-md-3">
																	<label for="Bairro">Bairro:</label>
																	<input type="text" class="form-control" id="Bairro" maxlength="100" <?php echo $readonly; ?>
																		   name="Bairro" value="<?php echo $query['Bairro']; ?>">
																</div>
																<div class="col-md-3">
																	<label for="Municipio">Municipio:</label>
																	<input type="text" class="form-control" maxlength="100" <?php echo $readonly; ?>
																		   name="Municipio" value="<?php echo $query['Municipio']; ?>">
																</div>												
																<div class="col-md-1">
																	<label for="Estado">Estado:</label>
																	<input type="text" class="form-control" id="Estado" maxlength="2" <?php echo $readonly; ?>
																		   name="Estado" value="<?php echo $query['Estado']; ?>">
																</div>
																<div class="col-md-2">
																	<label for="Cep">Cep:</label>
																	<input type="text" class="form-control" id="Cep" maxlength="8" <?php echo $readonly; ?>
																		   name="Cep" value="<?php echo $query['Cep']; ?>">
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">											
																<div class="col-md-3">
																	<label for="DataCadastroCliente">Cadastrado em:</label>													
																	<input type="text" class="form-control Date"  maxlength="10" readonly="" <?php echo $readonly; ?>
																		   name="DataCadastroCliente" placeholder="DD/MM/AAAA" value="<?php echo $query['DataCadastroCliente']; ?>">													
																</div>
																<div class="col-md-3">
																	<label for="RegistroFicha">Ficha Nº:</label>
																	<input type="text" class="form-control" maxlength="45" <?php echo $readonly; ?>
																		   name="RegistroFicha" value="<?php echo $query['RegistroFicha']; ?>">
																</div>
																<div class="col-md-4">
																	<label for="Obs">OBS:</label>
																	<textarea class="form-control" id="Obs" <?php echo $readonly; ?>
																			  name="Obs"><?php echo $query['Obs']; ?></textarea>
																</div>
																<div class="col-md-2">
																	<label for="Ativo">Ativo?</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['Ativo'] as $key => $row) {
																				(!$query['Ativo']) ? $query['Ativo'] = 'S' : FALSE;

																				if ($query['Ativo'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_Ativo" id="radiobutton_Ativo' . $key . '">'
																					. '<input type="radio" name="Ativo" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_Ativo" id="radiobutton_Ativo' . $key . '">'
																					. '<input type="radio" name="Ativo" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
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
									<!--
									<div class="panel-group">	
										<div class="panel panel-primary">
											<div class="panel-heading text-left">
												<a class="btn btn-primary" type="button" data-toggle="collapse" data-target="#Classificacao" aria-expanded="false" aria-controls="Classificacao">
													<span class="glyphicon glyphicon-menu-down"></span> Classificação
												</a>
											</div>
											<div class="panel panel-info">
												<div class="panel-heading">
													<div <?php echo $collapse1; ?> id="Classificacao">
													
														<div class="form-group">
															<div class="row">											
																<div class="col-md-2">
																	<label for="Aux1Cli">Ambicioso</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['Aux1Cli'] as $key => $row) {
																				(!$query['Aux1Cli']) ? $query['Aux1Cli'] = '0' : FALSE;

																				if ($query['Aux1Cli'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_Aux1Cli" id="radiobutton_Aux1Cli' . $key . '">'
																					. '<input type="radio" name="Aux1Cli" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_Aux1Cli" id="radiobutton_Aux1Cli' . $key . '">'
																					. '<input type="radio" name="Aux1Cli" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="Aux2Cli">Cond.Favor.</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['Aux2Cli'] as $key => $row) {
																				(!$query['Aux2Cli']) ? $query['Aux2Cli'] = '0' : FALSE;

																				if ($query['Aux2Cli'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_Aux2Cli" id="radiobutton_Aux2Cli' . $key . '">'
																					. '<input type="radio" name="Aux2Cli" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_Aux2Cli" id="radiobutton_Aux2Cli' . $key . '">'
																					. '<input type="radio" name="Aux2Cli" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="Aux3Cli">Popularid.</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['Aux3Cli'] as $key => $row) {
																				(!$query['Aux3Cli']) ? $query['Aux3Cli'] = '0' : FALSE;

																				if ($query['Aux3Cli'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_Aux3Cli" id="radiobutton_Aux3Cli' . $key . '">'
																					. '<input type="radio" name="Aux3Cli" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_Aux3Cli" id="radiobutton_Aux3Cli' . $key . '">'
																					. '<input type="radio" name="Aux3Cli" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																</div>
																<div class="col-md-2">
																	<label for="Aux4Cli">Credibilid.</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['Aux4Cli'] as $key => $row) {
																				(!$query['Aux4Cli']) ? $query['Aux4Cli'] = '0' : FALSE;

																				if ($query['Aux4Cli'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_Aux4Cli" id="radiobutton_Aux4Cli' . $key . '">'
																					. '<input type="radio" name="Aux4Cli" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_Aux4Cli" id="radiobutton_Aux4Cli' . $key . '">'
																					. '<input type="radio" name="Aux4Cli" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																</div>
																<div class="col-md-4">
																	<label for="Aux5Cli">Pontuação:</label><br>
																	<div class="form-group" id="txtHint">
																		<?php
																		$options = array(
																			'0'	=> '0 - Ruim',
																			'1'	=> '1 - Médio',
																			'2'	=> '2 - Bom',
																			'3'	=> '3 - Muito Bom',
																			'4'	=> '4 - Ótimo',
																		);
																		$cfg = 'data-placeholder="Selecione uma opção..." class="form-control" ' . $readonly . '
																				id="Aux5Cli"';
																		echo form_dropdown('Aux5Cli', $options, $query['Aux5Cli'], $cfg);
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
									<div class="panel-group">	
										<div class="panel panel-primary">		
											<div class="panel-heading text-left">
												<a class="btn btn-primary" type="button" data-toggle="collapse" data-target="#Acompanhamento" aria-expanded="false" aria-controls="Acompanhamento">
													<span class="glyphicon glyphicon-menu-down"></span> Acompanhamento
												</a>
											</div>
											<div class="panel panel-info">
												<div class="panel-heading">	
													<div <?php echo $collapse2; ?> id="Acompanhamento">
														<div class="form-group">
															<div class="row">
																<div class="col-md-3">	
																	<label for="Associado">Cliente ou Associado?</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['Associado'] as $key => $row) {
																				(!$query['Associado']) ? $query['Associado'] = 'N' : FALSE;

																				if ($query['Associado'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_Associado" id="radiobutton_Associado' . $key . '">'
																					. '<input type="radio" name="Associado" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_Associado" id="radiobutton_Associado' . $key . '">'
																					. '<input type="radio" name="Associado" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																</div>	
																<div class="col-md-3">	
																	<label for="Aux6Cli">1ªPasso - Concl.?</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['Aux6Cli'] as $key => $row) {
																				(!$query['Aux6Cli']) ? $query['Aux6Cli'] = 'N' : FALSE;

																				if ($query['Aux6Cli'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_Aux6Cli" id="radiobutton_Aux6Cli' . $key . '">'
																					. '<input type="radio" name="Aux6Cli" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_Aux6Cli" id="radiobutton_Aux6Cli' . $key . '">'
																					. '<input type="radio" name="Aux6Cli" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																</div>
																<div class="col-md-3">
																	<label for="Aux7Cli">2ªPasso - Concl.?</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['Aux7Cli'] as $key => $row) {
																				(!$query['Aux7Cli']) ? $query['Aux7Cli'] = 'N' : FALSE;

																				if ($query['Aux7Cli'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_Aux7Cli" id="radiobutton_Aux7Cli' . $key . '">'
																					. '<input type="radio" name="Aux7Cli" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_Aux7Cli" id="radiobutton_Aux7Cli' . $key . '">'
																					. '<input type="radio" name="Aux7Cli" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
																			}
																			?>
																		</div>
																	</div>
																</div>
																<div class="col-md-3">
																	<label for="Aux8Cli">3ªPasso - Concl.?</label><br>
																	<div class="form-group">
																		<div class="btn-group" data-toggle="buttons">
																			<?php
																			foreach ($select['Aux8Cli'] as $key => $row) {
																				(!$query['Aux8Cli']) ? $query['Aux8Cli'] = 'N' : FALSE;

																				if ($query['Aux8Cli'] == $key) {
																					echo ''
																					. '<label class="btn btn-warning active" name="radiobutton_Aux8Cli" id="radiobutton_Aux8Cli' . $key . '">'
																					. '<input type="radio" name="Aux8Cli" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" checked>' . $row
																					. '</label>'
																					;
																				} else {
																					echo ''
																					. '<label class="btn btn-default" name="radiobutton_Aux8Cli" id="radiobutton_Aux8Cli' . $key . '">'
																					. '<input type="radio" name="Aux8Cli" id="radiobutton" '
																					. 'autocomplete="off" value="' . $key . '" >' . $row
																					. '</label>'
																					;
																				}
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
									-->
									<div class="form-group">
										<div class="row">
											<input type="hidden" name="idApp_Cliente" value="<?php echo $query['idApp_Cliente']; ?>">
											<?php if ($metodo == 2) { ?>

												<div class="col-md-6">
													<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
														<span class="glyphicon glyphicon-save"></span> Salvar
													</button>
												</div>
												<div class="col-md-6 text-right">
													<button  type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal-sm">
														<span class="glyphicon glyphicon-trash"></span> Excluir
													</button>
												</div>

												<div class="modal fade bs-excluir-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header bg-danger">
																<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<h4 class="modal-title">Tem certeza que deseja excluir?</h4>
															</div>
															<div class="modal-body">
																<p>Ao confirmar esta operação todos os dados serão excluídos permanentemente do sistema.
																	Esta operação é irreversível.</p>
															</div>
															<div class="modal-footer">
																<div class="col-md-6 text-left">
																	<button type="button" class="btn btn-warning" data-dismiss="modal">
																		<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
																	</button>
																</div>
																<div class="col-md-6 text-right">
																	<a class="btn btn-danger" href="<?php echo base_url() . 'cliente/excluir/' . $query['idApp_Cliente'] ?>" role="button">
																		<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
																	</a>
																</div>
															</div>
														</div>
													</div>
												</div>

											<?php } elseif ($metodo == 3) { ?>
												<div class="col-md-12 text-center">
													<button class="btn btn-lg btn-danger" id="inputDb" data-loading-text="Aguarde..." name="submit" value="1" type="submit">
														<span class="glyphicon glyphicon-trash"></span> Excluir
													</button>
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
								</div>		
							</div>
						</form>
						</div>
					</div>							
				</div>
			</div>
		</div>
		<div class="col-md-2"></div>
	</div>	
</div>
