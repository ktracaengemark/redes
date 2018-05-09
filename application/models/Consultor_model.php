<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Consultor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }


    ##############
    #RESPONSÁVEL
    ##############

    public function set_consultor($data) {

        $query = $this->db->insert('App_Consultor', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_agenda($data) {
        #unset($data['idSisgef_Fila']);
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit();
         */
        $query = $this->db->insert('App_Agenda', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        }
        else {
            #return TRUE;
            return $this->db->insert_id();
        }

    }
	
	public function get_consultor($data) {
        $query = $this->db->query('SELECT * FROM App_Consultor WHERE idApp_Consultor = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function update_consultor($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Consultor', $data, array('idApp_Consultor' => $id));
        /*
          echo $this->db->last_query();
          echo '<br>';
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit ();
         */
        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_consultor($data) {

        $query = $this->db->query('SELECT idApp_OrcaTrataCons FROM App_OrcaTrataCons WHERE idApp_Consultor = ' . $data);
        $query = $query->result_array();

        /*
        echo $this->db->last_query();
        #$query = $query->result();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";


        foreach ($query as $key) {
            /*
            echo $key['idApp_OrcaTrataCons'];
            echo '<br />';
            #echo $value;
            echo '<br />';
        }

        exit();

        */

        #$this->db->delete('App_Consulta', array('idApp_Consultor' => $data));
        $this->db->delete('App_ContatoConsultor', array('idApp_Consultor' => $data));

        foreach ($query as $key) {
            $query = $this->db->delete('App_ProdutoVendaCons', array('idApp_OrcaTrataCons' => $key['idApp_OrcaTrataCons']));
            $query = $this->db->delete('App_ServicoVendaCons', array('idApp_OrcaTrataCons' => $key['idApp_OrcaTrataCons']));
            $query = $this->db->delete('App_ParcelasRecebiveisCons', array('idApp_OrcaTrataCons' => $key['idApp_OrcaTrataCons']));
            $query = $this->db->delete('App_ProcedimentoCons', array('idApp_OrcaTrataCons' => $key['idApp_OrcaTrataCons']));
        }

        $this->db->delete('App_OrcaTrataCons', array('idApp_Consultor' => $data));
        $this->db->delete('App_Consultor', array('idApp_Consultor' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_consultor($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_Consultor WHERE '
                . 'Empresa = ' . $_SESSION['log']['Empresa'] . ' AND '
				. 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND '
				. 'Nivel =  3  AND '
                . '(NomeConsultor like "%' . $data . '%" OR '
                #. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'NomeConsultor like "%' . $data . '%" OR '
                . 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Celular like "%' . $data . '%") '
                . 'ORDER BY NomeConsultor ASC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
        */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($x === FALSE) {
                return TRUE;
            } else {
                foreach ($query->result() as $row) {
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                }

                return $query;
            }
        }
    }

    public function lista_contatoconsultor($id, $bool) {

        $query = $this->db->query(
            'SELECT * '
                . 'FROM App_ContatoConsultor WHERE '
                . 'idApp_Consultor = ' . $id . ' '
            . 'ORDER BY NomeContatoConsultor ASC ');
        /*
          echo $this->db->last_query();
          echo "<pre>";
          print_r($query);
          echo "</pre>";
          exit();
         */
        if ($query->num_rows() === 0) {
            return FALSE;
        } else {
            if ($bool === FALSE) {
                return TRUE;
            } else {
                foreach ($query->result() as $row) {
                    $row->Idade = $this->basico->calcula_idade($row->DataNascimento);
                    $row->DataNascimento = $this->basico->mascara_data($row->DataNascimento, 'barras');
                    $row->Sexo = $this->Basico_model->get_sexo($row->Sexo);
                    $row->RelaPes = $this->Basico_model->get_relapes($row->RelaPes);
                    $row->RelaPes2 = $this->Basico_model->get_relapes($row->RelaPes2);
                }

                return $query;
            }
        }
    }

	public function select_consultor2() {

        $query = $this->db->query('
            SELECT
				P.idApp_Consultor,
				CONCAT(IFNULL(P.NomeConsultor,"")) AS NomeConsultor
            FROM
                App_Consultor AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "2"  
			ORDER BY P.NomeConsultor ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Consultor] = $row->NomeConsultor;
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

	public function select_consultorgestor($data = FALSE) {

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
				P.Nivel = "4"  
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
				P.Nivel = "4"  
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
