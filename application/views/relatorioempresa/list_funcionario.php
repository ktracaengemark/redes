<div class="container-fluid">
    <div class="row">

        <div>
			<table class="table table-bordered table-condensed table-striped">	
				<tfoot>
                    <tr>
                        <th colspan="9" class="active">Total encontrado: <?php echo $report->num_rows(); ?> resultado(s)</th>
                    </tr>
                </tfoot>
			</table>
            <table class="table table-bordered table-condensed table-striped">

                <thead>
                    <tr>
                        <th class="active">id</th>
                        <th class="active">Nome do Usuário</th>
						<th class="active">Sexo</th>
						<th class="active">Cpf</th>
						<th class="active">Rg</th>
						<th class="active">Funcao</th>						
						<!--<th class="active">Nivel</th>
						<th class="active">Permissao</th>-->
						<th class="active">Data do Cadastro</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    foreach ($report->result_array() as $row) {

                        #echo '<tr>';
                        echo '<tr class="clickable-row" data-href="' . base_url() . 'funcionario/prontuario/' . $row['idSis_Usuario'] . '">';
                            echo '<td>' . $row['idSis_Usuario'] . '</td>';
                            echo '<td>' . $row['Nome'] . '</td>';
							echo '<td>' . $row['Sexo'] . '</td>';
							echo '<td>' . $row['CpfUsuario'] . '</td>';
							echo '<td>' . $row['RgUsuario'] . '</td>';
							echo '<td>' . $row['Funcao'] . '</td>';
							#echo '<td>' . $row['Nivel'] . '</td>';
							#echo '<td>' . $row['Permissao'] . '</td>';
							echo '<td>' . $row['DataCriacao'] . '</td>';
                        echo '</tr>';
                    }
                    ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
