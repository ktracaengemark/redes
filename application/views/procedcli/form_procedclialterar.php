<?php if (isset($msg)) echo $msg; ?>
<?php if ( !isset($evento) && isset($_SESSION['Cliente'])) { ?>

<div class="container-fluid">
	<div class="row">

		<div class="col-md-1"></div>
		<div class="col-md-10 ">

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
								<?php if ($_SESSION['Cliente']['Profissional'] == $_SESSION['log']['id'] ) { ?>
								<li>
									<a href="<?php echo base_url() . 'procedcli/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-usd"></span> List. Orçams.
									</a>
								</li>
								<li>
									<a href="<?php echo base_url() . 'procedcli/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-plus"></span> Cad. Orçam.
									</a>
								</li>
								<?php } ?>
								<li>
									<a href="<?php echo base_url() . 'procedcli/listar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-pencil"></span> List. Proced.
									</a>
								</li>
								<li>
									<a href="<?php echo base_url() . 'procedcli/cadastrar/' . $_SESSION['Cliente']['idApp_Cliente']; ?>">
										<span class="glyphicon glyphicon-plus"></span> Cad. Proced.
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

								<div class="panel-heading"><strong>Orçamento - <?php echo $orcatrata['idApp_Procedimento'] ?></strong></div>
								<div class="panel-body">

									<?php echo form_open_multipart($form_open_path); ?>

									
									<!--<div class="panel-group" id="accordion4" role="tablist" aria-multiselectable="true">-->
									<div class="panel-group">	
										<div class="panel panel-primary">
	
											<div class="panel-heading text-left">
												<a class="btn btn-primary" type="button" data-toggle="collapse" data-target="#Orcamento" aria-expanded="false" aria-controls="Orcamento">
													<span class="glyphicon glyphicon-menu-down"></span> Orçam. & Forma de Pagam.
												</a>
											</div>
											
											<div <?php echo $collapse; ?> id="Orcamento">	
												<div class="panel-body">
													<div class="panel panel-info">
														<div class="panel-heading">														
															<div class="col-md-1"></div>
															<div class="form-group">	
																<div class="row">
																																		
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<!--<div class="panel-group" id="accordion8" role="tablist" aria-multiselectable="true">-->
									<div class="panel-group">	
										<div class="panel panel-primary">

											<div class="panel-heading text-left">
												<a class="btn btn-primary" type="button" data-toggle="collapse" data-target="#Statusorca" aria-expanded="false" aria-controls="Statusorca">
													<span class="glyphicon glyphicon-menu-down"></span> Status do Orçam.
												</a>
											</div>
											
											<div <?php echo $collapse; ?> id="Statusorca">	
												<div class="panel-body">
													<div class="form-group">
														<div class="panel panel-info">
															<div class="panel-heading">
																<div class="col-md-1"></div>
																<div class="form-group text-left">
																	<div class="row">
																		
																		<div class="col-md-3 form-inline">
																			<label for="ConcluidoProcedimento">Concluído?</label><br>
																			<div class="form-group">
																				<div class="btn-group" data-toggle="buttons">
																					<?php
																					foreach ($select['ConcluidoProcedimento'] as $key => $row) {
																						(!$orcatrata['ConcluidoProcedimento']) ? $orcatrata['ConcluidoProcedimento'] = 'N' : FALSE;

																						if ($orcatrata['ConcluidoProcedimento'] == $key) {
																							echo ''
																							. '<label class="btn btn-warning active" name="radiobutton_ConcluidoProcedimento" id="radiobutton_ConcluidoProcedimento' . $key . '">'
																							. '<input type="radio" name="ConcluidoProcedimento" id="radiobutton" '
																							. 'autocomplete="off" value="' . $key . '" checked>' . $row
																							. '</label>'
																							;
																						} else {
																							echo ''
																							. '<label class="btn btn-default" name="radiobutton_ConcluidoProcedimento" id="radiobutton_ConcluidoProcedimento' . $key . '">'
																							. '<input type="radio" name="ConcluidoProcedimento" id="radiobutton" '
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
																<div class="col-md-1"></div>
																<div class="form-group text-left">
																	<div class="row">
																		<div class="col-md-3">
																			<label for="DataProcedimento">Data:</label>
																			<div class="input-group <?php echo $datepicker; ?>">
																				<span class="input-group-addon" disabled>
																					<span class="glyphicon glyphicon-calendar"></span>
																				</span>
																				<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																						name="DataProcedimento" value="<?php echo $orcatrata['DataProcedimento']; ?>">
																				
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-md-1"></div>
																<div class="form-group text-left">
																	<div class="row">
																		<div class="col-md-6">
																			<label for="Procedimento">OBS:</label>
																			<textarea class="form-control" id="Procedimento" <?php echo $readonly; ?>
																					  name="Procedimento"><?php echo $orcatrata['Procedimento']; ?></textarea>
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
									
									<div class="form-group">
										<div class="row">
											<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">
											<input type="hidden" name="idApp_Procedimento" value="<?php echo $orcatrata['idApp_Procedimento']; ?>">
											<?php if ($metodo > 1) { ?>
											<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
											<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelasrec['idApp_ParcelasRec']; ?>">-->
											<?php } ?>
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
																	<a class="btn btn-danger" href="<?php echo base_url() . 'procedcli/excluir/' . $orcatrata['idApp_Procedimento'] ?>" role="button">
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
		<div class="col-md-1"></div>
	</div>
</div>
