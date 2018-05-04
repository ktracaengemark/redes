<?php if ($msg) echo $msg; ?>


	<div class="col-md-1"></div>
    <div class="col-md-10">
		<div class="row">
				
			<div class="main">

				<?php echo validation_errors(); ?>

				<div class="panel panel-primary">

					<div class="panel-heading"><strong><?php echo $titulo; ?></strong>
					
						<?php echo form_open('relatorioconsultor/orcamento', 'role="form"'); ?>
					
						<div class="text-left">	
							<button class="btn btn-sm btn-info" name="pesquisar" value="0" type="submit">
								<span class="glyphicon glyphicon-search"></span> Pesquisar
							</button>
							<button  class="btn btn-sm btn-success" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
								<span class="glyphicon glyphicon-filter"></span> Filtros
							</button>											
							<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>relatorioconsultor/clientesusuario" role="button"> 
								<span class="glyphicon glyphicon-plus"></span> Novo Orç.
							</a>
						</div>
						
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
												<div class="col-md-9  text-left">
													<label for="Ordenamento">Nome do Cliente:</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" onchange="this.form.submit()"
															id="NomeCliente" name="NomeCliente">
														<?php
														foreach ($select['NomeCliente'] as $key => $row) {
															if ($query['NomeCliente'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
												</div>
												<div class="col-md-3 text-left">
													<label for="ServicoConcluido">Prod. Entr.?</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " onchange="this.form.submit()"
															id="ServicoConcluido" name="ServicoConcluido">
														<?php
														foreach ($select['ServicoConcluido'] as $key => $row) {
															if ($query['ServicoConcluido'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
												</div>												
											</div>	
											<div class="row">	
												<div class="col-md-9 text-left">
													<label for="Ordenamento">Ordenamento:</label>
													<div class="form-group btn-block">
														<div class="row">
															<div class="col-md-9">
																<select data-placeholder="Selecione uma opção..." class="form-control Chosen " 
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

															<div class="col-md-3">
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
												<div class="col-md-3 text-left">
													<label for="Ordenamento">Forma de Pag.</label>
													<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block " onchange="this.form.submit()"
															id="FormaPag" name="FormaPag">
														<?php
														foreach ($select['FormaPag'] as $key => $row) {
															if ($query['FormaPag'] == $key) {
																echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
															} else {
																echo '<option value="' . $key . '">' . $row . '</option>';
															}
														}
														?>
													</select>
												</div>
											</div>	
											<div class="row">																	
												<div class="col-md-3 text-left">
													<label for="DataInicio">Orç. - Dt Inc.</label>
													<div class="input-group DatePicker btn-block">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
														
													</div>
												</div>
												<div class="col-md-3 text-left">
													<label for="DataFim">Orç. - Dt Fim</label>
													<div class="input-group DatePicker btn-block">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
														
													</div>
												</div>
							
												<div class="col-md-3 text-left">
													<label for="DataInicio3">Ret. - Dt Inc.</label>
													<div class="input-group DatePicker btn-block">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																name="DataInicio3" value="<?php echo set_value('DataInicio3', $query['DataInicio3']); ?>">
														
													</div>
												</div>
												<div class="col-md-3 text-left">
													<label for="DataFim3">Ret. - Dt Fim</label>
													<div class="input-group DatePicker btn-block">
														<span class="input-group-addon" disabled>
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
														<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
																name="DataFim3" value="<?php echo set_value('DataFim3', $query['DataFim3']); ?>">
														
													</div>
												</div>	
											</div>	
											<div class="row">
												<br>
												<div class="col-md-3 text-left">
													<div class="form-footer btn-block">
														<button class="btn btn-primary " name="pesquisar" value="0" type="submit">
														<span class="glyphicon glyphicon-search"></span> Pesquisar</button>
													</div>
												</div>
												<div class="col-md-2 text-left">
													<div class="form-footer btn-block">
														<button type="button" class="btn btn-default" data-dismiss="modal">
														<span class="glyphicon glyphicon-remove"> Fechar</button>
													</div>
												</div>
											</div>													
										</div>	
									</div>
								</div>
							</div>
						</div>

						<?php echo (isset($list)) ? $list : FALSE ?>
					
					</div>
					
					</form>
					
				</div>
				
			</div>
				
		</div>
		
	</div>	
	<div class="col-md-1"></div>	

