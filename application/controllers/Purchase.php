<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends MY_Controller {

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
		$this->load->view('dashboard', array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname')));
	}

	public function setfcash()
	{
		$gold = $this->cimongo->where( array( 'uid' => $this->input->post( 'uid' ) ) )->get('user')->result_array()[0]['fcash'];
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '무료캐시변경', $gold.' => '.( $gold + $this->input->post('change_amount') ), $this->input->post('uid') );
		echo boolval( $this->cimongo->where( array( 'uid' => $this->input->post( 'uid' ) ) )->set(
						array(
							'fcash' => new MongoInt32( $gold + $this->input->post('change_amount') )
						)
		)->update('user') );
	}

	public function setpcash()
	{
		$gold = $this->cimongo->where( array( 'uid' => $this->input->post( 'uid' ) ) )->get('user')->result_array()[0]['pcash'];
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '유료캐시변경', $gold.' => '.( $gold + $this->input->post('change_amount') ), $this->input->post('uid') );
		echo boolval( $this->cimongo->where( array( 'uid' => $this->input->post( 'uid' ) ) )->set(
						array(
							'pcash' => new MongoInt32( $gold + $this->input->post('change_amount') )
						)
		)->update('user') );
	}

	public function purchaselog()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'));

		$this->load->view('purchaselog', $arrayParam);
	}

	public function purchaseloglist()
	{
		if ( $this->session->userdata('searchuid') == '' || $this->input->post('start_date') == '' || $this->input->post('end_date') == ''
			|| $this->session->userdata('searchuid') == null || $this->input->post('start_date') == null || $this->input->post('end_date') == null
		)
		{
			echo json_encode( array(), JSON_UNESCAPED_UNICODE );
			exit;
		}

		$this->load->model('Model_Log', 'dbLog');

		$arrResult = $this->dbLog->purchase_loglist(
			$this->session->userdata('searchuid'),
			str_replace( '-', '', $this->input->post('start_date') ),
			str_replace( '-', '', $this->input->post('end_date') )
			)->result_array();

		echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
	}

	public function purchaseloglist_refund()
	{
		if ( $this->session->userdata('searchuid') == null
			|| $this->session->userdata('searchuid') == '' 
			|| $this->input->post('id_') == null
			|| $this->input->post('id_') == ''
		)
		{
			echo 'false1';
		}

		$query = $this->cimongo->get_where( 'user', array( 'uid' => $this->session->userdata('searchuid') ) );
		$user = $query->result_array()[0];
		$lv = $user['lv'];
		$pcash = $user['pcash'];
		$fcash = $user['fcash'];
		$cash = $pcash + $fcash;

		$refund_pcash = (int)$this->input->post('pcash');
		$refund_fcash = (int)$this->input->post('fcash');

		if ($pcash < $refund_pcash || $fcash < $refund_fcash) {
			echo 'false1';
			return;
		}

		$result =  $this->cimongo->where(
			array( 'uid' => $this->session->userdata('searchuid') ) 
			)->inc(
				array(
					'pcash' => new MongoInt32(-$refund_pcash),
					'fcash' => new MongoInt32(-$refund_fcash),
				)
			)->update('user');

		$this->load->model('Model_Log', 'dbLog');
		$this->dbLog->purchase_refund(
			array(
				'id'=>$this->input->post('id_')
				,'uid'=>$this->session->userdata('searchuid')
				,'lv'=>$lv
				,'cash'=>-($refund_fcash+$refund_pcash)
				,'fcash'=>-$refund_fcash
				,'pcash'=>-$refund_pcash
				,'total_cash'=>$cash-($refund_fcash+$refund_pcash)
				,'total_fcash'=>$cash-$refund_fcash
				,'total_pcash'=>$cash-$refund_pcash
				,'order_id'=>$this->input->post('order_id')
				,'admin_id'=>$this->session->userdata('admin_id')
			)
		);
		
		echo 'true';
	}

	public function purchaseloglist_refund_cancel()
	{
		if ( $this->session->userdata('searchuid') == null
			|| $this->session->userdata('searchuid') == '' 
			|| $this->input->post('id_') == null
			|| $this->input->post('id_') == ''
		)
		{
			echo 'false1';
		}

		$query = $this->cimongo->get_where( 'user', array( 'uid' => $this->session->userdata('searchuid') ) );
		$user = $query->result_array()[0];
		$lv = $user['lv'];
		$pcash = $user['pcash'];
		$fcash = $user['fcash'];
		$cash = $pcash + $fcash;

		$refund_pcash = (int)$this->input->post('pcash');
		$refund_fcash = (int)$this->input->post('fcash');

		$result =  $this->cimongo->where(
			array( 'uid' => $this->session->userdata('searchuid') ) 
			)->inc(
				array(
					'pcash' => new MongoInt32($refund_pcash),
					'fcash' => new MongoInt32($refund_fcash),
				)
			)->update('user');

		$this->load->model('Model_Log', 'dbLog');
		$this->dbLog->purchase_refund_cancel(
			array(
				'id'=>$this->input->post('id_')
				,'uid'=>$this->session->userdata('searchuid')
				,'lv'=>$lv
				,'cash'=>($refund_fcash+$refund_pcash)
				,'fcash'=>$refund_fcash
				,'pcash'=>$refund_pcash
				,'total_cash'=>$cash+($refund_fcash+$refund_pcash)
				,'total_fcash'=>$cash+$refund_fcash
				,'total_pcash'=>$cash+$refund_pcash
				,'order_id'=>$this->input->post('order_id')
				,'admin_id'=>$this->session->userdata('admin_id')
			)
		);
		
		echo 'true';
	}

	public function orderid()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'));

		$this->load->view('orderid', $arrayParam);
	}

	public function orderid_request()
	{
		$validation_key = $this->input->post('validation_key');
		$ret = $this->curl->simple_post(PLATFORM_URL.'/payment/requestRefund', array('validation_key'=>$validation_key));

		$ret = json_decode($ret, true);

		if (isset($ret['status']) == false || $ret['status']['retcode'] != 0) {
			echo '[]';
			return;
		}

		$arrResult = array();
		array_push($arrResult, 
				array(
					'validation_key' => $validation_key,
					'order_id' => $ret['orderId'],
					'uid' => $ret['uid'],
					'market' => $ret['market'],
					'created_at' => $ret['created_at'],
					'state' => $ret['state']
				)
			);

		echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
	}

	public function orderid_finishrefund()
	{
		$ret = $this->curl->simple_post(PLATFORM_URL.'/payment/finishRefund', 
			array(
				'validation_key'=>$this->input->post('validation_key'),
				'uid'=>$this->input->post('uid')
			)
		);
				
		$ret = json_decode($ret, true);
		if (isset($ret['status']) == false || $ret['status']['retcode'] != 0) {
		 	echo 'false';
		 	return;
		}
		//$this->load->model('Model_Admin', 'dbAdmin');
		//$this->dbAdmin->adminLoginsert( '로그인선물삭제', 'push_id => '.$push_id );

		echo 'true';
	}
}
