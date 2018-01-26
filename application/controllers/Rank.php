<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rank extends MY_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('dashboard', array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname')));
	}

	public function cashrank()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'));

		$this->load->view('cashrank', $arrayParam);
	}

	public function ranklist()
	{
    	$this->redis = new CI_Redis();
		$this->reflection = new ReflectionMethod('CI_Redis', '_encode_request');
		$this->reflection->setAccessible(TRUE);
		$this->redis->command('SELECT 6');

		if ( ENVIRONMENT != 'production' )
		{
			$arrResult = $this->redis->command( 'ZREVRANGEBYSCORE rsg_qa|user_rank|'.$this->input->post('type').' +inf -inf WITHSCORES' );
		}
		else
		{
			$arrResult = $this->redis->command( 'ZREVRANGEBYSCORE rsg|user_rank|cash'.$this->input->post('type').' +inf -inf WITHSCORES' );
		}
var_dump($arrResult);
//		echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
	}
}
?>