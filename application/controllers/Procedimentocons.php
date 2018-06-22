<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Procedimentocons extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Procedimentocons_model'));
        #$this->load->model(array('Basico_model', 'Procedimentocons_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerconsultor');
        $this->load->view('basico/nav_principalconsultor');

        #$this->load->view('procedimento/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('procedimento/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Consultor',
			'idApp_ProcedimentoCons',
			'Procedimento',
            'DataProcedimento',
			'DataProcedimentoLimite',
			'ConcluidoProcedimento',
			'idApp_Cliente',
        ), TRUE));

		(!$data['query']['DataProcedimento']) ? $data['query']['DataProcedimento'] = date('d/m/Y', time()) : FALSE;
		(!$data['query']['DataProcedimentoLimite']) ? $data['query']['DataProcedimentoLimite'] = date('d/m/Y', time()) : FALSE;
		
	   $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Procedimento', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_ProcedimentoCons.Procedimento.DataProcedimento.' . $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql') . ']');

        $this->form_validation->set_rules('DataProcedimento', 'Data de Nascimento', 'trim|valid_date');

		
		$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['idApp_Cliente'] = $this->Basico_model->select_cliente();
		
        $data['titulo'] = 'Anotações';
        $data['form_open_path'] = 'procedimentocons/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;


		$data['collapse'] = 'class="collapse"';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['tela'] = $this->load->view('procedimentocons/form_procedimentocons', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('procedimentocons/form_procedimentocons', $data);
        } else {

			

            $data['query']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql');            
			$data['query']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['query']['DataProcedimentoLimite'], 'mysql');
			$data['query']['Procedimento'] = nl2br($data['query']['Procedimento']);
			$data['query']['Empresa'] = $_SESSION['log']['Empresa'];
			$data['query']['idApp_Consultor'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_ProcedimentoCons'] = $this->Procedimentocons_model->set_procedimento($data['query']);

            if ($data['idApp_ProcedimentoCons'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('procedimentocons/form_procedimentocons', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_ProcedimentoCons'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ProcedimentoCons', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'relatorioconsultor/procedimento/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            #'idApp_Consultor',
			'idApp_ProcedimentoCons',
			'Procedimento',
            'DataProcedimento',
			'DataProcedimentoLimite',
			'ConcluidoProcedimento',
			'idApp_Cliente',
        ), TRUE);

        if ($id) {
            $data['query'] = $this->Procedimentocons_model->get_procedimento($id);
            $data['query']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'barras');
			$data['query']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['query']['DataProcedimentoLimite'], 'barras');
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Procedimento', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_ProcedimentoCons.Procedimento.DataProcedimento.' . $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql') . ']');

        $this->form_validation->set_rules('DataProcedimento', 'Data do Procedimento', 'trim|valid_date');


		$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['idApp_Cliente'] = $this->Basico_model->select_cliente();
		
        $data['titulo'] = 'Editar Anotações';
        $data['form_open_path'] = 'procedimentocons/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;


		$data['collapse'] = 'class="collapse"';

        $data['nav_secundario'] = $this->load->view('procedimentocons/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('procedimentocons/form_procedimentocons', $data);
        } else {


            $data['query']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql');
            $data['query']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['query']['DataProcedimentoLimite'], 'mysql');
			$data['query']['Procedimento'] = nl2br($data['query']['Procedimento']);
			$data['query']['Empresa'] = $_SESSION['log']['Empresa'];
			#$data['query']['idApp_Consultor'] = $_SESSION['log']['id'];
						
            $data['anterior'] = $this->Procedimentocons_model->get_procedimento($data['query']['idApp_ProcedimentoCons']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ProcedimentoCons'], TRUE);

            if ($data['auditoriaitem'] && $this->Procedimentocons_model->update_procedimento($data['query'], $data['query']['idApp_ProcedimentoCons']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'procedimentocons/form_procedimentocons/' . $data['query']['idApp_ProcedimentoCons'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ProcedimentoCons', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'relatorioconsultor/procedimento' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->Procedimentocons_model->delete_procedimento($id);

        $data['msg'] = '?m=1';

		redirect(base_url() . 'relatorioconsultor/procedimento' . $data['msg']);
		exit();

        $this->load->view('basico/footer');
    }

}
