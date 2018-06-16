<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Tarefacons extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Tarefacons_model', 'Profissional_model', 'Formapag_model'));
        $this->load->driver('session');

        
        $this->load->view('basico/headerconsultor');
        $this->load->view('basico/nav_principalconsultor');

        
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('tarefa/tela_index', $data);

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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['tarefa'] = quotes_to_entities($this->input->post(array(
            #### App_Tarefacons ####
            'idApp_Tarefacons',           
            'DataTarefa',
			'DataPrazoTarefa',
            'ProfissionalTarefa',
            'TarefaConcluida',
            'Rotina',
            'Prioridade',
            'DataConclusao',
            'DataRetorno',           
            'ObsTarefa',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

       
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');

        //Data de hoje como default
        (!$data['tarefa']['DataTarefa']) ? $data['tarefa']['DataTarefa'] = date('d/m/Y', time()) : FALSE;
		(!$data['tarefa']['DataPrazoTarefa']) ? $data['tarefa']['DataPrazoTarefa'] = date('d/m/Y', time()) : FALSE;
		
		
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

        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Tarefacons ####
        $this->form_validation->set_rules('DataTarefa', 'Tarefa Criada em', 'trim|valid_date');
        $this->form_validation->set_rules('DataPrazoTarefa', 'Prazo para Conclusão', 'trim');
        #$this->form_validation->set_rules('ProfissionalTarefa', 'Profissional', 'required|trim');

        $data['select']['TarefaConcluida'] = $this->Basico_model->select_status_sn();
        $data['select']['Rotina'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['Prioridade'] = $this->Basico_model->select_status_sn();
        $data['select']['Profissional'] = $this->Profissional_model->select_profissional();

        $data['titulo'] = 'Cadastar';
        $data['form_open_path'] = 'tarefacons/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional'])
        if (isset($data['procedimento']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo
        (!$data['tarefa']['TarefaConcluida']) ? $data['tarefa']['TarefaConcluida'] = 'N' : FALSE;

        $data['radio'] = array(
            'TarefaConcluida' => $this->basico->radio_checked($data['tarefa']['TarefaConcluida'], 'Tarefa Aprovado', 'NS'),
        );

        ($data['tarefa']['TarefaConcluida'] == 'S') ?
            $data['div']['TarefaConcluida'] = '' : $data['div']['TarefaConcluida'] = 'style="display: none;"';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';


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
            $this->load->view('tarefacons/form_tarefacons', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Tarefacons ####
            $data['tarefa']['DataTarefa'] = $this->basico->mascara_data($data['tarefa']['DataTarefa'], 'mysql');
            $data['tarefa']['DataPrazoTarefa'] = $this->basico->mascara_data($data['tarefa']['DataPrazoTarefa'], 'mysql');
			$data['tarefa']['DataConclusao'] = $this->basico->mascara_data($data['tarefa']['DataConclusao'], 'mysql');
            $data['tarefa']['DataRetorno'] = $this->basico->mascara_data($data['tarefa']['DataRetorno'], 'mysql');
			$data['tarefa']['Empresa'] = $_SESSION['log']['Empresa'];            
            $data['tarefa']['idApp_Consultor'] = $_SESSION['log']['id'];
            $data['tarefa']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['tarefa']['idApp_Tarefacons'] = $this->Tarefacons_model->set_tarefa($data['tarefa']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### App_ProcedimentoCons ####
            if (isset($data['procedimento'])) {
                $max = count($data['procedimento']);
                for($j=1;$j<=$max;$j++) {
                    $data['procedimento'][$j]['idApp_Consultor'] = $_SESSION['log']['id'];
                    $data['procedimento'][$j]['Empresa'] = $_SESSION['log']['Empresa'];
					$data['procedimento'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['procedimento'][$j]['idApp_Tarefacons'] = $data['tarefa']['idApp_Tarefacons'];

                    $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'mysql');
					

                }
                $data['procedimento']['idApp_ProcedimentoCons'] = $this->Tarefacons_model->set_procedimento($data['procedimento']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idApp_Tarefacons'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('tarefacons/form_tarefacons', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Tarefacons'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Tarefacons', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'tarefa/listar/' . $data['msg']);
				redirect(base_url() . 'relatorioconsultor/tarefa/' . $data['msg']);
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
        $data['tarefa'] = quotes_to_entities($this->input->post(array(
            #### App_Tarefacons ####
            'idApp_Tarefacons',			
            'DataTarefa',
			'DataPrazoTarefa',
            'ProfissionalTarefa',
            'TarefaConcluida',
            'Rotina',
            'Prioridade',
            'DataConclusao',
            'DataRetorno',            
            'ObsTarefa',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');

        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('DataProcedimento' . $i) || $this->input->post('Profissional' . $i) ||
                    $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
                $data['procedimento'][$j]['idApp_ProcedimentoCons'] = $this->input->post('idApp_ProcedimentoCons' . $i);
                $data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
                $data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
                $data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
				$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);
                $j++;
            }

        }
        $data['count']['PMCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### App_Tarefacons ####
            $data['tarefa'] = $this->Tarefacons_model->get_tarefa($id);
            $data['tarefa']['DataTarefa'] = $this->basico->mascara_data($data['tarefa']['DataTarefa'], 'barras');
            $data['tarefa']['DataPrazoTarefa'] = $this->basico->mascara_data($data['tarefa']['DataPrazoTarefa'], 'barras');
			$data['tarefa']['DataConclusao'] = $this->basico->mascara_data($data['tarefa']['DataConclusao'], 'barras');
            $data['tarefa']['DataRetorno'] = $this->basico->mascara_data($data['tarefa']['DataRetorno'], 'barras');
            

            #### Carrega os dados do cliente nas variáves de sessão ####
            #$this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['tarefa']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### App_ProcedimentoCons ####
            $data['procedimento'] = $this->Tarefacons_model->get_procedimento($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);

                if (isset($data['procedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
                        $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');
						

                }
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Tarefacons ####
        $this->form_validation->set_rules('DataTarefa', 'Tarefa Criada em', 'trim|valid_date');        
		$this->form_validation->set_rules('DataPrazoTarefa', 'Prazo para Conclusão', 'trim');      
        #$this->form_validation->set_rules('ProfissionalTarefa', 'Profissional', 'required|trim');

        $data['select']['TarefaConcluida'] = $this->Basico_model->select_status_sn();        
        $data['select']['Rotina'] = $this->Basico_model->select_status_sn();        
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['Prioridade'] = $this->Basico_model->select_status_sn();       
        $data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        

        $data['titulo'] = 'Editar';
        $data['form_open_path'] = 'tarefacons/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if (isset($data['procedimento']) && ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional']))
        if ($data['count']['PMCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo
        (!$data['tarefa']['TarefaConcluida']) ? $data['tarefa']['TarefaConcluida'] = 'N' : FALSE;

        $data['radio'] = array(
            'TarefaConcluida' => $this->basico->radio_checked($data['tarefa']['TarefaConcluida'], 'Tarefa Aprovado', 'NS'),
        );

        ($data['tarefa']['TarefaConcluida'] == 'S') ?
            $data['div']['TarefaConcluida'] = '' : $data['div']['TarefaConcluida'] = 'style="display: none;"';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        
        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('tarefacons/form_tarefacons', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Tarefacons ####
            $data['tarefa']['DataTarefa'] = $this->basico->mascara_data($data['tarefa']['DataTarefa'], 'mysql');
            $data['tarefa']['DataPrazoTarefa'] = $this->basico->mascara_data($data['tarefa']['DataPrazoTarefa'], 'mysql');
			$data['tarefa']['DataConclusao'] = $this->basico->mascara_data($data['tarefa']['DataConclusao'], 'mysql');
            $data['tarefa']['DataRetorno'] = $this->basico->mascara_data($data['tarefa']['DataRetorno'], 'mysql');
			$data['tarefa']['Empresa'] = $_SESSION['log']['Empresa'];             

            $data['tarefa']['idApp_Consultor'] = $_SESSION['log']['id'];
            $data['tarefa']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['tarefa']['anterior'] = $this->Tarefacons_model->get_tarefa($data['tarefa']['idApp_Tarefacons']);
            $data['update']['tarefa']['campos'] = array_keys($data['tarefa']);
            $data['update']['tarefa']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['tarefa']['anterior'],
                $data['tarefa'],
                $data['update']['tarefa']['campos'],
                $data['tarefa']['idApp_Tarefacons'], TRUE);
            $data['update']['tarefa']['bd'] = $this->Tarefacons_model->update_tarefa($data['tarefa'], $data['tarefa']['idApp_Tarefacons']);

            #### App_ProcedimentoCons ####
            $data['update']['procedimento']['anterior'] = $this->Tarefacons_model->get_procedimento($data['tarefa']['idApp_Tarefacons']);
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
                    $data['update']['procedimento']['inserir'][$j]['idApp_Tarefacons'] = $data['tarefa']['idApp_Tarefacons'];

                    $data['update']['procedimento']['inserir'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimento'], 'mysql');
					
                }

                $max = count($data['update']['procedimento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['alterar'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimento'], 'mysql');

                }

                if (count($data['update']['procedimento']['inserir']))
                    $data['update']['procedimento']['bd']['inserir'] = $this->Tarefacons_model->set_procedimento($data['update']['procedimento']['inserir']);

                if (count($data['update']['procedimento']['alterar']))
                    $data['update']['procedimento']['bd']['alterar'] =  $this->Tarefacons_model->update_procedimento($data['update']['procedimento']['alterar']);

                if (count($data['update']['procedimento']['excluir']))
                    $data['update']['procedimento']['bd']['excluir'] = $this->Tarefacons_model->delete_procedimento($data['update']['procedimento']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_Tarefacons'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['tarefa']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('tarefacons/form_tarefacons', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Tarefacons'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Tarefacons', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'tarefa/listar/' . $data['msg']);
				redirect(base_url() . 'relatorioconsultor/tarefa/' . $data['msg']);
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
        
                $this->Tarefacons_model->delete_tarefa($id);

                $data['msg'] = '?m=1';

                #redirect(base_url() . 'tarefa/listar/' . $data['msg']);
				redirect(base_url() . 'relatorioconsultor/tarefa/' . $data['msg']);
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


        //$_SESSION['Tarefa'] = $this->Tarefacons_model->get_cliente($id, TRUE);
        //$_SESSION['Tarefa']['idApp_Cliente'] = $id;
        $data['aprovado'] = $this->Tarefacons_model->list_tarefa($id, 'S', TRUE);
        $data['naoaprovado'] = $this->Tarefacons_model->list_tarefa($id, 'N', TRUE);

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('tarefa/list_tarefa', $data, TRUE);
       # $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('tarefa/tela_tarefa', $data);

        $this->load->view('basico/footer');
    }

    public function listarBKP($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['Tarefa'] = $this->Tarefacons_model->get_cliente($id, TRUE);
        #$_SESSION['Tarefa']['idApp_Cliente'] = $id;
        $data['query'] = $this->Tarefacons_model->list_tarefa(TRUE, TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('tarefa/list_tarefa', $data, TRUE);

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('tarefa/tela_tarefa', $data);

        $this->load->view('basico/footer');
    }

}
