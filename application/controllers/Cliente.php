<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Funcao_model', 'Cliente_model'));
        #$this->load->model(array('Basico_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerfuncionario');
        $this->load->view('basico/nav_principalfuncionario');

        #$this->load->view('cliente/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('cliente/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'idSis_Usuario',
			'idApp_Cliente',
			'Usuario',
            'NomeCliente',
			'Senha',
			'Confirma',
            'DataNascimento',
            'Celular',
			'Email',
            'Sexo',
			#'Permissao',
			#'Funcao',
			'Inativo',
			'DataCriacao',
			'QuemCad',
			'Associado',
			'Cpf',
			'Rg',
			'OrgaoExp',
			'EstadoExp',
			'DataExp',			
			'Cep',
            'Telefone2',
            'Telefone3',
            'Endereco',
            'Bairro',
            'Municipio',
			'Estado',
			'Titulo',
			'Obs',

        ), TRUE));

        (!$data['query']['DataCriacao']) ? $data['query']['DataCriacao'] = date('d/m/Y', time()) : FALSE;
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email|is_unique[App_Cliente.Email]');
        $this->form_validation->set_rules('Usuario', 'Usu�rio', 'required|trim|is_unique[App_Cliente.Usuario]');
		$this->form_validation->set_rules('NomeCliente', 'NomeCliente do Usu�rio', 'required|trim');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataExp', 'Data de Emiss�o', 'trim|valid_date');
        $this->form_validation->set_rules('Celular', 'Celular', 'required|trim');
		#$this->form_validation->set_rules('Permissao', 'N�vel', 'required|trim');
		#$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');

        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		#$data['select']['Cliente'] = $this->Basico_model->select_status_sn();
		$data['select']['Inativo'] = $this->Basico_model->select_inativo();
		$data['select']['Permissao'] = $this->Basico_model->select_permissao();
		$data['select']['Funcao'] = $this->Funcao_model->select_funcao();

        $data['titulo'] = 'Cadastrar Cliente';
        $data['form_open_path'] = 'cliente/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
		
        if ($data['query']['Sexo'] || $data['query']['Endereco'] || $data['query']['Bairro'] ||
			$data['query']['Municipio'] || $data['query']['Estado'] || $data['query']['Obs'] || $data['query']['Email'] || 
			$data['query']['Cep'] || $data['query']['Cpf'] || $data['query']['Rg']  || $data['query']['OrgaoExp'] || 
			$data['query']['EstadoExp']  || $data['query']['DataExp'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';		

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['tela'] = $this->load->view('cliente/form_cliente', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('cliente/form_cliente', $data);
        } else {

			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
			$data['query']['Empresa'] = $_SESSION['log']['Empresa'];
            $data['query']['NomeEmpresa'] = $_SESSION['log']['NomeEmpresa'];
			$data['query']['idSis_EmpresaMatriz'] = $_SESSION['log']['Empresa'];
			$data['query']['Associado'] = 1;
			$data['query']['QuemCad'] = $_SESSION['log']['id'];
			$data['query']['Senha'] = md5($data['query']['Senha']);
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataExp'] = $this->basico->mascara_data($data['query']['DataExp'], 'mysql');
            $data['query']['DataCriacao'] = $this->basico->mascara_data($data['query']['DataCriacao'], 'mysql');
			$data['query']['Codigo'] = md5(uniqid(time() . rand()));
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['query']['Inativo'] = 0;
			$data['query']['Nivel'] = 3;
			$data['query']['Permissao'] = 3;
			$data['query']['Funcao'] = 1;
            unset($data['query']['Confirma']);
			#unset($data['query']['Confirma'], $data['query']['ConfirmarEmail']);

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Cliente'] = $this->Cliente_model->set_cliente($data['query']);

            if ($data['idApp_Cliente'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('cliente/form_cliente', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Cliente'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

				$data['agenda'] = array(
                    'NomeAgenda' => 'Cliente',
					'Empresa' => $_SESSION['log']['Empresa'],
                    'idApp_Cliente' => $data['idApp_Cliente']
                );
                $data['campos'] = array_keys($data['agenda']);

                $data['idApp_Agenda'] = $this->Cliente_model->set_agenda($data['agenda']);
				$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['agenda'], $data['campos'], $data['idApp_Cliente']);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Agenda', 'CREATE', $data['auditoriaitem'], $data['idApp_Cliente']);

				redirect(base_url() . 'cliente/prontuario/' . $data['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/cliente/' .  $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(

			'idApp_Cliente',
			#'Usuario',
            'NomeCliente',
            'DataNascimento',
            'Celular',
            'Email',
			'Sexo',
			#'Permissao',
			#'Funcao',
			'Inativo',
			'Cpf',
			'Rg',
			'OrgaoExp',
			'EstadoExp',
			'DataExp',			
			'Cep',
            'Telefone2',
            'Telefone3',
            'Endereco',
            'Bairro',
            'Municipio',
			'Estado',
			'Titulo',
			'Obs',

        ), TRUE);

        if ($id) {
            $data['query'] = $this->Cliente_model->get_cliente($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
			$data['query']['DataExp'] = $this->basico->mascara_data($data['query']['DataExp'], 'barras');
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeCliente', 'NomeCliente do Respons�vel', 'required|trim|is_unique_duplo[App_Cliente.NomeCliente.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('NomeCliente', 'NomeCliente do Respons�vel', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataExp', 'Data de Emiss�o', 'trim|valid_date');
		$this->form_validation->set_rules('Celular', 'Celular', 'required|trim');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		#$this->form_validation->set_rules('Permissao', 'N�vel', 'required|trim');
		#$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		#$data['select']['Cliente'] = $this->Basico_model->select_status_sn();
		$data['select']['Inativo'] = $this->Basico_model->select_inativo();
		$data['select']['Permissao'] = $this->Basico_model->select_permissao();
		$data['select']['Funcao'] = $this->Funcao_model->select_funcao();

        $data['titulo'] = 'Editar Cliente';
        $data['form_open_path'] = 'cliente/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        if ($data['query']['Sexo'] || $data['query']['Endereco'] || $data['query']['Bairro'] ||
			$data['query']['Municipio'] || $data['query']['Estado'] || $data['query']['Obs'] || $data['query']['Email'] || 
			$data['query']['Cep'] || $data['query']['Cpf'] || $data['query']['Rg']  || $data['query']['OrgaoExp'] || 
			$data['query']['EstadoExp']  || $data['query']['DataExp'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('cliente/form_clientealterar', $data);
        } else {

            $data['query']['NomeCliente'] = trim(mb_strtoupper($data['query']['NomeCliente'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataExp'] = $this->basico->mascara_data($data['query']['DataExp'], 'mysql');
            #$data['query']['Obs'] = nl2br($data['query']['Obs']);


            $data['anterior'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Cliente'], TRUE);

            if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'cliente/form_clientealterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->Cliente_model->delete_cliente($id);

        $data['msg'] = '?m=1';

		redirect(base_url() . 'relatoriofuncionario/clientees' . $data['msg']);
		exit();

        $this->load->view('basico/footer');
    }

    public function pesquisar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim|callback_get_cliente');

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'),0,-3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'),0,-3);
        }

        $data['titulo'] = "Pesquisar Cliente";

        $data['Pesquisa'] = $this->input->post('Pesquisa');
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        #run form validation
        if ($this->form_validation->run() !== FALSE && $this->Cliente_model->lista_cliente($data['Pesquisa'], FALSE) === TRUE) {

            $data['query'] = $this->Cliente_model->lista_cliente($data['Pesquisa'], TRUE);

            if ($data['query']->num_rows() == 1) {
                $info = $data['query']->result_array();

                if ($_SESSION['agenda'])
                    redirect('consulta/cadastrar/' . $info[0]['idApp_Cliente'] );
                else
                    redirect('cliente/prontuario/' . $info[0]['idApp_Cliente'] );

                exit();
            } else {
                $data['list'] = $this->load->view('cliente/list_cliente', $data, TRUE);
            }

        }

        ($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

        $this->load->view('cliente/pesq_cliente', $data);

        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($id, TRUE);
        #$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontu�rio ' . $data['query']['NomeCliente'];
        $data['panel'] = 'primary';
        $data['metodo'] = 4;

        $_SESSION['log']['idApp_Cliente'] = $data['resumo']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
        $data['resumo']['NomeCliente'] = $data['query']['NomeCliente'];

        $data['query']['Idade'] = $this->basico->calcula_idade($data['query']['DataNascimento']);
        $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');

        /*
        if ($data['query']['Sexo'] == 1)
            $data['query']['profile'] = 'm';
        elseif ($data['query']['Sexo'] == 2)
            $data['query']['profile'] = 'f';
        else
            $data['query']['profile'] = 'o';
        */
        $data['query']['profile'] = ($data['query']['Sexo']) ? strtolower($data['query']['Sexo']) : 'o';

        $data['query']['Sexo'] = $this->Basico_model->get_sexo($data['query']['Sexo']);
		$data['query']['Inativo'] = $this->Basico_model->get_inativo($data['query']['Inativo']);
		$data['query']['Funcao'] = $this->Basico_model->get_funcao($data['query']['Funcao']);
		$data['query']['Permissao'] = $this->Basico_model->get_permissao($data['query']['Permissao']);
		$data['query']['Empresa'] = $this->Basico_model->get_empresa($data['query']['Empresa']);
		#$data['query']['Cliente'] = $data['query']['Cliente'];

        $data['query']['Telefone'] = $data['query']['Celular'];

        $data['contatocliente'] = $this->Cliente_model->lista_contatocliente($id, TRUE);
        /*
          echo "<pre>";
          print_r($data['contatocliente']);
          echo "</pre>";
          exit();
          */
        if (!$data['contatocliente'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('cliente/list_contatocliente', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        $this->load->view('cliente/tela_cliente', $data);

        $this->load->view('basico/footer');
    }

    function get_cliente($data) {

        if ($this->Cliente_model->lista_cliente($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_cliente', '<strong>Cliente</strong> n�o encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
