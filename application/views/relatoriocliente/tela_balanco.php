<?php if ($msg) echo $msg; ?>


	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="row">

			<div class="main">

				<?php echo validation_errors(); ?>

				<div class="panel panel-primary">

					<div class="panel-heading"><strong><?php echo $titulo; ?></strong>
						<?php echo form_open('relatoriocliente/balanco', 'role="form"'); ?>
						
						<div class="row">
							<div class="col-md-2">
								<div>
									<input type="text" class="form-control Numero" maxlength="4" placeholder="AAAA"
										   autofocus name="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
								</div>
							
								<button class="btn btn-sm btn-info" name="pesquisar" value="0" type="submit">
									<span class="glyphicon glyphicon-search"></span> Pesq.
								</button>									
							</div>
						</div>	
					</div>
					<div class="panel-body">

						</form>

						<?php echo (isset($list)) ? $list : FALSE ?>

					</div>

				</div>

			</div>

		</div>
	</div>
	<div class="col-md-1"></div>
