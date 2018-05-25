<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Loginconsultor extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model(array('Login_model', 'Loginconsultor_model', 'Funcao_model', 'Basico_model', 'Consultor_model'));
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('basico', 'form_validation', 'user_agent'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerloginconsultor');

        if ($this->agent->is_browser()) {

            if (
                    (preg_match("/(chrome|Firefox)/i", $this->agent->browser()) && $this->agent->version() < 30) ||
                    (preg_match("/(safari)/i", $this->agent->browser()) && $this->agent->version() < 6) ||
                    (preg_match("/(opera)/i", $this->agent->browser()) && $this->agent->version() < 12) ||
                    (preg_match("/(internet explorer)/i", $this->agent->browser()) && $this->agent->version() < 9 )
            ) {
                $msg = '<h2><strong>Navegador n�o suportado.</strong></h2>';

                echo $this->basico->erro($msg);
                exit();
            }
        }
    }

    public function index() {

        #$_SESSION['log']['cliente'] = $_SESSION['log']['nome_modulo'] =
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'varejo';
        $_SESSION['log']['idTab_Modulo'] = 1;

        ###################################################
        #s� pra eu saber quando estou no banco de testes ou de produ��o
        #$CI = & get_instance();
        #$CI->load->database();
        #if ($CI->db->database != 'sishuap')
        #echo $CI->db->database;
        ###################################################
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #Get GET or POST data
        $usuario = $this->input->get_post('Usuario');
		#$nomeempresa = $this->input->get_post('NomeEmpresa');
        $senha = md5($this->input->get_post('Senha'));

        #set validation rules
        $this->form_validation->set_rules('Usuario', 'Usu�rio', 'required|trim|callback_valid_usuario');
		#$this->form_validation->set_rules('NomeEmpresa', 'Nome da Empresa', 'required|trim|callback_valid_nomeempresa[' . $usuario . ']');
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5|callback_valid_senha[' . $usuario . ']');

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Sua sess�o expirou. Fa�a o loginconsultor novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>Usu�rio ativado com sucesso! Fa�a o loginconsultor para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginconsultor view
            $this->load->view('loginconsultor/form_loginconsultor', $data);
        } else {

            session_regenerate_id(true);

            #Get GET or POST data
            #$usuario = $this->input->get_post('Usuario');
            #$senha = md5($this->input->get_post('Senha'));
            /*
              echo "<pre>";
              print_r($query);
              echo "</pre>";
              exit();
             */
            $query = $this->Loginconsultor_model->check_dados_usuario($senha, $usuario, TRUE);
            #$_SESSION['log']['Agenda'] = $this->Loginconsultor_model->get_agenda_padrao($query['idApp_Consultor']);

            #echo "<pre>".print_r($query)."</pre>";
            #exit();

            if ($query === FALSE) {
                #$msg = "<strong>Senha</strong> incorreta ou <strong>usu�rio</strong> inexistente.";
                #$this->basico->erro($msg);
                $data['msg'] = $this->basico->msg('<strong>Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
				#$data['msg'] = $this->basico->msg('<strong>NomeEmpresa</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('form_loginconsultor', $data);

            } else {
                #initialize session
                $this->load->driver('session');

                #$_SESSION['log']['Usuario'] = $query['Usuario'];
                //se for necess�rio reduzir o tamanho do nome de usu�rio, que pode ser um email
                $_SESSION['log']['Usuario'] = (strlen($query['Usuario']) > 15) ? substr($query['Usuario'], 0, 15) : $query['Usuario'];
                $_SESSION['log']['NomeConsultor2'] = (strlen($query['NomeConsultor']) > 10) ? substr($query['NomeConsultor'], 0, 10) : $query['NomeConsultor'];
				$_SESSION['log']['NomeConsultor'] = $query['NomeConsultor'];
				$_SESSION['log']['id'] = $query['idApp_Consultor'];
				$_SESSION['log']['idSis_EmpresaFilial'] = $query['idSis_EmpresaFilial'];
				$_SESSION['log']['idSis_EmpresaMatriz'] = $query['idSis_EmpresaMatriz'];
				$_SESSION['log']['Empresa'] = $query['Empresa'];
				$_SESSION['log']['NomeEmpresa2'] = (strlen($query['NomeEmpresa']) > 12) ? substr($query['NomeEmpresa'], 0, 12) : $query['NomeEmpresa'];
				$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];				
				$_SESSION['log']['Nivel'] = $query['Nivel'];
				$_SESSION['log']['Permissao'] = $query['Permissao'];
				$_SESSION['log']['Funcao'] = $query['Funcao'];
				$_SESSION['log']['Associado'] = $query['Associado'];
				

                $this->load->database();
                $_SESSION['db']['hostname'] = $this->db->hostname;
                $_SESSION['db']['username'] = $this->db->username;
                $_SESSION['db']['password'] = $this->db->password;
                $_SESSION['db']['database'] = $this->db->database;

                if ($this->Loginconsultor_model->set_acesso($_SESSION['log']['id'], 'LOGIN') === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('form_loginconsultor');
                } else {
                    
					#redirect('cliente');
					redirect('acessoconsultor');
                }
            }
        }

        #load footer view
        $this->load->view('basico/footerloginconsultor');
        $this->load->view('basico/footer');
    }

    public function registrar() {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'varejo';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'Email',
            'Usuario',
            'Nome',
            'Senha',
            'Confirma',
            'DataNascimento',
            'Celular',
            'Sexo',
			'Permissao',
			'Nivel',
			'QuemCad',
			'Funcao',
			'TipoProfissional',
			'DataCriacao',
			'CpfUsuario',
			'RgUsuario',
			'OrgaoExpUsuario',
			'EstadoEmUsuario',
			'DataEmUsuario',
			'EnderecoUsuario',
			'BairroUsuario',
			'MunicipioUsuario',
			'EstadoUsuario',
			'CepUsuario',
			'Associado',
			
                ), TRUE);

        (!$data['query']['DataCriacao']) ? $data['query']['DataCriacao'] = date('d/m/Y', time()) : FALSE;
		
		$this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');
	
        $this->form_validation->set_rules('Email', 'E-mail', 'required|trim|valid_email|is_unique[App_Consultor.Email]');		
        $this->form_validation->set_rules('Usuario', 'Usu�rio', 'required|trim|is_unique[App_Consultor.Usuario]');
		$this->form_validation->set_rules('Nome', 'Nome do Usu�rio', 'required|trim');      	
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('Celular', 'Celular', 'required|trim');
		
		#$this->form_validation->set_rules('CpfUsuario', 'Cpf', 'required|trim|valid_cpf|is_unique[App_Consultor.CpfUsuario]');
		#$this->form_validation->set_rules('RgUsuario', 'Rg', 'required|trim');
		$this->form_validation->set_rules('EnderecoUsuario', 'Endere�o', 'required|trim');
		$this->form_validation->set_rules('BairroUsuario', 'Bairro', 'required|trim');
		$this->form_validation->set_rules('MunicipioUsuario', 'Munic�pio', 'required|trim');
		$this->form_validation->set_rules('EstadoUsuario', 'Estado', 'required|trim');
		$this->form_validation->set_rules('CepUsuario', 'Cep', 'required|trim|valid_cep');
		
		
		#$this->form_validation->set_rules('Permissao', 'N�vel', 'required|trim');
		#$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');
		
		$data['select']['Permissao'] = $this->Basico_model->select_permissao();
		#$data['select']['Associado'] = $this->Consultor_model->select_consultorgestor();
		$data['select']['TipoProfissional'] = $this->Basico_model->select_tipoprofissional();
		$data['select']['Funcao'] = $this->Funcao_model->select_funcao();
        $data['select']['MunicipioUsuario'] = $this->Basico_model->select_municipio();
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginconsultor view
            $this->load->view('loginconsultor/form_registrar', $data);
        } else {
			
			$data['query']['idSis_EmpresaFilial'] = 0;
			$data['query']['idSis_EmpresaMatriz'] = 2;
			$data['query']['Empresa'] = 2;
			$data['query']['NomeEmpresa'] = "Rede Calisi de Vendas" ;
			$data['query']['idTab_Modulo'] = 1;
			$data['query']['QuemCad'] = 0;
			$data['query']['Funcao'] = 1;
			$data['query']['Nivel'] = 3;
			$data['query']['Permissao'] = 3;
			$data['query']['Associado'] = 1;
            $data['query']['Senha'] = md5($data['query']['Senha']);
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'mysql');
            $data['query']['DataCriacao'] = $this->basico->mascara_data($data['query']['DataCriacao'], 'mysql');
			$data['query']['Codigo'] = md5(uniqid(time() . rand()));
            $data['query']['Inativo'] = 1;
            //ACESSO LIBERADO PRA QUEM REALIZAR O CADASTRO
            #$data['query']['Inativo'] = 0;
            unset($data['query']['Confirma']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            $data['idApp_Consultor'] = $this->Loginconsultor_model->set_usuario($data['query']);
            $_SESSION['log']['id'] = 1;

            if ($data['idApp_Consultor'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('loginconsultor/form_loginconsultor', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Consultor']);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consultor', 'CREATE', $data['auditoriaitem'], $data['idApp_Consultor']);
                /*
                  echo $this->db->last_query();
                  echo "<pre>";
                  print_r($data);
                  echo "</pre>";
                  exit();
                 */
                $data['agenda'] = array(
                    'NomeAgenda' => 'Padr�o',
					'Empresa' => '2',
                    'idApp_Consultor' => $data['idApp_Consultor']
                );
                $data['campos'] = array_keys($data['agenda']);

                $data['idApp_Agenda'] = $this->Loginconsultor_model->set_agenda($data['agenda']);
                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['agenda'], $data['campos'], $data['idApp_Consultor']);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Agenda', 'CREATE', $data['auditoriaitem'], $data['idApp_Consultor']);

                $this->load->library('email');

                $this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
                $this->email->to($data['query']['Email']);

                $this->email->subject('[KTRACA] Confirma��o de registro - Usu�rio: ' . $data['query']['Usuario']);
                /*
                  $this->email->message('Por favor, clique no link a seguir para confirmar seu registro: '
                  . 'http://www.romati.com.br/app/loginconsultor/confirmar/' . $data['query']['Codigo']);

                  $this->email->send();

                  $data['aviso'] = ''
                  . '
                  <div class="alert alert-success" role="alert">
                  <h4>
                  <p><b>Usu�rio cadastrado com sucesso!</b></p>
                  <p>O link para ativa��o foi enviado para seu e-mail cadastrado.</p>
                  <p>Caso o e-mail com o link n�o esteja na sua caixa de entrada <b>verifique tamb�m sua caixa de SPAM</b>.</p>
                  </h4>
                  </div> '
                  . '';
                 */

                $this->email->message('Sua conta foi ativada com sucesso! Aproveite e teste todas as funcionalidades do sistema.'
                        . 'Qualquer sugest�o ou cr�tica ser� bem vinda. ');

                $this->email->send();

                $data['aviso'] = ''
                        . '
                  <div class="alert alert-success" role="alert">
                  <h4>
                  <p><b>Usu�rio cadastrado com sucesso!</b></p>
                  <p>Clique no bot�o abaixo e retorne para a tela de<strong> "Acesso dos Usu�rios da Empresa"</strong> ,para entrar no sistema.</p>
                  </h4>
                  <br>
                  <a class="btn btn-primary" href="' . base_url() . '" role="button">Acessar o Sistema</a>
                  </div> '
                        . '';

                $this->load->view('loginconsultor/tela_msg', $data);
                #redirect(base_url() . 'loginconsultor' . $data['msg']);
                #exit();
            }
        }

        $this->load->view('basico/footerloginconsultor');
        $this->load->view('basico/footer');
    }

    public function confirmar($codigo) {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'varejo';
        $_SESSION['log']['idTab_Modulo'] = 1;


        $data['anterior'] = array(
            'Inativo' => '1',
            'Codigo' => $codigo
        );

        $data['confirmar'] = array(
            'Inativo' => '0',
            'Codigo' => 'NULL'
        );

        $data['campos'] = array_keys($data['confirmar']);
        $id = $this->Loginconsultor_model->get_data_by_codigo($codigo);

        if ($this->Loginconsultor_model->ativa_usuario($codigo, $data['confirmar']) === TRUE) {

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['confirmar'], $data['campos'], $id['idApp_Consultor'], TRUE);
            $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consultor', 'UPDATE', $data['auditoriaitem'], $id['idApp_Consultor']);

            $data['msg'] = '?m=4';
            redirect(base_url() . 'loginconsultor/' . $data['msg']);
        } else {
            $data['msg'] = '?m=5';
            redirect(base_url() . 'loginconsultor/' . $data['msg']);
        }
    }

    public function recuperar() {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'varejo';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'Usuario',
                ), TRUE);

        if (isset($_GET['usuario']))
            $data['query']['Usuario'] = $_GET['usuario'];

        $this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

        $this->form_validation->set_rules('Usuario', 'Usuario', 'required|trim|callback_valid_usuario');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginconsultor view
            $this->load->view('loginconsultor/form_recuperar', $data);
        } else {

            $data['query']['Codigo'] = md5(uniqid(time() . rand()));

            $id = $this->Loginconsultor_model->get_data_by_usuario($data['query']['Usuario']);

            if ($this->Loginconsultor_model->troca_senha($id['idApp_Consultor'], array('Codigo' => $data['query']['Codigo'])) === FALSE) {

                $data['anterior'] = array(
                    'Codigo' => 'NULL'
                );

                $data['confirmar'] = array(
                    'Codigo' => $data['query']['Codigo']
                );

                $data['campos'] = array_keys($data['confirmar']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['confirmar'], $data['campos'], $id['idApp_Consultor'], TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consultor', 'UPDATE', $data['auditoriaitem'], $id['idApp_Consultor']);

                $this->load->library('email');

                $this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
                $this->email->to($id['Email']);

                $this->email->subject('[KTRACA] Altera��o de Senha - Usu�rio: ' . $data['query']['Usuario']);
                $this->email->message('Por favor, clique no link a seguir para alterar sua senha: '
                        //. 'http://www.romati.com.br/app/loginconsultor/trocar_senha/' . $data['query']['Codigo']);
                        . base_url() . 'loginconsultor/trocar_senha/' . $data['query']['Codigo']);

                $this->email->send();

                $data['aviso'] = ''
                        . '
                    <div class="alert alert-success" role="alert">
                        <h4>
                            <p><b>Link enviado com sucesso!</b></p>
                            <p>O link para alterar senha foi enviado para seu e-mail.</p>
                            <p>Caso o e-mail com o link n�o esteja na sua caixa de entrada <b>verifique tamb�m sua caixa de SPAM</b>.</p>
                        </h4>
                    </div> '
                        . '';

                #$data['msg'] = '?m=4';
                $this->load->view('loginconsultor/tela_msg', $data);
            } else {
                $data['msg'] = '?m=5';
                redirect(base_url() . 'loginconsultor/' . $data['msg']);
            }
        }
    }

    public function trocar_senha($codigo = NULL) {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'varejo';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idApp_Consultor',
            'Email',
            'Usuario',
            'Codigo',
                ), TRUE);

        if ($codigo) {
            $data['query'] = $this->Loginconsultor_model->get_data_by_codigo($codigo);
            $data['query']['Codigo'] = $codigo;
        } else {
            $data['query']['Codigo'] = $this->input->post('Codigo', TRUE);
        }

        $data['query']['Senha'] = $this->input->post('Senha', TRUE);
        $data['query']['Confirma'] = $this->input->post('Confirma', TRUE);

        $this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
        #$this->form_validation->set_rules('Codigo', 'C�digo', 'required|trim');
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginconsultor view
            $this->load->view('loginconsultor/form_troca_senha', $data);
        } else {

            ###n�o est� registrando a auditoria do trocar senha. tenho que ver isso
            ###ver tamb�m o link para troca, quando expirado avisar
            #$id = $data['query']['Senha']
            $data['query']['Senha'] = md5($data['query']['Senha']);
            $data['query']['Codigo'] = NULL;
            unset($data['query']['Confirma']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            if ($this->Loginconsultor_model->troca_senha($data['query']['idApp_Consultor'], $data['query']) === TRUE) {
                $data['msg'] = '?m=2';
                $this->load->view('loginconsultor/form_troca_senha', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consultor'], TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consultor', 'UPDATE', $data['auditoriaitem'], $data['query']['idApp_Consultor']);
                /*
                  echo $this->db->last_query();
                  echo "<pre>";
                  print_r($data);
                  echo "</pre>";
                  exit();
                 */
                $data['msg'] = '?m=1';
                redirect(base_url() . 'loginconsultor' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footerloginconsultor');
        $this->load->view('basico/footer');
    }

    public function sair($m = TRUE) {
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #set logout in database
        if ($_SESSION['log'] && $m === TRUE) {
            $this->Loginconsultor_model->set_acesso($_SESSION['log']['id'], 'LOGOUT');
        } else {
            if (!isset($_SESSION['log']['id'])) {
                $_SESSION['log']['id'] = 1;
            }
            $this->Loginconsultor_model->set_acesso($_SESSION['log']['id'], 'TIMEOUT');
            $data['msg'] = '?m=2';
        }

        #clear de session data
        $this->session->unset_userdata('log');
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage

        /*
          #load header view
          $this->load->view('basico/headerloginconsultor');

          $msg = "<strong>Voc� saiu do sistema.</strong>";

          $this->basico->alerta($msg);
          $this->load->view('loginconsultor');
          $this->load->view('basico/footer');
         *
         */

        redirect(base_url() . 'loginconsultor/' . $data['msg']);
        #redirect('loginconsultor');
    }

    function valid_usuario($data) {

        if ($this->Loginconsultor_model->check_usuario($data) == 1) {
            $this->form_validation->set_message('valid_usuario', '<strong>%s</strong> n�o existe.');
            return FALSE;
        } else if ($this->Loginconsultor_model->check_usuario($data) == 2) {
            $this->form_validation->set_message('valid_usuario', '<strong>%s</strong> inativo! Fale com o Administrador da sua Empresa!');
            return FALSE;
        } else if ($this->Loginconsultor_model->check_usuario($data) == 3) {
            $this->form_validation->set_message('valid_usuario', '<strong>%s</strong> Acesso Errado! Entre pelo Acesso Correto!');
            return FALSE;		
		} else {
            return TRUE;
        }
    }
	


    function valid_senha($senha, $usuario) {

        if ($this->Loginconsultor_model->check_dados_usuario($senha, $usuario) == FALSE) {
            $this->form_validation->set_message('valid_senha', '<strong>%s</strong> incorreta! Ou este n�o � o M�dulo do seu Sistema.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	

}
