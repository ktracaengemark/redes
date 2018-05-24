<div class="panel panel-default">
    <div class="panel-body">

		<div class="col-md-1"></div>
        <!--
		<div class="col-md-3">
            <label for="DataFim">Total dos Orçamentos:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Orcamentos" value="<?php echo $report->soma->somaorcamento ?>">
            </div>
        </div>
		<div class="col-md-3">
            <label for="DataFim">Total dos Descontos:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Descontos" value="<?php echo $report->soma->somadesconto ?>">
            </div>
        </div>
		-->
		<div class="col-md-3">
            <label for="DataFim">Total A Receber:</label>
            <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" disabled aria-label="Total Restante" value="<?php echo $report->soma->somarestante ?>">
            </div>
        </div>
		<div class="col-md-1"></div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div>
			<table class="table table-bordered table-condensed table-striped">
				<tfoot>
                    <tr>
                        <th colspan="3" class="active">Total: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </tfoot>
			</table>
            <table class="table table-bordered table-condensed table-striped">
                <thead>
                    <tr>
						<th class="active">Orç.</th>
						
						<!--<th class="active">Cliente</th>-->
						<th class="active">Cliente/ Rec.</th>
                        <th class="active">Concl.</th>
						<th class="active">Dt. Orç.</th>
						<th class="active">Dt. Retor.</th>
						<!--<th class="active">Orçam.</th>
						<th class="active">Descontos</th>-->
						<th class="active">A Receber</th>											
						<!--<th class="active">Forma Pag.</th>-->
                        				
                        <th class="active"></th>
                    </tr>
                </thead>
				<tbody>
                    <?php
                    foreach ($report->result_array() as $row) {
                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatratacons/alterar2/' . $row['idApp_OrcaTrataCons'] . '">';

						#echo '<div class="clickable-row" data-href="' . base_url() . 'orcatratacons/alterar/' . $row['idApp_OrcaTrataCons'] . '">';
							echo '<td>' . $row['idApp_OrcaTrataCons'] . '</td>';
							#echo '<td>' . $row['NomeCliente'] . '</td>';
							echo '<td>' . $row['Receitas'] . '</td>';
							echo '<td>' . $row['ServicoConcluido'] . '</td>';
							echo '<td>' . $row['DataOrca'] . '</td>';
                            echo '<td>' . $row['DataRetorno'] . '</td>';
                            #echo '<td class="text-left">R$ ' . $row['ValorOrca'] . '</td>';
							#echo '<td class="text-left">R$ ' . $row['ValorDev'] . '</td>';
							echo '<td class="text-left">R$ ' . $row['ValorRestanteOrca'] . '</td>';														
                            #echo '<td>' . $row['FormaPag'] . '</td>';                            							
                            #echo '</div>';
                            echo '<td class="notclickable">
                                    <a class="btn btn-md btn-info notclickable" target="_blank" href="' . base_url() . 'OrcatrataPrintCons/imprimir/' . $row['idApp_OrcaTrataCons'] . '">
                                        <span class="glyphicon glyphicon-print notclickable"></span>
                                    </a>
                                </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>
</div>
