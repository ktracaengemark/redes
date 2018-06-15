<?php

#modelo que verifica usu�rio e senha e loga o usu�rio no sistema, criando as sess�es necess�rias

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }


    ##############
    #RESPONS�VEL
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

    public function get_cliente($data) {
        $query = $this->db->query('SELECT * FROM App_Cliente WHERE idApp_Cliente = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }
	
	public function get_cliente1($data) {
        $query = $this->db->query('
		SELECT *

		FROM 
			App_Cliente AS C 
				LEFT JOIN App_Consultor AS CO ON CO.idApp_Consultor = C.idApp_Consultor
		WHERE 
			C.idApp_Cliente = ' . $data);

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
		$this->db->delete('App_ProcedimentoCons', array('idApp_Cliente' => $data));

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
				. 'idApp_Consultor = ' . $_SESSION['log']['id'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND '
                . '(NomeCliente like "%' . $data . '%" OR '
                #. 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'NomeCliente like "%' . $data . '%" OR '
                . 'DataNascimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Telefone1 like "%' . $data . '%" OR Telefone2 like "%' . $data . '%" OR Telefone3 like "%' . $data . '%") '
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

    public function set_procedimento($data) {

        $query = $this->db->insert_batch('App_ProcedimentoCons', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }	
	
    public function get_procedimento($data) {
		$query = $this->db->query('SELECT * FROM App_ProcedimentoCons WHERE idApp_Cliente = ' . $data);
        $query = $query->result_array();

        return $query;
    }	

    public function update_procedimento($data) {

        $query = $this->db->update_batch('App_ProcedimentoCons', $data, 'idApp_ProcedimentoCons');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_procedimento($data) {

        $this->db->where_in('idApp_ProcedimentoCons', $data);
        $this->db->delete('App_ProcedimentoCons');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
		
}
