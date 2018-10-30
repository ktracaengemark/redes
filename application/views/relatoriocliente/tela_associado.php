<?php if ($msg) echo $msg; ?>

<div class="col-md-2"></div>
<div class="col-md-8">
    <div class="row">
        <div class="main">
            <?php echo validation_errors(); ?>
            <div class="panel panel-primary">
                <div class="panel-heading"><strong><?php echo $titulo; ?></strong></div>
                <div class="panel-body">
                    <?php echo form_open('relatoriocliente/associado', 'role="form"'); ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <label for="Ordenamento">Nome do Associado:</label>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <select data-placeholder="Selecione uma opção..." class="form-control Chosen"
                                                    id="NomeCliente" autofocus name="NomeCliente">
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
                                    </div>
                                </div>
                            </div>						
                            <div class="col-md-6">
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
							
                            <div class="col-md-1"></div>
                        </div>
                    </div>
					<div class="col-md-1"></div>
					<div class="col-md-10" >
						<div class="form-group">
							<div class="row">
								<div class="col-md-4 text-left">
									<button class="btn btn-md btn-primary" name="pesquisar" value="0" type="submit">
										<span class="glyphicon glyphicon-search"></span> Pesquisar
									</button>
								</div>
								<div class="col-md-4 text-left">											
									<a class="btn btn-md btn-success" href="<?php echo base_url() ?>relatoriocliente/associadopag" role="button"> 
										<span class="glyphicon glyphicon-plus"></span> Pag. dos Indicados
									</a>
								</div>
								<div class="col-md-4 text-left">											
									<a class="btn btn-md btn-danger" href="<?php echo base_url() ?>clienteassociado/cadastrar" role="button"> 
										<span class="glyphicon glyphicon-plus"></span> Cadastrar Indicação
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-1"></div>
                    </form>
                    <br>
                    <?php echo (isset($list)) ? $list : FALSE ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-2"></div>