<?php if ($msg) echo $msg; ?>

	<div class="col-md-1"></div>
	<div class="col-md-10">		
		<div class="row">
			<div class="main">
				<?php echo validation_errors(); ?>
				<div class="panel panel-primary">
					<div class="panel-heading"><strong><?php echo $titulo; ?></strong>
						
						<?php echo form_open('relatoriofuncionario/consultores', 'role="form"'); ?>
						
						<button class="btn btn-sm btn-info" name="pesquisar" value="0" type="submit">
							<span class="glyphicon glyphicon-search"></span> Pesq.
						</button>
						
						<button  class="btn btn-sm btn-success" type="button" data-toggle="modal" data-loading-text="Aguarde..." data-target=".bs-excluir-modal2-sm">
							<span class="glyphicon glyphicon-filter"></span> Filtros
						</button>
							
						<a class="btn btn-sm btn-danger" href="<?php echo base_url() ?>consultor/cadastrar" role="button"> 
							<span class="glyphicon glyphicon-plus"></span> Novo Consul.
						</a>					
					</div>
					<div class="panel-body">
						
						<div class="col-md-8" >							
							<div class="form-group">
								
								<div class="modal fade bs-excluir-modal2-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header bg-danger">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title"><span class="glyphicon glyphicon-filter"></span> Filtros</h4>
											</div>
											<div class="modal-footer">
												<div class="form-group">
													<div class="row">
														<div class="col-md-12 text-left">
															<label for="Ordenamento">Nome do Cliente:</label>
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block" onchange="this.form.submit()"
																	id="Nome" autofocus name="Nome">
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
														<div class="col-md-9 text-left">
															<label for="Ordenamento">Ordenamento:</label>
															<div class="form-group btn-block">
																<div class="row">
																	<div class="col-md-8">
																		<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
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
																		<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
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
															<label for="Inativo">Ativo?</label>
															<select data-placeholder="Selecione uma opção..." class="form-control Chosen btn-block"
																	id="Inativo" name="Inativo">
																<?php
																foreach ($select['Inativo'] as $key => $row) {
																	if ($query['Inativo'] == $key) {
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

