<!--"ODONTO"-->

<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Consultafuncionario extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Profissional_model', 'Consultafuncionario_model', 'Consultor_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principalfuncionario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('consulta/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($idApp_Consultor = NULL, $idApp_ContatoConsultor = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Consultor',
            'Data',
            'HoraInicio',
            'HoraFim',
            'Paciente',
			'idTab_Status',
            'idTab_TipoConsulta',
            'idApp_ContatoConsultor',
            'idApp_Profissional',
            'Procedimento',
            'Obs',
                ), TRUE));

        if ($idApp_Consultor) {
            $data['query']['idApp_Consultor'] = $idApp_Consultor;
            $_SESSION['Consultor'] = $this->Consultor_model->get_consultor($idApp_Consultor, TRUE);
        }

        if ($idApp_ContatoConsultor) {
            $data['query']['idApp_ContatoConsultor'] = $idApp_ContatoConsultor;
            $data['query']['Paciente'] = 'D';
        }

        if (isset($_SESSION['agenda']) && !$data['query']['HoraInicio'] && !$data['query']['HoraFim']) {
            $data['query']['Data'] = date('d/m/Y', $_SESSION['agenda']['HoraInicio']);
            $data['query']['HoraInicio'] = date('H:i', $_SESSION['agenda']['HoraInicio']);
            $data['query']['HoraFim'] = date('H:i', $_SESSION['agenda']['HoraFim']);
        }

        #Ver uma solução melhor para este campo
        (!$data['query']['Paciente']) ? $data['query']['Paciente'] = 'R' : FALSE;

        $data['radio'] = array(
            'Paciente' => $this->basico->radio_checked($data['query']['Paciente'], 'Paciente', 'RD'),
        );

        ($data['query']['Paciente'] == 'D') ?
            $data['div']['Paciente'] = '' : $data['div']['Paciente'] = 'style="display: none;"';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        $this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
        #$this->form_validation->set_rules('idTab_TipoConsulta', 'Tipo de Consulta', 'required|trim');
        #$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');


        if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoConsultor', 'ContatoConsultor', 'required|trim');

        $data['resumo'] = $this->Consultor_model->get_consultor($data['query']['idApp_Consultor']);

		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoConsulta'] = $this->Basico_model->select_tipo_consulta();
        $data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        $data['select']['ContatoConsultor'] = $this->Consultafuncionario_model->select_contatoconsultor_consultor($data['query']['idApp_Consultor']);

        #echo $data['query']['idApp_Agenda'] . ' ' . $_SESSION['log']['id'];
        #$data['query']['idApp_Agenda'] = ($_SESSION['log']['Permissao'] > 2) ? $_SESSION['log']['id'] : FALSE;

        /*
        echo count($data['select']['idApp_Agenda']);
        echo '<br>';
        echo "<pre>";
        print_r($data['select']['idApp_Agenda']);
        echo "</pre>";
        #exit();
        */

        $data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoConsultor',
        );

        $data['titulo'] = 'Agenda Empresa C/ Consultor';
        $data['form_open_path'] = 'consultafuncionario/cadastrar';
        $data['panel'] = 'primary';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['metodo'] = 1;

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('consultor/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consultafuncionario/form_consultafuncionario', $data);
        } else {

			$data['query']['Tipo'] = 2;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
            //$data['query']['idTab_Status'] = 1;
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
			$data['query']['Empresa'] = $_SESSION['log']['Empresa'];
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['redirect'] = '&gtd3=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');

            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Consulta'] = $this->Consultafuncionario_model->set_consulta($data['query']);

            unset($_SESSION['Agenda']);

            if ($data['idApp_Consulta'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('consulta/form_consulta', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Consulta'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'consultor/prontuario/' . $data['query']['idApp_Consultor'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar($idApp_Consultor = FALSE, $idApp_Consulta = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Consultor',
            'Data',
            'HoraInicio',
            'HoraFim',
            'idTab_Status',
            'Paciente',
            'idApp_ContatoConsultor',
            'idApp_Profissional',
            'Procedimento',
            'Obs',
			'idTab_TipoConsulta',
                ), TRUE);

        if ($idApp_Consultor) {
            $data['query']['idApp_Consultor'] = $idApp_Consultor;
            $_SESSION['Consultor'] = $this->Consultor_model->get_consultor($idApp_Consultor, TRUE);
        }

        if ($idApp_Consulta) {
            $data['query']['idApp_Consultor'] = $idApp_Consultor;
            $data['query'] = $this->Consultafuncionario_model->get_consulta($idApp_Consulta);

            $dataini = explode(' ', $data['query']['DataInicio']);
            $datafim = explode(' ', $data['query']['DataFim']);

            $data['query']['Data'] = $this->basico->mascara_data($dataini[0], 'barras');
            $data['query']['HoraInicio'] = substr($dataini[1], 0, 5);
            $data['query']['HoraFim'] = substr($datafim[1], 0, 5);
        }
        else {
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
        }


        if ($data['query']['DataFim'] < date('Y-m-d H:i:s', time())) {
            #$data['readonly'] = 'readonly';
            $data['readonly'] = '';
            $data['datepicker'] = '';
            $data['timepicker'] = '';
        } else {
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        }

        #echo $data['query']['DataInicio'];
        #$data['query']['idApp_Agenda'] = 1;


        #Ver uma solução melhor para este campo
        (!$data['query']['Paciente']) ? $data['query']['Paciente'] = 'R' : FALSE;

        $data['radio'] = array(
            'Paciente' => $this->basico->radio_checked($data['query']['Paciente'], 'Paciente', 'RD'),
        );

        ($data['query']['Paciente'] == 'D') ?
            $data['div']['Paciente'] = '' : $data['div']['Paciente'] = 'style="display: none;"';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        $this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
        #$this->form_validation->set_rules('idTab_TipoConsulta', 'Tipo de Consulta', 'required|trim');
        #$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');


        if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoConsultor', 'ContatoConsultor', 'required|trim');

		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
        $data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoConsulta'] = $this->Basico_model->select_tipo_consulta();
        $data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        $data['select']['ContatoConsultor'] = $this->Consultafuncionario_model->select_contatoconsultor_consultor($data['query']['idApp_Consultor']);

        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoConsultor',
        );

        $data['resumo'] = $this->Consultor_model->get_consultor($data['query']['idApp_Consultor']);

        //echo '<br><br><br><br>================================== '.$data['query']['idTab_Status'];

        $data['titulo'] = 'Agenda Empresa C/ Consultor';
        $data['form_open_path'] = 'consulta/alterar';
        #$data['readonly'] = '';
        #$data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['nav_secundario'] = $this->load->view('consultor/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_consulta', $data);
        } else {

            #echo '<br><br><br><br>================================== '.$data['query']['idTab_Status'];
            #exit();

            $data['query']['Tipo'] = 2;
			$data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['redirect'] = '&gtd3=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
            //exit();

            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);

            $data['anterior'] = $this->Consultafuncionario_model->get_consulta($data['query']['idApp_Consulta']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], TRUE);

            unset($_SESSION['Agenda']);

            if ($data['auditoriaitem'] && $this->Consultafuncionario_model->update_consulta($data['query'], $data['query']['idApp_Consulta']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Consulta'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                //redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Consultor'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function listar($idApp_Consultor = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($idApp_Consultor) {
            $data['resumo'] = $this->Consultor_model->get_consultor($idApp_Consultor);
            $_SESSION['Consultor'] = $this->Consultor_model->get_consultor($idApp_Consultor, TRUE);
        }

        $data['titulo'] = 'Listar Consultas';
        $data['panel'] = 'primary';
        $data['novo'] = '';
        $data['metodo'] = 4;

        $data['query'] = array();
        $data['proxima'] = $this->Consultafuncionario_model->lista_consulta_proxima($idApp_Consultor);
        $data['anterior'] = $this->Consultafuncionario_model->lista_consulta_anterior($idApp_Consultor);

        #$data['tela'] = $this->load->view('consulta/list_consulta', $data, TRUE);
        #$data['resumo'] = $this->Consultor_model->get_consultor($data['Consultor']['idApp_Consultor']);
        $data['nav_secundario'] = $this->load->view('consultor/nav_secundario', $data, TRUE);

        $this->load->view('consulta/list_consulta', $data);

        $this->load->view('basico/footer');
    }

    public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        if (!$id) {
            $data['msg'] = '?m=2';
            redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Consulta'] . $data['msg']);
        } else {

            $data['anterior'] = $this->Consultafuncionario_model->get_consulta($id);
            #$data['campos'] = array_keys($data['query']);
            $data['campos'] = array_keys($data['anterior']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['query']['idApp_Consulta'], FALSE, TRUE);
            $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'DELETE', $data['auditoriaitem']);

            $this->Consultafuncionario_model->delete_consulta($id);

            $data['msg'] = '?m=1';

            redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
            exit();
        }

        $this->load->view('basico/footer');
    }

    /*
     * Cadastrar/Alterar Eventos
     */

    public function cadastrar_evento($idApp_Consultor = NULL, $idApp_Agenda = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
                    'idSis_Usuario',
					'idApp_Consulta',
                    'idApp_Agenda',
                    'Data',
                    'HoraInicio',
                    'HoraFim',
                    'Evento',
                    'Obs',
					'idApp_Profissional',
                        ), TRUE));

        if ($this->input->get('start') && $this->input->get('end')) {
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraInicio'] = date('H:i', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraFim'] = date('H:i', substr($this->input->get('end'), 0, -3));
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        $this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		#$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');
		$data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        $data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();

        $data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

		$data['titulo'] = 'Agenda Empresa Pessoal';
        $data['form_open_path'] = 'consulta/cadastrar_evento';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        $data['evento'] = 1;

        $data['readonly'] = '';
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('consultor/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_evento', $data);
        } else {

			$data['query']['Tipo'] = 1;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
			$data['query']['Empresa'] = $_SESSION['log']['Empresa'];
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');

            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Consulta'] = $this->Consultafuncionario_model->set_consulta($data['query']);

            if ($data['idApp_Consulta'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('consulta/form_consulta', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Consulta'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'consultor/prontuario/' . $data['query']['idApp_Consultor'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar_evento($idApp_Consulta = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
            'Data',
            'HoraInicio',
            'HoraFim',
            'Evento',
            'Obs',
			'idApp_Profissional',
                ), TRUE);


        if ($idApp_Consulta) {
            $data['query'] = $this->Consultafuncionario_model->get_consulta($idApp_Consulta);

            $dataini = explode(' ', $data['query']['DataInicio']);
            $datafim = explode(' ', $data['query']['DataFim']);

            $data['query']['Data'] = $this->basico->mascara_data($dataini[0], 'barras');
            $data['query']['HoraInicio'] = substr($dataini[1], 0, 5);
            $data['query']['HoraFim'] = substr($datafim[1], 0, 5);
        }

        if ($data['query']['DataFim'] < date('Y-m-d H:i:s', time())) {
            #$data['readonly'] = 'readonly';
            $data['readonly'] = '';
            $data['datepicker'] = '';
            $data['timepicker'] = '';
        } else {
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        $this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		#$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');
		$data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        $data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();

        $data['titulo'] = 'Agenda Empresa Pessoal';
        $data['form_open_path'] = 'consulta/alterar_evento';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['evento'] = 1;

        $data['nav_secundario'] = $this->load->view('consultor/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_evento', $data);
        } else {

			$data['query']['Tipo'] = 1;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
            //exit();

            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);

            $data['anterior'] = $this->Consultafuncionario_model->get_consulta($data['query']['idApp_Consulta']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], TRUE);

            if ($data['auditoriaitem'] && $this->Consultafuncionario_model->update_consulta($data['query'], $data['query']['idApp_Consulta']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Consulta'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                //redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Consultor'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

	public function cadastrar_particular($idApp_Consultor = NULL, $idApp_Agenda = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
                    'idSis_Usuario',
					'idApp_Consulta',
                    'idApp_Agenda',
                    'Data',
                    'HoraInicio',
                    'HoraFim',
                    'Evento',
                    'Obs',
					'idApp_Profissional',
                        ), TRUE));

        if ($this->input->get('start') && $this->input->get('end')) {
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraInicio'] = date('H:i', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraFim'] = date('H:i', substr($this->input->get('end'), 0, -3));
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        $this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		#$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');

        $data['select']['Profissional'] = $this->Profissional_model->select_profissional();
        $data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();

        $data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

		$data['titulo'] = 'Agenda Particular';
        $data['form_open_path'] = 'consulta/cadastrar_particular';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        $data['evento'] = 3;

        $data['readonly'] = '';
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('consultor/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_particular', $data);
        } else {

			$data['query']['Tipo'] = 3;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
            $data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
			$data['query']['Empresa'] = $_SESSION['log']['Empresa'];
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');

            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Consulta'] = $this->Consultafuncionario_model->set_consulta($data['query']);

            if ($data['idApp_Consulta'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('consulta/form_consulta', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Consulta'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'consultor/prontuario/' . $data['query']['idApp_Consultor'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar_particular($idApp_Consulta = FALSE, $idApp_Agenda = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
            'Data',
            'HoraInicio',
            'HoraFim',
            'Evento',
            'Obs',
			'idApp_Profissional',
                ), TRUE);


        if ($idApp_Consulta) {
            $data['query'] = $this->Consultafuncionario_model->get_consulta($idApp_Consulta);

            $dataini = explode(' ', $data['query']['DataInicio']);
            $datafim = explode(' ', $data['query']['DataFim']);

            $data['query']['Data'] = $this->basico->mascara_data($dataini[0], 'barras');
            $data['query']['HoraInicio'] = substr($dataini[1], 0, 5);
            $data['query']['HoraFim'] = substr($datafim[1], 0, 5);
        }

        if ($data['query']['DataFim'] < date('Y-m-d H:i:s', time())) {
            #$data['readonly'] = 'readonly';
            $data['readonly'] = '';
            $data['datepicker'] = '';
            $data['timepicker'] = '';
        } else {
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        $this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		#$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');
		$data['select']['Profissional'] = $this->Profissional_model->select_profissional();
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
        $data['titulo'] = 'Agenda Particular';
        $data['form_open_path'] = 'consulta/alterar_particular';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['evento'] = 1;

        $data['nav_secundario'] = $this->load->view('consultor/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_particular', $data);
        } else {

			$data['query']['Tipo'] = 3;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
            //exit();

            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);

            $data['anterior'] = $this->Consultafuncionario_model->get_consulta($data['query']['idApp_Consulta']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], TRUE);

            if ($data['auditoriaitem'] && $this->Consultafuncionario_model->update_consulta($data['query'], $data['query']['idApp_Consulta']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Consulta'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                //redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Consultor'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

}
