<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('login');
	}

	public function forgotpassword()
	{
		$this->load->view('forgotpassword');
	}

	public function resetpassword()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		if ( empty($this->dbAdmin->select_user_by_email($this->input->post('reminder-email'))->result_array()) )
		{
			$this->load->view('alertlocationview', array(
				'alertprefix' => 'Oops...',
				'alertstring' => '입력한 이메일에 해당하는 아이디가 존재하지 않습니다.',
				'alerttype' => 'error',
				'afterlocation' => '/Login/forgotpassword',
			));
		}
		else
		{
			$rand_string = $this->generateRandomString(30);
			if ( $this->dbAdmin->insert_user_pass_temp($this->input->post('reminder-email'), $rand_string) > 0 )
			{
				$this->load->library('email');
				$this->email->from('admin@rythemstar.com', '리듬스타운영툴');
				$this->email->to($this->input->post('reminder-email'));
				$this->email->subject('리듬스타 운영툴 암호 변경');
				$strMessage = '본메일은 리듬스타 운영툴 암호 변경을 위한 메일입니다.'.PHP_EOL;
				$strMessage .= '암호변경을 신청하신 내용이 없으면 해당 메일을 삭제해주세요.'.PHP_EOL;
				$strMessage .= PHP_EOL;
				$strMessage .= '암호변경을 신청하셨으면 아래 링크를 클릭하세요.'.PHP_EOL;
				$strMessage .= 'http://'.$this->input->server('SERVER_NAME').'/Login/changepassword/'.$this->RS_ENCRYPT($this->input->post('reminder-email')).'/'.$rand_string;
				$this->email->message($strMessage);

				if ( $this->email->send() )
				{
					$this->load->view('alertlocationview', array(
						'alertprefix' => 'Success',
						'alertstring' => '메일이 발송되었습니다. 메일함을 확인하세요.',
						'alerttype' => 'success',
						'afterlocation' => '/Login',
					));
				}
				else
				{
					$this->load->view('alertlocationview', array(
						'alertprefix' => 'Oops...',
						'alertstring' => '메일 발송이 실패하였습니다. 관리자에게 문의하세요.',
						'alerttype' => 'error',
						'afterlocation' => '/Login',
					));
				}
			}
			else
			{
				$this->load->view('alertlocationview', array(
					'alertprefix' => 'Oops...',
					'alertstring' => '난수 생성이 실패하였습니다. 관리자에게 문의하세요.',
					'alerttype' => 'error',
					'afterlocation' => '/Login',
				));
			}
		}
	}

	public function changepassword( $email, $rand_string )
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$admin_user_change_log = $this->dbAdmin->select_change_log_by_email($this->RS_DECRYPT($email))->result_array();
		if ( empty($admin_user_change_log) )
		{
			$this->load->view('alertlocationview', array(
				'alertprefix' => 'Oops...',
				'alertstring' => '요청되지 않은 내용입니다. 암호변경을 처음부터 다시 진행해주세요.',
				'alerttype' => 'error',
				'afterlocation' => '/Login/forgotpassword',
			));
		}
		else
		{
			$admin_idx_max = max(array_column($admin_user_change_log, 'idx'));
			$expire = false;
			$difference = false;
			foreach ( $admin_user_change_log as $row )
			{
				if ( $row['rand_string'] == $rand_string )
				{
					if ( $admin_idx_max == $row['idx'] )
					{
						echo '<script type="text/javascript">location.href="/Login/changepass/'.$row['idx'].'";</script>';
						exit();
					}
					else
					{
						$expire = true;
					}
				}
				else
				{
					$difference = true;
				}
			}

			if ( $expire )
			{
				$this->load->view('alertlocationview', array(
					'alertprefix' => 'Oops...',
					'alertstring' => '만료된 토큰입니다. 암호변경을 처음부터 다시 진행해주세요.',
					'alerttype' => 'error',
					'afterlocation' => '/Login/forgotpassword',
				));
			}
			else if ( $difference )
			{
				$this->load->view('alertlocationview', array(
					'alertprefix' => 'Oops...',
					'alertstring' => '토큰이 일치하지 않습니다. 암호변경을 처음부터 다시 진행해주세요.',
					'alerttype' => 'error',
					'afterlocation' => '/Login/forgotpassword',
				));
			}
			else
			{
				$this->load->view('alertlocationview', array(
					'alertprefix' => 'Oops...',
					'alertstring' => '알수 없는 오류입니다. 암호변경을 처음부터 다시 진행해주세요.',
					'alerttype' => 'error',
					'afterlocation' => '/Login/forgotpassword',
				));
			}
		}
	}

	public function changepass( $idx )
	{
		$this->load->view('changepass', array( 'idx' => $idx ) );
	}

	public function savepass()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		if ( $this->dbAdmin->update_admin_user_password($this->input->post('val-idx'), $this->input->post('val-password')) > 0 )
		{
			$this->load->view('alertlocationview', array(
				'alertprefix' => 'Success',
				'alertstring' => '암호변경이 완료되었습니다. 로그인화면으로 돌아갑니다.',
				'alerttype' => 'success',
				'afterlocation' => '/Login',
			));
		}
		else
		{
			$this->load->view('alertlocationview', array(
				'alertprefix' => 'Oops...',
				'alertstring' => '암호변경이 실패 되었습니다. 처음부터 다시 진행해주세요.',
				'alerttype' => 'error',
				'afterlocation' => '/Login/forgotpassword',
			));
		}
	}

	public function act()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$arrResult = $this->dbAdmin->select_admin_user_with_id_password($this->input->post('login-username'), $this->input->post('login-password'))->result_array();
		if ( count($arrResult) > 0 )
		{
			$this->session->set_userdata( array( 'admin_id' => $this->input->post('login-username' ), 'admin_auth' => $arrResult[0]['_auth'] ) );
			echo '<script type="text/javascript">location.href="/Dashboard/index";</script>';
		}
		else
		{
			$this->load->view('alertlocationview', array(
				'alertprefix' => 'Oops...',
				'alertstring' => '아이디 또는 암호가 일치하지 않습니다. 다시 로그인해주세요.',
				'alerttype' => 'error',
				'afterlocation' => '/Login',
			));
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		echo '<script type="text/javascript">location.href="/Login";</script>';
	}

	public function checkpw()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		if ( $this->dbAdmin->select_admin_user_with_id_password($this->session->userdata('admin_id'), $this->input->post('passwd')) > 0 )
		{
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}

	public function register()
	{
		$this->load->view( 'register' );
	}

	public function duplicationcheck()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		if ( $this->dbAdmin->selectUsername( $this->input->post('register-username') ) )
		{
			echo 'false';
		}
		else
		{
			echo 'true';
		}
	}

	public function registeraction()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		if ( $this->dbAdmin->insertUser(
					$this->input->post('register-username'), $this->input->post('register-password'), $this->input->post('register-name'), $this->input->post('register-email'),
					$this->input->post('register-depart'), $this->input->post('register-reason')
			)
		)
		{
			$this->load->view('alertlocationview', array(
				'alertprefix' => 'Success',
				'alertstring' => '계정 신청이 완료 되었습니다.',
				'alerttype' => 'success',
				'afterlocation' => '/Login',
			));
		}
		else
		{
			$this->load->view('alertlocationview', array(
				'alertprefix' => 'Oops...',
				'alertstring' => '계정 신청이 실패 하였습니다.',
				'alerttype' => 'error',
				'afterlocation' => '/Login/register',
			));
		}
	}

}
