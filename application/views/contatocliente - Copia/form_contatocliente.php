<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

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
										<span class="glyphicon glyphicon-pencil"></span> Anota��es
									</a>
								</li>

								<li>
									<a href="<?php echo base_url() . 'orcatratacons/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-usd"></span> Ver Or�ams.
									</a>
								</li>

								<li>
									<a href="<?php echo base_url() . 'orcatratacons/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-plus"></span> Cad. Or�am.
									</a>
								</li>
							</ul>

						</div>
					  </div>
					</nav>

					<?php } ?>

					<div class="row">
						
						<div class="col-md-12 col-lg-12">
							<?php echo validation_errors(); ?>

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading"><strong>Contato</strong></div>
								<div class="panel-body">

									<?php echo form_open_multipart($form_open_path); ?>

									<div class="form-group">
										<div class="row">
											<div class="col-md-4">
												<label for="NomeContatoCliente">Nome do ContatoCliente: *</label>
												<input type="text" class="form-control" id="NomeContatoCliente" maxlength="255" <?php echo $readonly; ?>
													   name="NomeContatoCliente" autofocus value="<?php echo $query['NomeContatoCliente']; ?>">
											</div>
											<div class="col-md-4">
												<label for="TelefoneContatoCliente">Telefone Principal: *</label>
												<input type="text" class="form-control Celular CelularVariavel" id="TelefoneContatoCliente" maxlength="14" <?php echo $readonly; ?>
													   name="TelefoneContatoCliente" placeholder="(XX)999999999" value="<?php echo $query['TelefoneContatoCliente']; ?>">
											</div>
											<div class="col-md-4">
												<label for="DataNascimento">Data de Nascimento:</label>
												<input type="text" class="form-control Date" maxlength="10" <?php echo $readonly; ?>
													   name="DataNascimento" placeholder="DD/MM/AAAA" value="<?php echo $query['DataNascimento']; ?>">
											</div>                        													 
											<!--
											<div class="col-md-2 form-inline">
												<label for="StatusVida">Status de Vida:</label><br>
												<div class="form-group">
													<div class="btn-group" data-toggle="buttons">
														<?php
														foreach ($select['StatusVida'] as $key => $row) {
															if (!$query['StatusVida'])
																$query['StatusVida'] = 'V';

															if ($query['StatusVida'] == $key) {
																echo ''
																. '<label class="btn btn-warning active" name="radio_StatusVida" id="radiogeral' . $key . '">'
																. '<input type="radio" name="StatusVida" id="radiogeral" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																. '</label>'
																;
															} else {
																echo ''
																. '<label class="btn btn-default" name="radio_StatusVida" id="radiogeral' . $key . '">'
																. '<input type="radio" name="StatusVida" id="radiogeral" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																. '</label>'
																;
															}
														}
														?>  
													</div>
												</div>
											</div>
											-->
										</div>
									</div> 

									<div class="form-group">
										<div class="row">
											<div class="col-md-4">
												<label for="Sexo">Sexo:</label>
												<select data-placeholder="Selecione uma Op��o..." class="form-control" <?php echo $readonly; ?>
														id="Sexo" name="Sexo">
													<option value="">-- Selecione uma op��o --</option>
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
											<div class="col-md-4">
												<label for="RelaPes">Rela��o*</label>
												<!--<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>relapes/cadastrar/relapes" role="button"> 
													<span class="glyphicon glyphicon-plus"></span> <b>Nova Rela��o</b>
												</a>-->
												<select data-placeholder="Selecione uma op��o..." class="form-control" <?php echo $readonly; ?>
														id="RelaPes" name="RelaPes">
													<option value="">-- Selecione uma Rela��o --</option>
													<?php
													foreach ($select['RelaPes'] as $key => $row) {
														if ($query['RelaPes'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>   
												</select>          
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
									
									<div class="form-group">
										<div class="row">
											<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>"> 
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
																	<a class="btn btn-danger" href="<?php echo base_url() . 'contatocliente/excluir/' . $query['idApp_ContatoCliente'] ?>" role="button">
																		<span class="glyphicon glyphicon-trash"></span> Confirmar Exclus�o
																	</a>
																</div>
															</div>
														</div>
													</div>
												</div>

											<?php } else { ?>
												<div class="col-md-6">
													<button class="btn btn-lg btn-primary" id="inputDb" data-loading-text="Aguarde..." type="submit">
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
		<div class="col-md-2"></div>
	</div>	
</div>