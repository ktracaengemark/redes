<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatoriocliente extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Profissional_model', 'Cliente_model', 'Relatoriocliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headercliente');
        $this->load->view('basico/nav_principalcliente');

        #$this->load->view('relatoriocliente/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('relatoriocliente/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function financeiro() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
            'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',
            'AprovadoOrca',
            'QuitadoOrca',
			'ServicoConcluido',
        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluido'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',

            'OT.idApp_OrcaTrata' => 'N�mero do Or�amento',
            'OT.AprovadoOrca' => 'Or�amento Aprovado?',
            'OT.DataOrca' => 'Data do Or�amento',
            'OT.ValorOrca' => 'Valor do Or�amento',

            'OT.ServicoConcluido' => 'Servi�o Conclu�do?',
            'OT.QuitadoOrca' => 'Or�amento Quitado?',
            'OT.DataConclusao' => 'Data de Conclus�o',
            'OT.DataQuitado' => 'Data de Quitado',
			'OT.DataRetorno' => 'Data de Retorno',
			'OT.ProfissionalOrca' => 'Profissional',
			'PR.DataVencimentoRecebiveis' => 'Data do Venc.',
			'PR.DataPagoRecebiveis' => 'Data do Pagam.',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();

		/*
        $data['select']['Pesquisa'] = array(
            'DataEntradaOrca' => 'Data de Entrada',
            'DataVencimentoRecebiveis' => 'Data de Vencimento da Parcela',
        );
        */


        $data['titulo'] = 'Or�amentos & Pagamentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');

			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ServicoConcluido'] = $data['query']['ServicoConcluido'];

            $data['report'] = $this->Relatoriocliente_model->list_financeiro($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_financeiro', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_financeiro', $data);

        $this->load->view('basico/footer');

    }

	public function receitas() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'Ano',
			'Mesvenc',
			'Mespag',			
			'TipoReceita',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
            'AprovadoOrca',
            'QuitadoOrca',
			'ServicoConcluido',
			'QuitadoRecebiveis',
			'Modalidade',
        ), TRUE));
/*
		if (!$data['query']['DataInicio2'])
           $data['query']['DataInicio2'] = date("d/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		
		if (!$data['query']['DataFim2'])
           $data['query']['DataFim2'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
						
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2018';
		
		if (!$data['query']['DataFim'])
           $data['query']['DataFim'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));

	   
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
	   
	   if (!$data['query']['Mespag'])
           $data['query']['Mespag'] = date('m', time());
*/
		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());
	   
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
		#$this->form_validation->set_rules('Mesvenc', 'M�s do Vencimento', 'required|trim');
		#$this->form_validation->set_rules('Mespag', 'M�s do Pagamento', 'required|trim');
		#$this->form_validation->set_rules('Ano', 'Ano', 'required|trim');        
		$this->form_validation->set_rules('DataInicio', 'Data In�cio do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio do Pagamento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim do Pagamento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Or�amento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Or�amento', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            'S' => 'Sim',
			'N' => 'N�o',
			'#' => 'TODOS',
        );

        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluido'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['QuitadoRecebiveis'] = array(
            '#' => 'TODOS',
			'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['Modalidade'] = array(
            '#' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );
		
        $data['select']['Campo'] = array(
            'PR.DataVencimentoRecebiveis' => 'Data do Venc.',
			'PR.DataPagoRecebiveis' => 'Data do Pagam.',
			'PR.QuitadoRecebiveis' => 'Quit.Parc.',
			'C.NomeCliente' => 'Nome do Cliente',
			'TR.TipoReceita' => 'Tipo de Receita',
			'OT.Modalidade' => 'Modalidade',
            'OT.idApp_OrcaTrataCons' => 'N�mero do Or�amento',
            'OT.DataOrca' => 'Data do Or�amento',
            'OT.ValorOrca' => 'Valor do Or�amento',
            'OT.ServicoConcluido' => 'Servi�o Conclu�do?',
            'OT.QuitadoOrca' => 'Or�amento Quitado?',
            'OT.DataRetorno' => 'Data de Retorno',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();
		$data['select']['TipoReceita'] = $this->Relatoriocliente_model->select_tiporeceita();
		$data['select']['Mesvenc'] = $this->Relatoriocliente_model->select_mes();
		$data['select']['Mespag'] = $this->Relatoriocliente_model->select_mes();
		/*
        $data['select']['Pesquisa'] = array(
            'DataEntradaOrca' => 'Data de Entrada',
            'DataVencimentoRecebiveis' => 'Data de Vencimento da Parcela',
        );
        */


        $data['titulo'] = 'Receitas & Pagamentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['TipoReceita'] = $data['query']['TipoReceita'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ServicoConcluido'] = $data['query']['ServicoConcluido'];
			$data['bd']['QuitadoRecebiveis'] = $data['query']['QuitadoRecebiveis'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            $data['report'] = $this->Relatoriocliente_model->list_receitas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_receitas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_receitas', $data);

        $this->load->view('basico/footer');

    }

    public function orcamento() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(

            'DataInicio',
            'DataFim',
			'DataInicio',
            'DataFim2',
			'DataInicio2',
            'DataFim3',
			'DataInicio3',
			'DataFim4',
			'DataInicio4',
            'Ordenamento',
            'Campo',
            'AprovadoOrca',
            'QuitadoOrca',
			'ServicoConcluido',
			'FormaPag',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio do Or�amento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Or�amento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Retorno', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Retorno', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data In�cio do Quitado', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Quitado', 'trim|valid_date');


        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluido'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(


            'OT.idApp_OrcaTrataCons' => 'N�mero do Or�amento',
            'OT.AprovadoOrca' => 'Or�amento Aprovado?',
            'OT.DataOrca' => 'Data do Or�amento',
			'OT.DataEntradaOrca' => 'Validade do Or�amento',
			'OT.DataPrazo' => 'Data da Entrega',
            'OT.ValorOrca' => 'Valor do Or�amento',
			'OT.ValorEntradaOrca' => 'Valor do Desconto',
			'OT.ValorRestanteOrca' => 'Valor a Receber',
			'OT.FormaPag' => 'Forma de Pag.?',
            'OT.ServicoConcluido' => 'Servi�o Conclu�do?',
            'OT.QuitadoOrca' => 'Or�amento Quitado?',
            'OT.DataConclusao' => 'Data de Conclus�o',
			'OT.DataQuitado' => 'Data de Quitado',
            'OT.DataRetorno' => 'Data de Retorno',
			'OT.ProfissionalOrca' => 'Profissional',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        #$data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();
		$data['select']['FormaPag'] = $this->Relatoriocliente_model->select_formapag();

        $data['titulo'] = 'Clientes & Or�amentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];

			$data['bd']['FormaPag'] = $data['query']['FormaPag'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ServicoConcluido'] = $data['query']['ServicoConcluido'];

            $data['report'] = $this->Relatoriocliente_model->list_orcamento($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_orcamento', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_orcamento', $data);

        $this->load->view('basico/footer');



    }

    public function orcamento2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(

            'idApp_OrcaTrata',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        #$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        #$this->form_validation->set_rules('DataInicio', 'Data In�cio do Or�amento', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim', 'Data Fim do Or�amento', 'trim|valid_date');
		#$this->form_validation->set_rules('DataInicio2', 'Data In�cio da Entrega', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		#$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Retorno', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim3', 'Data Fim do Retorno', 'trim|valid_date');
		#$this->form_validation->set_rules('DataInicio4', 'Data In�cio do Quitado', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim4', 'Data Fim do Quitado', 'trim|valid_date');



        $data['select']['Campo'] = array(

            'OT.idApp_OrcaTrata' => 'N�mero do Or�amento',


        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );



        $data['titulo'] = 'Clientes & Or�amentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];


            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];


            $data['report'] = $this->Relatoriocliente_model->list_orcamento($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_orcamento', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_orcamento', $data);

        $this->load->view('basico/footer');



    }
	
    public function orcamentorede() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
            'DataInicio',
            'DataFim',
			'DataInicio',
            'DataFim2',
			'DataInicio2',
            'DataFim3',
			'DataInicio3',
			'DataFim4',
			'DataInicio4',
            'Ordenamento',
            'Campo',
            'AprovadoOrca',
            'QuitadoOrca',
			'ServicoConcluido',
			'FormaPag',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio do Or�amento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Or�amento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Retorno', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Retorno', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data In�cio do Quitado', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Quitado', 'trim|valid_date');


        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluido'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(

            'OT.idApp_OrcaTrata' => 'N�mero do Or�amento',
            'OT.AprovadoOrca' => 'Or�amento Aprovado?',
			'OT.ServicoConcluido' => 'Or�am. Conclu�do?',
            'OT.DataOrca' => 'Data do Or�amento',
			'OT.QuitadoOrca' => 'Or�am. Quitado?',
            'OT.DataConclusao' => 'Data de Conclus�o',
			'OT.DataQuitado' => 'Data de Quitado',
            'OT.DataRetorno' => 'Data de Retorno',          
			#'OT.DataEntradaOrca' => 'Validade do Or�amento',
			#'OT.DataPrazo' => 'Data da Entrega',
            'OT.ValorOrca' => 'Valor do Or�amento',
			'OT.ValorEntradaOrca' => 'Valor do Desconto',
			'OT.ValorRestanteOrca' => 'Valor a Receber',
			'OT.FormaPagamento' => 'Forma de Pag.?',
            

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientees();
		$data['select']['FormaPag'] = $this->Relatoriocliente_model->select_formapag();

        $data['titulo'] = 'Or�amentos com a Rede';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['FormaPag'] = $data['query']['FormaPag'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ServicoConcluido'] = $data['query']['ServicoConcluido'];

            $data['report'] = $this->Relatoriocliente_model->list_orcamentorede($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_orcamentorede', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_orcamentorede', $data);

        $this->load->view('basico/footer');



    }
	
	public function despesas() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'Ano',
			'Mesvenc',
			'Mespag',
			'TipoDespesa',
			'TipoProduto',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
			'AprovadoDespesas',
			'ServicoConcluidoDespesas',
            'QuitadoDespesas',
			'QuitadoPagaveis',
			'ModalidadeDespesas',

        ), TRUE));
/*
        if (!$data['query']['DataInicio2'])
           $data['query']['DataInicio2'] = date("d/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		
		if (!$data['query']['DataFim2'])
           $data['query']['DataFim2'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
						
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2018';
		
		if (!$data['query']['DataFim'])
           $data['query']['DataFim'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));		

	   
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
	   
		if (!$data['query']['Mespag'])
           $data['query']['Mespag'] = date('m', time());
*/
		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());
	   
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        #$this->form_validation->set_rules('Mesvenc', 'M�s do Vencimento', 'required|trim');
		#$this->form_validation->set_rules('Mespag', 'M�s do Pagamento', 'required|trim');
		#$this->form_validation->set_rules('Ano', 'Ano', 'required|trim');        
		$this->form_validation->set_rules('DataInicio', 'Data In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Or�amento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Or�amento', 'trim|valid_date');

		$data['select']['AprovadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluidoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['QuitadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['QuitadoPagaveis'] = array(
			'#' => 'TODOS',            
			'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ModalidadeDespesas'] = array(
            '#' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );
		
        $data['select']['Campo'] = array(

            'PP.DataVencimentoPagaveis' => 'Data do Venc.',
			'PP.DataPagoPagaveis' => 'Data do Pagam.',
			'PP.QuitadoPagaveis' => 'Quit.Parc.',
			'DS.idApp_Despesascons' => 'N�mero da Despesa',
            'DS.DataDespesas' => 'Data da Despesa',
            'DS.ValorDespesas' => 'Valor da Despesa',
			'DS.Despesa' => 'Despesa',
			'DS.TipoDespesa' => 'Tipo de Despesa',
            'DS.QuitadoDespesas' => 'Despesa Quitada?',
			'DS.ModalidadeDespesas' => 'Modalidade',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['TipoDespesa'] = $this->Relatoriocliente_model->select_tipodespesa();
		$data['select']['Mesvenc'] = $this->Relatoriocliente_model->select_mes();
		$data['select']['Mespag'] = $this->Relatoriocliente_model->select_mes();
		
        $data['titulo'] = 'Despesas & Pagamentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['TipoDespesa'] = $data['query']['TipoDespesa'];
			$data['bd']['TipoProduto'] = $data['query']['TipoProduto'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['AprovadoDespesas'] = $data['query']['AprovadoDespesas'];
			$data['bd']['ServicoConcluidoDespesas'] = $data['query']['ServicoConcluidoDespesas'];
            $data['bd']['QuitadoDespesas'] = $data['query']['QuitadoDespesas'];
			$data['bd']['QuitadoPagaveis'] = $data['query']['QuitadoPagaveis'];
			$data['bd']['ModalidadeDespesas'] = $data['query']['ModalidadeDespesas'];
            $data['report'] = $this->Relatoriocliente_model->list_despesas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_despesas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_despesas', $data);

        $this->load->view('basico/footer');

    }

	public function despesasprod() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'TipoDespesa',
			'TipoProduto',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
			'AprovadoDespesas',
			'ServicoConcluidoDespesas',
            'QuitadoDespesas',
			'QuitadoPagaveis',

        ), TRUE));
		/*
        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

		if (!$data['query']['DataInicio2'])
           $data['query']['DataInicio2'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Or�amento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Or�amento', 'trim|valid_date');

		$data['select']['AprovadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluidoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['QuitadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['QuitadoPagaveis'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(

            'PP.DataVencimentoPagaveis' => 'Data do Venc.',
			'PP.DataPagoPagaveis' => 'Data do Pagam.',
			'PP.QuitadoPagaveis' => 'Quit.Parc.',
			'DS.idApp_Despesas' => 'N�mero da Despesa',
            'DS.DataDespesas' => 'Data da Despesa',
            'DS.ValorDespesas' => 'Valor da Despesa',
			'DS.Despesa' => 'Despesa',
			'DS.TipoDespesa' => 'Tipo de Despesa',
            'DS.QuitadoDespesas' => 'Despesa Quitada?',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['TipoDespesa'] = $this->Relatoriocliente_model->select_tipodespesa();

        $data['titulo'] = 'Relat�rio de Despesas & Sa�das';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['TipoDespesa'] = $data['query']['TipoDespesa'];
			$data['bd']['TipoProduto'] = $data['query']['TipoProduto'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['AprovadoDespesas'] = $data['query']['AprovadoDespesas'];
			$data['bd']['ServicoConcluidoDespesas'] = $data['query']['ServicoConcluidoDespesas'];
            $data['bd']['QuitadoDespesas'] = $data['query']['QuitadoDespesas'];
			$data['bd']['QuitadoPagaveis'] = $data['query']['QuitadoPagaveis'];

            $data['report'] = $this->Relatoriocliente_model->list_despesas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_despesas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_despesas', $data);

        $this->load->view('basico/footer');

    }

	public function despesaspag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'TipoDespesa',
			'TipoProduto',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
			'AprovadoDespesas',
			'ServicoConcluidoDespesas',
            'QuitadoDespesas',
			'QuitadoPagaveis',

        ), TRUE));
		/*
        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

		if (!$data['query']['DataInicio2'])
           $data['query']['DataInicio2'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Or�amento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Or�amento', 'trim|valid_date');

		$data['select']['AprovadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluidoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['QuitadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['QuitadoPagaveis'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(

            'PP.DataVencimentoPagaveis' => 'Data do Venc.',
			'PP.DataPagoPagaveis' => 'Data do Pagam.',
			'PP.QuitadoPagaveis' => 'Quit.Parc.',
			'DS.idApp_Despesas' => 'N�mero da Despesa',
            'DS.DataDespesas' => 'Data da Despesa',
            'DS.ValorDespesas' => 'Valor da Despesa',
			'DS.Despesa' => 'Despesa',
			'DS.TipoDespesa' => 'Tipo de Despesa',
            'DS.QuitadoDespesas' => 'Despesa Quitada?',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['TipoDespesa'] = $this->Relatoriocliente_model->select_tipodespesa();

        $data['titulo'] = 'Relat�rio de Despesas & Sa�das';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['TipoDespesa'] = $data['query']['TipoDespesa'];
			$data['bd']['TipoProduto'] = $data['query']['TipoProduto'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['AprovadoDespesas'] = $data['query']['AprovadoDespesas'];
			$data['bd']['ServicoConcluidoDespesas'] = $data['query']['ServicoConcluidoDespesas'];
            $data['bd']['QuitadoDespesas'] = $data['query']['QuitadoDespesas'];
			$data['bd']['QuitadoPagaveis'] = $data['query']['QuitadoPagaveis'];

            $data['report'] = $this->Relatoriocliente_model->list_despesaspag($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_despesaspag', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_despesaspag', $data);

        $this->load->view('basico/footer');

    }

	public function devolucao1DESPESAS() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'TipoDespesa',
			'TipoProduto',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
			'AprovadoDespesas',
			'ServicoConcluidoDespesas',
            'QuitadoDespesas',
			'QuitadoPagaveis',

        ), TRUE));
		/*
        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

		if (!$data['query']['DataInicio2'])
           $data['query']['DataInicio2'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Or�amento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Or�amento', 'trim|valid_date');

		$data['select']['AprovadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluidoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['QuitadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['QuitadoPagaveis'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(

            'PP.DataVencimentoPagaveis' => 'Data do Venc.',
			'PP.DataPagoPagaveis' => 'Data do Pagam.',
			'PP.QuitadoPagaveis' => 'Quit.Parc.',
			'DS.idApp_Despesas' => 'N�mero da Despesa',
            'DS.DataDespesas' => 'Data da Despesa',
            'DS.ValorDespesas' => 'Valor da Despesa',
			'DS.Despesa' => 'Despesa',
			'DS.TipoDespesa' => 'Tipo de Despesa',
            'DS.QuitadoDespesas' => 'Despesa Quitada?',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['TipoDespesa'] = $this->Relatoriocliente_model->select_tipodespesa();

        $data['titulo'] = 'Relat�rio de Devolu��es';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['TipoDespesa'] = $data['query']['TipoDespesa'];
			$data['bd']['TipoProduto'] = $data['query']['TipoProduto'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['AprovadoDespesas'] = $data['query']['AprovadoDespesas'];
			$data['bd']['ServicoConcluidoDespesas'] = $data['query']['ServicoConcluidoDespesas'];
            $data['bd']['QuitadoDespesas'] = $data['query']['QuitadoDespesas'];
			$data['bd']['QuitadoPagaveis'] = $data['query']['QuitadoPagaveis'];

            $data['report'] = $this->Relatoriocliente_model->list_devolucao($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_devolucao', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_devolucao', $data);

        $this->load->view('basico/footer');

    }

    public function balanco() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Ano',
        ), TRUE));

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = '2018';		
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('Ano', 'Ano', 'required|trim|integer|greater_than[1900]');

        $data['titulo'] = 'Relat�rio de Balan�o';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            $data['report'] = $this->Relatoriocliente_model->list_balanco($data['query']);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_balanco', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_balanco', $data);

        $this->load->view('basico/footer');

    }

    public function estoque() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Produtos',
            'DataInicio',
            'DataFim',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['Campo'] = array(
			'TP.CodProd' => 'C�digo',
			'TP.idTab_Produtos' => 'Id',
			'TP.Produtos' => 'Produto',
			'TP.Categoria' => 'Prod/Serv',
			'TP.Prodaux1' => 'Aux1',
			'TP.Prodaux2' => 'Aux2',
			'TP.Prodaux3' => 'Categoria',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );



        $data['select']['Produtos'] = $this->Relatoriocliente_model->select_produtos();
		$data['select']['Prodaux1'] = $this->Relatoriocliente_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatoriocliente_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Relatoriocliente_model->select_prodaux3();


        $data['titulo'] = 'Relat�rio de Estoque';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_estoque($data['bd']);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              #exit();
              #*/

            $data['list'] = $this->load->view('relatoriocliente/list_estoque', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_estoque', $data);

        $this->load->view('basico/footer');

    }

	public function rankingvendas() {

	if ($this->input->get('m') == 1)
		$data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
	elseif ($this->input->get('m') == 2)
		$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
	else
		$data['msg'] = '';

	$data['query'] = quotes_to_entities($this->input->post(array(
		'ValorOrca',
		'NomeCliente',
		'idApp_Cliente',
		'DataInicio',
		'DataFim',
		'Ordenamento',
		'Campo',
	), TRUE));

	$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
	#$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
	$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
	$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

	$data['select']['Campo'] = array(

		'TC.NomeCliente' => 'Cliente',
		'TC.idApp_Cliente' => 'Id',

	);

	$data['select']['Ordenamento'] = array(
		'ASC' => 'Crescente',
		'DESC' => 'Decrescente',
	);



	$data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();
	$data['select']['idApp_Cliente'] = $this->Relatoriocliente_model->select_clientes();


	$data['titulo'] = 'Relat�rio de Estoque';

	#run form validation
	if ($this->form_validation->run() !== FALSE) {

		$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
		$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
		$data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
		$data['bd']['Campo'] = $data['query']['Campo'];

		$data['report'] = $this->Relatoriocliente_model->list_rankingvendas($data['bd']);

		/*
		  echo "<pre>";
		  print_r($data['report']);
		  echo "</pre>";
		  #exit();
		  #*/

		$data['list'] = $this->load->view('relatoriocliente/list_rankingvendas', $data, TRUE);
		//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
	}

	$this->load->view('relatoriocliente/tela_rankingvendas', $data);

	$this->load->view('basico/footer');

}
	
    public function estoque2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Produtos',
            'DataInicio',
            'DataFim',
            'Prodaux1',
            'Prodaux2',
            'Prodaux3',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['Campo'] = array(
            'TP.CodProd' => 'C�digo',
            'TP.idTab_Produtos' => 'Id',
            'TP.Produtos' => 'Produto',
            'TP.Categoria' => 'Prod/Serv',
            'TP.Prodaux1' => 'Aux1',
            'TP.Prodaux2' => 'Aux2',
            'TP.Prodaux3' => 'Categoria',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Produtos'] = $this->Relatoriocliente_model->select_produtos();
        $data['select']['Prodaux1'] = $this->Relatoriocliente_model->select_prodaux1();
        $data['select']['Prodaux2'] = $this->Relatoriocliente_model->select_prodaux2();
        $data['select']['Prodaux3'] = $this->Relatoriocliente_model->select_prodaux3();

        $data['titulo'] = 'Relat�rio de Estoque';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
            $data['bd']['Produtos'] = $data['query']['Produtos'];
            $data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
            $data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
            $data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_estoque($data['bd']);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_estoque', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_estoque', $data);

        $this->load->view('basico/footer');

    }

	public function admin() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $data['titulo1'] = 'Cadastrar';
		$data['titulo2'] = 'Finan�as & Estoque';
		$data['titulo3'] = 'Relat�rio 3';
		$data['titulo4'] = 'Comiss�o';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatoriocliente/tela_admin', $data);

        $this->load->view('basico/footer');

    }

	public function adminempresa() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $data['titulo1'] = 'Cadastrar';
		$data['titulo2'] = 'Relat�rios';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatoriocliente/tela_adminempresa', $data);

        $this->load->view('basico/footer');

    }

	public function sistema() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $data['titulo1'] = 'Manute��o';
		$data['titulo2'] = 'Comiss�o';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatoriocliente/tela_sistema', $data);

        $this->load->view('basico/footer');

    }

	public function produtosvend() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'CodProd',
			'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'AprovadoOrca',
			'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'Ordenamento',
            'Campo',

        ), TRUE));
/*
        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Entrega In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Entrega Fim', 'trim|valid_date');

		$data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrataCons' => 'Id Or�am.',
			'OT.AprovadoOrca' => 'Or�. Aprov./Fechado?',
            'OT.DataOrca' => 'Data do Or�am.',
			'TPV.CodProd' => 'C�digo',
			'TPV.Produtos' => 'Produto',
			'TPV.Prodaux1' => 'Aux1',
			'TPV.Prodaux2' => 'Aux2',
			'TPV.Prodaux3' => 'Categoria',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();
		$data['select']['Produtos'] = $this->Relatoriocliente_model->select_produtos();
		$data['select']['Prodaux1'] = $this->Relatoriocliente_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatoriocliente_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Relatoriocliente_model->select_prodaux3();

        $data['titulo'] = 'Relat�rio de Produtos Vendidos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['report'] = $this->Relatoriocliente_model->list_produtosvend($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_produtosvend', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_produtosvend', $data);

        $this->load->view('basico/footer');

    }

	public function produtosdevol1() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Nome',
			'CodProd',
			'TipoDevolucao',
			'TipoRD',
			'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'AprovadoOrca',
			'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'Ordenamento',
            'Campo',

        ), TRUE));
/*
        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Entrega In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Entrega Fim', 'trim|valid_date');


        $data['select']['Campo'] = array(
            'C.Nome' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'N� Dev.',
			'OT.Orcamento' => 'N� Or�.',
            'OT.DataOrca' => 'Dt. Dev.',
			'OT.CodProd' => 'Cd. Prod.',
			'TPV.QtdVendaServico' => 'Qtd. do Produto',
			'TPV.Produtos' => 'Produto',
			'TPV.Prodaux1' => 'Aux1',
			'TPV.Prodaux2' => 'Aux2',
			'TPV.Prodaux3' => 'Categoria',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['Nome'] = $this->Relatoriocliente_model->select_clientes();
		$data['select']['TipoDevolucao'] = $this->Relatoriocliente_model->select_tipodevolucao();
		$data['select']['Produtos'] = $this->Relatoriocliente_model->select_produtos();
		$data['select']['Prodaux1'] = $this->Relatoriocliente_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatoriocliente_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Relatoriocliente_model->select_prodaux3();

		$data['titulo'] = 'Relat�rio de Produtos Devolvidos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
			$data['bd']['Nome'] = $data['query']['Nome'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$data['bd']['TipoDevolucao'] = $data['query']['TipoDevolucao'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_produtosdevol1($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_produtosdevol1', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_produtosdevol1', $data);

        $this->load->view('basico/footer');

    }

	public function servicosprest1() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'NomeProfissional',
			'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',

        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');


        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'Id Or�am.',
            'OT.DataOrca' => 'Data do Or�am.',
			'OT.ProfissionalOrca' => 'Respons�vel',
			'TPB.ServicoBase' => 'Servi�o',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();
		$data['select']['NomeProfissional'] = $this->Relatoriocliente_model->select_profissional();

        $data['titulo'] = 'Relat�rio de Servi�os Prestados';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_servicosprest($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_servicosprest', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_servicosprest', $data);

        $this->load->view('basico/footer');

    }

	public function servicosprest() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'NomeProfissional',
			'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',

        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');


        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'Id Or�am.',
            'OT.DataOrca' => 'Data do Or�am.',
			'OT.ProfissionalOrca' => 'Respons�vel',
			'PD.NomeServico' => 'Servi�o',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();
		$data['select']['NomeProfissional'] = $this->Relatoriocliente_model->select_profissional();

        $data['titulo'] = 'Relat�rio de Servi�os Prestados';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_servicosprest($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_servicosprest', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_servicosprest', $data);

        $this->load->view('basico/footer');

    }

	public function consumo() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'TipoDespesa',
			'TipoProduto',
			'Produtos',
            'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',
        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['Campo'] = array(

			'TCO.idApp_Despesas' => 'Id do Consumo',
            'TCO.DataDespesas' => 'Data do Consumo',
			'TCO.TipoDespesa' => 'Tipo de Consumo',
			'TCO.Despesa' => 'Consumo',
			'APC.QtdCompraProduto' => 'Qtd. do Produto',
			'TPB.Produtos' => 'Produto',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['TipoDespesa'] = $this->Relatoriocliente_model->select_tipoconsumo();
		$data['select']['Produtos'] = $this->Relatoriocliente_model->select_produtos();

        $data['titulo'] = 'Relat�rio de Produtos Cons. Inter.';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['TipoDespesa'] = $data['query']['TipoDespesa'];
			$data['bd']['TipoProduto'] = $data['query']['TipoProduto'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_consumo($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_consumo', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_consumo', $data);

        $this->load->view('basico/footer');

    }

	public function produtoscomp() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'TipoDespesa',
			'TipoProduto',
			'Produtos',
            'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',
        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['Campo'] = array(

			'TCO.idApp_Despesas' => 'Id da Despesa',
            'TCO.DataDespesas' => 'Data da Despesa',
			'TCO.TipoDespesa' => 'Tipo de Despesa',
			'TCO.Despesa' => 'Descr. da Despesa',
			'APC.QtdCompraProduto' => 'Qtd. do Produto',
			'TPB.Produtos' => 'Produto',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['TipoDespesa'] = $this->Relatoriocliente_model->select_tipodespesa();
		$data['select']['Produtos'] = $this->Relatoriocliente_model->select_produtos();

        $data['titulo'] = 'Relat�rio de Produtos Comprados';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['TipoDespesa'] = $data['query']['TipoDespesa'];
			$data['bd']['TipoProduto'] = $data['query']['TipoProduto'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_produtoscomp($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_produtoscomp', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_produtoscomp', $data);

        $this->load->view('basico/footer');

    }

	public function produtosdevol() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'CodProd',
			'TipoDespesa',
			'TipoProduto',
			'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'AprovadoDespesas',
            'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',
        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
/*
        $data['select']['AprovadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
*/

		$data['select']['Campo'] = array(
			'C.NomeCliente' => 'Cliente',
			'TCO.idApp_Despesas' => 'N� da Devol.',
			'TCO.idApp_OrcaTrata' => 'N� do Or�am.',
            'TCO.DataDespesas' => 'Data da Devol.',
			'TCO.AprovadoDespesas' => 'Devol. Aprov./Fechado?',
			'TCO.CodProd' => 'C�digo',
			'TCO.TipoDespesa' => 'Tipo de Devol.',
			'TCO.Despesa' => 'Descr. da Devol.',
			'APC.QtdCompraProduto' => 'Qtd. do Produto',
			'TPB.Produtos' => 'Produto',
			'TPB.Prodaux1' => 'Aux1',
			'TPB.Prodaux2' => 'Aux2',
			'TPB.Prodaux3' => 'Categoria',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['TipoDespesa'] = $this->Relatoriocliente_model->select_tipodespesa();
		$data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();
		$data['select']['Produtos'] = $this->Relatoriocliente_model->select_produtos();
		$data['select']['Prodaux1'] = $this->Relatoriocliente_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatoriocliente_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Relatoriocliente_model->select_prodaux3();



        $data['titulo'] = 'Relat�rio de Produtos Devolvidos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['AprovadoDespesas'] = $data['query']['AprovadoDespesas'];
			$data['bd']['TipoDespesa'] = $data['query']['TipoDespesa'];
			$data['bd']['TipoProduto'] = $data['query']['TipoProduto'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_produtosdevol($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_produtosdevol', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_produtosdevol', $data);

        $this->load->view('basico/footer');

    }

    public function devolucaorede() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Nome',
            'DataInicio',
            'DataFim',
			'DataInicio',
            'DataFim2',
			'DataInicio2',
            'DataFim3',
			'DataInicio3',
			'DataFim4',
			'DataInicio4',
            'Ordenamento',
            'Campo',
            'AprovadoOrca',
            'QuitadoOrca',
			'ServicoConcluido',
			'FormaPag',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio do Or�amento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Or�amento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Retorno', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Retorno', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data In�cio do Quitado', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Quitado', 'trim|valid_date');


        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluido'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(

            'OT.idApp_OrcaTrata' => 'N�mero do Or�amento',
            'OT.AprovadoOrca' => 'Or�amento Aprovado?',
			'OT.ServicoConcluido' => 'Or�am. Conclu�do?',
            'OT.DataOrca' => 'Data do Or�amento',
			'OT.QuitadoOrca' => 'Or�am. Quitado?',
            'OT.DataConclusao' => 'Data de Conclus�o',
			'OT.DataQuitado' => 'Data de Quitado',
            'OT.DataRetorno' => 'Data de Retorno',          
			#'OT.DataEntradaOrca' => 'Validade do Or�amento',
			#'OT.DataPrazo' => 'Data da Entrega',
            'OT.ValorOrca' => 'Valor do Or�amento',
			'OT.ValorDev' => 'Valor do Desconto',
			'OT.ValorRestanteOrca' => 'Valor a Receber',
			'OT.FormaPag' => 'Forma de Pag.?',
            

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatoriocliente_model->select_clientees();
		$data['select']['FormaPag'] = $this->Relatoriocliente_model->select_formapag();

        $data['titulo'] = 'Or�amentos com a Rede';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['Nome'] = $data['query']['Nome'];
			$data['bd']['FormaPag'] = $data['query']['FormaPag'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ServicoConcluido'] = $data['query']['ServicoConcluido'];

            $data['report'] = $this->Relatoriocliente_model->list_devolucaorede($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_devolucaorede', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_devolucaorede', $data);

        $this->load->view('basico/footer');



    }
	
	public function devolucao1() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Nome',
			'TipoRD',
			'TipoDevolucao',
            'DataInicio',
            'DataFim',
			'DataInicio',
            'DataFim2',
			'DataInicio2',
            'DataFim3',
			'DataInicio3',
			'DataFim4',
			'DataInicio4',
            'Ordenamento',
            'Campo',
            'AprovadoOrca',
            'QuitadoOrca',
			'ServicoConcluido',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio do Or�amento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Or�amento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Retorno', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Retorno', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data In�cio do Quitado', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Quitado', 'trim|valid_date');


        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluido'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.Nome' => 'Nome do Cliente',
            'OT.idApp_OrcaTrata' => 'N� Devol.',
            'OT.AprovadoOrca' => 'Apr./Fech.',
            'OT.DataOrca' => 'Dt. Devol.',
			'OT.TipoDevolucao' => 'Tipo Devol.',
			'OT.DataEntradaOrca' => 'Validade do Or�amento',
			'OT.DataPrazo' => 'Data da Entrega',
            'OT.ValorOrca' => 'Valor do Or�amento',
			'OT.ValorEntradaOrca' => 'Valor do Desconto',
			'OT.ValorRestanteOrca' => 'Valor a Receber',
            'OT.ServicoConcluido' => 'Servi�o Conclu�do?',
            'OT.QuitadoOrca' => 'Or�amento Quitado?',
            'OT.DataConclusao' => 'Data de Conclus�o',
			'OT.DataQuitado' => 'Data de Quitado',
            'OT.DataRetorno' => 'Data de Retorno',
			'OT.ProfissionalOrca' => 'Profissional',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatoriocliente_model->select_clientes();

        $data['titulo'] = 'Clientes & Devolu��es';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['Nome'] = $data['query']['Nome'];
			$data['bd']['TipoRD'] = $data['query']['TipoDevolucao'];
			$data['bd']['TipoDevolucao'] = $data['query']['TipoRD'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ServicoConcluido'] = $data['query']['ServicoConcluido'];

            $data['report'] = $this->Relatoriocliente_model->list_devolucao1($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_devolucao1', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_devolucao1', $data);

        $this->load->view('basico/footer');



    }

	public function devolucao() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'idApp_Despesas',
			'idApp_OrcaTrata',
			'NomeCliente',
            'DataFim',
			'DataInicio',
            'DataFim2',
			'DataInicio2',
            'DataFim3',
			'DataInicio3',
            'Ordenamento',
            'Campo',
            'AprovadoDespesas',
            'QuitadoDespesas',
			'ServicoConcluidoDespesas',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio do Or�amento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Or�amento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Retorno', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Retorno', 'trim|valid_date');


        $data['select']['AprovadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['QuitadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluidoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(

			'C.NomeCliente' => 'Cliente',
            'OT.idApp_Despesas' => 'N�mero da Devolu��o',
			'OT.idApp_OrcaTrata' => 'N�mero do Or�amento',
            'OT.AprovadoDespesas' => 'Or�amento Aprovado?',
            'OT.DataDespesas' => 'Data do Or�amento',
			'OT.DataEntradaDespesas' => 'Validade do Or�amento',
            'OT.ValorDespesas' => 'Valor do Or�amento',
			'OT.ValorEntradaDespesas' => 'Valor do Desconto',
			'OT.ValorRestanteDespesas' => 'Valor a Receber',

            'OT.ServicoConcluidoDespesas' => 'Servi�o Conclu�do?',
            'OT.QuitadoDespesas' => 'Or�amento Quitado?',
            'OT.DataConclusaoDespesas' => 'Data de Conclus�o',

            'OT.DataRetornoDespesas' => 'Data de Retorno',
			'OT.ProfissionalDespesas' => 'Profissional',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();

        $data['titulo'] = 'Clientes & Devolu��es';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoDespesas'] = $data['query']['AprovadoDespesas'];
            $data['bd']['QuitadoDespesas'] = $data['query']['QuitadoDespesas'];
			$data['bd']['ServicoConcluidoDespesas'] = $data['query']['ServicoConcluidoDespesas'];

            $data['report'] = $this->Relatoriocliente_model->list_devolucao($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_devolucao', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_devolucao', $data);

        $this->load->view('basico/footer');



    }

	public function despesas2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'idApp_Despesas',
			'idApp_OrcaTrata',
			'Categoriadesp',
			'TipoDespesa',
			'NomeCliente',
            'DataFim',
			'DataInicio',
            'DataFim2',
			'DataInicio2',
            'DataFim3',
			'DataInicio3',
            'Ordenamento',
            'Campo',
            'AprovadoDespesas',
            'QuitadoDespesas',
			'ServicoConcluidoDespesas',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio do Or�amento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Or�amento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Retorno', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Retorno', 'trim|valid_date');


        $data['select']['AprovadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['QuitadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluidoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(

			'C.NomeCliente' => 'Cliente',
            'OT.idApp_Despesas' => 'N�mero da Despesa',
            'OT.AprovadoDespesas' => 'Or�amento Aprovado?',
            'OT.TipoDespesa' => 'Tipo de Despesa',
			'OT.DataDespesas' => 'Data do Or�amento',
            'OT.ValorDespesas' => 'Valor do Or�amento',
			'OT.ValorEntradaDespesas' => 'Valor do Desconto',
			'OT.ValorRestanteDespesas' => 'Valor a Receber',
            'OT.ServicoConcluidoDespesas' => 'Servi�o Conclu�do?',
            'OT.QuitadoDespesas' => 'Or�amento Quitado?',
            'OT.DataConclusaoDespesas' => 'Data de Conclus�o',
			'OT.ProfissionalDespesas' => 'Profissional',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();
		$data['select']['TipoDespesa'] = $this->Relatoriocliente_model->select_tipodespesa();
		$data['select']['Categoriadesp'] = $this->Relatoriocliente_model->select_categoriadesp();

        $data['titulo'] = 'Despesas';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['TipoDespesa'] = $data['query']['TipoDespesa'];
			$data['bd']['Categoriadesp'] = $data['query']['Categoriadesp'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoDespesas'] = $data['query']['AprovadoDespesas'];
            $data['bd']['QuitadoDespesas'] = $data['query']['QuitadoDespesas'];
			$data['bd']['ServicoConcluidoDespesas'] = $data['query']['ServicoConcluidoDespesas'];

            $data['report'] = $this->Relatoriocliente_model->list_despesas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_despesas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_despesas', $data);

        $this->load->view('basico/footer');



    }

    public function clientes() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			#'Inativo',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
/*
        $data['select']['Inativo'] = array(
            'N' => 'N�o',
            'S' => 'Sim',
			'#' => 'TODOS',
        );
*/
		$data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'C.Inativo' => 'Inativo',
            'C.DataNascimento' => 'Data de Nascimento',
            'C.Sexo' => 'Sexo',
			'C.idApp_Cliente' => 'n� Cliente',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();

        $data['titulo'] = 'Relat�rio de Clientes';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			#$data['bd']['Inativo'] = $data['query']['Inativo'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_clientes($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_clientes', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_clientes', $data);

        $this->load->view('basico/footer');



    }

    public function aniversariantes() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Dia',
			'Mes',
			'Ano',
			'NomeCliente',
			'Inativo',
            'Ordenamento',
            'Campo',
        ), TRUE));

/*		
		if (!$data['query']['Dia'])
           $data['query']['Dia'] = date('d', time());
*/	   
		if (!$data['query']['Mes'])
           $data['query']['Mes'] = date('m', time());
	   
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
/*
        $data['select']['Inativo'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );
*/
		$data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'C.idApp_Cliente' => 'N� do Cliente',
			'C.Inativo' => 'Inativo',
            'C.DataNascimento' => 'Data de Nascimento',
            'C.Sexo' => 'Sexo',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();
		$data['select']['Dia'] = $this->Relatoriocliente_model->select_dia();
		$data['select']['Mes'] = $this->Relatoriocliente_model->select_mes();
		
        $data['titulo'] = 'Anivers�rio dos Clientes';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			#$data['bd']['Inativo'] = $data['query']['Inativo'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mes'] = $data['query']['Mes'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_aniversariantes($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_aniversariantes', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_aniversariantes', $data);

        $this->load->view('basico/footer');



    }
	
    public function clientesusuario() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Nome',
			'Inativo',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['Inativo'] = array(
            '#' => 'TODOS',
            '1' => 'N�o',
            '0' => 'Sim',
        );

		$data['select']['Campo'] = array(
            'C.idApp_Cliente' => 'n� Cliente',
			'C.Nome' => 'Nome do Cliente',
			'C.Inativo' => 'Inativo',
            'C.DataNascimento' => 'Data de Nascimento',
            'C.Sexo' => 'Sexo',
            'C.Email' => 'E-mail',


        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatoriocliente_model->select_clientes();
		#$data['select']['Inativo'] = $this->Relatoriocliente_model->select_inativo();

        $data['titulo'] = 'Relat�rio de Clientes';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Nome'] = $data['query']['Nome'];
			$data['bd']['Inativo'] = $data['query']['Inativo'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_clientesusuario($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_clientesusuario', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_clientesusuario', $data);

        $this->load->view('basico/footer');



    }

	public function clientees() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Nome',
			'Inativo',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['Inativo'] = array(
            '#' => 'TODOS',
            '1' => 'N�o',
            '0' => 'Sim',
        );

		$data['select']['Campo'] = array(
            'C.idApp_Cliente' => 'n� Cliente',
			'C.Nome' => 'Nome do Cliente',
			'C.Inativo' => 'Inativo',
            'C.DataNascimento' => 'Data de Nascimento',
            'C.Sexo' => 'Sexo',
            'C.Email' => 'E-mail',


        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatoriocliente_model->select_clientees();
		#$data['select']['Inativo'] = $this->Relatoriocliente_model->select_inativo();

        $data['titulo'] = 'Relat�rio de Clientees';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Nome'] = $data['query']['Nome'];
			$data['bd']['Inativo'] = $data['query']['Inativo'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_clientees($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_clientees', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_clientees', $data);

        $this->load->view('basico/footer');



    }
	
	public function associado() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',

            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');



		$data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Associado',
            'C.DataNascimento' => 'Data de Nascimento',
            'C.Sexo' => 'Sexo',
            'C.Email' => 'E-mail',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_associado();

        $data['titulo'] = 'Relat�rio de Associados';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_associado($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_associado', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_associado', $data);

        $this->load->view('basico/footer');

    }
	
	public function associadopag() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
            'AprovadoOrca',
            'QuitadoOrca',
			'ServicoConcluido',
			'QuitadoRecebiveis',
        ), TRUE));

		/*
        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

		if (!$data['query']['DataInicio2'])
           $data['query']['DataInicio2'] = '01/01/2017';
		*/

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio do Pagamento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim do Pagamento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Or�amento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Or�amento', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            'S' => 'Sim',
			'N' => 'N�o',
			'#' => 'TODOS',
        );

        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluido'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['QuitadoRecebiveis'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'PR.DataVencimentoRecebiveis' => 'Data do Venc.',
			'PR.DataPagoRecebiveis' => 'Data do Pagam.',
			'PR.QuitadoRecebiveis' => 'Quit.Parc.',
			'C.NomeCliente' => 'Nome do Cliente',
            'OT.idApp_OrcaTrata' => 'N�mero do Or�amento',
            'OT.AprovadoOrca' => 'Or�amento Aprovado?',
            'OT.DataOrca' => 'Data do Or�amento',
            'OT.ValorOrca' => 'Valor do Or�amento',
            'OT.ServicoConcluido' => 'Servi�o Conclu�do?',
            'OT.QuitadoOrca' => 'Or�amento Quitado?',
            'OT.DataConclusao' => 'Data de Conclus�o',
			'OT.DataQuitado' => 'Data de Quitado',
            'OT.DataRetorno' => 'Data de Retorno',
			'OT.ProfissionalOrca' => 'Profissional',


        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clienteassociado();

		/*
        $data['select']['Pesquisa'] = array(
            'DataEntradaOrca' => 'Data de Entrada',
            'DataVencimentoRecebiveis' => 'Data de Vencimento da Parcela',
        );
        */


        $data['titulo'] = 'Pagamento dos Indicados';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ServicoConcluido'] = $data['query']['ServicoConcluido'];
			$data['bd']['QuitadoRecebiveis'] = $data['query']['QuitadoRecebiveis'];

            $data['report'] = $this->Relatoriocliente_model->list_associadopag($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_associadopag', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_associadopag', $data);

        $this->load->view('basico/footer');

    }

	public function profissionais() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeProfissional',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'P.NomeProfissional' => 'Nome do Profissional',
			'P.Funcao' => 'Fun��o',
            'P.DataNascimento' => 'Data de Nascimento',
            'P.Sexo' => 'Sexo',
            'P.Bairro' => 'Bairro',
            'P.Municipio' => 'Munic�pio',
            'P.Email' => 'E-mail',
			'CP.NomeContatoProf' => 'Contato do Profissional',
			'TCP.RelaPes' => 'Rela��o',
			'CP.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeProfissional'] = $this->Relatoriocliente_model->select_profissional();

        $data['titulo'] = 'Relat�rio de Funcion�rios';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_profissionais($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_profissionais', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_profissionais', $data);

        $this->load->view('basico/footer');



    }

	public function funcionario() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Nome',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'F.Nome' => 'Nome do Funcion�rio',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatoriocliente_model->select_funcionario();

        $data['titulo'] = 'Relat�rio de Funcion�rios';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Nome'] = $data['query']['Nome'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_funcionario($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_funcionario', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_funcionario', $data);

        $this->load->view('basico/footer');



    }

	public function empresas() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeEmpresa',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'E.idApp_Empresa' => 'n� Empresa',
			'E.NomeEmpresa' => 'Nome do Fornecedor',
			'E.Atividade' => 'Atividade',
            #'E.DataNascimento' => 'Data de Nascimento',
            #'E.Sexo' => 'Sexo',
            'E.Bairro' => 'Bairro',
            'E.Municipio' => 'Munic�pio',
            'E.Email' => 'E-mail',
			'CE.NomeContato' => 'Contato da Empresa',
			'TCE.RelaCom' => 'Rela��o',
			'CE.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatoriocliente_model->select_empresas();

        $data['titulo'] = 'Relat�rio de Fornecedores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_empresas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_empresas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_empresas', $data);

        $this->load->view('basico/footer');

    }

	public function fornecedor() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeFornecedor',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'E.idApp_Fornecedor' => 'n� Fornecedor',
			'E.NomeFornecedor' => 'Nome do Fornecedor',
			'E.Atividade' => 'Atividade',
            #'E.DataNascimento' => 'Data de Nascimento',
            #'E.Sexo' => 'Sexo',
            'E.Bairro' => 'Bairro',
            'E.Municipio' => 'Munic�pio',
            'E.Email' => 'E-mail',
			'CE.NomeContatofornec' => 'Contatofornec da Fornecedor',
			'TCE.RelaCom' => 'Rela��o',
			'CE.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeFornecedor'] = $this->Relatoriocliente_model->select_fornecedor();

        $data['titulo'] = 'Relat�rio de Fornecedores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_fornecedor($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_fornecedor', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_fornecedor', $data);

        $this->load->view('basico/footer');

    }

	public function produtos() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Produtos',
			'CodProd',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Categoria',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
			'TP.CodProd' => 'C�digo',
			'TP.idTab_Produtos' => 'Id',
			'TP.Produtos' => 'Descri��o',
			'TP.Categoria' => 'Prod/Serv',
			'TP.Prodaux1' => 'Aux1',
			'TP.Prodaux2' => 'Aux2',
			'TP.Prodaux3' => 'Categoria',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Produtos'] = $this->Relatoriocliente_model->select_produtos();
		$data['select']['Prodaux1'] = $this->Relatoriocliente_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatoriocliente_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Relatoriocliente_model->select_prodaux3();

        $data['titulo'] = 'Produtos, Servi�os e Valores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['CodProd'] = $data['query']['CodProd'];
			$data['bd']['Categoria'] = $data['query']['Categoria'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_produtos($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_produtos', $data, TRUE);

        }

        $this->load->view('relatoriocliente/tela_produtos', $data);

        $this->load->view('basico/footer');

    }

	public function produtoscliente() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Produtos',
			'CodProd',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Categoria',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(

			'TP.idTab_Produtos' => 'Id',
			'TP.Produtos' => 'Descri��o',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Produtos'] = $this->Relatoriocliente_model->select_produtos();
		$data['select']['Prodaux1'] = $this->Relatoriocliente_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatoriocliente_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Relatoriocliente_model->select_prodaux3();

        $data['titulo'] = 'Produtos, Servi�os e Valores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['CodProd'] = $data['query']['CodProd'];
			$data['bd']['Categoria'] = $data['query']['Categoria'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_produtoscliente($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_produtoscliente', $data, TRUE);

        }

        $this->load->view('relatoriocliente/tela_produtoscliente', $data);

        $this->load->view('basico/footerempresa');

    }
	
	public function servicos() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Servicos',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
			'TP.idApp_Servicos' => 'id do Servi�o',
			'TP.Servicos' => 'Servi�o',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Servicos'] = $this->Relatoriocliente_model->select_servicos();

        $data['titulo'] = 'Servicos e Valores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Servicos'] = $data['query']['Servicos'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatoriocliente_model->list_servicos($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_servicos', $data, TRUE);

        }

        $this->load->view('relatoriocliente/tela_servicos', $data);

        $this->load->view('basico/footer');

    }

	public function orcamentopc() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'NomeProfissional',
            'DataInicio',
            'DataFim',
            'Ordenamento',
            'Campo',
            'AprovadoOrca',
            #'QuitadoOrca',
			'ServicoConcluido',
			'ConcluidoProcedimento',

        ), TRUE));

		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );
/*
        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );
*/
		$data['select']['ServicoConcluido'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );
		$data['select']['ConcluidoProcedimento'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'N�mero do Or�amento',
			'OT.DataOrca' => 'Data do Or�amento',
            'OT.DataPrazo' => 'Data Prazo',
			'OT.AprovadoOrca' => 'Or�amento Aprovado?',
			'OT.ValorOrca' => 'Valor do Or�amento',
            #'OT.QuitadoOrca' => 'Or�amento Quitado?',
			'OT.ServicoConcluido' => 'Servi�o Conclu�do?',
            'OT.DataConclusao' => 'Data de Conclus�o',
            #'OT.DataRetorno' => 'Renova��o',
			#'PD.QtdVendaProduto' => 'Qtd. do Produto',
			'PD.idTab_Produto' => 'Produto',
			'PC.DataProcedimento' => 'Data do Procedimento',
			'PC.Profissional' => 'Profissional',
			'PC.Procedimento' => 'Procedimento',
			'PC.ConcluidoProcedimento' => 'Proc. Concl.?',
			'PC.DataProcedimentoLimite' => 'Data Limite',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();
		$data['select']['NomeProfissional'] = $this->Relatoriocliente_model->select_profissional();

		$data['titulo'] = 'Clientes X Procedimentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            #$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ServicoConcluido'] = $data['query']['ServicoConcluido'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];

			#$data['bd']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql');


            $data['report'] = $this->Relatoriocliente_model->list_orcamentopc($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_orcamentopc', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_orcamentopc', $data);

        $this->load->view('basico/footer');



    }

	public function tarefa() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'DataInicio',
            'DataFim',
            'NomeProfissional',
			'Profissional',
			'Ordenamento',
            'Campo',
            'TarefaConcluida',
            'Prioridade',
			'Rotina',
			'ConcluidoProcedimento',
			'ObsTarefa',
			'Procedimento',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['TarefaConcluida'] = array(
            '#' => 'TODOS',
			'S' => 'Sim',
			'N' => 'N�o',
        );
/*
        $data['select']['Prioridade'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['Rotina'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );
*/
		$data['select']['ConcluidoProcedimento'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
           # 'C.NomeCliente' => 'Nome do Cliente',
			'TF.DataPrazoTarefa' => 'Prazo da Tarefa',
			'TF.DataTarefa' => 'Data do Tarefa',
			#'TF.ProfissionalTarefa' => 'Respons�vel',
			'TF.idApp_Tarefacons' => 'N�mero do Tarefas',
			'TF.ObsTarefa' => 'Tarefa',
			'TF.Rotina' => 'Rotina',
			'TF.Prioridade' => 'Prioridade',
			'TF.TarefaConcluida' => 'Tarefa Concl.?',
			'TF.DataConclusao' => 'Data da Concl.',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        #$data['select']['NomeProfissional'] = $this->Relatoriocliente_model->select_profissional3();
		#$data['select']['Profissional'] = $this->Relatoriocliente_model->select_profissional2();
		$data['select']['ObsTarefa'] = $this->Relatoriocliente_model->select_obstarefa();
		#$data['select']['Procedtarefa'] = $this->Relatoriocliente_model->select_procedtarefa();
		$data['select']['Procedimento'] = $this->Relatoriocliente_model->select_procedtarefa();

        $data['titulo'] = 'Funcion�rios & Tarefas';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
			$data['bd']['Profissional'] = $data['query']['Profissional'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['TarefaConcluida'] = $data['query']['TarefaConcluida'];
            $data['bd']['Prioridade'] = $data['query']['Prioridade'];
			$data['bd']['Rotina'] = $data['query']['Rotina'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
			$data['bd']['ObsTarefa'] = $data['query']['ObsTarefa'];
			$data['bd']['Procedimento'] = $data['query']['Procedimento'];


            $data['report'] = $this->Relatoriocliente_model->list_tarefa($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_tarefa', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_tarefa', $data);

        $this->load->view('basico/footer');



    }

    public function procedimento() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'ConcluidoProcedimento',
            'Ordenamento',
            'Campo',
			'NomeCliente',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['ConcluidoProcedimento'] = array(
            'N' => 'N�o',
            'S' => 'Sim',
			'#' => 'TODOS',
        );

		$data['select']['Campo'] = array(
			'C.DataProcedimento' => 'Data',
			'C.ConcluidoProcedimento' => 'Concl.',
            'C.idApp_Procedimento' => 'id',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        $data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();
		$data['select']['Dia'] = $this->Relatoriocliente_model->select_dia();
		$data['select']['Mesvenc'] = $this->Relatoriocliente_model->select_mes();
		
        $data['titulo'] = 'Anota��es';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
	
            $data['report'] = $this->Relatoriocliente_model->list_procedimento($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_procedimento', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_procedimento', $data);

        $this->load->view('basico/footer');

    }
	
	public function clienteprod() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Ordenamento',
            'Campo',
			'AprovadoOrca',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

		$data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
			'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'N�mero do Or�amento',
			'OT.AprovadoOrca' => 'Aprovado?',
			'PD.QtdVendaProduto' => 'Qtd. do Produto',
			'PD.idTab_Produto' => 'Produto',
			'PC.Procedimento' => 'Procedimento',
			'PC.ConcluidoProcedimento' => 'Proc. Concl.?',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['titulo'] = 'Relat�rio Clientes X Produtos X Procedimentos';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			#$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];

            $data['report'] = $this->Relatoriocliente_model->list_clienteprod($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_clienteprod', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_clienteprod', $data);

        $this->load->view('basico/footer');



    }

	public function orcamentosv() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
            'DataInicio',
            'DataFim',
            'Ordenamento',
            'Campo',
            'AprovadoOrca',
            #'QuitadoOrca',
			'ServicoConcluido',
			'ConcluidoProcedimento',

        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );
/*
        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );
*/
		$data['select']['ServicoConcluido'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );
		$data['select']['ConcluidoProcedimento'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'N�mero do Or�amento',
			'OT.DataOrca' => 'Data do Or�amento',
            'OT.DataPrazo' => 'Data Prazo',
			'OT.AprovadoOrca' => 'Or�amento Aprovado?',
			'OT.ValorOrca' => 'Valor do Or�amento',
            #'OT.QuitadoOrca' => 'Or�amento Quitado?',
			'OT.ServicoConcluido' => 'Servi�o Conclu�do?',
            'OT.DataConclusao' => 'Data de Conclus�o',
            #'OT.DataRetorno' => 'Renova��o',
			#'PD.QtdVendaProduto' => 'Qtd. do Produto',
			#'PD.idTab_Produto' => 'Produto',
			'SV.idTab_Servico' => 'Servico',
			'PC.DataProcedimento' => 'Data do Procedimento',
			'PC.Profissional' => 'Profissional',
			'PC.Procedimento' => 'Procedimento',
			'PC.ConcluidoProcedimento' => 'Proc. Concl.?',
			'PC.DataProcedimentoLimite' => 'Data Limite',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatoriocliente_model->select_clientes();

        $data['titulo'] = 'Relat�rio de Or�amentos X Procedimentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            #$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ServicoConcluido'] = $data['query']['ServicoConcluido'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];

			#$data['bd']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql');


            $data['report'] = $this->Relatoriocliente_model->list_orcamentosv($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatoriocliente/list_orcamentosv', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatoriocliente/tela_orcamentosv', $data);

        $this->load->view('basico/footer');



    }
	
}
