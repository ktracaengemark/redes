<?php if ($msg) echo $msg; ?>


	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="row">

			<div class="main">

				<?php echo validation_errors(); ?>

				<div class="panel panel-primary">

					<div class="panel-heading"><strong><?php echo $titulo; ?> - Ano</strong>
						
						<?php echo form_open('relatorioempresa/balanco', 'role="form"'); ?>

						<button class="btn btn-sm">
							<input type="text" class="form-control" maxlength="4" placeholder="AAAA"
								   autofocus name="Ano" value="<?php echo set_value('Ano', $query['Ano']); ?>">
						</button>

						<button class="btn btn-sm btn-info" name="pesquisar" value="0" type="submit">
							<span class="glyphicon glyphicon-search"></span> Pesquisar
						</button>
					
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
