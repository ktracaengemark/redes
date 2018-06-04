<?php if (isset($msg)) echo $msg; ?>

<div class="container-fluid">	
	<div class="row">
	
		<div class="col-md-1"></div>
		<div class="col-md-10 ">

			<?php echo validation_errors(); ?>

			<div class="panel panel-<?php echo $panel; ?>">

				<div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
				<div class="panel-body">

					<?php echo form_open_multipart($form_open_path); ?>

						<div class="panel-group" id="accordion4" role="tablist" aria-multiselectable="true">
							<div class="panel panel-primary">
								<div class="panel-heading collapsed" role="tab" id="heading4" data-toggle="collapse" data-parent="#accordion4" data-target="#collapse4" aria-expanded="false">								<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Despesa & Forma de Pagam.
										</a>
									</h4>
								</div>

								<div id="collapse4" class="panel-collapse" role="tabpanel" aria-labelledby="heading4" aria-expanded="false">
									<div class="panel-body">
										<div class="panel panel-danger">
											<div class="panel-heading">
												<div class="row">
													<div class="col-md-2">
														<label for="TipoDespesa">Tipo de Despesa</label>
														<!--<a class="btn btn-xs btn-info" href="<?php echo base_url() ?>tipodespesa/cadastrar/tipodespesa" role="button">
															<span class="glyphicon glyphicon-plus"></span> <b>Forma Pag</b>
														</a>-->
														<select data-placeholder="Selecione uma opção..." class="form-control Chosen" <?php echo $readonly; ?>
																id="TipoDespesa" name="TipoDespesa">
															<!--<option value="">-- Sel. Tipo Despesa --</option>-->
															<?php
															foreach ($select['TipoDespesa'] as $key => $row) {
																(!$despesas['TipoDespesa']) ? $despesas['TipoDespesa'] = '1' : FALSE;
																if ($despesas['TipoDespesa'] == $key) {
																	echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																} else {
																	echo '<option value="' . $key . '">' . $row . '</option>';
																}
															}
															?>
														</select>
													</div>
													<div class="col-md-2">
														<label for="Despesa">Despesa</label><br>
														<input type="text" class="form-control" maxlength="200"
																name="Despesa" value="<?php echo $despesas['Despesa'] ?>">
													</div>
													<div class="col-md-2">
														<label for="ValorRestanteDespesas">Valor da Despesa:</label><br>
														<div class="input-group" id="txtHint">
															<span class="input-group-addon" id="basic-addon1">R$</span>
															<input type="text" class="form-control Valor" id="ValorRestanteDespesas" maxlength="10" placeholder="0,00"
																data-toggle="collapse" onkeyup="calculaParcelasPagaveis()"
																data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																   name="ValorRestanteDespesas" value="<?php echo $despesas['ValorRestanteDespesas'] ?>">
														</div>
													</div>
													<div class="col-md-2">
														<label for="DataVencimentoDespesas">Dt Desp/ 1º Venc.</label>
														<div class="input-group <?php echo $datepicker; ?>">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
															<input type="text" class="form-control Date" id="DataVencimentoDespesas" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																   name="DataVencimentoDespesas" value="<?php echo $despesas['DataVencimentoDespesas']; ?>">
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">														
														<div class="col-md-2">
															<label for="FormaPagamentoDespesas">Forma de Pag.</label>
															<select data-placeholder="Selecione uma opção..." class="form-control" <?php echo $readonly; ?>
																	id="FormaPagamentoDespesas" name="FormaPagamentoDespesas">
																<!--<option value="">-- Selecione uma opção --</option>-->
																<?php
																foreach ($select['FormaPagamentoDespesas'] as $key => $row) {
																	(!$despesas['FormaPagamentoDespesas']) ? $despesas['FormaPagamentoDespesas'] = '1' : FALSE;
																	if ($despesas['FormaPagamentoDespesas'] == $key) {
																		echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																	} else {
																		echo '<option value="' . $key . '">' . $row . '</option>';
																	}
																}
																?>
															</select>
														</div>
														<div class="col-md-2">
															<label for="QtdParcelasDespesas">Qtd. Parc.:</label><br>
															<input type="text" class="form-control Numero" id="QtdParcelasDespesas" maxlength="3" placeholder="0"
																   data-toggle="collapse" onkeyup="calculaParcelasPagaveis()"
																	data-target="#Parcelas" aria-expanded="false" aria-controls="Parcelas"
																   name="QtdParcelasDespesas" value="<?php echo $despesas['QtdParcelasDespesas'] ?>">
														</div>
														<div class="col-md-3">
															<label for="ModalidadeDespesas">Modalidade</label><br>
															<div class="form-group">
																<div class="btn-block" data-toggle="buttons">
																	<?php
																	foreach ($select['ModalidadeDespesas'] as $key => $row) {
																		(!$despesas['ModalidadeDespesas']) ? $despesas['ModalidadeDespesas'] = 'P' : FALSE;

																		if ($despesas['ModalidadeDespesas'] == $key) {
																			echo ''
																			. '<label class="btn btn-warning active" name="radiobutton_ModalidadeDespesas" id="radiobutton_ModalidadeDespesas' .  $key . '">'
																			. '<input type="radio" name="ModalidadeDespesas" id="radiobuttondinamico" '
																			. 'onchange="calculaParcelasPagaveis()" '
																			. 'autocomplete="off" value="' . $key . '" checked>' . $row
																			. '</label>'
																			;
																		} else {
																			echo ''
																			. '<label class="btn btn-default" name="radiobutton_ModalidadeDespesas" id="radiobutton_ModalidadeDespesas' .  $key . '">'
																			. '<input type="radio" name="ModalidadeDespesas" id="radiobuttondinamico" '
																			. 'onchange="calculaParcelasPagaveisMensais()" '
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
						</div>
						
						<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
							<div class="panel panel-primary">
								<div class="panel-heading" role="tab" id="heading2" data-toggle="collapse" data-parent="#accordion2" data-target="#collapse2">
									<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Parcelas
										</a>
									</h4>
								</div>
								<div id="collapse2" class="panel-collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false">									
									
									<!--App_parcelasRec-->
									<div class="panel-body">
										<div class="input_fields_parcelas2">

										<?php
										for ($i=1; $i <= $despesas['QtdParcelasDespesas']; $i++) {
										?>

											<?php if ($metodo > 1) { ?>
											<input type="hidden" name="idApp_ParcelasPagaveiscons<?php echo $i ?>" value="<?php echo $parcelaspag[$i]['idApp_ParcelasPagaveiscons']; ?>"/>
											<?php } ?>
											<div class="form-group">
												<div class="panel panel-danger">
													<div class="panel-heading">
														<div class="row">
															<div class="col-md-1">
																<label for="ParcelaPagaveis">Parcela:</label><br>
																<input type="text" class="form-control" maxlength="6" readonly=""
																	   name="ParcelaPagaveis<?php echo $i ?>" value="<?php echo $parcelaspag[$i]['ParcelaPagaveis'] ?>">
															</div>
															<div class="col-md-2">
																<label for="ValorParcelaPagaveis">Valor Parcela:</label><br>
																<div class="input-group" id="txtHint">
																	<span class="input-group-addon" id="basic-addon1">R$</span>
																	<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorParcelaPagaveis<?php echo $i ?>"
																		   name="ValorParcelaPagaveis<?php echo $i ?>" value="<?php echo $parcelaspag[$i]['ValorParcelaPagaveis'] ?>">
																</div>
															</div>
															<div class="col-md-2">
																<label for="DataVencimentoPagaveis">Data Venc. Parc.</label>
																<div class="input-group DatePicker">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>
																	<input type="text" class="form-control Date" id="DataVencimentoPagaveis<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																		   name="DataVencimentoPagaveis<?php echo $i ?>" value="<?php echo $parcelaspag[$i]['DataVencimentoPagaveis'] ?>">
																	
																</div>
															</div>
															<div class="col-md-2">
																<label for="ValorPagoPagaveis">Valor Pago:</label><br>
																<div class="input-group" id="txtHint">
																	<span class="input-group-addon" id="basic-addon1">R$</span>
																	<input type="text" class="form-control Valor" maxlength="10" placeholder="0,00" id="ValorPagoPagaveis<?php echo $i ?>"
																		   name="ValorPagoPagaveis<?php echo $i ?>" value="<?php echo $parcelaspag[$i]['ValorPagoPagaveis'] ?>">
																</div>
															</div>
															<div class="col-md-2">
																<label for="DataPagoPagaveis">Data Pag.</label>
																<div class="input-group DatePicker">
																	<span class="input-group-addon" disabled>
																		<span class="glyphicon glyphicon-calendar"></span>
																	</span>
																	<input type="text" class="form-control Date" id="DataPagoPagaveis<?php echo $i ?>" maxlength="10" placeholder="DD/MM/AAAA"
																		   name="DataPagoPagaveis<?php echo $i ?>" value="<?php echo $parcelaspag[$i]['DataPagoPagaveis'] ?>">
																	
																</div>
															</div>
															<div class="col-md-2">
																<label for="QuitadoPagaveis">Quitado?</label><br>
																<div class="form-group">
																	<div class="btn-group" data-toggle="buttons">
																		<?php
																		foreach ($select['QuitadoPagaveis'] as $key => $row) {
																			(!$parcelaspag[$i]['QuitadoPagaveis']) ? $parcelaspag[$i]['QuitadoPagaveis'] = 'N' : FALSE;

																			if ($parcelaspag[$i]['QuitadoPagaveis'] == $key) {
																				echo ''
																				. '<label class="btn btn-warning active" name="radiobutton_QuitadoPagaveis' . $i . '" id="radiobutton_QuitadoPagaveis' . $i .  $key . '">'
																				. '<input type="radio" name="QuitadoPagaveis' . $i . '" id="radiobuttondinamico" '
																				. 'onchange="carregaQuitadoDespesas(this.value,this.name,'.$i.')" '
																				. 'autocomplete="off" value="' . $key . '" checked>' . $row
																				. '</label>'
																				;
																			} else {
																				echo ''
																				. '<label class="btn btn-default" name="radiobutton_QuitadoPagaveis' . $i . '" id="radiobutton_QuitadoPagaveis' . $i .  $key . '">'
																				. '<input type="radio" name="QuitadoPagaveis' . $i . '" id="radiobuttondinamico" '
																				. 'onchange="carregaQuitadoDespesas(this.value,this.name,'.$i.')" '
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
										<?php
										}
										?>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="panel-group" id="accordion8" role="tablist" aria-multiselectable="true">
							<div class="panel panel-primary">
								<div class="panel-heading collapsed" role="tab" id="heading8" data-toggle="collapse" data-parent="#accordion8" data-target="#collapse8" aria-expanded="false">								<h4 class="panel-title">
										<a class="accordion-toggle">
											<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
											Status da Despesa
										</a>
									</h4>
								</div>

								<div id="collapse8" class="panel-collapse" role="tabpanel" aria-labelledby="heading8" aria-expanded="false">
									<div class="panel-body">
										<div class="panel panel-danger">
											<div class="panel-heading">
												<div class="row">									
													<div class="col-md-2 form-inline">
														<label for="ServicoConcluidoDespesas">Prod.Entr.?</label><br>
														<div class="btn-group" data-toggle="buttons">
															<?php
															foreach ($select['ServicoConcluidoDespesas'] as $key => $row) {
																(!$despesas['ServicoConcluidoDespesas']) ? $despesas['ServicoConcluidoDespesas'] = 'N' : FALSE;

																if ($despesas['ServicoConcluidoDespesas'] == $key) {
																	echo ''
																	. '<label class="btn btn-warning active" name="radiobutton_ServicoConcluidoDespesas" id="radiobutton_ServicoConcluidoDespesas' . $key . '">'
																	. '<input type="radio" name="ServicoConcluidoDespesas" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" checked>' . $row
																	. '</label>'
																	;
																} else {
																	echo ''
																	. '<label class="btn btn-default" name="radiobutton_ServicoConcluidoDespesas" id="radiobutton_ServicoConcluidoDespesas' . $key . '">'
																	. '<input type="radio" name="ServicoConcluidoDespesas" id="radiobutton" '
																	. 'autocomplete="off" value="' . $key . '" >' . $row
																	. '</label>'
																	;
																}
															}
															?>
														</div>
													</div>
													<div class="col-md-2 text-left form-inline">
														<label for="QuitadoDespesas">Desp.Quitada?</label><br>
														<div class="form-group">
															<div class="btn-group" data-toggle="buttons">
																<?php
																foreach ($select['QuitadoDespesas'] as $key => $row) {
																	(!$despesas['QuitadoDespesas']) ? $despesas['QuitadoDespesas'] = 'N' : FALSE;
																	

																	($key == 'S') ? $hideshow = 'showradio' : $hideshow = 'hideradio';
																												
																	if ($despesas['QuitadoDespesas'] == $key) {
																		echo ''
																		. '<label class="btn btn-warning active" name="QuitadoDespesas_' . $hideshow . '">'
																		. '<input type="radio" name="QuitadoDespesas" id="' . $hideshow . '" '
																		. 'autocomplete="off" value="' . $key . '" checked>' . $row
																		. '</label>'
																		;
																	} else {
																		echo ''
																		. '<label class="btn btn-default" name="QuitadoDespesas_' . $hideshow . '">'
																		. '<input type="radio" name="QuitadoDespesas" id="' . $hideshow . '" '
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
														<label for="DataDespesas">Dt.Despesa:</label>
														<div class="input-group <?php echo $datepicker; ?>">
															<span class="input-group-addon" disabled>
																<span class="glyphicon glyphicon-calendar"></span>
															</span>
															<input type="text" class="form-control Date" <?php echo $readonly; ?> maxlength="10" placeholder="DD/MM/AAAA"
																   name="DataDespesas" value="<?php echo $despesas['DataDespesas']; ?>">
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
								<!--<input type="hidden" name="idApp_Cliente" value="<?php echo $_SESSION['Cliente']['idApp_Cliente']; ?>">-->
								<input type="hidden" name="idApp_Despesascons" value="<?php echo $despesas['idApp_Despesascons']; ?>">
								<?php if ($metodo > 1) { ?>
								<!--<input type="hidden" name="idApp_Procedimento" value="<?php echo $procedimento['idApp_Procedimento']; ?>">
								<input type="hidden" name="idApp_ParcelasRec" value="<?php echo $parcelaspag['idApp_ParcelasRec']; ?>">-->
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
														<a class="btn btn-danger" href="<?php echo base_url() . 'despesascons/excluir/' . $despesas['idApp_Despesascons'] ?>" role="button">
															<span class="glyphicon glyphicon-trash"></span> Confirmar Exclusão
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } else { ?>
									<div class="col-md-3">
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
		<div class="col-md-1"></div>
	</div>
</div>