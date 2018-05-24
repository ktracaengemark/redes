
<div class="container-fluid">
    <div class="row">
        <div>	
			<table class="table table-bordered table-condensed table-striped">
                <thead>
					<tr>
						<th colspan="4" class="active">Total: <?php echo $report->num_rows(); ?> resultado(s) /  <?php echo $report->soma->quantidade ?> Itens(s)</th>
					</tr>
				</thead>
			</table>	
			<table class="table table-bordered table-condensed table-striped">	
				<thead>
                    <tr>						
						<th class="active">Nº Orç.</th>
                        <th class="active">Consultor</th>
						<th class="active">Dt.Orç.</th>
						<th class="active">Código</th>
						<th class="active">Qtd.</th>
						<th class="active">Categoria</th>
						<th class="active">Produto</th>						
						<th class="active">Aux1</th>
						<th class="active">Aux2</th>
						<th class="active">Valor</th>						
						<th class="active">Dt.Dev.</th>
						<th class="active">Obs</th>						
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'orcatrata/alterar/' . $row['idApp_OrcaTrata'] . '">';							
							echo '<td>' . $row['idApp_OrcaTrata'] . '</td>';
                            echo '<td>' . $row['NomeConsultor'] . '</td>';
							echo '<td>' . $row['DataOrca'] . '</td>';
							echo '<td>' . $row['CodProd'] . '</td>';
							echo '<td>' . $row['QtdVendaServico'] . '</td>';
							echo '<td>' . $row['Prodaux3'] . '</td>';
							echo '<td>' . $row['Produtos'] . '</td>';							
							echo '<td>' . $row['Prodaux1'] . '</td>';
							echo '<td>' . $row['Prodaux2'] . '</td>';
							echo '<td>' . $row['ValorVendaServico'] . '</td>';
							echo '<td>' . $row['DataValidadeServico'] . '</td>';
							echo '<td>' . $row['ObsServico'] . '</td>';							
                        echo '</tr>';
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
