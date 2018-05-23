<?php if ($msg) echo $msg; ?>


	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="row">

			<div class="main">

				<?php echo validation_errors(); ?>

				<div class="panel panel-primary">

					<div class="panel-heading"><strong><?php echo $titulo; ?></strong>
					
					<?php echo form_open('relatorioconsultor/despesas', 'role="form"'); ?>
					
						<button class="btn btn-sm btn-info" name="pesquisar" value="0" type="submit">
							<span class="glyphicon glyphicon-search"></span> Pesquisar
						</button>
						<button  class="btn btn-sm btn-success" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-filter"></span> Filtros
						</button>											
						<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>despesascons/cadastrar" role="button"> 
							<span class="glyphicon glyphicon-plus"></span> Nova Despesa
						</a>
					
					</div>
					<div class="panel-body">
						<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header bg-danger">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros</h4>
									</div>
									<div class="modal-footer">
										<div class="form-group text-left">
											<div class="row">
												<div class="col-md-3">
													<label for="Ordenamento">Tipo de Despesa:</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
															id="TipoDespesa" name="TipoDespesa">
														<?php
														foreach ($select['TipoDespesa'] as $key => $row) {
															if ($query['TipoDespesa'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
												</div>						
												
												<div class="col-md-2">
													<label for="ServicoConcluidoDespesas">Desp. Concl.?</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
															id="ServicoConcluidoDespesas" name="ServicoConcluidoDespesas">
														<?php
														foreach ($select['ServicoConcluidoDespesas'] as $key => $row) {
															if ($query['ServicoConcluidoDespesas'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
												</div>
												<!--
												<div class="col-md-2">
													<label for="QuitadoDespesas">Desp.Quit.?</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
															id="QuitadoDespesas" name="QuitadoDespesas">
														<?php
														foreach ($select['QuitadoDespesas'] as $key => $row) {
															if ($query['QuitadoDespesas'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
												</div>
												-->
												<div class="col-md-2">
													<label for="QuitadoPagaveis">Parc. Quit.?</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
															id="QuitadoPagaveis" name="QuitadoPagaveis">
														<?php
														foreach ($select['QuitadoPagaveis'] as $key => $row) {
															if ($query['QuitadoPagaveis'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
												</div>
												
												<div class="col-md-5">
													<label for="Ordenamento">Ordenamento:</label>
													<div class="form-group">
														<div class="row">
															<div class="col-md-8">
																<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																		id="Campo" name="Campo">
																	<?php
																	foreach ($select['Campo'] as $key => $row) {
																		if ($query['Campo'] == $key) {
																			echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
																		} else {
																			echo '<option value="' . $key . '">' . $row . '</option>';
																		}
																	}
																	?>
																</select>
															</div>

															<div class="col-md-4">
																<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
																		id="Ordenamento" name="Ordenamento">
																	<?php
																	foreach ($select['Ordenamento'] as $key => $row) {
																		if ($query['Ordenamento'] == $key) {
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
												</div>
												
											</div>

											<div class="row">
												<!--
												<div class="col-md-2">
													<label for="DataInicio3">Orç.- Data Inc.</label>
													<div class="input-group DatePicker">
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
															   autofocus name="DataInicio3" value="<?php echo set_value('DataInicio3', $query['DataInicio3']); ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
													</div>
												</div>
												<div class="col-md-2">
													<label for="DataFim3">Orç.- Data Fim</label>
													<div class="input-group DatePicker">
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
															   autofocus name="DataFim3" value="<?php echo set_value('DataFim3', $query['DataFim3']); ?>">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
													</div>
												</div>
												-->
												<div class="col-md-3">
													<label for="DataInicio">Venc.- Data Inc.</label>
													<div class="input-group DatePicker">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
															   autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
													</div>
												</div>
												<div class="col-md-3">
													<label for="DataFim">Venc.- Data Fim</label>
													<div class="input-group DatePicker">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
															   autofocus name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
													</div>
												</div>
												<div class="col-md-3">
													<label for="DataInicio2">Pagam.- Data Inc.</label>
													<div class="input-group DatePicker">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
															   autofocus name="DataInicio2" value="<?php echo set_value('DataInicio2', $query['DataInicio2']); ?>">
													</div>
												</div>
												<div class="col-md-3">
													<label for="DataFim2">Pagam.- Data Fim</label>
													<div class="input-group DatePicker">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
															   autofocus name="DataFim2" value="<?php echo set_value('DataFim2', $query['DataFim2']); ?>">
													</div>
												</div>
											</div>

											<div class="row">
												<br>
												<div class="col-md-3 text-left">
													<div class="form-footer btn-block">
														<button class="btn btn-primary" name="pesquisar" value="0" type="submit">
														<span class="glyphicon glyphicon-search"></span> Pesquisar</button>
													</div>
												</div>
												<div class="col-md-2 text-left">
													<div class="form-footer btn-block">
														<button type="button" class="btn btn-default " data-dismiss="modal">
														<span class="glyphicon glyphicon-remove"> Fechar</button>
													</div>
												</div>
											</div>
										</div>
									</div>	
								</div>		
							</div>			
						</div>
						
						</form>

						<?php echo (isset($list)) ? $list : FALSE ?>

					</div>

				</div>

			</div>

		</div>
	</div>
	<div class="col-md-1"></div>

