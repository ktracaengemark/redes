<?php

#modelo que verifica usu�rio e senha e loga o usu�rio no sistema, criando as sess�es necess�rias

defined('BASEPATH') OR exit('No direct script access allowed');

class Basico_model extends CI_Model {

    public function __construct() {
        #parent::__construct();
        $this->load->database();
        $this->load->library(array('basico', 'user_agent'));
    }

    public function select_item($modulo, $tabela, $campo = FALSE, $campoitem = FALSE) {

        if ($campo !== FALSE) {
            $query = $this->db->query('SELECT id' . $modulo . '_' . $tabela . ' AS Id, ' . $tabela . ' AS Item FROM '
                    . '' . $modulo . '_' . $tabela . ' '
                    . 'WHERE ' . $campo . ' = "' . $campoitem . '" ORDER BY ' . $tabela . ' ASC');
        } else {
            $query = $this->db->query('SELECT id' . $modulo . '_' . $tabela . ' AS Id, ' . $tabela . ' AS Item FROM '
                    . '' . $modulo . '_' . $tabela . ' ORDER BY ' . $tabela . ' ASC');
        }

        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Id] = $row->Item;
            }

            /*
              echo $this->db->last_query();
              echo '<br>';
              echo "<pre>";
              print_r($array);
              echo "</pre>";
              exit();
             */

            return $array;
        }
    }

    public function select_nacionalidade() {

        $query = $this->db->query('SELECT * FROM Tab_Nacionalidade ORDER BY Nacionalidade ASC');

        $array = array();
        $array[0] = ':: SELECIONE ::';
        foreach ($query->result() as $row) {
            $array[$row->idTab_Nacionalidade] = $row->Nacionalidade;
        }

        return $array;
    }

    public function select_estado_civil($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_EstadoCivil ORDER BY EstadoCivil ASC');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_EstadoCivil ORDER BY EstadoCivil ASC');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_EstadoCivil] = $row->EstadoCivil;
            }
        }

        return $array;
    }

    public function select_uf($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Uf ORDER BY Uf ASC');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Uf ORDER BY Uf ASC');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Uf] = $row->Uf;
            }
        }

        return $array;
    }

    public function select_sexo($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Sexo');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Sexo');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->Sexo;
            }
        }

        return $array;
    }

    public function select_tipo_consulta($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_TipoConsulta');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_TipoConsulta');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoConsulta] = $row->TipoConsulta;
            }
        }

        return $array;
    }

	public function select_tipo_concluido($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_TipoConcluido');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_TipoConcluido');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoConcluido] = $row->TipoConcluido;
            }
        }

        return $array;
    }

	public function select_tipo_tratamentos($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_TipoConsulta');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_TipoConsulta');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoConsulta] = $row->TipoConsulta;
            }
        }

        return $array;
    }

    public function select_status($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Status');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Status');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Status] = $row->Status;
            }
        }

        return $array;
    }

    public function select_municipio2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Municipio ORDER BY NomeMunicipio ASC');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Municipio ORDER BY NomeMunicipio ASC');

            $array = array();
            #$array[0] = ':: SELECIONE ::';
            foreach ($query->result() as $row) {
                $array[$row->idTab_Municipio] = $row->NomeMunicipio;
            }
        }

        return $array;
    }

	public function select_municipio($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
				'SELECT
					idTab_Municipio,
					CONCAT(Uf, " - ", NomeMunicipio) AS NomeMunicipio
				FROM
					Tab_Municipio
				ORDER BY NomeMunicipio ASC, Uf ASC'
				);
        } else {
            $query = $this->db->query(
				'SELECT
					idTab_Municipio,
					CONCAT(Uf, " - ", NomeMunicipio) AS NomeMunicipio
				FROM
					Tab_Municipio
				ORDER BY Uf ASC, NomeMunicipio ASC'
				);

            $array = array();
            #$array[0] = ':: SELECIONE ::';
            foreach ($query->result() as $row) {
                $array[$row->idTab_Municipio] = $row->NomeMunicipio;
            }
        }

        return $array;
    }

    function set_auditoria($auditoriaitem, $tabela, $operacao, $data, $id = NULL) {

        if ($id == NULL)
            $id = $_SESSION['log']['id'];

        $auditoria = array(
            'Tabela' => $tabela,
            'idSis_Usuario' => $id,
            'DataAuditoria' => date('Y-m-d H:i:s', time()),
            'Operacao' => $operacao,
            'Ip' => $this->input->ip_address(),
            'So' => $this->agent->platform(),
            'Navegador' => $this->agent->browser(),
            'NavegadorVersao' => $this->agent->version(),
        );

        if ($this->db->insert('Sis_Auditoria', $auditoria)) {
            $i = 0;
            while (isset($data['auditoriaitem'][$i])) {
                $data['auditoriaitem'][$i]['idSis_Auditoria'] = $this->db->insert_id();
                $i++;
            }

            $this->db->insert_batch('Sis_AuditoriaItem', $data['auditoriaitem']);
        }
    }

    function set_auditoriaempresa($auditoriaitem, $tabela, $operacao, $data, $id = NULL) {

        if ($id == NULL)
            $id = $_SESSION['log']['id'];

        $auditoria = array(
            'Tabela' => $tabela,
            'idSis_EmpresaMatriz' => $id,
            'DataAuditoria' => date('Y-m-d H:i:s', time()),
            'Operacao' => $operacao,
            'Ip' => $this->input->ip_address(),
            'So' => $this->agent->platform(),
            'Navegador' => $this->agent->browser(),
            'NavegadorVersao' => $this->agent->version(),
        );

        if ($this->db->insert('Sis_AuditoriaEmpresa', $auditoria)) {
            $i = 0;
            while (isset($data['auditoriaitem'][$i])) {
                $data['auditoriaitem'][$i]['idSis_AuditoriaEmpresa'] = $this->db->insert_id();
                $i++;
            }

            $this->db->insert_batch('Sis_AuditoriaItemEmpresa', $data['auditoriaitem']);
        }
    }
	
    function set_auditoriaconsultor($auditoriaitem, $tabela, $operacao, $data, $id = NULL) {

        if ($id == NULL)
            $id = $_SESSION['log']['id'];

        $auditoria = array(
            'Tabela' => $tabela,
            'idApp_Consultor' => $id,
            'DataAuditoria' => date('Y-m-d H:i:s', time()),
            'Operacao' => $operacao,
            'Ip' => $this->input->ip_address(),
            'So' => $this->agent->platform(),
            'Navegador' => $this->agent->browser(),
            'NavegadorVersao' => $this->agent->version(),
        );

        if ($this->db->insert('Sis_AuditoriaConsultor', $auditoria)) {
            $i = 0;
            while (isset($data['auditoriaitem'][$i])) {
                $data['auditoriaitem'][$i]['idSis_AuditoriaConsultor'] = $this->db->insert_id();
                $i++;
            }

            $this->db->insert_batch('Sis_AuditoriaItemConsultor', $data['auditoriaitem']);
        }
    }

    public function get_municipio($data) {

        if (isset($data) && $data) {

            $query = $this->db->query('SELECT * FROM Tab_Municipio WHERE idTab_Municipio = ' . $data);

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0];
            }
        } else {
            return "---";
        }
    }

    public function get_sexo($data) {

        if (isset($data) && $data) {

            #$query = $this->db->query('SELECT * FROM Tab_Sexo WHERE idTab_Sexo = ' . $data);
            $query = $this->db->query('SELECT * FROM Tab_Sexo WHERE Abrev = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['Sexo'];
            }
        } else {
            return '';
        }
    }

	public function get_relacom($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_RelaCom WHERE idTab_RelaCom = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['RelaCom'];
            }
        } else {
            return '';
        }
    }

	public function get_relapes($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_RelaPes WHERE idTab_RelaPes = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['RelaPes'];
            }
        } else {
            return '';
        }
    }

	public function get_funcao($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_Funcao WHERE idTab_Funcao = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['Funcao'];
            }
        } else {
            return '';
        }
    }

	public function get_permissao($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Sis_Permissao WHERE idSis_Permissao = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['Nivel'];
            }
        } else {
            return '';
        }
    }

	public function get_atividade($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM App_Atividade WHERE idApp_Atividade = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['Atividade'];
            }
        } else {
            return '';
        }
    }

	public function get_tipofornec($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_TipoFornec WHERE Abrev = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['TipoFornec'];
            }
        } else {
            return '';
        }
    }

	public function get_vendafornec($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_StatusSN WHERE Abrev = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['StatusSN'];
            }
        } else {
            return '';
        }
    }

	public function get_ativo($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_StatusSN WHERE Abrev = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['StatusSN'];
            }
        } else {
            return '';
        }
    }

	public function get_compagenda($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_StatusSN WHERE Abrev = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['StatusSN'];
            }
        } else {
            return '';
        }
    }
	
	public function get_inativo($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('SELECT * FROM Tab_StatusSN WHERE Inativo = "' . $data . '"');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['StatusSN'];
            }
        } else {
            return '';
        }
    }

	public function get_empresa($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('
				SELECT *
					FROM
						Sis_EmpresaFilial
					WHERE
						idSis_EmpresaFilial = "' . $data . '"
				');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['NomeEmpresa'];
            }
        } else {
            return '';
        }
    }

	public function get_profissional($data) {

        if (isset($data) && $data) {

			$query = $this->db->query('
				SELECT *
					FROM
						Sis_Usuario
					WHERE
						idSis_Usuario = "' . $data . '"
				');

            if ($query->num_rows() === 0) {
                return '';
            } else {
                $query = $query->result_array();
                return $query[0]['Nome'];
            }
        } else {
            return '';
        }
    }	
	
	public function select_cliente($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_Cliente,
				CONCAT(IFNULL(NomeCliente, ""), " --- ", IFNULL(Telefone1, ""), " --- ", IFNULL(Telefone2, ""), " --- ", IFNULL(Telefone3, "")) As NomeCliente				
            FROM
                App_Cliente					
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				idApp_Consultor = ' . $_SESSION['log']['id'] . '
			ORDER BY 
				NomeCliente ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_Cliente,
				CONCAT(IFNULL(NomeCliente, ""), " --- ", IFNULL(Telefone1, ""), " --- ", IFNULL(Telefone2, ""), " --- ", IFNULL(Telefone3, "")) As NomeCliente				
            FROM
                App_Cliente					
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				idApp_Consultor = ' . $_SESSION['log']['id'] . '
			ORDER BY 
				NomeCliente ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Cliente] = $row->NomeCliente;
            }
        }

        return $array;
    }

	public function select_orcatrata($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
					P.idApp_OrcaTrata,					
					CONCAT(P.idApp_OrcaTrata, " --- ", U.Nome) AS Nome,
					U.idSis_Usuario
				FROM
					App_OrcaTrata AS P
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idApp_Cliente
				WHERE
					P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					U.Associado = ' . $_SESSION['log']['id'] . ' AND
					P.TipoRD = "R" AND
					P.ServicoConcluido = "N"
					
				ORDER BY
					idApp_OrcaTrata ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
					P.idApp_OrcaTrata,					
					CONCAT(P.idApp_OrcaTrata, " --- ", U.Nome) AS Nome,
					U.idSis_Usuario
				FROM
					App_OrcaTrata AS P
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idApp_Cliente
				WHERE
					P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					U.Associado = ' . $_SESSION['log']['id'] . ' AND
					P.TipoRD = "R" AND
					P.ServicoConcluido = "N"
				ORDER BY
					idApp_OrcaTrata ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_OrcaTrata] = $row->Nome;
            }
        }

        return $array;
    }
	
	public function select_orcatrata2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
					P.idApp_OrcaTrata,					
					CONCAT(P.idApp_OrcaTrata, " --- ", U.Nome) AS Nome,
					U.idSis_Usuario
				FROM
					App_OrcaTrata AS P
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idApp_Cliente
				WHERE
					P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					U.Associado = ' . $_SESSION['log']['id'] . ' AND
					P.TipoRD = "R" AND
					U.idSis_Usuario = ' . $_SESSION['Cliente']['idSis_Usuario'] . ' AND
					P.ServicoConcluido = "N"
					
				ORDER BY
					idApp_OrcaTrata ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
					P.idApp_OrcaTrata,					
					CONCAT(P.idApp_OrcaTrata, " --- ", U.Nome) AS Nome,
					U.idSis_Usuario
				FROM
					App_OrcaTrata AS P
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idApp_Cliente
				WHERE
					P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					U.Associado = ' . $_SESSION['log']['id'] . ' AND
					P.TipoRD = "R" AND
					U.idSis_Usuario = ' . $_SESSION['Cliente']['idSis_Usuario'] . ' AND
					P.ServicoConcluido = "N"
				ORDER BY
					idApp_OrcaTrata ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_OrcaTrata] = $row->Nome;
            }
        }

        return $array;
    }
	
	public function select_orcatrata3($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
					P.idApp_OrcaTrata,					
					CONCAT(P.idApp_OrcaTrata, " --- ", U.Nome) AS Nome,
					U.idSis_Usuario
				FROM
					App_OrcaTrata AS P
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idApp_Cliente
				WHERE
					P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					U.Associado = ' . $_SESSION['log']['id'] . ' AND
					P.TipoRD = "R" AND
					U.idSis_Usuario = ' . $_SESSION['Cliente']['idSis_Usuario'] . ' 
					
				ORDER BY
					idApp_OrcaTrata ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
					P.idApp_OrcaTrata,					
					CONCAT(P.idApp_OrcaTrata, " --- ", U.Nome) AS Nome,
					U.idSis_Usuario
				FROM
					App_OrcaTrata AS P
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idApp_Cliente
				WHERE
					P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					U.Associado = ' . $_SESSION['log']['id'] . ' AND
					P.TipoRD = "R" AND
					U.idSis_Usuario = ' . $_SESSION['Cliente']['idSis_Usuario'] . ' 
				ORDER BY
					idApp_OrcaTrata ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_OrcaTrata] = $row->Nome;
            }
        }

        return $array;
    }

	public function select_orcatratadevcons1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
					P.idApp_OrcaTrata,					
					CONCAT(P.idApp_OrcaTrata, " --- ", U.Nome) AS Nome,
					U.idSis_Usuario
				FROM
					App_OrcaTrata AS P
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idApp_Cliente
				WHERE
					P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					U.Associado = ' . $_SESSION['log']['id'] . ' AND
					P.TipoRD = "R" AND
					U.idSis_Usuario = ' . $_SESSION['Consultor']['idSis_Usuario'] . ' AND
					P.ServicoConcluido = "N"
					
				ORDER BY
					idApp_OrcaTrata ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
					P.idApp_OrcaTrata,					
					CONCAT(P.idApp_OrcaTrata, " --- ", U.Nome) AS Nome,
					U.idSis_Usuario
				FROM
					App_OrcaTrata AS P
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idApp_Cliente
				WHERE
					P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					U.Associado = ' . $_SESSION['log']['id'] . ' AND
					P.TipoRD = "R" AND
					U.idSis_Usuario = ' . $_SESSION['Consultor']['idSis_Usuario'] . ' AND
					P.ServicoConcluido = "N"
				ORDER BY
					idApp_OrcaTrata ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_OrcaTrata] = $row->Nome;
            }
        }

        return $array;
    }
	
	public function select_orcatratadevcons2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
					P.idApp_OrcaTrata,					
					CONCAT(P.idApp_OrcaTrata, " --- ", U.Nome) AS Nome,
					U.idSis_Usuario
				FROM
					App_OrcaTrata AS P
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idApp_Cliente
				WHERE
					P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					U.Associado = ' . $_SESSION['log']['id'] . ' AND
					P.TipoRD = "R" AND
					U.idSis_Usuario = ' . $_SESSION['Consultor']['idSis_Usuario'] . ' 
					
				ORDER BY
					idApp_OrcaTrata ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
					P.idApp_OrcaTrata,					
					CONCAT(P.idApp_OrcaTrata, " --- ", U.Nome) AS Nome,
					U.idSis_Usuario
				FROM
					App_OrcaTrata AS P
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = P.idApp_Cliente
				WHERE
					P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
					P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
					U.Associado = ' . $_SESSION['log']['id'] . ' AND
					P.TipoRD = "R" AND
					U.idSis_Usuario = ' . $_SESSION['Consultor']['idSis_Usuario'] . ' 
				ORDER BY
					idApp_OrcaTrata ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_OrcaTrata] = $row->Nome;
            }
        }

        return $array;
    }	
	
	public function select_profissional($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
				'SELECT
				P.idApp_Profissional,
				CONCAT(F.Abrev, " --- ", P.NomeProfissional) AS NomeProfissional
            FROM
                App_Profissional AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY F.Abrev ASC, P.NomeProfissional ASC'
    );

        } else {
            $query = $this->db->query(
                'SELECT
				P.idApp_Profissional,
				CONCAT(F.Abrev, " --- ", P.NomeProfissional) AS NomeProfissional
            FROM
                App_Profissional AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . '
                ORDER BY F.Abrev ASC, P.NomeProfissional ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Profissional] = $row->NomeProfissional;
            }
        }

        return $array;
    }

	public function select_produto1($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT
				P.idTab_Produto,
				CONCAT(CO.Abrev, " --- ", PB.ProdutoBase, " --- ", PB.UnidadeProdutoBase, " --- ", EM.NomeEmpresa, " ---R$", P.ValorVendaProduto) AS ProdutoBase
            FROM
                Tab_Produto AS P
				LEFT JOIN Tab_ProdutoBase AS PB ON PB.idTab_ProdutoBase = P.ProdutoBase
				LEFT JOIN Tab_Convenio AS CO ON CO.idTab_Convenio = P.Convenio
				LEFT JOIN App_Empresa AS EM ON EM.idApp_Empresa = P.Empresa
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . '
			ORDER BY CO.Convenio DESC, PB.ProdutoBase ASC'
    );
        } else {
            $query = $this->db->query(
                'SELECT
				P.idTab_Produto,
				CONCAT(CO.Abrev, " --- ", PB.ProdutoBase, " --- ", PB.UnidadeProdutoBase, " --- ", EM.NomeEmpresa, " ---R$", P.ValorVendaProduto) AS ProdutoBase
            FROM
                Tab_Produto AS P
				LEFT JOIN Tab_ProdutoBase AS PB ON PB.idTab_ProdutoBase = P.ProdutoBase
				LEFT JOIN Tab_Convenio AS CO ON CO.idTab_Convenio = P.Convenio
				LEFT JOIN App_Empresa AS EM ON EM.idApp_Empresa = P.Empresa
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.idSis_Usuario = ' . $_SESSION['log']['id'] . '
			ORDER BY CO.Convenio DESC, PB.ProdutoBase ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produto] = $row->ProdutoBase;
            }
        }

        return $array;
    }

	public function select_produto($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT
                TPV.idTab_Produto,
				CONCAT(TPV.NomeProduto, " --- ", TPV.UnidadeProduto, " --- R$ ", TPV.ValorVendaProduto) AS NomeProduto,
				TPV.ValorVendaProduto
            FROM
                Tab_Produto AS TPV
            WHERE
				TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(TPV.Empresa = ' . $_SESSION['log']['id'] . ' OR
				 TPV.Empresa = ' . $_SESSION['log']['Empresa'] . ')
			ORDER BY
				TPV.NomeProduto ASC
    ');
        } else {
            $query = $this->db->query(
                'SELECT
                TPV.idTab_Produto,
				CONCAT(TPV.NomeProduto, " --- ", TPV.UnidadeProduto, " --- R$ ", TPV.ValorVendaProduto) AS NomeProduto,
				TPV.ValorVendaProduto
            FROM
                Tab_Produto AS TPV
            WHERE
				TPV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(TPV.Empresa = ' . $_SESSION['log']['id'] . ' OR
				 TPV.Empresa = ' . $_SESSION['log']['Empresa'] . ')
			ORDER BY
				TPV.NomeProduto ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Produto] = $row->NomeProduto;
            }
        }

        return $array;
    }

	public function select_produtos($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
            'SELECT
                V.idTab_Valor,
                CONCAT(IFNULL(P.CodProd,""), " - ", IFNULL(P.Produtos,""), " - ", IFNULL(V.Convdesc,""), " - R$ ", IFNULL(V.ValorVendaProduto,"")) AS NomeProduto,
                V.ValorVendaProduto,
				P.Categoria
            FROM
                
                Tab_Valor AS V
					LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = P.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = P.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = P.Prodaux1
            WHERE
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND				
				(P.Empresa = ' . $_SESSION['log']['Empresa'] . ' OR P.Empresa = "0" ) AND
				(P.ProdutoProprio = ' . $_SESSION['log']['id'] . ' OR P.ProdutoProprio = "0") AND
				V.Convenio = "53" AND				
                P.idTab_Produtos = V.idTab_Produtos
			ORDER BY
				V.idTab_Valor,
				P.CodProd ASC,
				P.Categoria ASC,
				TP3.Prodaux3,				
				P.Produtos ASC,
				TP1.Prodaux1,
				TP2.Prodaux2,
				TFO.NomeFornecedor ASC'
    );
        } else {
            $query = $this->db->query(
            'SELECT
                V.idTab_Valor,
                CONCAT(IFNULL(P.CodProd,""), " - ", IFNULL(P.Produtos,""), " - ", IFNULL(V.Convdesc,""), " - R$ ", IFNULL(V.ValorVendaProduto,"")) AS NomeProduto,
                V.ValorVendaProduto,
				P.Categoria
            FROM
                
                Tab_Valor AS V
					LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = P.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = P.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = P.Prodaux1
            WHERE
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND				
				(P.Empresa = ' . $_SESSION['log']['Empresa'] . ' OR P.Empresa = "0" ) AND
				(P.ProdutoProprio = ' . $_SESSION['log']['id'] . ' OR P.ProdutoProprio = "0") AND
				V.Convenio = "53" AND				
                P.idTab_Produtos = V.idTab_Produtos
			ORDER BY
				V.idTab_Valor,
				P.CodProd ASC,
				P.Categoria ASC,
				TP3.Prodaux3,				
				P.Produtos ASC,
				TP1.Prodaux1,
				TP2.Prodaux2,
				TFO.NomeFornecedor ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Valor] = $row->NomeProduto;
            }
        }

        return $array;
    }

	public function select_produtosemp($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
            'SELECT
                V.idTab_Valor,
                CONCAT(IFNULL(P.CodProd,""), " - ", IFNULL(P.Produtos,""), " - ", IFNULL(V.Convdesc,""), " - R$ ", IFNULL(V.ValorVendaProduto,"")) AS NomeProduto,
                V.ValorVendaProduto,
				P.Categoria
            FROM
                
                Tab_Valor AS V
					LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = P.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = P.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = P.Prodaux1
            WHERE
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND				
				(P.Empresa = ' . $_SESSION['log']['id'] . ' OR P.Empresa = "0" ) AND
				(P.ProdutoProprio = ' . $_SESSION['log']['id'] . ' OR P.ProdutoProprio = "0") AND
				V.Convenio = "53" AND				
                P.idTab_Produtos = V.idTab_Produtos
			ORDER BY
				V.idTab_Valor,
				P.CodProd ASC,
				P.Categoria ASC,
				TP3.Prodaux3,				
				P.Produtos ASC,
				TP1.Prodaux1,
				TP2.Prodaux2,
				TFO.NomeFornecedor ASC'
    );
        } else {
            $query = $this->db->query(
            'SELECT
                V.idTab_Valor,
                CONCAT(IFNULL(P.CodProd,""), " - ", IFNULL(P.Produtos,""), " - ", IFNULL(V.Convdesc,""), " - R$ ", IFNULL(V.ValorVendaProduto,"")) AS NomeProduto,
                V.ValorVendaProduto,
				P.Categoria
            FROM
                
                Tab_Valor AS V
					LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = P.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = P.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = P.Prodaux1
            WHERE
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND				
				(P.Empresa = ' . $_SESSION['log']['id'] . ' OR P.Empresa = "0" ) AND
				(P.ProdutoProprio = ' . $_SESSION['log']['id'] . ' OR P.ProdutoProprio = "0") AND
				V.Convenio = "53" AND				
                P.idTab_Produtos = V.idTab_Produtos
			ORDER BY
				V.idTab_Valor,
				P.CodProd ASC,
				P.Categoria ASC,
				TP3.Prodaux3,				
				P.Produtos ASC,
				TP1.Prodaux1,
				TP2.Prodaux2,
				TFO.NomeFornecedor ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Valor] = $row->NomeProduto;
            }
        }

        return $array;
    }
	
	public function select_produtoscons($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
            'SELECT
                V.idTab_Valor,
                CONCAT(IFNULL(P.CodProd,""), " -- ", IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(P.Produtos,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", IFNULL(TP2.Prodaux2,""), " -- ", IFNULL(TCO.Convenio,""), " -- ", IFNULL(V.Convdesc,""), " --- ", V.ValorVendaProduto, " -- ", IFNULL(P.UnidadeProduto,""), " -- ", IFNULL(TFO.NomeFornecedor,"")) AS NomeProduto,
                V.ValorVendaProduto,
				P.Categoria
            FROM
                Tab_Valor AS V
					LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = P.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = P.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = P.Prodaux1
            WHERE
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND				
				P.ProdutoProprio = "0") AND
				V.Convenio = "54" AND				
                P.idTab_Produtos = V.idTab_Produtos
			ORDER BY
				P.CodProd ASC,
				P.Categoria ASC,
				TP3.Prodaux3,				
				P.Produtos ASC,
				TP1.Prodaux1,
				TP2.Prodaux2,
				TFO.NomeFornecedor ASC'
    );
        } else {
            $query = $this->db->query(
            'SELECT
                V.idTab_Valor,
                CONCAT(IFNULL(P.CodProd,""), " -- ", IFNULL(TP3.Prodaux3,""), " -- ", IFNULL(P.Produtos,""), " -- ", IFNULL(TP1.Prodaux1,""), " -- ", IFNULL(TP2.Prodaux2,""), " -- ", IFNULL(TCO.Convenio,""), " -- ", IFNULL(V.Convdesc,""), " --- ", V.ValorVendaProduto, " -- ", IFNULL(P.UnidadeProduto,""), " -- ", IFNULL(TFO.NomeFornecedor,"")) AS NomeProduto,
                V.ValorVendaProduto,
				P.Categoria
            FROM
                Tab_Valor AS V
					LEFT JOIN Tab_Convenio AS TCO ON idTab_Convenio = V.Convenio
					LEFT JOIN Tab_Produtos AS P ON P.idTab_Produtos = V.idTab_Produtos
					LEFT JOIN App_Fornecedor AS TFO ON TFO.idApp_Fornecedor = P.Fornecedor
					LEFT JOIN Tab_Prodaux3 AS TP3 ON TP3.idTab_Prodaux3 = P.Prodaux3
					LEFT JOIN Tab_Prodaux2 AS TP2 ON TP2.idTab_Prodaux2 = P.Prodaux2
					LEFT JOIN Tab_Prodaux1 AS TP1 ON TP1.idTab_Prodaux1 = P.Prodaux1
            WHERE
				P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND				
				P.ProdutoProprio = "0") AND
				V.Convenio = "54" AND				
                P.idTab_Produtos = V.idTab_Produtos
			ORDER BY
				P.CodProd ASC,
				P.Categoria ASC,
				TP3.Prodaux3,				
				P.Produtos ASC,
				TP1.Prodaux1,
				TP2.Prodaux2,
				TFO.NomeFornecedor ASC'
    );

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Valor] = $row->NomeProduto;
            }
        }

        return $array;
    }
	
	public function select_servico4($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
            SELECT
                TSV.idTab_Servico,
                CONCAT(TCO.Abrev, " --- ", TSB.ServicoBase, " --- R$ ", TSV.ValorVendaServico) AS ServicoBase,
                TSV.ValorVendaServico
            FROM
                Tab_Servico AS TSV
				LEFT JOIN Tab_Convenio AS TCO ON TCO.idTab_Convenio = TSV.Convenio
				LEFT JOIN Tab_ServicoBase AS TSB ON TSB.idTab_ServicoBase = TSV.ServicoBase
            WHERE
                TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSV.idSis_Usuario = ' . $_SESSION['log']['id'] . '
			ORDER BY
				TCO.Convenio DESC,
				TSB.ServicoBase ASC
    ');
        } else {
            $query = $this->db->query('
            SELECT
                TSV.idTab_Servico,
                CONCAT(TCO.Abrev, " --- ", TSB.ServicoBase, " --- R$ ", TSV.ValorVendaServico) AS ServicoBase,
                TSV.ValorVendaServico
            FROM
                Tab_Servico AS TSV
				LEFT JOIN Tab_Convenio AS TCO ON TCO.idTab_Convenio = TSV.Convenio
				LEFT JOIN Tab_ServicoBase AS TSB ON TSB.idTab_ServicoBase = TSV.ServicoBase
            WHERE
                TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                TSV.idSis_Usuario = ' . $_SESSION['log']['id'] . '
			ORDER BY
				TCO.Convenio DESC,
				TSB.ServicoBase ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Servico] = $row->ServicoBase;
            }
        }

        return $array;
    }

	public function select_servico($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT
                TSV.idTab_Servico,
                CONCAT(TSV.NomeServico, " --- R$ ", TSV.ValorVendaServico) AS NomeServico,
                TSV.ValorVendaServico
            FROM
                Tab_Servico AS TSV
            WHERE
				TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(TSV.Empresa = ' . $_SESSION['log']['id'] . ' OR
				 TSV.Empresa = ' . $_SESSION['log']['Empresa'] . ')
			ORDER BY
				TSV.NomeServico ASC
    ');
        } else {
            $query = $this->db->query(
                'SELECT
                TSV.idTab_Servico,
                CONCAT(TSV.NomeServico, " --- R$ ", TSV.ValorVendaServico) AS NomeServico,
                TSV.ValorVendaServico
            FROM
                Tab_Servico AS TSV
            WHERE
				TSV.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
				(TSV.Empresa = ' . $_SESSION['log']['id'] . ' OR
				 TSV.Empresa = ' . $_SESSION['log']['Empresa'] . ')
			ORDER BY
				TSV.NomeServico ASC
    ');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Servico] = $row->NomeServico;
            }
        }

        return $array;
    }

	public function select_servico2($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(
                'SELECT '
                    . 'idTab_Servico, '
                    . 'NomeServico, '
                    . 'ValorVendaServico, '
					. 'ValorCompraServico '
                    . 'FROM '
                    . 'Tab_Servico '
                    . 'WHERE '
                    . 'idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND '
                    . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] );
        } else {
            $query = $this->db->query('SELECT idTab_Servico, NomeServico, ValorVendaServico, ValorCompraServico  FROM Tab_Servico WHERE idSis_Usuario = ' . $_SESSION['log']['id']);

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Servico] = $row->NomeServico;
            }
        }

        return $array;
    }

	public function select_status_sn($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusSN');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusSN');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->StatusSN;
            }
        }

        return $array;
    }

	public function select_associado($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusSN');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusSN');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->Associado;
            }
        }

        return $array;
    }
	
	public function select_inativo($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusSN');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusSN');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Inativo] = $row->StatusSN;
            }
        }

        return $array;
    }
	
	public function select_statusaux($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_StatusAux');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_StatusAux');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Aux] = $row->StatusAux;
            }
        }

        return $array;
    }

	public function select_tipoproduto($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_TipoProduto');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_TipoProduto');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->TipoProduto;
            }
        }

        return $array;
    }

	public function select_unidadeproduto($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_UnidadeProduto');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_UnidadeProduto');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->UnidadeProduto;
            }
        }

        return $array;
    }

	public function select_categoria($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Categoria');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Categoria');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->Categoria;
            }
        }

        return $array;
    }
	
	public function select_categoriadesp($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Categoriadesp');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Categoriadesp');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_Categoriadesp] = $row->Categoriadesp;
            }
        }

        return $array;
    }

	public function select_tipofornec($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_TipoFornec');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_TipoFornec');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->TipoFornec;
            }
        }

        return $array;
    }

	public function select_permissao($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT
                    idSis_Permissao,
                    Permissao,
					CONCAT(Nivel, " -- ", Permissao) AS Nivel
				FROM
                    Sis_Permissao

				ORDER BY idSis_Permissao ASC
			');

        } else {
            $query = $this->db->query('
				SELECT
                    idSis_Permissao,
                    Permissao,
					CONCAT(Nivel, " -- ", Permissao) AS Nivel
				FROM
                    Sis_Permissao

				ORDER BY idSis_Permissao ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Permissao] = $row->Nivel;
            }
        }

        return $array;
    }
	
	public function select_numusuarios($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT
                    idTab_NumUsuarios,
					DescNumUsuarios,
					CONCAT(NumUsuarios, " -- ", DescNumUsuarios) AS NumUsuarios
				FROM
                    Tab_NumUsuarios
				ORDER BY 
					idTab_NumUsuarios ASC
			');

        } else {
            $query = $this->db->query('
                SELECT
                    idTab_NumUsuarios,
					DescNumUsuarios,
					CONCAT(NumUsuarios, " -- ", DescNumUsuarios) AS NumUsuarios
				FROM
                    Tab_NumUsuarios
				ORDER BY 
					idTab_NumUsuarios ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->NumUsuarios] = $row->NumUsuarios;
            }
        }

        return $array;
    }	

	public function select_agenda($data = FALSE) {

        $q = ($_SESSION['log']['Permissao'] > 2) ?
            ' U.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT
                    A.idApp_Agenda,
                    A.idSis_Usuario,
					U.Nome
				FROM
                    App_Agenda AS A
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = A.idSis_Usuario
				WHERE
                    ' . $q . '
					A.Empresa = ' . $_SESSION['log']['Empresa'] . '
				ORDER BY
					U.Nome ASC
			');

        } else {
            $query = $this->db->query('
				SELECT
                    A.idApp_Agenda,
                    A.idSis_Usuario,
					CONCAT(IFNULL(F.Abrev,""), " --- ", IFNULL(U.Nome,"")) AS Nome

				FROM
                    App_Agenda AS A
						LEFT JOIN Sis_Usuario AS U ON U.idSis_Usuario = A.idSis_Usuario
						LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = U.Funcao
				WHERE
                    ' . $q . '
					A.Empresa = ' . $_SESSION['log']['Empresa'] . '
				ORDER BY
					F.Abrev ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Agenda] = $row->Nome;
            }
        }

        return $array;
    }

	public function select_profissional2($data = FALSE) {

        $q = ($_SESSION['log']['Permissao'] > 2) ? ' U.idSis_Usuario = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT

                    U.idSis_Usuario,
					U.Nome
				FROM

					Sis_Usuario AS U 
				WHERE
                    ' . $q . '
					U.Empresa = ' . $_SESSION['log']['Empresa'] . '
				ORDER BY
					U.Nome ASC
			');

        } else {
            $query = $this->db->query('
				SELECT

                    U.idSis_Usuario,
					CONCAT(IFNULL(F.Abrev,""), " --- ", IFNULL(U.Nome,"")) AS Nome

				FROM

					Sis_Usuario AS U 
						LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = U.Funcao
				WHERE
                    ' . $q . '
					U.Empresa = ' . $_SESSION['log']['Empresa'] . '
				ORDER BY
					F.Abrev ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idSis_Usuario] = $row->Nome;
            }
        }

        return $array;
    }	
		
	public function select_agendaconsultor($data = FALSE) {

        $q = ($_SESSION['log']['Permissao'] > 2) ?
            ' U.idApp_Consultor = ' . $_SESSION['log']['id'] . ' AND ' : FALSE;

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT
                    A.idApp_Agenda,
                    A.idApp_Consultor,
					U.NomeConsultor
				FROM
                    App_Agenda AS A
						LEFT JOIN App_Consultor AS U ON U.idApp_Consultor = A.idApp_Consultor
				WHERE
                    ' . $q . '
					A.Empresa = ' . $_SESSION['log']['Empresa'] . '
				ORDER BY
					U.NomeConsultor ASC
			');

        } else {
            $query = $this->db->query('
				SELECT
                    A.idApp_Agenda,
                    A.idApp_Consultor,
					CONCAT(IFNULL(F.Abrev,""), " --- ", IFNULL(U.NomeConsultor,"")) AS NomeConsultor

				FROM
                    App_Agenda AS A
						LEFT JOIN App_Consultor AS U ON U.idApp_Consultor = A.idApp_Consultor
						LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = U.Funcao
				WHERE
                    ' . $q . '
					A.Empresa = ' . $_SESSION['log']['Empresa'] . '
				ORDER BY
					F.Abrev ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Agenda] = $row->NomeConsultor;
            }
        }

        return $array;
    }

	public function select_tipoprofissional($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
                SELECT
                    idTab_TipoProfissional,
                    TipoProfissional,
					idTab_Modulo
				FROM
                    Tab_TipoProfissional
				WHERE
					idTab_Modulo = "1"
				ORDER BY TipoProfissional ASC
			');

        } else {
            $query = $this->db->query('
				SELECT
                    idTab_TipoProfissional,
                    TipoProfissional,
					idTab_Modulo
				FROM
                    Tab_TipoProfissional
				WHERE
					idTab_Modulo = "1"
				ORDER BY TipoProfissional ASC
			');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoProfissional] = $row->TipoProfissional;
            }
        }

        return $array;
    }

	public function select_modalidade($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('SELECT * FROM Tab_Modalidade');
        } else {
            $query = $this->db->query('SELECT * FROM Tab_Modalidade');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->Abrev] = $row->Modalidade;
            }
        }

        return $array;
    }

    public function select_tiporeceita($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query('
				SELECT 
					TD.idTab_TipoReceita, 
					CONCAT(TD.TipoReceita) AS TipoReceita
				FROM 
					Tab_TipoReceita AS TD
				WHERE 
					TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				ORDER BY
					TD.TipoReceita
				');
				   
        } 
		else {
            $query = $this->db->query('
				SELECT 
					TD.idTab_TipoReceita, 
					CONCAT(TD.TipoReceita) AS TipoReceita
				FROM 
					Tab_TipoReceita AS TD
				WHERE 
					TD.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . '
				ORDER BY
					TD.TipoReceita
				');

            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idTab_TipoReceita] = $row->TipoReceita;
            }
        }

        return $array;
    }

	public function select_consultor($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
				P.idApp_Consultor,
				CONCAT(IFNULL(P.NomeConsultor,"")) AS NomeConsultor
            FROM
                App_Consultor AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "3"  
			ORDER BY P.NomeConsultor ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
				P.idApp_Consultor,
				CONCAT(IFNULL(P.NomeConsultor,"")) AS NomeConsultor
            FROM
                App_Consultor AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "3"  
			ORDER BY P.NomeConsultor ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Consultor] = $row->NomeConsultor;
            }
        }

        return $array;
    }
	
}
