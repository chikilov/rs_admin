<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Present extends MY_Controller {

	public $platform_url = PLATFORM_URL;

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

	public function presentsend()
	{
		$arrayItem = $this->cimongo->get('rs_table_item')->result_array();
		$arrMessage = $this->cimongo->get('rs_table_server_text')->result_array();
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'), 'arrMessage' => $arrMessage, 'arrItem' => $arrayItem );

		$this->load->view('presentsend', $arrayParam);
	}

	public function presentsendaction()
	{
		$definedkey = '';
		while ( $definedkey == '' )
		{
			$key = $this->generateRandomString(20);
			if ( empty( $this->cimongo->where( array( 'key' => $key ) )->get('on_time_reward')->result_array() ) )
			{
				$definedkey = $key;
			}
		}
		$query = $this->cimongo->insert( 'on_time_reward', array(
							'key' => $definedkey,
							'begin_at'=> new MongoDate(strtotime($this->input->post('begin_at'))),
							'end_at'=> new MongoDate(strtotime($this->input->post('end_at'))),
							'item_id'=> new MongoInt32($this->input->post('item_id')),
							'msg_id'=> new MongoInt32($this->input->post('sendtext')),
							'count'=> new MongoInt32($this->input->post('v1'))
						)
		);

		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '전체선물지급', 'key => '.$definedkey.'\nbegin_at => '.$this->input->post('begin_at').'\nend_at => '.$this->input->post('end_at').'\nitem_id => '.$this->input->post('item_id').'\nmsg_id => '.$this->input->post('sendtext').'\ncount => '.$this->input->post('v1') );
		$this->dbAdmin->presentLogging( date('Y-m-d H:i:s', strtotime($this->input->post('begin_at'))), date('Y-m-d H:i:s', strtotime($this->input->post('end_at'))), $this->input->post('item_id'), $this->input->post('sendtext'), $this->input->post('admin_memo'), $this->input->post('v1'), $definedkey );
		if ( $query == 1 )
		{
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}

	public function presentsendeditaction()
	{
		$this->cimongo->where(array( 'key' => $this->input->post('mongokey') ) );
		$query = $this->cimongo->update( 'on_time_reward', array(
						'begin_at'=> new MongoDate(strtotime($this->input->post('begin_at'))),
						'end_at'=> new MongoDate(strtotime($this->input->post('end_at'))),
						'item_id'=> new MongoInt32($this->input->post('item_id')),
						'msg_id'=> new MongoInt32($this->input->post('sendtext')),
						'count'=> new MongoInt32($this->input->post('v1'))
				)
		);
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '전체선물지급수정', 'key => '.$this->input->post('mongokey').'\nbegin_at => '.$this->input->post('begin_at').'\nend_at => '.$this->input->post('end_at').'\nitem_id => '.$this->input->post('item_id').'\nmsg_id => '.$this->input->post('sendtext').'\ncount => '.$this->input->post('v1').'\nidx => '.$this->input->post('idx') );
		$query2 = $this->dbAdmin->presentLoggingedit( date('Y-m-d H:i:s', strtotime($this->input->post('begin_at'))), date('Y-m-d H:i:s', strtotime($this->input->post('end_at'))), $this->input->post('item_id'), $this->input->post('sendtext'), $this->input->post('admin_memo'), $this->input->post('v1'), $this->input->post('idx') );
		if ( $query == 1 && $query2 == 1 )
		{
			echo 'true';
		}
		else if ( $query == 1 && $query2 != 1 )
		{
			echo 'false1';
		}
		else if ( $query != 1 && $query2 == 1 )
		{
			echo 'false2';
		}
		else
		{
			echo 'false3';
		}
	}

	public function presentlog()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$rowArray = $this->dbAdmin->presentlog( $this->input->post('start_date'), $this->input->post('end_date') )->result_array();

		if ( !empty($rowArray) )
		{
			foreach ($rowArray as $key => $val)
			{
				if ( $val['item_id'] != '' && $val['item_id'] > 0 && $val['item_id'] != null )
				{
					$arrayItem = $this->cimongo->where(array( 'id' => new MongoInt32($val['item_id']) ))->get('rs_table_item')->result_array();
					$rowArray[$key]['item_name'] = $arrayItem[0]['t_name'];
				}
			}
		}
		echo json_encode( $rowArray, JSON_UNESCAPED_UNICODE );
	}

	public function presentdelete()
	{
		$this->cimongo->where(array( 'key' => $this->input->post('mongokey') ) );
		$query = $this->cimongo->delete( 'on_time_reward' );
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '전체선물지급삭제', 'key => '.$this->input->post('mongokey').'\nidx => '.$this->input->post('idx') );
		$query2 = $this->dbAdmin->presentLoggingdelete( $this->input->post('idx') );
		if ( $query == 1 && $query2 == 1 )
		{
			echo 'true';
		}
		else if ( $query == 1 && $query2 != 1 )
		{
			echo 'false1';
		}
		else if ( $query != 1 && $query2 == 1 )
		{
			echo 'false2';
		}
		else
		{
			echo 'false3';
		}
	}

	public function loginpresent()
	{
		$arrayItem = $this->cimongo->get('rs_table_item')->result_array();
		$arrMessage = $this->cimongo->get('rs_table_server_text')->result_array();
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'), 'arrMessage' => $arrMessage, 'arrItem' => $arrayItem );

		$this->load->view('loginpresent', $arrayParam);
	}

	public function loginpresent_get()
	{
		$rowArray = $this->cimongo->get('push_event')->result_array();
		$ret = $this->curl->simple_post($this->platform_url.'/push/getPushList');
		$ret = json_decode($ret, true);

		foreach ($rowArray as $key => $val)
		{
			if ( $val['item_id'] != '' && $val['item_id'] > 0 && $val['item_id'] != null )
			{
				$arrayItem = $this->cimongo->where(array( 'id' => new MongoInt32($val['item_id']) ))->get('rs_table_item')->result_array();
				$rowArray[$key]['item_name'] = $arrayItem[0]['t_name'];
			}
		}

		$retArray = array();

		foreach($rowArray as $r) {
			$r['message'] ='(no message)';
			if (isset($ret['pushList'])) {
				foreach($ret['pushList'] as $p) {
					if ($p['push_id'] == $r['push_id']) {
						$r['message'] = $p['message'];
						break;
					}
				}
			}
			array_push($retArray, $r);
		}
		echo json_encode( $retArray, JSON_UNESCAPED_UNICODE );
	}

	public function loginpresent_delete()
	{
		$push_id = (int)$this->input->post('push_id');
		$ret = $this->curl->simple_post($this->platform_url.'/push/removePush', array('push_id'=>abs($push_id)));
		$ret = json_decode($ret, true);

		if ( $push_id > 0 )
		{
			if (isset($ret['status']) == false || $ret['status']['retcode'] != 0) {
				echo 'false';
			}
		}

		if ($this->cimongo->where(
				array(
					'push_id'=>$push_id
					)
				)->delete('push_event')) {
			echo 'true';
		}
		else {
			echo 'false';
		}

		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '로그인선물삭제', 'push_id => '.$push_id );
	}

	public function loginpresent_insertaction()
	{
		$push_date = (string)$this->input->post('login_date');
		$push_time = strtotime($push_date);
		$push_time = date("Y-m-d H:i:s", strtotime(sprintf('+%d hours', (int)$this->input->post('login_hour')), $push_time));

		//플랫폼 서버에 푸시 등록
		$message = array('title'=>'리듬스타',
			'body'=>$this->input->post('push_message')
		);
		$message = json_encode($message, JSON_UNESCAPED_UNICODE);

		$params = array('message'=>$message, 'reserve_date'=>$push_time);

		$ret = $this->curl->simple_post($this->platform_url.'/push/registerPush', $params);

		$ret = json_decode($ret, true);
		if (isset($ret['status']) == false || $ret['status']['retcode'] != 0) {
		 	echo 'false';
		 	return;
		}
		$push_id = $ret['push_id'];

		//게임 몽고 디비에 푸시 이벤트 등록
		$hour__ = (int)$this->input->post('login_hour');
		$cron_exp = '* * '.$hour__.'-'.($hour__+1).' * * ?';

		$_date = date("Ymd", strtotime($push_time));
		$query = $this->cimongo->insert( 'push_event', array(
							'date' => $_date,
							'cron_exp' => $cron_exp,
							'item_id'=> new MongoInt32($this->input->post('item_id')),
							'count'=> new MongoInt32($this->input->post('v1')),
							'push_id'=> new MongoInt32($push_id)
						)
		);


		$this->load->model('Model_Admin', 'dbAdmin');
		if ( $this->input->post('push_status') == 0 )
		{
			$ret = $this->curl->simple_post($this->platform_url.'/push/removePush', array('push_id'=>$push_id));
			$ret = json_decode($ret, true);

			if (isset($ret['status']) == false || $ret['status']['retcode'] != 0) {
				echo 'false';
				exit;
			}

			$this->cimongo->where(
					array(
						'push_id'=>$push_id
						)
					)->update('push_event', array('push_id'=> new MongoInt32($push_id * -1))
			);
		}
		$this->dbAdmin->pushloginsert( $push_id, $message, $push_time );
		$this->dbAdmin->adminLoginsert( '로그인선물등록', 'message => '.$message.'\nreserve_date => '.$this->input->post('login_hour') );

		if ( $query == 1 )
		{
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}

	public function loginpresent_off()
	{
		$push_id = (int)$this->input->post('push_id');

		$this->load->model('Model_Admin', 'dbAdmin');
		if ( $push_id > 0 )
		{
			$push_id = (int)$this->input->post('push_id');
			$ret = $this->curl->simple_post($this->platform_url.'/push/removePush', array('push_id'=>$push_id));
			$ret = json_decode($ret, true);

			if (isset($ret['status']) == false || $ret['status']['retcode'] != 0) {
				echo 'false';
				exit;
			}

			if ($this->cimongo->where(
					array(
						'push_id'=>$push_id
						)
					)->update('push_event', array('push_id'=> new MongoInt32($push_id * -1)))) {
				echo 'true';
			}
			else {
				echo 'false';
			}

			$this->dbAdmin->adminLoginsert( '로그인선물푸시삭제', 'push_id => '.$push_id );
		}
		else
		{
			$prevRec = $this->dbAdmin->pushlogselect( ($push_id * -1) )->result_array();
			if ( empty($prevRec) )
			{
				echo 'false';
				exit;
			}
			$push_time = $prevRec[0]['push_time'];

			//플랫폼 서버에 푸시 등록
			$message = $prevRec[0]['message'];

			$params = array('message'=>$message, 'reserve_date'=>$push_time);

			$ret = $this->curl->simple_post($this->platform_url.'/push/registerPush', $params);

			$ret = json_decode($ret, true);
			if (isset($ret['status']) == false || $ret['status']['retcode'] != 0) {
			 	echo 'false';
			 	return;
			}
			$push_id = $ret['push_id'];

			if ($this->cimongo->where(
					array(
						'push_id'=>new MongoInt32($this->input->post('push_id'))
						)
					)->update('push_event', array('push_id'=> new MongoInt32($push_id)))) {
				echo 'true';
			}
			else {
				echo 'false';
			}

			$this->dbAdmin->pushloginsert( $push_id, $message, $push_time );
			$this->dbAdmin->adminLoginsert( '로그인선물푸시삭제복원', 'message => '.$message.'\nreserve_date => '.$this->input->post('login_hour') );
		}
	}

	public function presentgive()
	{
		$arrayItem = $this->cimongo->get('rs_table_item')->result_array();
		$randomString = $this->generateRandomString(20);
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'), 'arrItem' => $arrayItem, 'randomString' => $randomString );

		$this->load->view('presentgive', $arrayParam);
	}

	public function userfileupload()
	{
		$error = false;
		$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/';
	    foreach($_FILES as $file)
	    {
		    $tempname = $this->generateRandomString(20);
		    $tempname .= '.'.pathinfo($file['name'], PATHINFO_EXTENSION);
	        if(move_uploaded_file($file['tmp_name'], $uploaddir.$tempname))
	        {
	            $files[] = $uploaddir.$tempname;
	        }
	        else
	        {
	            $error = true;
	        }
	    }

	    $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);

		$this->load->library("PHPExcel");
		$objPHPExcel = new PHPExcel();
		$objPHPExcel = PHPExcel_IOFactory::load($uploaddir.$tempname);
		$sheetsCount = $objPHPExcel->getSheetCount();

		/* 쉬트별로 읽기 */
		for($i = 0; $i < $sheetsCount; $i++)
		{
		    $objPHPExcel->setActiveSheetIndex($i);
		    $sheet = $objPHPExcel->getActiveSheet();
		    $highestRow = $sheet->getHighestRow();
		    $highestColumn = $sheet->getHighestColumn();

		    /* 한줄읽기 */
		    for ($row = 1; $row <= $highestRow; $row++)
		    {
		        /* $rowData가 한줄의 데이터를 셀별로 배열처리 됩니다. */
		        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
		        echo $rowData[0][0].PHP_EOL;
		    }
		}
	}

	public function convertfileupload()
	{
		$error = false;
		$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/';
	    foreach($_FILES as $file)
	    {
		    $tempname = $this->generateRandomString(20);
		    $tempname .= '.'.pathinfo($file['name'], PATHINFO_EXTENSION);
	        if(move_uploaded_file($file['tmp_name'], $uploaddir.$tempname))
	        {
	            $files[] = $uploaddir.$tempname;
	        }
	        else
	        {
	            $error = true;
	        }
	    }

	    $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);

		$this->load->library("PHPExcel");
		$objPHPExcel = new PHPExcel();
		$objPHPExcel = PHPExcel_IOFactory::load($uploaddir.$tempname);
		$sheetsCount = $objPHPExcel->getSheetCount();

		/* 쉬트별로 읽기 */
		for($i = 0; $i < $sheetsCount; $i++)
		{
		    $objPHPExcel->setActiveSheetIndex($i);
		    $sheet = $objPHPExcel->getActiveSheet();
		    $highestRow = $sheet->getHighestRow();
		    $highestColumn = $sheet->getHighestColumn();

		    /* 한줄읽기 */
		    for ($row = 1; $row <= $highestRow; $row++)
		    {
		        /* $rowData가 한줄의 데이터를 셀별로 배열처리 됩니다. */
		        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE)[0];
		        if ( $row > 1 ) {
    		        if ( $rowData[0] === null && $rowData[1] !== null ) {
        		        $result = $this->cimongo->where( array( 'nickname' => $rowData[1] ) )->get('user')->result_array();
        		        if ( count( $result ) === 1 ) {
        		            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $result[0]['uid']);
        		        } else if ( count( $result ) > 1 ) {
            		        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, '중복발생');
        		        }
    		        } else if ( $rowData[1] === null && $rowData[0] !== null ) {
        		        $result = $this->cimongo->where( array( 'uid' => $rowData[0] ) )->get('user')->result_array();
        		        if ( count( $result ) === 1 ) {
        		            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $result[0]['nickname']);
        		        } else if ( count( $result ) > 1 ) {
            		        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, '중복발생');
        		        }
    		        }
		        }
		    }
		}
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($uploaddir.$tempname);
		echo $_SERVER['HTTP_HOST'].'/assets/upload/'.$tempname;
	}

	public function sendpresent()
	{
		$query = $this->cimongo->where( array( 'text' => $this->input->post('sendtext') ) )->get( 'text_table' )->result_array();
		if ( empty( $query ) )
		{
			$query = $this->cimongo->insert( 'text_table', array( 'text' => $this->input->post('sendtext') ) );
			$id = $this->cimongo->insert_id();
		}
		else
		{
			$id = $query[0]['_id'];
		}
		if ( $this->input->post('term') == 'E' )
		{
			$expire = null;
		}
		else
		{
			$nowdate = new Datetime();
			$expire = $nowdate->add( new DateInterval( 'P'.$this->input->post('term') ) );
			$expire = strtotime($expire->format('Y-m-d H:i:s'));
		}

		$this->load->model('Model_Admin', 'dbAdmin');
		$uid = array_filter( explode( PHP_EOL, $this->input->post('uid') ) );

		$result = true;
		$uidarr = '';
		foreach( $uid as $row )
		{
			$this->dbAdmin->adminLoginsert( '일괄지급', 'type => '.$this->input->post( 'type' ).'\nv1 => '.$this->input->post('v1').'\nlogt => '.$this->input->post('logt').'\nlogc => '.$this->input->post('logc').'\nexpire => '.$this->input->post('expire').'\nmsg_obj_id => '.$id, $row );
			$result = $result & boolval( $query = $this->cimongo->insert( 'mail', array(
								'uid' => $row,
								'c' => new MongoInt32(1),
								'r' => new MongoInt32(0),
								'type' => $this->input->post('type'),
								'v1' => new MongoInt32( $this->input->post('v1') ),
								'logt' => $this->input->post('logt'),
								'logc' => $this->input->post('logc'),
								'created_at'=> new MongoDate(),
								'expired_at'=> ( $expire == null ? $expire : new MongoDate($expire) ),
								'msg_obj_id'=> $id
							)
			) );

			if ( !($result) )
			{
				$this->dbAdmin->presentmultilog( $uidarr, $expire, $this->input->post('type'), $this->input->post('sendtext'), $this->input->post('admin_memo'), $this->input->post('logc'), $this->input->post('v1'), $this->input->post('logt') );
				break;
			}
			else
			{
				$uidarr .= ','.$row;
			}
		}

		if ( $result )
		{
			$this->dbAdmin->presentmultilog( $uid, $expire, $this->input->post('type'), $this->input->post('sendtext'), $this->input->post('admin_memo'), $this->input->post('logc'), $this->input->post('v1'), $this->input->post('logt') );
		}

		echo $result;
	}

	public function presentinfo()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$rowArray = $this->dbAdmin->presentmultiloginfo( $this->input->post('start_date'), $this->input->post('end_date') )->result_array();

		if ( !empty($rowArray) )
		{
			foreach ($rowArray as $key => $val)
			{
				if ( $val['item_id'] != '' && $val['item_id'] > 0 && $val['item_id'] != null )
				{
					$arrayItem = $this->cimongo->where(array( 'id' => new MongoInt32($val['item_id']) ))->get('rs_table_item')->result_array();
					$rowArray[$key]['item_name'] = $arrayItem[0]['t_name'];
				}
			}
		}
		echo json_encode( $rowArray, JSON_UNESCAPED_UNICODE );
	}

	public function convertXls()
	{
		$this->load->view('convertxls', null);
	}

}
