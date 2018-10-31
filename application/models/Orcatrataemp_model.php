<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Orcatrataemp_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_orcatrata($data) {

        $query = $this->db->insert('App_OrcaTrataEmp', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_servico_venda($data) {

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        //exit ();
        */

        $query = $this->db->insert_batch('App_ServicoVendaEmp', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_produto_venda($data) {

        $query = $this->db->insert_batch('App_ProdutoVendaEmp', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_parcelasrec($data) {

        $query = $this->db->insert_batch('App_ParcelasRecebiveisEmp', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_procedimento($data) {

        $query = $this->db->insert_batch('App_ProcedimentoEmp', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_orcatrata($data) {
        $query = $this->db->query('SELECT * FROM App_OrcaTrataEmp WHERE idApp_OrcaTrataEmp = ' . $data);
        $query = $query->result_array();

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($query);
        echo "</pre>";
        exit ();
        */

        return $query[0];
    }

	public function get_servico($data) {
		$query = $this->db->query('SELECT * FROM App_ServicoVendaEmp WHERE idApp_OrcaTrataEmp = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_produto($data) {
		$query = $this->db->query('SELECT * FROM App_ProdutoVendaEmp WHERE idApp_OrcaTrataEmp = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_parcelasrec($data) {
		$query = $this->db->query('SELECT * FROM App_ParcelasRecebiveisEmp WHERE idApp_OrcaTrataEmp = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_procedimento($data) {
		$query = $this->db->query('SELECT * FROM App_ProcedimentoEmp WHERE idApp_OrcaTrataEmp = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function list_orcamento($id, $aprovado, $completo) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_OrcaTrataEmp, '
            . 'OT.DataOrca, '
			. 'OT.DataPrazo, '
            . 'OT.ProfissionalOrca, '
            . 'OT.AprovadoOrca, '
			. 'OT.ServicoConcluido, '
			. 'OT.QuitadoOrca, '
            . 'OT.ObsOrca '
            . 'FROM '
            . 'App_OrcaTrataEmp AS OT '
            . 'WHERE '
            . 'OT.idSis_Usuario = ' . $id . ' AND '
			. 'OT.TipoRD = "R" AND '
            . 'OT.AprovadoOrca = "' . $aprovado . '" '
            . 'ORDER BY '
			#. 'OT.DataOrca DESC, '
			. 'OT.ServicoConcluido ASC ');
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
            if ($completo === FALSE) {
                return TRUE;
            } else {

                foreach ($query->result() as $row) {
					$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
					$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');
                    $row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
					$row->ServicoConcluido = $this->basico->mascara_palavra_completa($row->ServicoConcluido, 'NS');
					$row->QuitadoOrca = $this->basico->mascara_palavra_completa($row->QuitadoOrca, 'NS');
                    $row->ProfissionalOrca = $this->get_profissional($row->ProfissionalOrca);
                }
                return $query;
            }
        }
    }

    public function list_orcatrataBKP($x) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_OrcaTrataEmp, '
            . 'OT.DataOrca, '
			. 'OT.DataPrazo, '
            . 'OT.ProfissionalOrca, '
            . 'OT.AprovadoOrca, '
            . 'OT.ObsOrca '
            . 'FROM '
            . 'App_OrcaTrataEmp AS OT '
            . 'WHERE '
            . 'OT.idSis_Usuario = ' . $_SESSION['OrcaTrata']['idSis_Usuario'] . ' '
            . 'ORDER BY OT.DataOrca DESC ');
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
					$row->DataOrca = $this->basico->mascara_data($row->DataOrca, 'barras');
					$row->DataPrazo = $this->basico->mascara_data($row->DataPrazo, 'barras');                   
					$row->AprovadoOrca = $this->basico->mascara_palavra_completa($row->AprovadoOrca, 'NS');
                    $row->ProfissionalOrca = $this->get_profissional($row->ProfissionalOrca);
                }

                return $query;
            }
        }
    }

    public function update_orcatrata($data, $id) {

        unset($data['idApp_OrcaTrataEmp']);
        $query = $this->db->update('App_OrcaTrataEmp', $data, array('idApp_OrcaTrataEmp' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_servico_venda($data) {

        $query = $this->db->update_batch('App_ServicoVendaEmp', $data, 'idApp_ServicoVendaEmp');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_produto_venda($data) {

        $query = $this->db->update_batch('App_ProdutoVendaEmp', $data, 'idApp_ProdutoVendaEmp');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_parcelasrec($data) {

        $query = $this->db->update_batch('App_ParcelasRecebiveisEmp', $data, 'idApp_ParcelasRecebiveisEmp');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_procedimento($data) {

        $query = $this->db->update_batch('App_ProcedimentoEmp', $data, 'idApp_ProcedimentoEmp');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_servico_venda($data) {

        $this->db->where_in('idApp_ServicoVendaEmp', $data);
        $this->db->delete('App_ServicoVendaEmp');

        //$query = $this->db->delete('App_ServicoVendaEmp', array('idApp_ServicoVendaEmp' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_produto_venda($data) {

        $this->db->where_in('idApp_ProdutoVendaEmp', $data);
        $this->db->delete('App_ProdutoVendaEmp');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_parcelasrec($data) {

        $this->db->where_in('idApp_ParcelasRecebiveisEmp', $data);
        $this->db->delete('App_ParcelasRecebiveisEmp');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_procedimento($data) {

        $this->db->where_in('idApp_ProcedimentoEmp', $data);
        $this->db->delete('App_ProcedimentoEmp');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_orcatrata($id) {

        /*
        $tables = array('App_ServicoVendaEmp', 'App_ProdutoVendaEmp', 'App_ParcelasRecebiveisEmp', 'App_ProcedimentoEmp', 'App_OrcaTrataEmp');
        $this->db->where('idApp_Orcatrataemp', $id);
        $this->db->delete($tables);
        */

        $query = $this->db->delete('App_ServicoVendaEmp', array('idApp_Orcatrataemp' => $id));
        $query = $this->db->delete('App_ProdutoVendaEmp', array('idApp_Orcatrataemp' => $id));
        $query = $this->db->delete('App_ParcelasRecebiveisEmp', array('idApp_Orcatrataemp' => $id));
        $query = $this->db->delete('App_ProcedimentoEmp', array('idApp_Orcatrataemp' => $id));
        $query = $this->db->delete('App_OrcaTrataEmp', array('idApp_Orcatrataemp' => $id));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_profissional($data) {
		$query = $this->db->query('SELECT NomeProfissional FROM App_Profissional WHERE idApp_Profissional = ' . $data);
        $query = $query->result_array();

        return (isset($query[0]['NomeProfissional'])) ? $query[0]['NomeProfissional'] : FALSE;
    }

}
