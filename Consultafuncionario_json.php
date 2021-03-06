<?php

session_start();

$link = mysql_connect($_SESSION['db']['hostname'], $_SESSION['db']['username'], $_SESSION['db']['password']);
#$link = mysql_connect('159.203.125.243', 'usuario', '20UtpJ15');
#$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('N�o foi poss�vel conectar: ' . mysql_error());
}

$db = mysql_select_db($_SESSION['db']['database'], $link);
if (!$db) {
    die('N�o foi poss�vel selecionar banco de dados: ' . mysql_error());
}

#echo 'Conex�o bem sucedida';

//Acho que as pr�ximas linhas s�o redundantes, verificar
$query = ($_SESSION['log']['NomeUsuario'] && isset($_SESSION['log']['NomeUsuario'])) ?
    #'P.idApp_Consultor = ' . $_SESSION['log']['NomeUsuario'] . ' AND ' : FALSE;
	'A.idApp_Consultor = ' . $_SESSION['log']['NomeUsuario'] . ' AND ' : FALSE;

$permissao = ($_SESSION['log']['Permissao'] > 2) ?
	'A.idApp_Consultor = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;

$result = mysql_query(
        'SELECT
            A.idApp_Agenda,
			A.idApp_Consultor,
            U.Nome AS NomeProfissional,
			C.idApp_Consulta,
            C.idApp_Cliente,
            R.NomeCliente,
			R.Telefone1,
            D.NomeContatoCliente,
            P.NomeConsultor AS NomeUsuario,
			P.Permissao,
            C.DataInicio,
            C.DataFim,
            C.Procedimento,
            C.Paciente,
            C.Obs,
            C.idTab_Status,
            TC.TipoConsulta,
            C.Evento
        FROM
            App_Agenda AS A
                LEFT JOIN App_Consultor AS U ON U.idApp_Consultor = A.idApp_Consultor,
            App_Consulta AS C
                LEFT JOIN App_Cliente AS R ON R.idApp_Cliente = C.idApp_Cliente
                LEFT JOIN App_ContatoCliente AS D ON D.idApp_ContatoCliente = C.idApp_ContatoCliente
                LEFT JOIN App_Consultor AS P ON P.idApp_Consultor = C.idApp_Consultor
                LEFT JOIN Tab_TipoConsulta AS TC ON TC.idTab_TipoConsulta = C.idTab_TipoConsulta

        WHERE
			C.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
			C.idApp_Consultor = ' . $_SESSION['log']['id'] . ' AND
           	C.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
			' . $query . '
            ' . $permissao . '
            A.idApp_Agenda = C.idApp_Agenda
        ORDER BY C.DataInicio ASC'
);

while ($row = mysql_fetch_assoc($result)) {

    if ($row['Evento']) {

        $c = '_evento';
        //(strlen(utf8_encode($row['Obs'])) > 20) ? $title = substr(utf8_encode($row['Obs']), 0, 20).'...' : $title = utf8_encode($row['Obs']);
        $title = mb_convert_encoding($row['Obs'], "UTF-8", "ISO-8859-1");
		#$title = utf8_encode($row['NomeUsuario']);
		#$title = utf8_encode($row['idApp_Consultor']);
		$subtitle = mb_convert_encoding($row['NomeUsuario'], "UTF-8", "ISO-8859-1");

		#$profissional = utf8_encode($row['NomeUsuario']);
		#$profissional = utf8_encode($row['idApp_Agenda']);
		$profissional = mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");

	}
	else {

        $c = '/' . $row['idApp_Cliente'];

        if ($row['Paciente'] == 'D') {
            $title = mb_convert_encoding($row['NomeContatoCliente'], "UTF-8", "ISO-8859-1");
            $subtitle = mb_convert_encoding($row['NomeCliente'], "UTF-8", "ISO-8859-1");

			#$profissional = utf8_encode($row['NomeUsuario']);
			#$profissional = utf8_encode($row['idApp_Agenda']);
			$profissional = mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");

			$telefone1 = mb_convert_encoding($row['Telefone1'], "UTF-8", "ISO-8859-1");
        }
        else {

            #$title = utf8_encode($row['NomeCliente']);
            $title = mb_convert_encoding($row['NomeCliente'], "UTF-8", "ISO-8859-1");
            #$title = $row['NomeCliente'];
            #'name' => mb_convert_encoding($row['NomeProduto'], "UTF-8", "ISO-8859-1"),

			#$title = utf8_encode($row['NomeUsuario']);
			#$subtitle = utf8_encode($row['NomeUsuario']);
            $subtitle = mb_convert_encoding($row['NomeUsuario'], "UTF-8", "ISO-8859-1");

			#$profissional = utf8_encode($row['NomeUsuario']);
			#$profissional = utf8_encode($row['idApp_Agenda']);
			#$profissional = utf8_encode($row['idApp_Consultor']);
            $profissional = mb_convert_encoding($row['NomeProfissional'], "UTF-8", "ISO-8859-1");

			#$telefone1 = utf8_encode($row['Telefone1']);
            $telefone1 = mb_convert_encoding($row['Telefone1'], "UTF-8", "ISO-8859-1");

        }

    }

    $url = 'consultaconsultor/alterar' . $c . '/' . $row['idApp_Consulta'];

    if ($row['DataFim'] < date('Y-m-d H:i:s')) {

        //$url = false;
        $textColor = 'grey';

        if ($row['Evento'])
            $status = '#e6e6e6';
        else {
            if ($row['idTab_Status'] == 1)
                $status = '#EBCCA1';
            elseif ($row['idTab_Status'] == 2)
                $status = ' #95d095';
            elseif ($row['idTab_Status'] == 3)
                $status = '#99B6D0';
            else
                $status = '#E4BEBD';
        }
    }
    else {

        //$url = 'consulta/alterar/'.$row['idApp_Paciente'].'/'.$row['idApp_Consulta'];
        $textColor = 'black';

        if ($row['Evento'])
            $status = '#a6a6a6';
        else {
            if ($row['idTab_Status'] == 1)
                $status = '#f0ad4e';
            elseif ($row['idTab_Status'] == 2)
                $status = '#5cb85c';
            elseif ($row['idTab_Status'] == 3)
                $status = 'darken(#428bca, 6.5%)';
            else
                $status = '#d9534f';
        }
    }

    $event_array[] = array(
        'id' => $row['idApp_Consulta'],
        'title' => $title,
        'subtitle' => $subtitle,
        'start' => str_replace('', 'T', $row['DataInicio']),
        'end' => str_replace('', 'T', $row['DataFim']),
        'allDay' => false,
        'url' => $url,
        'color' => $status,
        'textColor' => $textColor,
        'TipoConsulta' => mb_convert_encoding($row['TipoConsulta'], "UTF-8", "ISO-8859-1"),
        'Procedimento' => mb_convert_encoding($row['Procedimento'], "UTF-8", "ISO-8859-1"),
		'Telefone1' => mb_convert_encoding($row['Telefone1'], "UTF-8", "ISO-8859-1"),
        'Obs' => mb_convert_encoding($row['Obs'], "UTF-8", "ISO-8859-1"),
        'Evento' => $row['Evento'],
        'Paciente' => $row['Paciente'],
        #   'ContatoCliente' => $contatocliente,
        'Profissional' => $profissional,
    );
}

echo json_encode($event_array);
mysql_close($link);
?>
