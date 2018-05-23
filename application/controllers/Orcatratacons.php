<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Orcatratacons extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Orcatratacons_model', 'Profissional_model', 'Consultor_model', 'Relatorio_model', 'Formapag_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerconsultor');
        $this->load->view('basico/nav_principalconsultor');

        #$this->load->view('orcatratacons/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('orcatratacons/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($idApp_Cliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
		$data['select']['Convenio'] = $this->Relatorio_model->select_convenio();

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Convenio',
        ), TRUE));

        $_SESSION['log']['Convenio'] = ($data['query']['Convenio']) ?
            $data['query']['Convenio'] : FALSE;
*/
		$data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrataCons ####
            'idApp_OrcaTrataCons',
            'idApp_Cliente',
            'DataOrca',
			'TipoReceita',
			'Receitas',
			'DataPrazo',
            'ProfissionalOrca',
            'AprovadoOrca',
            'ServicoConcluido',
            'QuitadoOrca',
            'DataConclusao',
            'DataRetorno',
			'DataQuitado',
            'ValorOrca',
			'ValorDev',
            'ValorEntradaOrca',
            'DataEntradaOrca',
            'ValorRestanteOrca',
            'FormaPagamento',
            'Modalidade',
            'QtdParcelasOrca',
            'DataVencimentoOrca',
            'ObsOrca',
			'TipoRD',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');

        //Data de hoje como default
        (!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['DataVencimentoOrca']) ? $data['orcatrata']['DataVencimentoOrca'] = date('d/m/Y', time()) : FALSE;
		#(!$data['orcatrata']['DataPrazo']) ? $data['orcatrata']['DataPrazo'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['TipoRD']) ? $data['orcatrata']['TipoRD'] = 'R' : FALSE;
		#(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = '1' : FALSE;
		(!$data['orcatrata']['TipoReceita']) ? $data['orcatrata']['TipoReceita'] = '1' : FALSE;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i) || $this->input->post('ValorVendaServico' . $i) ||
					$this->input->post('QtdVendaServico' . $i) || $this->input->post('SubtotalServico' . $i) ||
					$this->input->post('ObsServico' . $i) || $this->input->post('DataValidadeServico' . $i) || 
					$this->input->post('ConcluidoServico' . $i)) {
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
                $data['servico'][$j]['ValorVendaServico'] = $this->input->post('ValorVendaServico' . $i);
                $data['servico'][$j]['QtdVendaServico'] = $this->input->post('QtdVendaServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
                $data['servico'][$j]['DataValidadeServico'] = $this->input->post('DataValidadeServico' . $i);
				$data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {

            if ($this->input->post('idTab_Produto' . $i) || $this->input->post('ValorVendaProduto' . $i) ||
					$this->input->post('QtdVendaProduto' . $i) || $this->input->post('SubtotalProduto' . $i) ||
					$this->input->post('ObsProduto' . $i) || $this->input->post('DataValidadeProduto' . $i)) {
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
                $data['produto'][$j]['ValorVendaProduto'] = $this->input->post('ValorVendaProduto' . $i);
                $data['produto'][$j]['QtdVendaProduto'] = $this->input->post('QtdVendaProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
				$data['produto'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeProduto' . $i);
                $j++;
            }
        }
        $data['count']['PCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('DataProcedimento' . $i) ||
                    $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
                $data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
                #$data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
                $data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
				$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);

                $j++;
            }

        }
        $data['count']['PMCount'] = $j - 1;

        if ($data['orcatrata']['QtdParcelasOrca'] > 0) {

            for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

                $data['parcelasrec'][$i]['ParcelaRecebiveis'] = $this->input->post('ParcelaRecebiveis' . $i);
                $data['parcelasrec'][$i]['ValorParcelaRecebiveis'] = $this->input->post('ValorParcelaRecebiveis' . $i);
                $data['parcelasrec'][$i]['DataVencimentoRecebiveis'] = $this->input->post('DataVencimentoRecebiveis' . $i);
                $data['parcelasrec'][$i]['ValorPagoRecebiveis'] = $this->input->post('ValorPagoRecebiveis' . $i);
                $data['parcelasrec'][$i]['DataPagoRecebiveis'] = $this->input->post('DataPagoRecebiveis' . $i);
                $data['parcelasrec'][$i]['QuitadoRecebiveis'] = $this->input->post('QuitadoRecebiveis' . $i);

            }

        }

        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrataCons ####
        $this->form_validation->set_rules('DataOrca', 'Data do Orçamento', 'required|trim|valid_date');
        #$this->form_validation->set_rules('DataProcedimento', 'DataProcedimento', 'required|trim');
        #$this->form_validation->set_rules('ParcelaRecebiveis', 'ParcelaRecebiveis', 'required|trim');
        #$this->form_validation->set_rules('ProfissionalOrca', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('Modalidade', 'Tipo de Recebimento', 'required|trim');
		$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
		$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1ºVenc.', 'required|trim|valid_date');

        $data['select']['TipoReceita'] = $this->Basico_model->select_tiporeceita();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
        $data['select']['ServicoConcluido'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
		$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['QuitadoRecebiveis'] = $this->Basico_model->select_status_sn();
        $data['select']['Profissional'] = $this->Profissional_model->select_profissional1();
		$data['select']['idApp_Consultor'] = $this->Consultor_model->select_consultor();
        #$data['select']['Servico'] = $this->Basico_model->select_servico();
        #$data['select']['Produto'] = $this->Basico_model->select_produto();
        $data['select']['Servico'] = $this->Basico_model->select_produtos();
        $data['select']['Produto'] = $this->Basico_model->select_produtos();

        $data['titulo'] = 'Cadastar Orçamento';
        $data['form_open_path'] = 'orcatratacons/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorDev'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['orcatrata']['FormaPagamento'] || $data['orcatrata']['QtdParcelasOrca'] || $data['orcatrata']['DataVencimentoOrca'])
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';

        //if ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional'])
        if (isset($data['procedimento']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo
        (!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
		
		(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'S' : FALSE;

        $data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Orçamento Aprovado', 'NS'),
        );

        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            //if (1 == 1) {
            $this->load->view('orcatratacons/form_orcatratacons', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrataCons ####
            $data['orcatrata']['TipoReceita'] = $data['orcatrata']['TipoReceita'];
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
            $data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
			$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
            $data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
			$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
            $data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
            $data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
			$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
            $data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
			$data['orcatrata']['TipoRD'] = $data['orcatrata']['TipoRD'];
			$data['orcatrata']['Empresa'] = $_SESSION['log']['Empresa'];
            $data['orcatrata']['idApp_Consultor'] = $_SESSION['log']['id'];
            $data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['orcatrata']['idApp_OrcaTrataCons'] = $this->Orcatratacons_model->set_orcatrata($data['orcatrata']);

            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### App_ServicoVendaCons ####
            if (isset($data['servico'])) {
                $max = count($data['servico']);
                for($j=1;$j<=$max;$j++) {
                    $data['servico'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
					$data['servico'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
                    $data['servico'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['servico'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];
					$data['servico'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeServico'], 'mysql');
                    $data['servico'][$j]['ValorVendaServico'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorVendaServico']));
                    unset($data['servico'][$j]['SubtotalServico']);
                }
                $data['servico']['idApp_ServicoVendaCons'] = $this->Orcatratacons_model->set_servico_venda($data['servico']);
            }

            #### App_ProdutoVendaCons ####
            if (isset($data['produto'])) {
                $max = count($data['produto']);
                for($j=1;$j<=$max;$j++) {
                    $data['produto'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
					$data['produto'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
                    $data['produto'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['produto'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];
					$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'mysql');
                    $data['produto'][$j]['ValorVendaProduto'] = str_replace(',', '.', str_replace('.', '', $data['produto'][$j]['ValorVendaProduto']));
                    unset($data['produto'][$j]['SubtotalProduto']);
                }
                $data['produto']['idApp_ProdutoVendaCons'] = $this->Orcatratacons_model->set_produto_venda($data['produto']);
            }

            #### App_ParcelasRec ####
            if (isset($data['parcelasrec'])) {
                $max = count($data['parcelasrec']);
                for($j=1;$j<=$max;$j++) {
                    $data['parcelasrec'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
                    $data['parcelasrec'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
					$data['parcelasrec'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['parcelasrec'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];

                    $data['parcelasrec'][$j]['ValorParcelaRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorParcelaRecebiveis']));
                    $data['parcelasrec'][$j]['DataVencimentoRecebiveis'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimentoRecebiveis'], 'mysql');
                    $data['parcelasrec'][$j]['ValorPagoRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorPagoRecebiveis']));
                    $data['parcelasrec'][$j]['DataPagoRecebiveis'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPagoRecebiveis'], 'mysql');

                }
                $data['parcelasrec']['idApp_ParcelasRecebiveisCons'] = $this->Orcatratacons_model->set_parcelasrec($data['parcelasrec']);
            }

            #### App_ProcedimentoCons ####
            if (isset($data['procedimento'])) {
                $max = count($data['procedimento']);
                for($j=1;$j<=$max;$j++) {
                    $data['procedimento'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
                    $data['procedimento'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
					$data['procedimento'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['procedimento'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];
					$data['procedimento'][$j]['Profissional'] = $_SESSION['log']['id'];
                    $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'mysql');


                }
                $data['procedimento']['idApp_ProcedimentoCons'] = $this->Orcatratacons_model->set_procedimento($data['procedimento']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idApp_OrcaTrataCons'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatratacons/form_orcatratacons', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrataCons'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoriaconsultor($data['auditoriaitem'], 'App_OrcaTrataCons', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'orcatratacons/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function cadastrar2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*		
		$data['select']['Convenio'] = $this->Relatorio_model->select_convenio();

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Convenio',
        ), TRUE));

        $_SESSION['log']['Convenio'] = ($data['query']['Convenio']) ?
            $data['query']['Convenio'] : FALSE;        
*/		
		$data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrataCons ####
            'idApp_OrcaTrataCons',
            'idApp_Cliente',
            'DataOrca',
			'DataPrazo',
			'TipoReceita',
			'Receitas',
            'ProfissionalOrca',
            'AprovadoOrca',
            'ServicoConcluido',
            #'QuitadoOrca',
            'DataConclusao',
            'DataRetorno',
			'DataQuitado',
            'ValorOrca',
			'ValorDev',
            'ValorEntradaOrca',
            'DataEntradaOrca',
            'ValorRestanteOrca',
            'FormaPagamento',
			'Modalidade',
            'QtdParcelasOrca',
            'DataVencimentoOrca',
            'ObsOrca',
			'TipoRD',
			#'OrigemOrca',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');

        //Data de hoje como default
        (!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['DataVencimentoOrca']) ? $data['orcatrata']['DataVencimentoOrca'] = date('d/m/Y', time()) : FALSE;
		#(!$data['orcatrata']['DataPrazo']) ? $data['orcatrata']['DataPrazo'] = date('d/m/Y', time()) : FALSE;
        (!$data['orcatrata']['TipoRD']) ? $data['orcatrata']['TipoRD'] = 'R' : FALSE;
		#(!$data['orcatrata']['OrigemOrca']) ? $data['orcatrata']['OrigemOrca'] = 'U/C' : FALSE;
		#(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = '1' : FALSE;
		(!$data['orcatrata']['idApp_Cliente']) ? $data['orcatrata']['idApp_Cliente'] = '1' : FALSE;
		
		$j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
                $data['servico'][$j]['ValorVendaServico'] = $this->input->post('ValorVendaServico' . $i);
                $data['servico'][$j]['QtdVendaServico'] = $this->input->post('QtdVendaServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
                $data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {

            if ($this->input->post('idTab_Produto' . $i) || $this->input->post('ValorVendaProduto' . $i) ||
					$this->input->post('QtdVendaProduto' . $i) || $this->input->post('SubtotalProduto' . $i) ||
					$this->input->post('ObsProduto' . $i) || $this->input->post('DataValidadeProduto' . $i)) {
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
                $data['produto'][$j]['ValorVendaProduto'] = $this->input->post('ValorVendaProduto' . $i);
                $data['produto'][$j]['QtdVendaProduto'] = $this->input->post('QtdVendaProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
				$data['produto'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeProduto' . $i);
                $j++;
            }
        }
        $data['count']['PCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('DataProcedimento' . $i) || $this->input->post('Profissional' . $i) ||
                    $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
                $data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
                $data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
                $data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
				$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);
				
                $j++;
            }

        }
        $data['count']['PMCount'] = $j - 1;

        if ($data['orcatrata']['QtdParcelasOrca'] > 0) {

            for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

                $data['parcelasrec'][$i]['ParcelaRecebiveis'] = $this->input->post('ParcelaRecebiveis' . $i);
                $data['parcelasrec'][$i]['ValorParcelaRecebiveis'] = $this->input->post('ValorParcelaRecebiveis' . $i);
                $data['parcelasrec'][$i]['DataVencimentoRecebiveis'] = $this->input->post('DataVencimentoRecebiveis' . $i);
                $data['parcelasrec'][$i]['ValorPagoRecebiveis'] = $this->input->post('ValorPagoRecebiveis' . $i);
                $data['parcelasrec'][$i]['DataPagoRecebiveis'] = $this->input->post('DataPagoRecebiveis' . $i);
                $data['parcelasrec'][$i]['QuitadoRecebiveis'] = $this->input->post('QuitadoRecebiveis' . $i);

            }

        }

        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrataCons ####
        $this->form_validation->set_rules('DataOrca', 'Data do Orçamento', 'required|trim|valid_date');
        #$this->form_validation->set_rules('DataProcedimento', 'DataProcedimento', 'required|trim');
        #$this->form_validation->set_rules('ParcelaRecebiveis', 'ParcelaRecebiveis', 'required|trim');
        #$this->form_validation->set_rules('ProfissionalOrca', 'Profissional', 'required|trim');
		#$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
		$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
		$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1ºVenc.', 'required|trim|valid_date');

        $data['select']['TipoReceita'] = $this->Basico_model->select_tiporeceita();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
        $data['select']['ServicoConcluido'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
		$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['QuitadoRecebiveis'] = $this->Basico_model->select_status_sn();
        $data['select']['Profissional'] = $this->Profissional_model->select_profissional();
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		#$data['select']['idApp_Cliente'] = $this->Consultor_model->select_cliente();
        #$data['select']['Servico'] = $this->Basico_model->select_servico();
        #$data['select']['Produto'] = $this->Basico_model->select_produto();
        #$data['select']['Servico'] = $this->Basico_model->select_servicos();
        $data['select']['Produto'] = $this->Basico_model->select_produtos();		

        $data['titulo'] = 'Cadastar Orçamento';
        $data['form_open_path'] = 'orcatratacons/cadastrar2';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorDev'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['orcatrata']['FormaPagamento'] || $data['orcatrata']['QtdParcelasOrca'] || $data['orcatrata']['DataVencimentoOrca'])
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';

        //if ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional'])
        if (isset($data['procedimento']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo
        (!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
		
		(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'S' : FALSE;

        $data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Orçamento Aprovado', 'NS'),
        );

        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            //if (1 == 1) {
            $this->load->view('orcatratacons/form_orcatratacons2', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrataCons ####
            $data['orcatrata']['TipoReceita'] = $data['orcatrata']['TipoReceita'];
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');            
			$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
			$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
            $data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
			$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
            $data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
            $data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
			$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
            $data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
			$data['orcatrata']['TipoRD'] = $data['orcatrata']['TipoRD'];
			#$data['orcatrata']['OrigemOrca'] = $data['orcatrata']['OrigemOrca'];
			$data['orcatrata']['Empresa'] = $_SESSION['log']['Empresa']; 
            $data['orcatrata']['idApp_Consultor'] = $_SESSION['log']['id'];
            $data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['orcatrata']['idApp_OrcaTrataCons'] = $this->Orcatratacons_model->set_orcatrata($data['orcatrata']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### App_ServicoVendaCons ####
            if (isset($data['servico'])) {
                $max = count($data['servico']);
                for($j=1;$j<=$max;$j++) {
                    $data['servico'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
                    $data['servico'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
					#$data['servico'][$j]['OrigemOrca'] = 'U/C';
					$data['servico'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['servico'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];

                    $data['servico'][$j]['ValorVendaServico'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorVendaServico']));
                    unset($data['servico'][$j]['SubtotalServico']);
                }
                $data['servico']['idApp_ServicoVendaCons'] = $this->Orcatratacons_model->set_servico_venda($data['servico']);
            }

            #### App_ProdutoVendaCons ####
            if (isset($data['produto'])) {
                $max = count($data['produto']);
                for($j=1;$j<=$max;$j++) {
                    $data['produto'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
					$data['produto'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
                    #$data['produto'][$j]['OrigemOrca'] = 'U/C';
					$data['produto'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['produto'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];
					$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'mysql');
                    $data['produto'][$j]['ValorVendaProduto'] = str_replace(',', '.', str_replace('.', '', $data['produto'][$j]['ValorVendaProduto']));
                    unset($data['produto'][$j]['SubtotalProduto']);
                }
                $data['produto']['idApp_ProdutoVendaCons'] = $this->Orcatratacons_model->set_produto_venda($data['produto']);
            }

            #### App_ParcelasRec ####
            if (isset($data['parcelasrec'])) {
                $max = count($data['parcelasrec']);
                for($j=1;$j<=$max;$j++) {
                    $data['parcelasrec'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
                    $data['parcelasrec'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
					#$data['parcelasrec'][$j]['OrigemOrca'] = 'U/C';
					$data['parcelasrec'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['parcelasrec'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];

                    $data['parcelasrec'][$j]['ValorParcelaRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorParcelaRecebiveis']));
                    $data['parcelasrec'][$j]['DataVencimentoRecebiveis'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimentoRecebiveis'], 'mysql');
                    $data['parcelasrec'][$j]['ValorPagoRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorPagoRecebiveis']));
                    $data['parcelasrec'][$j]['DataPagoRecebiveis'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPagoRecebiveis'], 'mysql');

                }
                $data['parcelasrec']['idApp_ParcelasRecebiveisCons'] = $this->Orcatratacons_model->set_parcelasrec($data['parcelasrec']);
            }

            #### App_ProcedimentoCons ####
            if (isset($data['procedimento'])) {
                $max = count($data['procedimento']);
                for($j=1;$j<=$max;$j++) {
                    $data['procedimento'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
                    $data['procedimento'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
					#$data['procedimento'][$j]['OrigemOrca'] = 'U/C';
					$data['procedimento'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['procedimento'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];

                    $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'mysql');
					

                }
                $data['procedimento']['idApp_ProcedimentoCons'] = $this->Orcatratacons_model->set_procedimento($data['procedimento']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idApp_OrcaTrataCons'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatratacons/form_orcatratacons2', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrataCons'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrataCons', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'orcatrata2/listar/' . $data['msg']);
				redirect(base_url() . 'relatorioconsultor/orcamento/' . $data['msg']);
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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrataCons ####
            'idApp_OrcaTrataCons',
            #Não há a necessidade de atualizar o valor do campo a seguir
            #'idApp_Cliente',
            'DataOrca',
			'TipoReceita',
			'Receitas',
			'DataPrazo',
            'ProfissionalOrca',
            'AprovadoOrca',
            'ServicoConcluido',
            'QuitadoOrca',
            'DataConclusao',
            'DataRetorno',
			'DataQuitado',
            'ValorOrca',
			'ValorDev',
            'ValorEntradaOrca',
            'DataEntradaOrca',
            'ValorRestanteOrca',
            'FormaPagamento',
            'QtdParcelasOrca',
            'DataVencimentoOrca',
            'ObsOrca',
			#'TipoRD',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
		#(!$data['orcatrata']['TipoRD']) ? $data['orcatrata']['TipoRD'] = 'R' : FALSE;
		#(!$data['orcatrata']['TipoReceita']) ? $data['orcatrata']['TipoReceita'] = '1' : FALSE;

        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i) || $this->input->post('ValorVendaServico' . $i) ||
					$this->input->post('QtdVendaServico' . $i) || $this->input->post('SubtotalServico' . $i) ||
					$this->input->post('ObsServico' . $i) || $this->input->post('DataValidadeServico' . $i) || 
					$this->input->post('ConcluidoServico' . $i)) {
                $data['servico'][$j]['idApp_ServicoVendaCons'] = $this->input->post('idApp_ServicoVendaCons' . $i);
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
                $data['servico'][$j]['ValorVendaServico'] = $this->input->post('ValorVendaServico' . $i);
                $data['servico'][$j]['QtdVendaServico'] = $this->input->post('QtdVendaServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
				$data['servico'][$j]['DataValidadeServico'] = $this->input->post('DataValidadeServico' . $i);
                $data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {

            if ($this->input->post('idTab_Produto' . $i) || $this->input->post('ValorVendaProduto' . $i) ||
					$this->input->post('QtdVendaProduto' . $i) || $this->input->post('SubtotalProduto' . $i) ||
					$this->input->post('ObsProduto' . $i) || $this->input->post('DataValidadeProduto' . $i)) {
                $data['produto'][$j]['idApp_ProdutoVendaCons'] = $this->input->post('idApp_ProdutoVendaCons' . $i);
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
                $data['produto'][$j]['ValorVendaProduto'] = $this->input->post('ValorVendaProduto' . $i);
                $data['produto'][$j]['QtdVendaProduto'] = $this->input->post('QtdVendaProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
				$data['produto'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeProduto' . $i);
                $j++;
            }
        }
        $data['count']['PCount'] = $j - 1;

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

        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('ParcelaRecebiveis' . $i) || $this->input->post('ValorParcelaRecebiveis' . $i) || 
					$this->input->post('DataVencimentoRecebiveis' . $i) || $this->input->post('ValorPagoRecebiveis' . $i) || 
					$this->input->post('DataPagoRecebiveis' . $i) || $this->input->post('QuitadoRecebiveis' . $i)) {
                $data['parcelasrec'][$j]['idApp_ParcelasRecebiveisCons'] = $this->input->post('idApp_ParcelasRecebiveisCons' . $i);
                $data['parcelasrec'][$j]['ParcelaRecebiveis'] = $this->input->post('ParcelaRecebiveis' . $i);
                $data['parcelasrec'][$j]['ValorParcelaRecebiveis'] = $this->input->post('ValorParcelaRecebiveis' . $i);
                $data['parcelasrec'][$j]['DataVencimentoRecebiveis'] = $this->input->post('DataVencimentoRecebiveis' . $i);
                $data['parcelasrec'][$j]['ValorPagoRecebiveis'] = $this->input->post('ValorPagoRecebiveis' . $i);
                $data['parcelasrec'][$j]['DataPagoRecebiveis'] = $this->input->post('DataPagoRecebiveis' . $i);
                $data['parcelasrec'][$j]['QuitadoRecebiveis'] = $this->input->post('QuitadoRecebiveis' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### App_OrcaTrataCons ####
            $data['orcatrata'] = $this->Orcatratacons_model->get_orcatrata($id);
            $data['orcatrata']['TipoReceita'] = $data['orcatrata']['TipoReceita'];
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
            $data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'barras');
			$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'barras');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'barras');
            $data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'barras');
			$data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'barras');
            $data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'barras');

            #### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### App_ServicoVendaCons ####
            $data['servico'] = $this->Orcatratacons_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);

                if (isset($data['servico'])) {

                    for($j=1;$j<=$data['count']['SCount'];$j++) {
                        $data['servico'][$j]['SubtotalServico'] = number_format(($data['servico'][$j]['ValorVendaServico'] * $data['servico'][$j]['QtdVendaServico']), 2, ',', '.');
						$data['servico'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeServico'], 'barras');
					}
                }
            }

            #### App_ProdutoVendaCons ####
            $data['produto'] = $this->Orcatratacons_model->get_produto($id);

            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorVendaProduto'] * $data['produto'][$j]['QtdVendaProduto']), 2, ',', '.');
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
					}

                }
            }

            #### App_ParcelasRecebiveisCons ####
            $data['parcelasrec'] = $this->Orcatratacons_model->get_parcelasrec($id);
            if (count($data['parcelasrec']) > 0) {
                $data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));
				$data['count']['PRCount'] = count($data['parcelasrec']);
				
                if (isset($data['parcelasrec'])) {

                    for($j=1; $j <= $data['count']['PRCount']; $j++) {
                        $data['parcelasrec'][$j]['DataVencimentoRecebiveis'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimentoRecebiveis'], 'barras');
                        $data['parcelasrec'][$j]['DataPagoRecebiveis'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPagoRecebiveis'], 'barras');
                    }

                }
            }

            #### App_ProcedimentoCons ####
            $data['procedimento'] = $this->Orcatratacons_model->get_procedimento($id);
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

        #### App_OrcaTrataCons ####
        $this->form_validation->set_rules('DataOrca', 'Data do Orçamento', 'required|trim|valid_date');
		#$this->form_validation->set_rules('DataProcedimento', 'DataProcedimento', 'required|trim');
        #$this->form_validation->set_rules('ParcelaRecebiveis', 'ParcelaRecebiveis', 'required|trim');
        #$this->form_validation->set_rules('ProfissionalOrca', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
		$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1ºVenc.', 'required|trim|valid_date');

        $data['select']['TipoReceita'] = $this->Basico_model->select_tiporeceita();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
        $data['select']['ServicoConcluido'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
		$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['QuitadoRecebiveis'] = $this->Basico_model->select_status_sn();
        $data['select']['Profissional'] = $this->Profissional_model->select_profissional1();
        $data['select']['idApp_Consultor'] = $this->Consultor_model->select_consultor();
		#$data['select']['Servico'] = $this->Basico_model->select_servico();
        #$data['select']['Produto'] = $this->Basico_model->select_produto();
        $data['select']['Servico'] = $this->Basico_model->select_produtos();
        $data['select']['Produto'] = $this->Basico_model->select_produtos();

        $data['titulo'] = 'Editar Orçamento';
        $data['form_open_path'] = 'orcatratacons/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
        if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['orcatrata']['FormaPagamento'] || $data['orcatrata']['QtdParcelasOrca'] || $data['orcatrata']['DataVencimentoOrca'])
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';

        //if (isset($data['procedimento']) && ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional']))
        if ($data['count']['PMCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo
        (!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'S' : FALSE;

        $data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Orçamento Aprovado', 'NS'),
        );

        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatratacons/form_orcatrataconsalterar', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrataCons ####
            $data['orcatrata']['TipoReceita'] = $data['orcatrata']['TipoReceita'];
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
            $data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
			$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
            $data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
			$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
            $data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
            $data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
			$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
            $data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
			#$data['orcatrata']['TipoRD'] = $data['orcatrata']['TipoRD'];
			#$data['orcatrata']['Empresa'] = $_SESSION['log']['Empresa'];
            #$data['orcatrata']['idApp_Consultor'] = $_SESSION['log']['id'];
            #$data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['orcatrata']['anterior'] = $this->Orcatratacons_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrataCons']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idApp_OrcaTrataCons'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatratacons_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrataCons']);

            #### App_ServicoVendaCons ####
            $data['update']['servico']['anterior'] = $this->Orcatratacons_model->get_servico($data['orcatrata']['idApp_OrcaTrataCons']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idApp_ServicoVendaCons');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {

                    $data['update']['servico']['inserir'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
					$data['update']['servico']['inserir'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
                    $data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['servico']['inserir'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];
					$data['update']['servico']['inserir'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataValidadeServico'], 'mysql');
                    $data['update']['servico']['inserir'][$j]['ValorVendaServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorVendaServico']));
                    unset($data['update']['servico']['inserir'][$j]['SubtotalServico']);
                }

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['servico']['alterar'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataValidadeServico'], 'mysql');
					$data['update']['servico']['alterar'][$j]['ValorVendaServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorVendaServico']));
                    unset($data['update']['servico']['alterar'][$j]['SubtotalServico']);
                }

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Orcatratacons_model->set_servico_venda($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] = $this->Orcatratacons_model->update_servico_venda($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Orcatratacons_model->delete_servico_venda($data['update']['servico']['excluir']);
            }

            #### App_ProdutoVendaCons ####
            $data['update']['produto']['anterior'] = $this->Orcatratacons_model->get_produto($data['orcatrata']['idApp_OrcaTrataCons']);
            if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

                if (isset($data['produto']))
                    $data['produto'] = array_values($data['produto']);
                else
                    $data['produto'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_ProdutoVendaCons');

                $max = count($data['update']['produto']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['inserir'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
					$data['update']['produto']['inserir'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
                    $data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['produto']['inserir'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];
					$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataValidadeProduto'], 'mysql');
                    $data['update']['produto']['inserir'][$j]['ValorVendaProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorVendaProduto']));
                    unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
                }

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['alterar'][$j]['ValorVendaProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorVendaProduto']));
                    unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
                }

                if (count($data['update']['produto']['inserir']))
                    $data['update']['produto']['bd']['inserir'] = $this->Orcatratacons_model->set_produto_venda($data['update']['produto']['inserir']);

                if (count($data['update']['produto']['alterar']))
                    $data['update']['produto']['bd']['alterar'] =  $this->Orcatratacons_model->update_produto_venda($data['update']['produto']['alterar']);

                if (count($data['update']['produto']['excluir']))
                    $data['update']['produto']['bd']['excluir'] = $this->Orcatratacons_model->delete_produto_venda($data['update']['produto']['excluir']);

            }

            #### App_ParcelasRec ####
            $data['update']['parcelasrec']['anterior'] = $this->Orcatratacons_model->get_parcelasrec($data['orcatrata']['idApp_OrcaTrataCons']);
            if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['parcelasrec'] = array_values($data['parcelasrec']);
                else
                    $data['parcelasrec'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_ParcelasRecebiveisCons');

                $max = count($data['update']['parcelasrec']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
					$data['update']['parcelasrec']['inserir'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
                    $data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];

                    $data['update']['parcelasrec']['inserir'][$j]['ValorParcelaRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcelaRecebiveis']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataVencimentoRecebiveis'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimentoRecebiveis'], 'mysql');
                    $data['update']['parcelasrec']['inserir'][$j]['ValorPagoRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPagoRecebiveis']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataPagoRecebiveis'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPagoRecebiveis'], 'mysql');

                }

                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['alterar'][$j]['ValorParcelaRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcelaRecebiveis']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataVencimentoRecebiveis'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimentoRecebiveis'], 'mysql');
                    $data['update']['parcelasrec']['alterar'][$j]['ValorPagoRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPagoRecebiveis']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataPagoRecebiveis'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPagoRecebiveis'], 'mysql');
                }

                if (count($data['update']['parcelasrec']['inserir']))
                    $data['update']['parcelasrec']['bd']['inserir'] = $this->Orcatratacons_model->set_parcelasrec($data['update']['parcelasrec']['inserir']);

                if (count($data['update']['parcelasrec']['alterar']))
                    $data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatratacons_model->update_parcelasrec($data['update']['parcelasrec']['alterar']);

                if (count($data['update']['parcelasrec']['excluir']))
                    $data['update']['parcelasrec']['bd']['excluir'] = $this->Orcatratacons_model->delete_parcelasrec($data['update']['parcelasrec']['excluir']);

            }
			
            #### App_ProcedimentoCons ####
            $data['update']['procedimento']['anterior'] = $this->Orcatratacons_model->get_procedimento($data['orcatrata']['idApp_OrcaTrataCons']);
            if (isset($data['procedimento']) || (!isset($data['procedimento']) && isset($data['update']['procedimento']['anterior']) ) ) {

                if (isset($data['servico']))
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
                    $data['update']['procedimento']['inserir'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];

                    $data['update']['procedimento']['inserir'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimento'], 'mysql');

                }

                $max = count($data['update']['procedimento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['alterar'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimento'], 'mysql');

                }

                if (count($data['update']['procedimento']['inserir']))
                    $data['update']['procedimento']['bd']['inserir'] = $this->Orcatratacons_model->set_procedimento($data['update']['procedimento']['inserir']);

                if (count($data['update']['procedimento']['alterar']))
                    $data['update']['procedimento']['bd']['alterar'] =  $this->Orcatratacons_model->update_procedimento($data['update']['procedimento']['alterar']);

                if (count($data['update']['procedimento']['excluir']))
                    $data['update']['procedimento']['bd']['excluir'] = $this->Orcatratacons_model->delete_procedimento($data['update']['procedimento']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_OrcaTrataCons'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatratacons/form_orcatrataconsalterar', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrataCons'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrataCons', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'orcatratacons/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function alterar2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrataCons ####
            'idApp_OrcaTrataCons',
            #Não há a necessidade de atualizar o valor do campo a seguir
            'idApp_Cliente',
            'DataOrca',
			'TipoReceita',
			'DataPrazo',
			'Receitas',
            'ProfissionalOrca',
            'AprovadoOrca',
            'ServicoConcluido',
            'QuitadoOrca',
            'DataConclusao',
            'DataRetorno',
			'DataQuitado',
            'ValorOrca',
			'ValorDev',
            'ValorEntradaOrca',
            'DataEntradaOrca',
            'ValorRestanteOrca',
            'FormaPagamento',
            'QtdParcelasOrca',
            'DataVencimentoOrca',
            'ObsOrca',
			#'TipoRD',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
		#(!$data['orcatrata']['TipoRD']) ? $data['orcatrata']['TipoRD'] = 'R' : FALSE;
		(!$data['orcatrata']['idApp_Cliente']) ? $data['orcatrata']['idApp_Cliente'] = '1' : FALSE;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i) || $this->input->post('ValorVendaServico' . $i) ||
					$this->input->post('QtdVendaServico' . $i) || $this->input->post('SubtotalServico' . $i) ||
					$this->input->post('ObsServico' . $i) || $this->input->post('DataValidadeServico' . $i) || 
					$this->input->post('ConcluidoServico' . $i)) {
                $data['servico'][$j]['idApp_ServicoVendaCons'] = $this->input->post('idApp_ServicoVendaCons' . $i);
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
                $data['servico'][$j]['ValorVendaServico'] = $this->input->post('ValorVendaServico' . $i);
                $data['servico'][$j]['QtdVendaServico'] = $this->input->post('QtdVendaServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
				$data['servico'][$j]['DataValidadeServico'] = $this->input->post('DataValidadeServico' . $i);
                $data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {

            if ($this->input->post('idTab_Produto' . $i) || $this->input->post('ValorVendaProduto' . $i) ||
					$this->input->post('QtdVendaProduto' . $i) || $this->input->post('SubtotalProduto' . $i) ||
					$this->input->post('ObsProduto' . $i) || $this->input->post('DataValidadeProduto' . $i)) {
                $data['produto'][$j]['idApp_ProdutoVendaCons'] = $this->input->post('idApp_ProdutoVendaCons' . $i);
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
                $data['produto'][$j]['ValorVendaProduto'] = $this->input->post('ValorVendaProduto' . $i);
                $data['produto'][$j]['QtdVendaProduto'] = $this->input->post('QtdVendaProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
				$data['produto'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeProduto' . $i);
                $j++;
            }
        }
        $data['count']['PCount'] = $j - 1;

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

        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('ParcelaRecebiveis' . $i) || $this->input->post('ValorParcelaRecebiveis' . $i) || 
					$this->input->post('DataVencimentoRecebiveis' . $i) || $this->input->post('ValorPagoRecebiveis' . $i) || 
					$this->input->post('DataPagoRecebiveis' . $i) || $this->input->post('QuitadoRecebiveis' . $i)) {
                $data['parcelasrec'][$j]['idApp_ParcelasRecebiveisCons'] = $this->input->post('idApp_ParcelasRecebiveisCons' . $i);
                $data['parcelasrec'][$j]['ParcelaRecebiveis'] = $this->input->post('ParcelaRecebiveis' . $i);
                $data['parcelasrec'][$j]['ValorParcelaRecebiveis'] = $this->input->post('ValorParcelaRecebiveis' . $i);
                $data['parcelasrec'][$j]['DataVencimentoRecebiveis'] = $this->input->post('DataVencimentoRecebiveis' . $i);
                $data['parcelasrec'][$j]['ValorPagoRecebiveis'] = $this->input->post('ValorPagoRecebiveis' . $i);
                $data['parcelasrec'][$j]['DataPagoRecebiveis'] = $this->input->post('DataPagoRecebiveis' . $i);
                $data['parcelasrec'][$j]['QuitadoRecebiveis'] = $this->input->post('QuitadoRecebiveis' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### App_OrcaTrataCons ####
            $data['orcatrata'] = $this->Orcatratacons_model->get_orcatrata($id);
            $data['orcatrata']['TipoReceita'] = $data['orcatrata']['TipoReceita'];
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
            $data['orcatrata']['Receitas'] = $data['orcatrata']['Receitas'];
			$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'barras');
			$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'barras');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'barras');
            $data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'barras');
			$data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'barras');
            $data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'barras');

            #### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### App_ServicoVendaCons ####
            $data['servico'] = $this->Orcatratacons_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);

                if (isset($data['servico'])) {

                    for($j=1;$j<=$data['count']['SCount'];$j++) {
                        $data['servico'][$j]['SubtotalServico'] = number_format(($data['servico'][$j]['ValorVendaServico'] * $data['servico'][$j]['QtdVendaServico']), 2, ',', '.');
						$data['servico'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeServico'], 'barras');
					}
                }
            }

            #### App_ProdutoVendaCons ####
            $data['produto'] = $this->Orcatratacons_model->get_produto($id);

            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorVendaProduto'] * $data['produto'][$j]['QtdVendaProduto']), 2, ',', '.');
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
					}

                }
            }

            #### App_ParcelasRecebiveisCons ####
            $data['parcelasrec'] = $this->Orcatratacons_model->get_parcelasrec($id);
            if (count($data['parcelasrec']) > 0) {
                $data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));
				$data['count']['PRCount'] = count($data['parcelasrec']);
				
                if (isset($data['parcelasrec'])) {

                    for($j=1; $j <= $data['count']['PRCount']; $j++) {
                        $data['parcelasrec'][$j]['DataVencimentoRecebiveis'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimentoRecebiveis'], 'barras');
                        $data['parcelasrec'][$j]['DataPagoRecebiveis'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPagoRecebiveis'], 'barras');
                    }

                }
            }

            #### App_ProcedimentoCons ####
            $data['procedimento'] = $this->Orcatratacons_model->get_procedimento($id);
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

        #### App_OrcaTrataCons ####
        $this->form_validation->set_rules('DataOrca', 'Data do Orçamento', 'required|trim|valid_date');
		#$this->form_validation->set_rules('DataProcedimento', 'DataProcedimento', 'required|trim');
        #$this->form_validation->set_rules('ParcelaRecebiveis', 'ParcelaRecebiveis', 'required|trim');
        #$this->form_validation->set_rules('ProfissionalOrca', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
		$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1ºVenc.', 'required|trim|valid_date');

        $data['select']['TipoReceita'] = $this->Basico_model->select_tiporeceita();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
        $data['select']['ServicoConcluido'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
		$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['QuitadoRecebiveis'] = $this->Basico_model->select_status_sn();
        $data['select']['Profissional'] = $this->Profissional_model->select_profissional1();
        $data['select']['idApp_Consultor'] = $this->Consultor_model->select_consultor();
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		#$data['select']['Servico'] = $this->Basico_model->select_servico();
        #$data['select']['Produto'] = $this->Basico_model->select_produto();
        $data['select']['Servico'] = $this->Basico_model->select_produtos();
        $data['select']['Produto'] = $this->Basico_model->select_produtos();

        $data['titulo'] = 'Editar Orçamento';
        $data['form_open_path'] = 'orcatratacons/alterar2';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
        if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['orcatrata']['FormaPagamento'] || $data['orcatrata']['QtdParcelasOrca'] || $data['orcatrata']['DataVencimentoOrca'])
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';

        //if (isset($data['procedimento']) && ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional']))
        if ($data['count']['PMCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo
        (!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'S' : FALSE;

        $data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Orçamento Aprovado', 'NS'),
        );

        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatratacons/form_orcatrataconsalterar2', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrataCons ####
            $data['orcatrata']['TipoReceita'] = $data['orcatrata']['TipoReceita'];
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
            $data['orcatrata']['Receitas'] = $data['orcatrata']['Receitas'];
			$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
			$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
            $data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
			$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
            $data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
            $data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
			$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
            $data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
			#$data['orcatrata']['TipoRD'] = $data['orcatrata']['TipoRD'];
			#$data['orcatrata']['Empresa'] = $_SESSION['log']['Empresa'];
            #$data['orcatrata']['idApp_Consultor'] = $_SESSION['log']['id'];
            #$data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['orcatrata']['anterior'] = $this->Orcatratacons_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrataCons']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idApp_OrcaTrataCons'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatratacons_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrataCons']);

            #### App_ServicoVendaCons ####
            $data['update']['servico']['anterior'] = $this->Orcatratacons_model->get_servico($data['orcatrata']['idApp_OrcaTrataCons']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idApp_ServicoVendaCons');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {

                    $data['update']['servico']['inserir'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
                    $data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['servico']['inserir'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];
					$data['update']['servico']['inserir'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataValidadeServico'], 'mysql');
                    $data['update']['servico']['inserir'][$j]['ValorVendaServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorVendaServico']));
                    unset($data['update']['servico']['inserir'][$j]['SubtotalServico']);
                }

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['servico']['alterar'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataValidadeServico'], 'mysql');
					$data['update']['servico']['alterar'][$j]['ValorVendaServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorVendaServico']));
                    unset($data['update']['servico']['alterar'][$j]['SubtotalServico']);
                }

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Orcatratacons_model->set_servico_venda($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] = $this->Orcatratacons_model->update_servico_venda($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Orcatratacons_model->delete_servico_venda($data['update']['servico']['excluir']);
            }

            #### App_ProdutoVendaCons ####
            $data['update']['produto']['anterior'] = $this->Orcatratacons_model->get_produto($data['orcatrata']['idApp_OrcaTrataCons']);
            if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

                if (isset($data['produto']))
                    $data['produto'] = array_values($data['produto']);
                else
                    $data['produto'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_ProdutoVendaCons');

                $max = count($data['update']['produto']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['inserir'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
                    $data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['produto']['inserir'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];
					$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataValidadeProduto'], 'mysql');
                    $data['update']['produto']['inserir'][$j]['ValorVendaProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorVendaProduto']));
                    unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
                }

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['alterar'][$j]['ValorVendaProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorVendaProduto']));
                    unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
                }

                if (count($data['update']['produto']['inserir']))
                    $data['update']['produto']['bd']['inserir'] = $this->Orcatratacons_model->set_produto_venda($data['update']['produto']['inserir']);

                if (count($data['update']['produto']['alterar']))
                    $data['update']['produto']['bd']['alterar'] =  $this->Orcatratacons_model->update_produto_venda($data['update']['produto']['alterar']);

                if (count($data['update']['produto']['excluir']))
                    $data['update']['produto']['bd']['excluir'] = $this->Orcatratacons_model->delete_produto_venda($data['update']['produto']['excluir']);

            }

            #### App_ParcelasRec ####
            $data['update']['parcelasrec']['anterior'] = $this->Orcatratacons_model->get_parcelasrec($data['orcatrata']['idApp_OrcaTrataCons']);
            if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['parcelasrec'] = array_values($data['parcelasrec']);
                else
                    $data['parcelasrec'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_ParcelasRecebiveisCons');

                $max = count($data['update']['parcelasrec']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
                    $data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];

                    $data['update']['parcelasrec']['inserir'][$j]['ValorParcelaRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcelaRecebiveis']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataVencimentoRecebiveis'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimentoRecebiveis'], 'mysql');
                    $data['update']['parcelasrec']['inserir'][$j]['ValorPagoRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPagoRecebiveis']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataPagoRecebiveis'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPagoRecebiveis'], 'mysql');

                }

                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['alterar'][$j]['ValorParcelaRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcelaRecebiveis']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataVencimentoRecebiveis'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimentoRecebiveis'], 'mysql');
                    $data['update']['parcelasrec']['alterar'][$j]['ValorPagoRecebiveis'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPagoRecebiveis']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataPagoRecebiveis'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPagoRecebiveis'], 'mysql');
                }

                if (count($data['update']['parcelasrec']['inserir']))
                    $data['update']['parcelasrec']['bd']['inserir'] = $this->Orcatratacons_model->set_parcelasrec($data['update']['parcelasrec']['inserir']);

                if (count($data['update']['parcelasrec']['alterar']))
                    $data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatratacons_model->update_parcelasrec($data['update']['parcelasrec']['alterar']);

                if (count($data['update']['parcelasrec']['excluir']))
                    $data['update']['parcelasrec']['bd']['excluir'] = $this->Orcatratacons_model->delete_parcelasrec($data['update']['parcelasrec']['excluir']);

            }
			
            #### App_ProcedimentoCons ####
            $data['update']['procedimento']['anterior'] = $this->Orcatratacons_model->get_procedimento($data['orcatrata']['idApp_OrcaTrataCons']);
            if (isset($data['procedimento']) || (!isset($data['procedimento']) && isset($data['update']['procedimento']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['procedimento'] = array_values($data['procedimento']);
                else
                    $data['procedimento'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['procedimento'] = $this->basico->tratamento_array_multidimensional($data['procedimento'], $data['update']['procedimento']['anterior'], 'idApp_ProcedimentoCons');

                $max = count($data['update']['procedimento']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['inserir'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
                    $data['update']['procedimento']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['procedimento']['inserir'][$j]['idApp_OrcaTrataCons'] = $data['orcatrata']['idApp_OrcaTrataCons'];

                    $data['update']['procedimento']['inserir'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimento'], 'mysql');

                }

                $max = count($data['update']['procedimento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['alterar'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimento'], 'mysql');

                }

                if (count($data['update']['procedimento']['inserir']))
                    $data['update']['procedimento']['bd']['inserir'] = $this->Orcatratacons_model->set_procedimento($data['update']['procedimento']['inserir']);

                if (count($data['update']['procedimento']['alterar']))
                    $data['update']['procedimento']['bd']['alterar'] =  $this->Orcatratacons_model->update_procedimento($data['update']['procedimento']['alterar']);

                if (count($data['update']['procedimento']['excluir']))
                    $data['update']['procedimento']['bd']['excluir'] = $this->Orcatratacons_model->delete_procedimento($data['update']['procedimento']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_OrcaTrataCons'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatratacons/form_orcatrataconsalterar2', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrataCons'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrataCons', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'orcatratacons/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				redirect(base_url() . 'relatorioconsultor/orcamento/' . $data['msg']);

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

 
                $this->Orcatratacons_model->delete_orcatrata($id);

                $data['msg'] = '?m=1';
               
				redirect(base_url() . 'orcatratacons/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorioconsultor/orcamento/' . $data['msg']);
                exit();
            //}
        //}

        $this->load->view('basico/footer');
    }
	
    public function excluir2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

 
                $this->Orcatratacons_model->delete_orcatrata($id);

                $data['msg'] = '?m=1';

				#redirect(base_url() . 'orcatratacons/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				redirect(base_url() . 'relatorioconsultor/orcamento/' . $data['msg']);
                exit();
            //}
        //}

        $this->load->view('basico/footer');
    }	

    public function listar($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['OrcaTrata'] = $this->Orcatratacons_model->get_cliente($id, TRUE);
        //$_SESSION['OrcaTrata']['idApp_Cliente'] = $id;
        $data['aprovado'] = $this->Orcatratacons_model->list_orcamento($id, 'S', TRUE);
        $data['naoaprovado'] = $this->Orcatratacons_model->list_orcamento($id, 'N', TRUE);

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('orcatratacons/list_orcatratacons', $data, TRUE);
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('orcatratacons/list_orcatratacons', $data);

        $this->load->view('basico/footer');
    }

    public function listarBKP($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['OrcaTrata'] = $this->Orcatratacons_model->get_cliente($id, TRUE);
        $_SESSION['OrcaTrata']['idApp_Cliente'] = $id;
        $data['query'] = $this->Orcatratacons_model->list_orcatrata(TRUE, TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('orcatratacons/list_orcatratacons', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('orcatratacons/tela_orcatratacons', $data);

        $this->load->view('basico/footer');
    }

}
