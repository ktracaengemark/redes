<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }


    ##############
    #RESPONSÁVEL
    ##############

    public function set_cliente($data) {

        $query = $this->db->insert('App_Cliente', $data);

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
	
	public function get_cliente($data) {
        $query = $this->db->query('SELECT * FROM App_Cliente WHERE idApp_Cliente = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function update_cliente($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_Cliente', $data, array('idApp_Cliente' => $id));
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

    public function delete_cliente($data) {

        $query = $this->db->query('SELECT idApp_OrcaTrataCons FROM App_OrcaTrataCons WHERE idApp_Cliente = ' . $data);
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

        #$this->db->delete('App_Consulta', array('idApp_Cliente' => $data));
        $this->db->delete('App_ContatoCliente', array('idApp_Cliente' => $data));

        foreach ($query as $key) {
            $query = $this->db->delete('App_ProdutoVendaCons', array('idApp_OrcaTrataCons' => $key['idApp_OrcaTrataCons']));
            $query = $this->db->delete('App_ServicoVendaCons', array('idApp_OrcaTrataCons' => $key['idApp_OrcaTrataCons']));
            $query = $this->db->delete('App_ParcelasRecebiveisCons', array('idApp_OrcaTrataCons' => $key['idApp_OrcaTrataCons']));
            $query = $this->db->delete('App_ProcedimentoCons', array('idApp_OrcaTrataCons' => $key['idApp_OrcaTrataCons']));
        }

        $this->db->delete('App_OrcaTrataCons', array('idApp_Cliente' => $data));
        $this->db->delete('App_Cliente', array('idApp_Cliente' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_cliente($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_Cliente WHERE '
                . 'Empresa = ' . $_SESSION['log']['Empresa'] . ' AND '
				. 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND '
				. 'Nivel =  3  AND '
                . '(NomeCliente like "%' . $data . '%" OR '
                #. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'NomeCliente like "%' . $data . '%" OR '
                . 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Celular like "%' . $data . '%") '
                . 'ORDER BY NomeCliente ASC ');
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

    public function lista_contatocliente($id, $bool) {

        $query = $this->db->query(
            'SELECT * '
                . 'FROM App_ContatoCliente WHERE '
                . 'idApp_Cliente = ' . $id . ' '
            . 'ORDER BY NomeContatoCliente ASC ');
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

	public function select_cliente2() {

        $query = $this->db->query('
            SELECT
				P.idApp_Cliente,
				CONCAT(IFNULL(P.NomeCliente,"")) AS NomeCliente
            FROM
                App_Cliente AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "2"  
			ORDER BY P.NomeCliente ASC
        ');

        $array = array();
        $array[0] = ':: Todos ::';
        foreach ($query->result() as $row) {
            $array[$row->idApp_Cliente] = $row->NomeCliente;
        }

        return $array;
    }

	public function select_cliente($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
				P.idApp_Cliente,
				CONCAT(IFNULL(P.NomeCliente,"")) AS NomeCliente
            FROM
                App_Cliente AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "3"  
			ORDER BY P.NomeCliente ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
				P.idApp_Cliente,
				CONCAT(IFNULL(P.NomeCliente,"")) AS NomeCliente
            FROM
                App_Cliente AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "3"  
			ORDER BY P.NomeCliente ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Cliente] = $row->NomeCliente;
            }
        }

        return $array;
    }

	public function select_clientegestor($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT
				P.idApp_Cliente,
				CONCAT(IFNULL(P.NomeCliente,"")) AS NomeCliente
            FROM
                App_Cliente AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "4"  
			ORDER BY P.NomeCliente ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT
				P.idApp_Cliente,
				CONCAT(IFNULL(P.NomeCliente,"")) AS NomeCliente
            FROM
                App_Cliente AS P
					LEFT JOIN Tab_Funcao AS F ON F.idTab_Funcao = P.Funcao
            WHERE
                P.idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                P.Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				P.Nivel = "4"  
			ORDER BY P.NomeCliente ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_Cliente] = $row->NomeCliente;
            }
        }

        return $array;
    }
}
