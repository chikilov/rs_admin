<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stat extends MY_Controller {

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
		if ( !( in_array( $this->session->userdata('admin_id'), array('jhkim', 'nara', 'jjo', 'anbsoft', 'jwjung', 'chikilov') ) ) )
		{
			echo "<script type=\"text/javascript\">alert('권한이 없습니다.');history.back();</script>";
			exit;
		}
	}

	public function index()
	{
		$this->load->view('dashboard', array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname')));
	}

	public function statlist1()
	{
		$this->load->model('Model_Log', 'dbLog');
		$arrLimit = $this->dbLog->getminlimit('game_log')->result_array();
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'), 'limitdate' => ( $arrLimit[0]['table_name'] == null ? '-' : $arrLimit[0]['table_name']) );

		$this->load->view('statlist1', $arrayParam);
	}

	public function statinfo1()
	{
		$this->load->model('Model_Log', 'dbLog');
		$arrResult = array();
		$arrResult[0]['date'] = $this->input->post('searchdate');
		$arrResult[0]['cnt1'] = $this->dbLog->statinfo1_1( str_replace('-', '', $this->input->post('searchdate')) )->result_array()[0]['cnt'];
		$arrResult[0]['cnt2'] = $this->dbLog->statinfo1_2( str_replace('-', '', $this->input->post('searchdate')) )->result_array()[0]['cnt'];

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function statlist2()
	{
		$this->load->model('Model_Log', 'dbLog');
		$arrLimit = $this->dbLog->getminlimit('userinfo_backup')->result_array();

		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'), 'limitdate' => ( $arrLimit[0]['table_name'] == null ? '-' : $arrLimit[0]['table_name']) );

		$this->load->view('statlist2', $arrayParam);
	}

	public function statinfo2()
	{
		$this->load->model('Model_Log', 'dbLog');
		$arrResult = $this->dbLog->statinfo2( str_replace('-', '', $this->input->post('searchdate')) )->result_array();

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function statlist3()
	{
		$this->load->model('Model_Log', 'dbLog');
		$arrLimit = $this->dbLog->getminlimit('userinfo_backup')->result_array();
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'), 'limitdate' => ( $arrLimit[0]['table_name'] == null ? '-' : $arrLimit[0]['table_name']) );

		$this->load->view('statlist3', $arrayParam);
	}

	public function statinfo3()
	{
		$this->load->model('Model_Log', 'dbLog');
		$arrResult = $this->dbLog->statinfo3( str_replace('-', '', $this->input->post('searchdate')) )->result_array();

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function statlist4()
	{
		$this->load->model('Model_Log', 'dbLog');
		$arrLimit = $this->dbLog->getminlimit('game_log')->result_array();
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'), 'limitdate' => ( $arrLimit[0]['table_name'] == null ? '-' : $arrLimit[0]['table_name']) );

		$this->load->view('statlist4', $arrayParam);
	}

	public function statinfo4()
	{
		$this->load->model('Model_Log', 'dbLog');
		$arrResult = $this->dbLog->statinfo4( str_replace('-', '', $this->input->post('searchdate')) )->result_array();

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function statlist5()
	{
		$this->load->model('Model_Log', 'dbLog');
		$arrLimit = $this->dbLog->getminlimit('userinfo_backup')->result_array();
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'), 'limitdate' => ( $arrLimit[0]['table_name'] == null ? '-' : $arrLimit[0]['table_name']) );

		$this->load->view('statlist5', $arrayParam);
	}

	public function statinfo5()
	{
		$this->load->model('Model_Log', 'dbLog');
		$arrResult = $this->dbLog->statinfo5( str_replace('-', '', $this->input->post('searchdate')) )->result_array();

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function statlist6()
	{
		$this->load->model('Model_Log', 'dbLog');
		$arrLimit = $this->dbLog->getminlimit('userinfo_backup')->result_array();
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'), 'limitdate' => ( $arrLimit[0]['table_name'] == null ? '-' : $arrLimit[0]['table_name']) );

		$this->load->view('statlist6', $arrayParam);
	}

	public function statinfo6()
	{
		$this->load->model('Model_Log', 'dbLog');
		$arrResult = $this->dbLog->statinfo6( str_replace('-', '', $this->input->post('searchdate')) )->result_array();

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}

	public function statlist7()
	{
		$this->load->model('Model_Log', 'dbLog');
		$arrLimit = $this->dbLog->getminlimitarray( array( 'cash_log', 'gold_log' ) )->result_array();
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'), 'limitdate' => ( $arrLimit[0]['table_name'] == null ? '-' : $arrLimit[0]['table_name']) );

		$this->load->view('statlist7', $arrayParam);
	}

	public function statinfo7()
	{
		$this->load->model('Model_Log', 'dbLog');
		$arrResult = array();
		$arrResult = $this->dbLog->statinfo7( str_replace('-', '', $this->input->post('searchdate')) )->result_array();
		foreach( $arrResult as $key => $val )
		{
			if ( $val['type'] == 'item' )
			{
				if ( array_key_exists( $val['value1'], ITEMNAMEARRAY ) )
				{
					$arrResult[$key]['itemname'] = ITEMNAMEARRAY[$val['value1']];
				}
				else
				{
					$arrResult[$key]['itemname'] = $val['value1'];
				}
			}
			else if ( $val['type'] == 'song' )
			{
				if ( array_key_exists( $val['value1'], SONGOPENARRAY ) )
				{
					$arrResult[$key]['itemname'] = SONGOPENARRAY[$val['value1']];
				}
				else
				{
					$arrResult[$key]['itemname'] = $val['value1'];
				}
			}
			else
			{
				$arrResult[$key]['itemname'] = $val['value1'];
			}
		}

		echo json_encode($arrResult, JSON_UNESCAPED_UNICODE);
	}
}
