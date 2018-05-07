<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Contatoconsultor extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Contatoconsultor_model', 'Relapes_model', 'Usuario_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerfuncionario');
        $this->load->view('basico/nav_principalfuncionario');

        #$this->load->view('contatoconsultor/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('contatoconsultor/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($idSis_Usuario = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_ContatoUsuario',
            'idSis_Usuario',
			'idSis_EmpresaMatriz',			
            'NomeContatoUsuario',
            'StatusVida',
			'Ativo',
            'DataNascimento',
            'Sexo',
			'RelaPes',
			'TelefoneContatoUsuario',
            'Obs',
			'QuemCad',
            
                        ), TRUE));

        //echo '<br><br><br><br><br>==========================================='.$data['query']['StatusVida']='V';
        
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeContatoUsuario', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('TelefoneContatoUsuario', 'TelefoneContatoUsuario', 'required|trim');
        $this->form_validation->set_rules('RelaPes', 'RelaPes', 'required|trim');
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVida'] = $this->Contatoconsultor_model->select_status_vida();
		$data['select']['RelaPes'] = $this->Relapes_model->select_relapes();
        $data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		
		$data['titulo'] = 'Cadastrar Contatoconsultor';
        $data['form_open_path'] = 'contatoconsultor/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        #$data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);
        
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contatoconsultor/form_contatoconsultor', $data);
        } else {

            $data['query']['NomeContatoUsuario'] = trim(mb_strtoupper($data['query']['NomeContatoUsuario'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
			$data['query']['idSis_EmpresaMatriz'] = $_SESSION['log']['Empresa'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['query']['QuemCad'] = $_SESSION['log']['id'];
			$data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_ContatoUsuario'] = $this->Contatoconsultor_model->set_contatoconsultor($data['query']);

            if ($data['idApp_ContatoUsuario'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('contatoconsultor/form_contatoconsultor', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_ContatoUsuario'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoUsuario', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'contatoconsultor/pesquisar/' . $_SESSION['Consultor']['idSis_Usuario'] . $data['msg']);
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
            'idApp_ContatoUsuario',
            #'idSis_Usuario',
			'idSis_EmpresaMatriz',
            'NomeContatoUsuario',
            'StatusVida',
            'DataNascimento',
            'Sexo',
			'RelaPes',
            'TelefoneContatoUsuario',
            'Obs',       
			'Ativo',
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Contatoconsultor_model->get_contatoconsultor($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
            $_SESSION['log']['idApp_ContatoUsuario'] = $id;
						
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeContatoUsuario', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('TelefoneContatoUsuario', 'TelefoneContatoUsuario', 'required|trim');
        $this->form_validation->set_rules('RelaPes', 'RelaPes', 'required|trim');
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVida'] = $this->Contatoconsultor_model->select_status_vida();
        $data['select']['RelaPes'] = $this->Relapes_model->select_relapes();
        $data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		
		$data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'contatoconsultor/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #$data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contatoconsultor/form_contatoconsultor', $data);
        } else {

            $data['query']['NomeContatoUsuario'] = trim(mb_strtoupper($data['query']['NomeContatoUsuario'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Obs'] = nl2br($data['query']['Obs']);
            $data['query']['idSis_EmpresaMatriz'] = $_SESSION['log']['Empresa']; 
			$data['query']['idApp_ContatoUsuario'] = $_SESSION['log']['idApp_ContatoUsuario'];

            $data['anterior'] = $this->Contatoconsultor_model->get_contatoconsultor($data['query']['idApp_ContatoUsuario']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ContatoUsuario'], TRUE);

            if ($data['auditoriaitem'] && $this->Contatoconsultor_model->update_contatoconsultor($data['query'], $data['query']['idApp_ContatoUsuario']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'contatoconsultor/form_contatoconsultor/' . $data['query']['idApp_ContatoUsuario'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoUsuario', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'contatoconsultor/pesquisar/' . $_SESSION['Consultor']['idSis_Usuario'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function excluir2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idApp_ContatoUsuario',
            'submit'
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Contatoconsultor_model->get_contatoconsultor($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
            $data['query']['ContatoconsultorDataNascimento'] = $this->basico->mascara_data($data['query']['ContatoconsultorDataNascimento'], 'barras');
        }

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();

        $data['titulo'] = 'Tem certeza que deseja excluir o registro abaixo?';
        $data['form_open_path'] = 'contatoconsultor/excluir';
        $data['readonly'] = 'readonly';
        $data['disabled'] = 'disabled';
        $data['panel'] = 'danger';
        $data['metodo'] = 3;

        $data['tela'] = $this->load->view('contatoconsultor/form_contatoconsultor', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('contatoconsultor/tela_contatoconsultor', $data);
        } else {

            if ($data['query']['idApp_ContatoUsuario'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('contatoconsultor/form_contatoconsultor', $data);
            } else {

                $data['anterior'] = $this->Contatoconsultor_model->get_contatoconsultor($data['query']['idApp_ContatoUsuario']);
                $data['campos'] = array_keys($data['anterior']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['query']['idApp_ContatoUsuario'], FALSE, TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ContatoUsuario', 'DELETE', $data['auditoriaitem']);

                $this->Contatoconsultor_model->delete_contatoconsultor($data['query']['idApp_ContatoUsuario']);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'contatoconsultor' . $data['msg']);
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

                $this->Contatoconsultor_model->delete_contatoconsultor($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'contatoconsultor/pesquisar/' . $_SESSION['Consultor']['idSis_Usuario'] . $data['msg']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }
	
    public function pesquisar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'), 0, -3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'), 0, -3);
        }

        $_SESSION['Consultor'] = $this->Usuario_model->get_usuario($id, TRUE);
        
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        $data['query'] = $this->Contatoconsultor_model->lista_contatoconsultor(TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('contatoconsultor/list_contatoconsultor', $data, TRUE);
        
        #$data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

        $this->load->view('contatoconsultor/tela_contatoconsultor', $data);

        $this->load->view('basico/footer');
    }

}
