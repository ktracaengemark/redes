<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Agendaconsultor extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Agendaconsultor_model', 'Relatorioconsultor_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerconsultor');
        $this->load->view('basico/nav_principalconsultor');

        unset($_SESSION['agenda']);

    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['select']['NomeConsultor'] = $this->Relatorioconsultor_model->select_usuario();

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeConsultor',
        ), TRUE));

        $_SESSION['log']['NomeConsultor'] = ($data['query']['NomeConsultor']) ?
            $data['query']['NomeConsultor'] : FALSE;

        $data['query']['estatisticas'] = $this->Agendaconsultor_model->resumo_estatisticas($_SESSION['log']['id']);
        $data['query']['cliente_aniversariantes'] = $this->Agendaconsultor_model->cliente_aniversariantes($_SESSION['log']['id']);
        $data['query']['contatocliente_aniversariantes'] = $this->Agendaconsultor_model->contatocliente_aniversariantes($_SESSION['log']['id']);
        #$data['query']['profissional_aniversariantes'] = $this->Agendaconsultor_model->profissional_aniversariantes($_SESSION['log']['id']);
		#$data['query']['contatoprof_aniversariantes'] = $this->Agendaconsultor_model->contatoprof_aniversariantes($_SESSION['log']['id']);
		
		$this->load->view('agendaconsultor/tela_agendaconsultor', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

}
