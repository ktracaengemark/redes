<div class="panel panel-default">
    <div class="panel-body">

		<div class="col-md-1"></div>
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

                        				
                        <th class="active"></th>
                    </tr>
                </thead>
				<tbody>
                    <?php
                    foreach ($report->result_array() as $row) {
                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar2/' . $row['idApp_OrcaTrata'] . '">';

						#echo '<div class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] . '">';
							echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
                           							
                            #echo '</div>';
                            echo '<td class="notclickable">
                                    <a class="btn btn-md btn-info notclickable" target="_blank" href="' . base_url() . 'OrcatrataPrint/imprimir/' . $row['idApp_OrcaTrata'] . '">
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
