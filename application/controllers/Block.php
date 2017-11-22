<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Block extends MY_Controller {

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

	public function massiveblock()
	{
		$randomString = $this->generateRandomString(20);
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'), 'arrItem' => ITEMARRAY, 'randomString' => $randomString );

		$this->load->view('massiveblock', $arrayParam);
	}

	public function setBlock()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$uidarr = array_filter( explode( PHP_EOL, $this->input->post('uidgroup') ) );
		$end_at = new DateTime();
		$result = true;

		$insert_id = $this->dbAdmin->massblockins( $this->input->post('type'), $this->input->post('end_at'), $this->input->post('block_reason') );
		if ( $this->input->post('type') == '0' )
		{
			$end_at = $end_at->format('Y-m-d H:i:s');
		}
		else if ( $this->input->post('type') == '1' )
		{
			$end_at = $end_at->add( new DateInterval( $this->input->post('end_at') ) )->format('Y-m-d H:i:s');
		}
		if ( $this->input->post('type') == '2' )
		{
			$end_at = $end_at->add( new DateInterval( 'P10Y' ) )->format('Y-m-d H:i:s');
		}

		foreach ( $uidarr as $key => $row )
		{
			$this->dbAdmin->adminLoginsert( ( $this->input->post('type') == '0' ? '블럭해제' : '블럭처리' ), ( $this->input->post('type') == '0' ? '' : 'account_block_end_at => '.$end_at ), $row );
			if ( $this->input->post('type') == '0' )
			{
				if ( $this->cimongo->where( array( 'uid' => $row ) )->unset_field( array( 'account_block_end_at' ) )->update('user') )
				{
					$uidarr[$key] = array( 'uid' => $row, 'result' => 'Y' );
					$this->dbAdmin->massblockdetins( $insert_id, $row, 1 );
				}
				else
				{
					$uidarr[$key] = array( 'uid' => $row, 'result' => 'N' );
					$this->dbAdmin->massblockdetins( $insert_id, $row, 0 );
				}
			}
			else
			{
				if ( $this->cimongo->where( array( 'uid' => $row ) )->set( array(
									'account_block_end_at' => new MongoDate( strtotime( $end_at ) )
								) )->update('user') )
				{
					$uidarr[$key] = array( 'uid' => $row, 'result' => 'Y' );
					$this->dbAdmin->massblockdetins( $insert_id, $row, 1 );
				}
				else
				{
					$uidarr[$key] = array( 'uid' => $row, 'result' => 'N' );
					$this->dbAdmin->massblockdetins( $insert_id, $row, 0 );
				}
			}
		}

		echo json_encode($uidarr, JSON_UNESCAPED_UNICODE);
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
				$this->dbAdmin->presentmultilog( $uidarr, $expire, $this->input->post('type'), $this->input->post('sendtext'), $this->input->post('admin_memo'), $this->input->post('logc'), $this->input->post('v1'), $this->input->post('logc') );
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

	public function blockinfo()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		echo json_encode( $this->dbAdmin->blockinfo()->result_array(), JSON_UNESCAPED_UNICODE );
	}

	public function makeexcel( $idx )
	{
        $this->load->model('Model_Admin', 'dbAdmin');
        $result = $this->dbAdmin->blockdetail( $idx )->result_array();

		$this->load->library("PHPExcel");
		$objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('blocklist');

        // read data to active sheet
        $objPHPExcel->getActiveSheet()->fromArray($result);

        $filename='block_list_'.$idx.'.xls'; //save our workbook as this file name

        header('Content-Type: application/vnd.ms-excel'); //mime type

        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name

        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
	}
}
