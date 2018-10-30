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
								<?php echo '<small>' . $_SESSION['Cliente']['NomeCliente'] . '</small> - <small>' . $_SESSION['Cliente']['idApp_Cliente'] . '</small>' ?> 
							</a>
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">

							<ul class="nav navbar-nav navbar-center">
								<li>
									<a href="<?php echo base_url() . 'cliente/alterar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-edit"></span> Edit. Cliente
									</a>
								</li>
								<li>
									<a href="<?php echo base_url() . 'consulta/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-calendar"></span> List. Agends.
									</a>
								</li>
								<li>
									<a href="<?php echo base_url() . 'consulta/cadastrar1/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-plus"></span> Cad. Agend.
									</a>
								
								</li>
								<li>
									<a href="<?php echo base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-usd"></span> List. Orçams.
									</a>
								</li>
								<li>
									<a href="<?php echo base_url() . 'orcatrata/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
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
							<?php echo validation_errors(); ?>

							<div class="panel panel-<?php echo $panel; ?>">

								<div class="panel-heading"><strong>Agendamentos</strong></div>
								<div class="panel-body">
									<div class="form-group">
										<div class="panel panel-info">
											<div class="panel-heading">
												<?php echo form_open_multipart($form_open_path); ?>

												<div class="form-group">
													<div class="row">
														<div class="col-md-4"></div>
														<!--
														<div class="col-md-4">
															<label for="idApp_Cliente">Cliente:*</label>
															<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>clienteusuario/cadastrar/clienteusuario" role="button">
																<span class="glyphicon glyphicon-plus"></span> <b>Novo Cliente</b>
															</a>
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?> readonly=""
																	id="idApp_Cliente" autofocus name="idApp_Cliente">

																<?php
																foreach ($select['idApp_Cliente'] as $key => $row) {
																	if ($query['idApp_Cliente'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>
														-->
														<div class="col-md-4">
															<label for="idApp_Agenda">Agenda do Profis.*</label>
															<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																	id="idApp_Agenda" autofocus name="idApp_Agenda">
																<?php echo $select['option']; ?>
																<?php
																foreach ($select['idApp_Agenda'] as $key => $row) {
																	if ($query['idApp_Agenda'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>
														<!--
														<div class="col-md-4">
															<label for="idSis_EmpresaFilial">Unidade: *</label>
															<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																	id="idSis_EmpresaFilial" name="idSis_EmpresaFilial">
																<option value="">-- Selecione a Unidade --</option>
																<?php
																foreach ($select['idSis_EmpresaFilial'] as $key => $row) {
																	if ($query['idSis_EmpresaFilial'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>
														-->
													</div>
												</div>
												<hr>
												<div class="form-group">
													<div class="row">		
														<div class="col-md-6">	
															<label for="Data">Data Início : </label>												
															<!--<div class="input-group <?php echo $datepicker; ?>">-->
																<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																	   name="Data" value="<?php echo $query['Data']; ?>">
																<!--<span class="input-group-addon" disabled>
																	<span class="glyphicon glyphicon-calendar"></span>
																</span>
															</div>-->
														</div>	
														
														<div class="col-md-6">
															<label for="Hora">Dàs :</label>
															<!--<div class="input-group <?php echo $timepicker; ?>">-->
																<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5"  placeholder="HH:MM"
																	   accept=""name="HoraInicio" value="<?php echo $query['HoraInicio']; ?>">
																<!--<span class="input-group-addon">
																	<span class="glyphicon glyphicon-time"></span>
																</span>
															</div>-->
														</div>
														
														<div class="col-md-6">	
															<label for="Data2">Data Fim : </label>												
															<!--<div class="input-group <?php echo $datepicker; ?>">-->
																<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																	   name="Data2" value="<?php echo $query['Data2']; ?>">
																<!--<span class="input-group-addon" disabled>
																	<span class="glyphicon glyphicon-calendar"></span>
																</span>
															</div>-->
														</div>
													
														<div class="col-md-6">		
															<label for="Hora">Às :</label>
															<!--<div class="input-group <?php echo $timepicker; ?>">-->
																<input type="text" class="form-control Time" <?php echo $readonly; ?> maxlength="5" placeholder="HH:MM"
																	   accept=""name="HoraFim" value="<?php echo $query['HoraFim']; ?>">
																<!--<span class="input-group-addon">
																	<span class="glyphicon glyphicon-time"></span>
																</span>
															</div>-->
														</div>
													</div>
												</div>
												<hr>
												<div class="form-group">
													<div class="row">														
														<div class="col-md-12 form-group text-left">
															<label for="Obs">Obs:</label>
															<textarea class="form-control" id="Obs"
																	  name="Obs"><?php echo $query['Obs']; ?></textarea>
														</div>
													</div>
												</div>
												<hr>									
												<div class="form-group">
													<div class="row">
														<div class="col-md-3 form-inline text-left">
															<label for="idTab_TipoConsulta">Tipo de Consulta:</label><br>
															<div class="form-group">
																<div class="btn-block" data-toggle="buttons">
																	<?php
																	foreach ($select['TipoConsulta'] as $key => $row) {
																		(!$query['idTab_TipoConsulta']) ? $query['idTab_TipoConsulta'] = '1' : FALSE;

																		if ($query['idTab_TipoConsulta'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="radio_idTab_TipoConsulta" id="radiogeral' . $key . '">'
																			. '<input type="radio" name="idTab_TipoConsulta" id="radiogeral" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="radio_idTab_TipoConsulta" id="radiogeral' . $key . '">'
																			. '<input type="radio" name="idTab_TipoConsulta" id="radiogeral" '
																				. 'autocomplete="off" value="' . $key . '" >' . $row
																			. '</label>'
																			;
																		}
																	}
																	?>
																</div>
															</div>
														</div>
														<div class="col-md-9 form-inline text-left">
															<label for="idTab_Status">Status:</label><br>
															<div class="form-group">
																<div class="btn-block" data-toggle="buttons">
																	<?php
																	foreach ($select['Status'] as $key => $row) {
																		if (!$query['idTab_Status'])
																			$query['idTab_Status'] = 1;

																		if ($query['idTab_Status'] == $key) {
																			echo ''
																			. '<label class="btn btn-' . $this->basico->tipo_status_cor($key) . ' active" name="radio" id="radio' . $key . '">'
																			. '<input type="radio" name="idTab_Status" id="radio" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="radio" id="radio' . $key . '">'
																			. '<input type="radio" name="idTab_Status" id="radio" class="idTab_Status" '
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
												<hr>
												<div class="form-group">
													<div class="row">
														<input type="hidden" name="idApp_Consulta" value="<?php echo $query['idApp_Consulta']; ?>">
														<!--<input type="hidden" name="idApp_Agenda" value="<?php echo $_SESSION['log']['Agenda']; ?>">-->
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
																				<a class="btn btn-danger" href="<?php echo base_url() . 'consulta/excluir/' . $query['idApp_Consulta'] ?>" role="button">
																					<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
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
						</div>

					</div>
				
			
		</div>
		<div class="col-md-2"></div>
	</div>
</div>
