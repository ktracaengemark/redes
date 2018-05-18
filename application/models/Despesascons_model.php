<?php

#modelo que verifica usuário e senha e loga o usuário no sistema, criando as sessões necessárias

defined('BASEPATH') OR exit('No direct script access allowed');

class Despesascons_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('basico');
        $this->load->model(array('Basico_model'));
    }

    public function set_despesas($data) {

        $query = $this->db->insert('App_Despesascons', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_servico_compra($data) {

        /*
        //echo $this->db->last_query();
        echo '<br>';
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        //exit ();
        */

        $query = $this->db->insert_batch('App_ServicoCompracons', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_produto_compra($data) {

        $query = $this->db->insert_batch('App_ProdutoCompracons', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function set_parcelaspag($data) {

        $query = $this->db->insert_batch('App_ParcelasPagaveiscons', $data);

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            #return TRUE;
            return $this->db->insert_id();
        }
    }

    public function get_despesas($data) {
        $query = $this->db->query('SELECT * FROM App_Despesascons WHERE idApp_Despesascons = ' . $data);
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
		$query = $this->db->query('SELECT * FROM App_ServicoCompracons WHERE idApp_Despesascons = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_produto($data) {
		$query = $this->db->query('SELECT * FROM App_ProdutoCompracons WHERE idApp_Despesascons = ' . $data);
        $query = $query->result_array();

        return $query;
    }

    public function get_parcelaspag($data) {
		$query = $this->db->query('SELECT * FROM App_ParcelasPagaveiscons WHERE idApp_Despesascons = ' . $data);
        $query = $query->result_array();

        return $query;
    }


    public function list_despesas($id, $aprovado, $completo) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_Despesascons, '
            . 'OT.DataDespesas, '

            . 'OT.ProfissionalDespesas, '
            . 'OT.AprovadoDespesas, '
            . 'OT.ObsDespesas '
            . 'FROM '
            . 'App_Despesascons AS OT '
            . 'WHERE '
            . 'OT.idApp_Cliente = ' . $id . ' AND '
            . 'OT.AprovadoDespesas = "' . $aprovado . '" '
            . 'ORDER BY OT.DataDespesas DESC ');
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
					$row->DataDespesas = $this->basico->mascara_data($row->DataDespesas, 'barras');

                    $row->AprovadoDespesas = $this->basico->mascara_palavra_completa($row->AprovadoDespesas, 'NS');
                    $row->ProfissionalDespesas = $this->get_profissional($row->ProfissionalDespesas);
                }
                return $query;
            }
        }
    }

    public function list_despesasBKP($x) {

        $query = $this->db->query('SELECT '
            . 'OT.idApp_Despesascons, '
            . 'OT.DataDespesas, '

            . 'OT.ProfissionalDespesas, '
            . 'OT.AprovadoDespesas, '
            . 'OT.ObsDespesas '
            . 'FROM '
            . 'App_Despesascons AS OT '
            . 'WHERE '
            . 'OT.idApp_Cliente = ' . $_SESSION['Despesas']['idApp_Cliente'] . ' '
            . 'ORDER BY OT.DataDespesas DESC ');
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
					$row->DataDespesas = $this->basico->mascara_data($row->DataDespesas, 'barras');
               
					$row->AprovadoDespesas = $this->basico->mascara_palavra_completa($row->AprovadoDespesas, 'NS');
                    $row->ProfissionalDespesas = $this->get_profissional($row->ProfissionalDespesas);
                }

                return $query;
            }
        }
    }

    public function update_despesas($data, $id) {

        unset($data['idApp_Despesascons']);
        $query = $this->db->update('App_Despesascons', $data, array('idApp_Despesascons' => $id));
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_servico_compra($data) {

        $query = $this->db->update_batch('App_ServicoCompracons', $data, 'idApp_ServicoCompracons');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_produto_compra($data) {

        $query = $this->db->update_batch('App_ProdutoCompracons', $data, 'idApp_ProdutoCompracons');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function update_parcelaspag($data) {

        $query = $this->db->update_batch('App_ParcelasPagaveiscons', $data, 'idApp_ParcelasPagaveiscons');
        return ($this->db->affected_rows() === 0) ? FALSE : TRUE;

    }

    public function delete_servico_compra($data) {

        $this->db->where_in('idApp_ServicoCompracons', $data);
        $this->db->delete('App_ServicoCompracons');

        //$query = $this->db->delete('App_ServicoCompracons', array('idApp_ServicoCompracons' => $data));

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_produto_compra($data) {

        $this->db->where_in('idApp_ProdutoCompracons', $data);
        $this->db->delete('App_ProdutoCompracons');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_parcelaspag($data) {

        $this->db->where_in('idApp_ParcelasPagaveiscons', $data);
        $this->db->delete('App_ParcelasPagaveiscons');

        if ($this->db->affected_rows() === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_despesas($id) {

        /*
        $tables = array('App_ServicoCompracons', 'App_ProdutoCompracons', 'App_ParcelasPagaveiscons', 'App_Procedimento', 'App_Despesascons');
        $this->db->where('idApp_Despesascons', $id);
        $this->db->delete($tables);
        */

        $query = $this->db->delete('App_ServicoCompracons', array('idApp_Despesascons' => $id));
        $query = $this->db->delete('App_ProdutoCompracons', array('idApp_Despesascons' => $id));
        $query = $this->db->delete('App_ParcelasPagaveiscons', array('idApp_Despesascons' => $id));
        $query = $this->db->delete('App_Despesascons', array('idApp_Despesascons' => $id));

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
