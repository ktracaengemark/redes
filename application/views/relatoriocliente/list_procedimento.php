<div class="container-fluid">
    <div class="row">

        <div>
			<table class="table table-bordered table-condensed table-striped">	
				<tfoot>
                    <tr>
                        <th colspan="9" class="active">Total: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </tfoot>
			</table>	
            <table class="table table-bordered table-condensed table-striped">								
                <thead>
                    <tr>
                        <!--<th class="active">id</th>-->
                        <th class="active">A��o</th>
						<th class="active">Data/Concl.</th>
						<th class="active">Contato</th>


                    </tr>
                </thead>

				<tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'procedimentocons/alterar/' . $row['idApp_ProcedimentoCons'] . '">';
                            #echo '<td>' . $row['idApp_Procedimento'] . '</td>';
                            echo '<td>' . $row['Procedimento'] . '</td>';
							echo '<td>' . $row['DataProcedimento'] . ' * ' . $row['ConcluidoProcedimento'] . '</td>';							
							echo '<td>' . $row['NomeCliente'] . '</td>';

                        echo '</tr>';
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
