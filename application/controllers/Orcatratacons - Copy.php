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
        $this->load->model(array('Basico_model', 'Cliente_model', 'Profissional_model', 'Consultor_model', 'Relatorio_model', 'Formapag_model', 'Cliente_model'));
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
	
    public function acompan($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_Cliente ####
            #'idApp_OrcaTrataCons',
            #Não há a necessidade de atualizar o valor do campo a seguir
            #'idApp_Cliente',
			'Aux1Cli',
			'Aux2Cli',
			'Aux3Cli',
			'Aux4Cli',
			'Aux5Cli',
			'Aux6Cli',
			'Aux7Cli',
			'Aux8Cli',
			'Associado',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

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


        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### App_Cliente ####
            $data['orcatrata'] = $this->Cliente_model->get_cliente($id);
            $data['orcatrata']['TipoReceita'] = $data['orcatrata']['TipoReceita'];


            #### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
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

        #### App_Cliente ####
        #$this->form_validation->set_rules('DataOrca', 'Data do Orçamento', 'required|trim|valid_date');
		#$this->form_validation->set_rules('DataProcedimento', 'DataProcedimento', 'required|trim');
        #$this->form_validation->set_rules('ParcelaRecebiveis', 'ParcelaRecebiveis', 'required|trim');
        #$this->form_validation->set_rules('ProfissionalOrca', 'Profissional', 'required|trim');
		#$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
		#$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
		#$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1ºVenc.', 'required|trim|valid_date');

        $data['select']['Associado'] = $this->Basico_model->select_associado();
		$data['select']['Aux1Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux2Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux3Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux4Cli'] = $this->Basico_model->select_statusaux();
		$data['select']['Aux6Cli'] = $this->Basico_model->select_status_sn();
		$data['select']['Aux7Cli'] = $this->Basico_model->select_status_sn();
		$data['select']['Aux8Cli'] = $this->Basico_model->select_status_sn();

        $data['titulo'] = 'Acompanhamento';
        $data['form_open_path'] = 'cliente/acompan';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		

        //if (isset($data['procedimento']) && ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional']))
        if ($data['count']['PMCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


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
            $this->load->view('cliente/form_acompan', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Cliente ####
            #$data['orcatrata']['TipoReceita'] = $data['orcatrata']['TipoReceita'];
			
            $data['update']['orcatrata']['anterior'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idApp_Cliente'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Cliente_model->update_cliente($data['orcatrata'], $data['orcatrata']['idApp_Cliente']);

			
            #### App_ProcedimentoCons ####
            $data['update']['procedimento']['anterior'] = $this->Cliente_model->get_procedimento($data['orcatrata']['idApp_Cliente']);
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
                    $data['update']['procedimento']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
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


            //if ($data['idApp_Cliente'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('cliente/form_acompan', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Cliente'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'orcatratacons/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				redirect(base_url() . 'cliente/prontuario/' . $data['idApp_Cliente'] . $data['msg']);
				exit();
            }
        }

        $this->load->view('basico/footer');

    }

}
