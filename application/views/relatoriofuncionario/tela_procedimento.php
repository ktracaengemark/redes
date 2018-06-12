<?php if ($msg) echo $msg; ?>

<div class="container-fluid">
    <div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="row">
			<div class="main">

				<?php echo validation_errors(); ?>

				<div class="panel panel-primary">

					<div class="panel-heading"><strong><?php echo $titulo; ?></strong>
					<?php echo form_open('relatoriofuncionario/procedimento', 'role="form"'); ?>
					
						<button class="btn btn-sm btn-info" name="pesquisar" value="0" type="submit">
							<span class="glyphicon glyphicon-search"></span>Pesquise
						</button>
						<button  class="btn btn-sm btn-success" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-filter"></span>Filtro
						</button>
					
					</div>
					<div class="panel-body">
						<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header bg-danger">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros</h4>
									</div>
									<div class="modal-footer">
										<div class="row">
											<div class="col-md-4 text-left">
												<label for="Ordenamento">Nome do Consultor:</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
														id="NomeConsultor" name="NomeConsultor">
													<?php
													foreach ($select['NomeConsultor'] as $key => $row) {
														if ($query['NomeConsultor'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
											
											<div class="col-md-4 text-left">
												<label for="Ordenamento">Profissional:</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
														id="Nome" name="Nome">
													<?php
													foreach ($select['Nome'] as $key => $row) {
														if ($query['Nome'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
											<div class="col-md-4 text-left">
												<label for="ConcluidoProcedimento">Proc. Concl.?</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
														id="ConcluidoProcedimento" name="ConcluidoProcedimento">
													<?php
													foreach ($select['ConcluidoProcedimento'] as $key => $row) {
														if ($query['ConcluidoProcedimento'] == $key) {
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
											<div class="col-md-4 text-left">
												<label for="AprovadoOrca">Aprovado?</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
														id="AprovadoOrca" name="AprovadoOrca">
													<?php
													foreach ($select['AprovadoOrca'] as $key => $row) {
														if ($query['AprovadoOrca'] == $key) {
															echo '<option value="' . $key . '" selected="selected">' . $row . '</option>';
														} else {
															echo '<option value="' . $key . '">' . $row . '</option>';
														}
													}
													?>
												</select>
											</div>
											<div class="col-md-4 text-left">
												<label for="ServicoConcluido">Concluído?</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
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
											<div class="col-md-4 text-left">
												<label for="QuitadoOrca">Quitado?</label>
												<select data-placeholder="Selecione uma opção..." class="form-control Chosen"
														id="QuitadoOrca" name="QuitadoOrca">
													<?php
													foreach ($select['QuitadoOrca'] as $key => $row) {
														if ($query['QuitadoOrca'] == $key) {
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
												<label for="DataInicio">Data Início: *</label>
												<div class="input-group DatePicker">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
													<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
														   autofocus name="DataInicio" value="<?php echo set_value('DataInicio', $query['DataInicio']); ?>">
													
												</div>
											</div>
											<div class="col-md-3 text-left">
												<label for="DataFim">Data Fim: (opc.)</label>
												<div class="input-group DatePicker">
													<span class="input-group-addon" disabled>
														<span class="glyphicon glyphicon-calendar"></span>
													</span>
													<input type="text" class="form-control Date" maxlength="10" placeholder="DD/MM/AAAA"
														   autofocus name="DataFim" value="<?php echo set_value('DataFim', $query['DataFim']); ?>">
													
												</div>
											</div>
											<div class="col-md-6 text-left">
												<label for="Ordenamento">Ordenamento:</label>
												<div class="form-group">
													<div class="row">
														<div class="col-md-6">
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

														<div class="col-md-6">
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
											<div class="form-group col-md-3 text-left">
												<div class="form-footer">
													<button class="btn btn-info btn-block" name="pesquisar" value="0" type="submit">
														<span class="glyphicon glyphicon-search"></span> Pesquisar
													</button>
												</div>
											</div>
											<div class="form-group col-md-3 text-left">
												<div class="form-footer ">
													<button type="button" class="btn btn-primary btn-block" data-dismiss="modal">
														<span class="glyphicon glyphicon-remove"> Fechar
													</button>
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
	<div class="col-md-2"></div>
</div>
