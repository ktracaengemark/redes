<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Procedimentocons_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
    }


    ##############
    #RESPONSÁVEL
    ##############

    public function set_procedimento($data) {

        $query = $this->db->insert('App_ProcedimentoCons', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_procedimento($data) {
        $query = $this->db->query('SELECT * FROM App_ProcedimentoCons WHERE idApp_ProcedimentoCons = ' . $data);

        $query = $query->result_array();

        return $query[0];
    }

    public function update_procedimento($data, $id) {

        unset($data['Id']);
        $query = $this->db->update('App_ProcedimentoCons', $data, array('idApp_ProcedimentoCons' => $id));
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

    public function delete_procedimento($data) {

        $query = $this->db->query('SELECT* FROM App_ProcedimentoCons WHERE idApp_ProcedimentoCons = ' . $data);
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
            echo $key['idApp_OrcaTrata'];
            echo '<br />';
            #echo $value;
            echo '<br />';
        }

        exit();

        */

        $this->db->delete('App_ProcedimentoCons', array('idApp_ProcedimentoCons' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lista_procedimento($data, $x) {

        $query = $this->db->query('SELECT * '
                . 'FROM App_ProcedimentoCons WHERE '
                . 'Empresa = ' . $_SESSION['log']['Empresa'] . ' AND '
				. 'idApp_Consultor = ' . $_SESSION['log']['id'] . ' AND '
                . 'idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND '
                . '(Procedimento like "%' . $data . '%" OR '
                #. 'DataProcedimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                #. 'Procedimento like "%' . $data . '%" OR '
                . 'DataProcedimento = "' . $this->basico->mascara_data($data, 'mysql') . '" OR '
                . 'Telefone1 like "%' . $data . '%" OR Telefone2 like "%' . $data . '%" OR Telefone3 like "%' . $data . '%") '
                . 'ORDER BY Procedimento ASC ');
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
                    $row->DataProcedimento = $this->basico->mascara_data($row->DataProcedimento, 'barras');
                }

                return $query;
            }
        }
    }
	
	public function select_procedimento($data = FALSE) {

        if ($data === TRUE) {
            $array = $this->db->query(					
				'SELECT                
				idApp_ProcedimentoCons,
				CONCAT(IFNULL(Procedimento, ""), " --- ", IFNULL(Telefone1, ""), " --- ", IFNULL(Telefone2, ""), " --- ", IFNULL(Telefone3, "")) As Procedimento				
            FROM
                App_ProcedimentoCons					
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				idApp_Consultor = ' . $_SESSION['log']['id'] . '
			ORDER BY 
				Procedimento ASC'
    );
					
        } else {
            $query = $this->db->query(
                'SELECT                
				idApp_ProcedimentoCons,
				CONCAT(IFNULL(Procedimento, ""), " --- ", IFNULL(Telefone1, ""), " --- ", IFNULL(Telefone2, ""), " --- ", IFNULL(Telefone3, "")) As Procedimento				
            FROM
                App_ProcedimentoCons					
            WHERE
                idTab_Modulo = ' . $_SESSION['log']['idTab_Modulo'] . ' AND
                Empresa = ' . $_SESSION['log']['Empresa'] . ' AND
				idApp_Consultor = ' . $_SESSION['log']['id'] . '
			ORDER BY 
				Procedimento ASC'
    );
            
            $array = array();
            foreach ($query->result() as $row) {
                $array[$row->idApp_ProcedimentoCons] = $row->Procedimento;
            }
        }

        return $array;
    }	

}
