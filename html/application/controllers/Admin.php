<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

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
	public function __construct()
	{//PHP_SELF
		parent::__construct();
		if ( $this->session->has_userdata('language') )
		{
			if ( $this->session->userdata('language') == '' || $this->session->userdata('language') == null )
			{
				$this->lang->load('Admin_lang', $this->config->item('language') );
			}
			else
			{
				$this->lang->load('Admin_lang', $this->session->userdata('language') );
			}
		}
		else
		{
			$this->lang->load('Admin_lang', $this->config->item('language') );
		}
	}

	public function index()
	{
		$this->load->view( 'login' );
	}

	public function adminmenu()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$arrGroup = $this->dbAdmin->grouplist()->result_array();

		$arrAuth = $this->checkAuth();
		$this->load->view( 'adminmenu', array( 'arrGroup' => $arrGroup, 'arrAuth' => $arrAuth ) );
	}

	public function menulist()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		echo json_encode( $this->dbAdmin->menufulllist()->result_array(), JSON_UNESCAPED_UNICODE );
	}

	public function menudel()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		if ( $this->dbAdmin->menudel($this->input->post('id')) == 1 )
		{
			$this->dbAdmin->adminLoginsert( '관리툴 메뉴 삭제', '_id => '.$this->input->post('id'), $this->input->post('uid') );
			var_export(true);
		}
		else
		{
			var_export(false);
		}
	}

	public function menudetails()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$arrResult = $this->dbAdmin->menudetails( $this->input->post('id') )->result_array();
		if ( !empty($arrResult) )
		{
			echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
		}
		else
		{
			echo '[]';
		}
	}

	public function menuupdate()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		if ( $this->input->post('_id') == '' || $this->input->post('_id') == null )
		{
			$result = $this->dbAdmin->menuinsert(
				$this->input->post('_title_kr'), $this->input->post('_controller'), $this->input->post('_view'),
				$this->input->post('_icon'), $this->input->post('_group_id'), $this->input->post('_active')
			);
			$this->dbAdmin->adminLoginsert( '관리툴 메뉴 추가', '_id => '.$result, $this->input->post('uid') );
		}
		else
		{
			$result = boolval( $this->dbAdmin->menuupdate(
				$this->input->post('_title_kr'), $this->input->post('_controller'), $this->input->post('_view'),
				$this->input->post('_icon'), $this->input->post('_group_id'), $this->input->post('_active'), $this->input->post('_id')
			) );
			$this->dbAdmin->adminLoginsert( '관리툴 메뉴 수정', '_id => '.$this->input->post('_id').'\n_title_kr => '.$this->input->post('_title_kr').'\n_controller => '.$this->input->post('_controller').'\n_view => '.$this->input->post('_view').'\n_icon => '.$this->input->post('_icon').'\n_group_id => '.$this->input->post('_group_id').'\n_active => '.$this->input->post('_active'), $this->input->post('uid') );
		}

		var_export( boolval( $result ) );
	}

	public function menuorder()
	{
		$result = true;
		$this->load->model('Model_Admin', 'dbAdmin');
		foreach( $this->input->post() as $key => $val )
		{
			$strLog = '';
			$isChanged = false;
			$subResult = boolval( $this->dbAdmin->menuorder( str_replace( 'order-', '', $key ), $val ) );
			$result = $result || $subResult;
			if ( $subResult )
			{
				if ( $strLog != '' )
				{
					$strLog .= ',';
				}
				$strLog .= ' _id => '.$key.', _order => '.$val.'';
				$isChanged = true;
			}
			if ( $isChanged )
			{
				$this->dbAdmin->adminLoginsert( '관리툴 메뉴 순서 수정', $strLog, $this->input->post('uid') );
			}
		}

		var_export( boolval($result) );
	}

	public function adminaccount()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$arrGroup = $this->dbAdmin->admingrouplist()->result_array();

		$arrAuth = $this->checkAuth();
		$this->load->view( 'adminaccount', array( 'arrGroup' => $arrGroup, 'arrAuth' => $arrAuth ) );
	}

	public function accountlist()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$arrResult = $this->dbAdmin->accountlist()->result_array();

		echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
	}

	public function accountdetails()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$arrResult = $this->dbAdmin->accountdetails( $this->input->post('_useraccount') )->result_array();

		echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
	}

	public function accountupdate()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		if ( $this->input->post('_approved') == '2' )
		{
			$_deleted = '1';
			$_approved = '1';
		}
		else
		{
			$_deleted = '0';
			$_approved = $this->input->post('_approved');
		}

		$result = boolval( $this->dbAdmin->accountupdate( $this->input->post('_username'), $this->input->post('_name'), $this->input->post('_reason'),
				$this->input->post('_depart'), $this->input->post('_auth'), $_approved, $_deleted
		) );
		$this->dbAdmin->adminLoginsert( '관리자 승인상태 변경', '_username => '.$this->input->post('_username').'\n_auth => '.$this->input->post('_auth').'\n_approved => '.$this->input->post('_title_kr').'\n_reason => '.$this->input->post('_reason').'', $this->input->post('uid') );
		var_export($result);
	}

	public function accountpassword()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$result = boolval( $this->dbAdmin->accountpassword( $this->input->post('_username') ) );
		$this->dbAdmin->adminLoginsert( '관리자 암호 리셋', '_username => '.$this->input->post('_username').'', $this->input->post('uid') );

		var_export($result);
	}

	public function accountlog()
	{
		echo json_encode( array(
				array('_regdate' => '2016-02-12 17:23:04', '_admin_id' => $this->input->post('admin_id'), '_logdetails' => '계정 삭제' ),
				array('_regdate' => '2016-01-09 17:23:04', '_admin_id' => $this->input->post('admin_id'), '_logdetails' => '비번 초기화' ),
				array('_regdate' => '2015-12-31 01:03:04', '_admin_id' => $this->input->post('admin_id'), '_logdetails' => '권한 부여 - HGM' ),
				array('_regdate' => '2015-12-10 17:28:22', '_admin_id' => $this->input->post('admin_id'), '_logdetails' => '권한 부여 - GM' ),
				array('_regdate' => '2015-12-10 17:23:04', '_admin_id' => $this->input->post('admin_id'), '_logdetails' => '계정 승인 - wjswlgus01' )
		), JSON_UNESCAPED_UNICODE );
	}

	public function adminauth()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$arrGroup = $this->dbAdmin->admingrouplist()->result_array();

		$arrAuth = $this->checkAuth();
		$this->load->view( 'adminauth', array( 'arrGroup' => $arrGroup, 'arrAuth' => $arrAuth ) );
	}

	public function admingroupauth()
	{
		$this->load->model('Model_Admin', 'dbAdmin');

		echo json_encode( $this->dbAdmin->admingroupauth( $this->input->post('group_id') )->result_array(), JSON_UNESCAPED_UNICODE );
	}

	public function authupdate()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$arrData = json_decode(json_decode($this->input->post('data'), true), true);
		$result = 0;
		foreach( $arrData as $key => $val )
		{
			$result += intval( $this->dbAdmin->adminauthupdate( $this->input->post('group_id'), $val['key'], $val['val']['view'], $val['val']['write'] ) );
			$this->dbAdmin->adminLoginsert( '권한 관리 수정', '_group_id => '.$this->input->post('group_id').'\n_menu_id => '.$val['key'].'\n_auth_view => '.$val['val']['view'].'\n_auth_write => '.$val['val']['write'].'', $this->input->post('uid') );
		}
		$arrResult = $this->dbAdmin->adminauthparentvalue( $this->input->post('group_id') )->result_array();
		foreach ( $arrResult as $row )
		{
			$result += intval( $this->dbAdmin->adminauthupdate( $this->input->post('group_id'), $row['_parent_id'], ( boolval( $row['sumval'] ) ? 'true' : 'false' ), ( boolval( $row['sumval'] ) ? 'true' : 'false' ) ) );
			$this->dbAdmin->adminLoginsert( '권한 관리 수정', '_group_id => '.$this->input->post('group_id').'\n_menu_id => '.$row['_parent_id'].'\n_auth_view => '.boolval( $row['sumval'] ).'\n_auth_write => '.boolval( $row['sumval'] ).'', $this->input->post('uid') );
		}

		echo $result;
	}

	public function groupnamecheck()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		var_export( $this->dbAdmin->groupnamecheck( $this->input->post('group_name') ) );
	}

	public function groupinsert()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		var_export( $this->dbAdmin->authgroupinsert( $this->input->post('group_name'), $this->input->post('group_applies') ) );
	}

	public function groupdelete()
	{
		$result = true;
		$this->load->model('Model_Admin', 'dbAdmin');
		$result = $result & boolval( $this->dbAdmin->authdelete( $this->input->post('group_id') ) );
		$result = $result & boolval( $this->dbAdmin->authgroupdelete( $this->input->post('group_id') ) );
		var_export( boolval( $result ) );
	}

	public function adminlog()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$arrGroup = $this->dbAdmin->grouplist()->result_array();

		$this->load->view( 'adminlog', array( 'arrGroup' => $arrGroup ) );
	}

	public function adminloglist()
	{

		$this->load->model('Model_Admin', 'dbAdmin');
		$arrLog = $this->dbAdmin->adminlog( $this->input->post('daterange1'), $this->input->post('daterange2'), $this->input->post('search_type'), $this->input->post('search_value'), $this->input->post('log_type') )->result_array();

		echo json_encode( $arrLog, JSON_UNESCAPED_UNICODE );
	}
}
