<?php
class MY_Controller extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->driver('cache');
		if ( isset($this->session->userdata) )
		{
			if ( !array_key_exists('admin_id', $this->session->userdata) )
			{
				if ( $this->router->fetch_class() != 'Login' )
				{
					if ( $this->session->has_userdata('admin_id') && $this->session->has_userdata('admin_auth') )
					{
						if ( $this->session->userdata('admin_id') == '' || $this->session->userdata('admin_id') == null )
						{
							if ( array_key_exists( 'HTTP_X_REQUESTED_WITH', $this->input->server() ) )
							{
								header("HTTP/1.0 901 Session Timeout");
								$this->output->_display();
								exit;
							}
							else
							{
								$this->session->set_userdata( array( 'admin_auth' => 0 ) );
								$this->load->view('alertlocationview', array(
									'alertprefix' => 'Oops...',
									'alertstring' => $this->lang->line('need_to_login'),
									'alerttype' => 'error',
									'afterlocation' => '/Login',
								));
								$this->output->_display();
								exit;
							}
						}
					}
					else
					{
						if ( $this->input->server('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest' )
						{
							header("HTTP/1.0 901 Session Timeout");
							$this->output->_display();
							exit;
						}
						else
						{
							$this->session->set_userdata( array( 'admin_auth' => 0 ) );
							$this->load->view('alertlocationview', array(
								'alertprefix' => 'Oops...',
								'alertstring' => $this->lang->line('need_to_login'),
								'alerttype' => 'error',
								'afterlocation' => '/Login',
							));
							$this->output->_display();
							exit;
						}
					}
				}
			}
		}

		if ( $this->input->post('searchval') != '' && $this->input->post('searchval') != null )
		{
			$this->session->set_userdata( array('searchval' => $this->input->post('searchval')) );
		}

		if ( $this->input->post('searchuid') != '' && $this->input->post('searchuid') != null )
		{
			$this->session->set_userdata( array('searchuid' => $this->input->post('searchuid')) );
		}

		if ( $this->input->post('searchname') != '' && $this->input->post('searchname') != null )
		{
			$this->session->set_userdata( array('searchname' => $this->input->post('searchname')) );
		}
	}

	function __destruct(){
	}

	function index()
	{
		return;
	}

	function RS_ENCRYPT( $string, $key = NULL )
	{
		$key = $key == NULL ? $this->config->item('encryption_key') : $key;
		return urlencode(base64_encode(openssl_encrypt($string, "aes-256-cbc", $key, true, str_repeat(chr(0), 16))));
    }

    function RS_DECRYPT( $encrypted_string, $key = NULL )
    {
		$key = $key == NULL ? $this->config->item('encryption_key') : $key;
		return openssl_decrypt(base64_decode(urldecode($encrypted_string)), "aes-256-cbc", $key, true, str_repeat(chr(0), 16));
    }

	function generateRandomString( $length )
	{
		$charactersAtFirstBit = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	    	if ($i == 0)
	    	{
		        $randomString .= $charactersAtFirstBit[rand(0, strlen($charactersAtFirstBit) - 1)];
	    	}
	    	else
	    	{
		        $randomString .= $characters[rand(0, strlen($characters) - 1)];
		    }
	    }
	    return $randomString;
	}

	function checkauth()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$arrAuth = $this->dbAdmin->loadauth( explode( '/', $this->uri->uri_string() ) )->result_array();

		if ( empty( $arrAuth ) )
		{
			$this->load->view('alertlocationview', array(
				'alertprefix' => 'Oops...',
				'alertstring' => '권한이 없습니다.',
				'alerttype' => 'error',
				'afterlocation' => 'history.back()',
			));
			$this->output->_display();
			exit;
		}
		else
		{
			$arrAuth = $arrAuth[0];
			if ( intval( $arrAuth['_auth_view'] ) < 1 )
			{
				$this->load->view('alertlocationview', array(
					'alertprefix' => 'Oops...',
					'alertstring' => '권한이 없습니다.',
					'alerttype' => 'error',
					'afterlocation' => 'history.back()',
				));
				$this->output->_display();
				exit;
			}
		}

		return $arrAuth;
	}

}