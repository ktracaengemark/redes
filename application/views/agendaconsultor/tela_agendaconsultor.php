<?php if (isset($msg)) echo $msg; ?>

<!--<div id="dp" class="col-md-2"></div>
<div id="datepickerinline" class="col-md-2"></div>
<div id="calendar" class="col-md-8"></div>-->

<div class="col-md-2"></div>
<div class="col-md-7">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong></strong></div>
		<div class="panel-body">
			<div class="form-group">
				<div class="row">
					<div id="calendarconsultor" class="col-md-12"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="fluxo" class="modal bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="fluxo" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-sm vertical-align-center">
            <div class="modal-content">
                <div class="modal-body text-center">
					<div class="row">
						<div class="col-md-8 col-lg-12">
							<!--<label for="">Agendamento:</label>-->
							<div class="row">
								<button type="button" id="MarcarConsulta" onclick="redirecionar1(2)" class="btn btn-primary"> Agendamento
								</button>
							</div>
							<input type="hidden" id="start" />
							<input type="hidden" id="end" />
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong></strong></div>
		<div class="panel-body">
			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<?php if ($_SESSION['log']['Permissao'] == 1 || $_SESSION['log']['Permissao'] == 2) { ?>
						<?php echo form_open('agendaconsultor', 'role="form"'); ?>
							<div class="col-md-12">
								<label for="Ordenamento">Agenda por Prof.:</label>
								<div class="form-group">
									<div class="row">
										<div class="col-md-12">
											<select data-placeholder="Selecione uma opção..." class="form-control Chosen" onchange="this.form.submit()"
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
									</div>
								</div>
							</div>
						</form>
						<?php } ?>
						<div id="datepickerinline2" class="col-md-12"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
