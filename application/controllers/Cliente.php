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
        $this->load->model(array('Basico_model', 'Cliente_model', 'Contatocliente_model'));
        #$this->load->model(array('Basico_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerconsultor');
        $this->load->view('basico/nav_principalconsultor');

        #$this->load->view('cliente/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_Consultor',
			'idApp_Cliente',
            'NomeCliente',
            'DataNascimento',
			'DataCadastroCliente',
			'Cpf',
			'Rg',
			'OrgaoExp',
			'EstadoExp',
			'DataEmissao',			
			'Cep',
            'Telefone1',
            'Telefone2',
            'Telefone3',
			'Ativo',
            'Sexo',
            'Endereco',
            'Bairro',
            'Municipio',
			'Estado',
            'Obs',
			'Email',
			'RegistroFicha',
			#'Aux1Cli',
			#'Aux2Cli',
			#'Aux3Cli',
			#'Aux4Cli',
			'Aux5Cli',
			#'Aux6Cli',
			#'Aux7Cli',
			#'Aux8Cli',
			'Associado',
        ), TRUE));

       
		(!$data['query']['DataCadastroCliente']) ? $data['query']['DataCadastroCliente'] = date('d/m/Y', time()) : FALSE;
		(!$data['query']['Aux5Cli']) ? $data['query']['Aux5Cli'] = '0' : FALSE;
		(!$data['query']['Associado']) ? $data['query']['Associado'] = 'N' : FALSE;
		
	   $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeCliente', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Cliente.NomeCliente.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('NomeCliente', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataEmissao', 'Data de Emissão', 'trim|valid_date');
        $this->form_validation->set_rules('Telefone1', 'Telefone1', 'required|trim');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		
		
        #$data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Associado'] = $this->Basico_model->select_associado();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		$data['select']['Aux1Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux2Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux3Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux4Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux6Cli'] = $this->Basico_model->select_status_sn();
		$data['select']['Aux7Cli'] = $this->Basico_model->select_status_sn();
		$data['select']['Aux8Cli'] = $this->Basico_model->select_status_sn();		
        $data['titulo'] = 'Cadastrar Cliente';
        $data['form_open_path'] = 'cliente/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

		$data['collapse1'] = 'class="collapse"';
		$data['collapse2'] = 'class="collapse"';
		
        if ($data['query']['Sexo'] || $data['query']['Endereco'] || $data['query']['Bairro'] ||
			$data['query']['Municipio'] || $data['query']['Estado'] || $data['query']['Obs'] || $data['query']['Email'] || 
			$data['query']['RegistroFicha'] || $data['query']['Cep'] || $data['query']['Cpf'] || 
			$data['query']['Rg']  || $data['query']['OrgaoExp'] || $data['query']['EstadoExp']  || $data['query']['DataEmissao'])
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

			
            $data['query']['NomeCliente'] = trim(mb_strtoupper($data['query']['NomeCliente'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'mysql');
			$data['query']['DataCadastroCliente'] = $this->basico->mascara_data($data['query']['DataCadastroCliente'], 'mysql');
			$data['query']['Obs'] = nl2br($data['query']['Obs']);
			$data['query']['Empresa'] = $_SESSION['log']['Empresa'];
			$data['query']['idApp_Consultor'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Cliente'] = $this->Cliente_model->set_cliente($data['query']);

            if ($data['idApp_Cliente'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('cliente/form_cliente', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Cliente'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoriaconsultor($data['auditoriaitem'], 'App_Cliente', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'cliente/prontuario/' . $data['idApp_Cliente'] . $data['msg']);
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
            'idApp_Cliente',
            'NomeCliente',
            'DataNascimento',
			'DataCadastroCliente',
			'Cpf',
			'Rg',
			'OrgaoExp',
			'EstadoExp',
			'DataEmissao',
			'Cep',
            'Telefone1',
            'Telefone2',
            'Telefone3',
			'Ativo',
            'Sexo',
            'Endereco',
            'Bairro',
            'Municipio',
			'Estado',
            'Obs',
            #'idSis_Usuario',
            'Email',
			'RegistroFicha',
			#'Aux1Cli',
			#'Aux2Cli',
			#'Aux3Cli',
			#'Aux4Cli',
			'Aux5Cli',
			#'Aux6Cli',
			#'Aux7Cli',
			#'Aux8Cli',
			'Associado',
        ), TRUE);

		(!$data['query']['DataCadastroCliente']) ? $data['query']['DataCadastroCliente'] = date('d/m/Y', time()) : FALSE;
		(!$data['query']['Aux5Cli']) ? $data['query']['Aux5Cli'] = '0' : FALSE;
		(!$data['query']['Associado']) ? $data['query']['Associado'] = 'N' : FALSE;
		
        if ($id) {
            $data['query'] = $this->Cliente_model->get_cliente($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
			$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'barras');
			$data['query']['DataCadastroCliente'] = $this->basico->mascara_data($data['query']['DataCadastroCliente'], 'barras');
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeCliente', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Cliente.NomeCliente.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('NomeCliente', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataEmissao', 'Data de Emissão', 'trim|valid_date');
        $this->form_validation->set_rules('Telefone1', 'Telefone1', 'required|trim');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');

        #$data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Associado'] = $this->Basico_model->select_associado();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		$data['select']['Aux1Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux2Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux3Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux4Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux6Cli'] = $this->Basico_model->select_status_sn();
		$data['select']['Aux7Cli'] = $this->Basico_model->select_status_sn();
		$data['select']['Aux8Cli'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'cliente/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

		$data['collapse1'] = 'class="collapse"';
		$data['collapse2'] = 'class="collapse"';
		
        if ($data['query']['Sexo'] || $data['query']['Endereco'] || $data['query']['Bairro'] ||
			$data['query']['Municipio'] || $data['query']['Estado'] || $data['query']['Obs'] || $data['query']['Email'] || 
			$data['query']['RegistroFicha'] || $data['query']['Cep'] || $data['query']['Cpf'] || 
			$data['query']['Rg']  || $data['query']['OrgaoExp'] || $data['query']['EstadoExp']  || $data['query']['DataEmissao'])
            $data['collapse'] = 'class="collapse"';
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
			$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'mysql');
            $data['query']['DataCadastroCliente'] = $this->basico->mascara_data($data['query']['DataCadastroCliente'], 'mysql');
			$data['query']['Obs'] = nl2br($data['query']['Obs']);
			$data['query']['Empresa'] = $_SESSION['log']['Empresa'];
			#$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
						
            $data['anterior'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Cliente'], TRUE);

            if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
                $data['msg'] = '?m=1';
                #redirect(base_url() . 'cliente/form_clientealterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg']);
				exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoriaconsultor($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function acomp($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idApp_Cliente',
            #'NomeCliente',
            #'DataNascimento',
			#'DataCadastroCliente',
			#'Cpf',
			#'Rg',
			#'OrgaoExp',
			#'EstadoExp',
			#'DataEmissao',
			#'Cep',
            #'Telefone1',
            #'Telefone2',
            #'Telefone3',
			#'Ativo',
            #'Sexo',
            #'Endereco',
            #'Bairro',
            #'Municipio',
			#'Estado',
            #'Obs',
            #'idSis_Usuario',
            #'Email',
			#'RegistroFicha',
			'Aux1Cli',
			'Aux2Cli',
			'Aux3Cli',
			'Aux4Cli',
			'Aux5Cli',
			'Aux6Cli',
			'Aux7Cli',
			'Aux8Cli',
			'Associado',
        ), TRUE);

		(!$data['query']['Aux5Cli']) ? $data['query']['Aux5Cli'] = '0' : FALSE;
		
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('DataProcedimento' . $i) ||
                    $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
                $data['procedimento'][$j]['idApp_ProcedimentoCons'] = $this->input->post('idApp_ProcedimentoCons' . $i);
                $data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
                #$data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
                $data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
				$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);

                $j++;
            }

        }
        $data['count']['PMCount'] = $j - 1;

        if ($id) {
            $data['query'] = $this->Cliente_model->get_cliente($id);
            #$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
			#$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'barras');
			#$data['query']['DataCadastroCliente'] = $this->basico->mascara_data($data['query']['DataCadastroCliente'], 'barras');
			
            #### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];


            #### App_ProcedimentoCons ####
            $data['procedimento'] = $this->Cliente_model->get_procedimento($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);

                if (isset($data['procedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++) {
                        $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');

					}
                }
            }			
			
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeCliente', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Cliente.NomeCliente.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        #$this->form_validation->set_rules('NomeCliente', 'Nome do Responsável', 'required|trim');
        #$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		#$this->form_validation->set_rules('DataEmissao', 'Data de Emissão', 'trim|valid_date');
        #$this->form_validation->set_rules('Telefone1', 'Telefone1', 'required|trim');
        #$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		$this->form_validation->set_rules('Associado', 'Associado', 'required|trim');

        #$data['select']['Municipio'] = $this->Basico_model->select_municipio();
        #$data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Associado'] = $this->Basico_model->select_associado();
		#$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		$data['select']['Aux1Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux2Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux3Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux4Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux6Cli'] = $this->Basico_model->select_status_sn();
		$data['select']['Aux7Cli'] = $this->Basico_model->select_status_sn();
		$data['select']['Aux8Cli'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();		
		
        $data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'cliente/acomp';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

		$data['collapse'] = '';
		$data['collapse1'] = '';
		$data['collapse2'] = '';
/*		
        if ($data['query']['Sexo'] || $data['query']['Endereco'] || $data['query']['Bairro'] ||
			$data['query']['Municipio'] || $data['query']['Estado'] || $data['query']['Obs'] || $data['query']['Email'] || 
			$data['query']['RegistroFicha'] || $data['query']['Cep'] || $data['query']['Cpf'] || 
			$data['query']['Rg']  || $data['query']['OrgaoExp'] || $data['query']['EstadoExp']  || $data['query']['DataEmissao'])
            $data['collapse'] = 'class="collapse"';
        else
            $data['collapse'] = 'class="collapse"';
*/
        
		$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';
		
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';		

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('cliente/form_acomp', $data);
        } else {

            #$data['query']['NomeCliente'] = trim(mb_strtoupper($data['query']['NomeCliente'], 'ISO-8859-1'));
            #$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			#$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'mysql');
            #$data['query']['DataCadastroCliente'] = $this->basico->mascara_data($data['query']['DataCadastroCliente'], 'mysql');
			#$data['query']['Obs'] = nl2br($data['query']['Obs']);
			$data['query']['Empresa'] = $_SESSION['log']['Empresa'];
			#$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
			
            #### App_ProcedimentoCons ####
            $data['update']['procedimento']['anterior'] = $this->Cliente_model->get_procedimento($data['query']['idApp_Cliente']);
            if (isset($data['procedimento']) || (!isset($data['procedimento']) && isset($data['update']['procedimento']['anterior']) ) ) {

                if (isset($data['procedimento']))
                    $data['procedimento'] = array_values($data['procedimento']);
                else
                    $data['procedimento'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['procedimento'] = $this->basico->tratamento_array_multidimensional($data['procedimento'], $data['update']['procedimento']['anterior'], 'idApp_ProcedimentoCons');

                $max = count($data['update']['procedimento']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['inserir'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
					$data['update']['procedimento']['inserir'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
                    $data['update']['procedimento']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['procedimento']['inserir'][$j]['idApp_Cliente'] = $data['query']['idApp_Cliente'];
                    $data['update']['procedimento']['inserir'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimento'], 'mysql');

                }

                $max = count($data['update']['procedimento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['alterar'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimento'], 'mysql');

                }

                if (count($data['update']['procedimento']['inserir']))
                    $data['update']['procedimento']['bd']['inserir'] = $this->Cliente_model->set_procedimento($data['update']['procedimento']['inserir']);

                if (count($data['update']['procedimento']['alterar']))
                    $data['update']['procedimento']['bd']['alterar'] =  $this->Cliente_model->update_procedimento($data['update']['procedimento']['alterar']);

                if (count($data['update']['procedimento']['excluir']))
                    $data['update']['procedimento']['bd']['excluir'] = $this->Cliente_model->delete_procedimento($data['update']['procedimento']['excluir']);

            }
			
            $data['anterior'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Cliente'], TRUE);

            if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
                $data['msg'] = '?m=1';
                #redirect(base_url() . 'cliente/form_clientealterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
				redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoriaconsultor($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            }
			
/*
            if ($data['auditoriaitem'] && !$data['update']['query']['bd']) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'cliente/form_acomp/' . $data['query']['idApp_Cliente'] . $data['msg']);
				
                exit();
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrataCons'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrataCons', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg']);

				exit();
            }
*/			
			
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

        $this->Cliente_model->delete_cliente($id);

        $data['msg'] = '?m=1';

		#redirect(base_url() . 'agenda' . $data['msg']);
		redirect(base_url() . 'relatorioconsultor/clientes' . $data['msg']);
		exit();

        $this->load->view('basico/footer');
    }

    public function excluirBKP($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idApp_Cliente',
            'submit'
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Cliente_model->get_cliente($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
            $data['query']['ClienteDataNascimento'] = $this->basico->mascara_data($data['query']['ClienteDataNascimento'], 'barras');
        }

        #$data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();

        $data['titulo'] = 'Tem certeza que deseja excluir o registro abaixo?';
        $data['form_open_path'] = 'cliente/excluir';
        $data['readonly'] = 'readonly';
        $data['disabled'] = 'disabled';
        $data['panel'] = 'danger';
        $data['metodo'] = 3;

        $data['tela'] = $this->load->view('cliente/form_cliente', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('cliente/tela_cliente', $data);
        } else {

            if ($data['query']['idApp_Cliente'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('cliente/form_cliente', $data);
            } else {

                $data['anterior'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
                $data['campos'] = array_keys($data['anterior']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['query']['idApp_Cliente'], FALSE, TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'DELETE', $data['auditoriaitem']);

                $this->Cliente_model->delete_cliente($data['query']['idApp_Cliente']);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'cliente' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function pesquisar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($id, TRUE);
        #$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontuário ' . $data['query']['NomeCliente'];
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
		$data['query']['Ativo'] = $this->Basico_model->get_ativo($data['query']['Ativo']);
		$data['query']['Empresa'] = $this->Basico_model->get_empresa($data['query']['Empresa']);
		
        $data['query']['Telefone'] = $data['query']['Telefone1'];
        ($data['query']['Telefone2']) ? $data['query']['Telefone'] = $data['query']['Telefone'] . ' - ' . $data['query']['Telefone2'] : FALSE;
        ($data['query']['Telefone3']) ? $data['query']['Telefone'] = $data['query']['Telefone'] . ' - ' . $data['query']['Telefone3'] : FALSE;

		/*
        if ($data['query']['Municipio']) {
            $mun = $this->Basico_model->get_municipio($data['query']['Municipio']);
            $data['query']['Municipio'] = $mun['NomeMunicipio'] . '/' . $mun['Uf'];
        } else {
            $data['query']['Municipio'] = $data['query']['Uf'] = $mun['Uf'] = '';
        }
		*/
        $data['contatocliente'] = $this->Contatocliente_model->lista_contatocliente(TRUE);
        /*
          echo "<pre>";
          print_r($data['contatocliente']);
          echo "</pre>";
          exit();
        */
        if (!$data['contatocliente'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('contatocliente/list_contatocliente', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        $this->load->view('cliente/tela_cliente', $data);

        $this->load->view('basico/footer');
    }

    function get_cliente($data) {

        if ($this->Cliente_model->lista_cliente($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_cliente', '<strong>Cliente</strong> não encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
