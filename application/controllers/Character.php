<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Character extends MY_Controller {

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

	public function basicinfo()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'));

		$this->load->view('basicinfo', $arrayParam);
	}

	public function userbasicinfo()
	{
		if ( $this->input->post('part') == '1' )
		{
			$mappingArray = array(
				'uid' => '회원번호',
				'nickname' => '닉네임',
				'pcash' => '유료 캐시',
				'fcash' => '무료 캐시',
				'tbp' => '총 결제 금액',
			);
		}
		else if ( $this->input->post('part') == '2' )
		{
			$mappingArray = array(
				'email' => '계정',
				'star/tp_free' => '별/트로피',
				'gold' => '보유 골드',
				't_iv_cnt' => '친구 초대 수',
				'withdraw_at' => '탈퇴 일시',
			);
		}
		else if ( $this->input->post('part') == '3' )
		{
			$mappingArray = array(
				'account_block_end_at' => '계정 상태',
				'leave' => '접속 여부',
				'leave_at' => '최근 로그 아웃',
				'created_at' => '가입일',
				'device_model' => '휴대폰 기종',
				'market' => '휴대폰 OS'
			);
		}
		else
		{
			echo "ERROR";
			exit();
		}
		if ( $this->session->userdata('searchuid') != null && $this->session->userdata('searchuid') != '' )
		{
			$query = $this->cimongo->get_where( 'user', array( 'uid' => $this->session->userdata('searchuid') ) );
			$result = $query->result_array()[0];
			$rowArray = array();
			foreach( $mappingArray as $key => $val )
			{
				if ( is_numeric($key) )
				{
					array_push( $rowArray, array( 'title' => $key, 'value' => '' ) );
				}
				else
				{
					$key = explode('/', $key);
					$tempval = array();
					foreach( $key as $seq => $row )
					{
						if ( array_key_exists($row, $result) )
						{
							if ($result[$row] instanceof MongoDate)
							{
								if ( $row == 'account_block_end_at' )
								{
									$nowdate = new DateTime();
									if ( array_key_exists('account_block_end_at', $result) )
									{
										if ( $result['account_block_end_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul')) > $nowdate )
										{
											array_push( $tempval, '제제중 / '.$result['account_block_end_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s') );
										}
										else
										{
											array_push( $tempval, '정상' );
										}
									}
									else
									{
										array_push( $tempval, '정상' );
									}
								}
								else
								{
									array_push( $tempval, $result[$row]->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s') );
								}
							}
							else
							{
								array_push( $tempval, $result[$row] );
							}
						}
						else
						{
							if ( $row == 'leave' )
							{
								array_push( $tempval, '(없음)' );
							}
							else if ( $row == 'account_block_end_at' )
							{
								$nowdate = new DateTime();
								if ( array_key_exists('account_block_end_at', $result) )
								{
									if ( $result['account_block_end_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul')) > $nowdate )
									{
										array_push( $tempval, '제제중 / '.$result['account_block_end_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s') );
									}
									else
									{
										array_push( $tempval, '정상' );
									}
								}
								else
								{
									array_push( $tempval, '정상' );
								}
							}
							else if ( $row == 'star' || $row == 'tp_free' )
							{
								if ( array_key_exists($row, $result['stats']) )
								{
									array_push( $tempval, $result['stats'][$row] );
								}
								else
								{
									array_push( $tempval, '0' );
								}
							}
							else
							{
								array_push( $tempval, '' );
							}
						}
					}
					array_push( $rowArray, array( 'title' => $val, 'value' => implode(' / ', $tempval) ) );
				}
			}
			echo json_encode( $rowArray, JSON_UNESCAPED_UNICODE );
		}
		else
		{
			echo '[]';
		}
	}

	public function presentinfo()
	{
		$arrayItem = $this->cimongo->get('rs_table_item')->result_array();
		$randomString = $this->generateRandomString(20);
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'), 'arrItem' => $arrayItem, 'randomString' => $randomString );

		$this->load->view('presentinfo', $arrayParam);
	}

	public function userpresentinfo()
	{
		if ( $this->session->userdata('searchuid') != null && $this->session->userdata('searchuid') != ''
			&& $this->input->post('start_date') != null && $this->input->post('start_date') != ''
			&& $this->input->post('end_date') != null && $this->input->post('end_date') != ''
		)
		{
			$query = $this->cimongo->where( array( 'uid' => $this->session->userdata('searchuid'), 'c' => 1 ) )->where_between( 'created_at', new MongoDate(strtotime($this->input->post('start_date').' 00:00:00')), new MongoDate(strtotime($this->input->post('end_date').' 00:00:00'.' +1 days')) )->get('mail');
			$Result = $query->result_array();
			$rowArray = array();
			foreach ( $Result as $val )
			{
				if ($val['created_at'] instanceof MongoDate)
				{
					$val['created_at'] = $val['created_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s');
				}
				else
				{
					$val['created_at'] = $val['created_at'];
				}
				if ( array_key_exists('read_at', $val) )
				{
					if ($val['read_at'] instanceof MongoDate)
					{
						$val['read_at'] = $val['read_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s');
					}
					else
					{
						$val['read_at'] = $val['read_at'];
					}
				}
				else
				{
					$val['read_at'] = '';
				}

				if ( $val['expired_at'] == null ) $val['expired_at'] = new MongoDate( strtotime('2099-12-31 23:59:59') );
				$ex = new MongoDate($val['expired_at']->sec, $val['expired_at']->usec);
				$ex = $ex->toDatetime()->setTimezone(new DateTimeZone('Asia/Seoul'));

				if ( $val['r'] == 1 )
				{
					$rString = '수령';
					$readString = ( $val['read_at'] instanceof MongoDate ? $val['read_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s') : $val['read_at'] );
				}
				else if ( $val['r'] == 0 )
				{
					if ( $ex > new DateTime('now') )
					{
						$rString = '미수령';
						$readString = '<button class="btn btn-xs btn-primary btnUndo" data-objectid="'.$val['_id'].'"><i class="fa fa-undo"></i></button>';

					}
					else
					{
						$rString = '기간만료';
						$readString = '(없음)';
					}
				}
				else if ( $val['r'] == 2 )
				{
					$rString = '기간만료';
					$readString = '(없음)';
				}
				else if ( $val['r'] == 3 )
				{
					$rString = '삭제(회수)';
					$readString = ( $val['read_at'] instanceof MongoDate ? $val['read_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s') : $val['read_at'] );
				}

				$arrayItem = $this->cimongo->get('rs_table_item')->result_array();
				$key = array_search($val['type'], array_column($arrayItem, 'mail_type'));
				if ( $key !== false )
				{
					if ( array_key_exists('t_name', $arrayItem[$key]) )
					{
						$strType = $arrayItem[$key]['t_name'];
					}
					else
					{
						$strType = '???';
					}
				}
				else
				{
					$strType = '???';
				}

				if ( $val['expired_at'] == new MongoDate( strtotime('2099-12-31 23:59:59') ) ) $val['expired_at'] = '(무제한)';

				$strValue = '';
				if ( array_key_exists('t1', $val) )
				{
					if ( $strValue != '' )
					{
						$strValue .= '<br />';
					}
					$strValue .= 't1 => '.$val['t1'];
				}
				if ( array_key_exists('t2', $val) )
				{
					if ( $strValue != '' )
					{
						$strValue .= '<br />';
					}
					$strValue .= 't2 => '.$val['t2'];
				}
				if ( array_key_exists('t3', $val) )
				{
					if ( $strValue != '' )
					{
						$strValue .= '<br />';
					}
					$strValue .= 't3 => '.$val['t3'];
				}
				if ( array_key_exists('v2', $val) )
				{
					if ( $strValue != '' )
					{
						$strValue .= '<br />';
					}
					$strValue .= 'v2 => '.$val['v2'];
				}
				if ( array_key_exists('v3', $val) )
				{
					if ( $strValue != '' )
					{
						$strValue .= '<br />';
					}
					$strValue .= 'v3 => '.$val['v3'];
				}

				if ( array_key_exists('logt', $val) )
				{
					$logt = $val['logt'];
				}
				else
				{
					$logt = '';
				}

				array_push( $rowArray, array( '_id' => $val['_id'], 'type' => $strType, 'nickname' => (array_key_exists( 'nickname', $val ) ? $val['nickname'] : '(시스템)'), 'created_at' => ( $val['created_at'] instanceof MongoDate ? $val['created_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s') : $val['created_at'] ), 'logc' => $val['logc'], 'logt' => $logt, 'amount' => $val['v1'], 'value' => $strValue, 'isRead' => $rString, 'read_at' => $readString, 'expired_at' => ( $val['expired_at'] instanceof MongoDate ? $val['expired_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s') : $val['expired_at'] )
				) );
			}
			echo json_encode( $rowArray, JSON_UNESCAPED_UNICODE );
		}
		else
		{
			echo '[]';
		}
	}

	public function messageinfo()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'));

		$this->load->view('messageinfo', $arrayParam);
	}

	public function usermessageinfo()
	{
		if ( $this->session->userdata('searchuid') != null && $this->session->userdata('searchuid') != ''
			&& $this->input->post('start_date') != null && $this->input->post('start_date') != ''
			&& $this->input->post('end_date') != null && $this->input->post('end_date') != ''
		)
		{
			$query = $this->cimongo->where( array( 'uid' => $this->session->userdata('searchuid'), 'c' => 2 ) )->where_between( 'created_at', new MongoDate(strtotime($this->input->post('start_date').' 00:00:00')), new MongoDate(strtotime($this->input->post('end_date').' 00:00:00'.' +1 days')) )->get('mail');
			$Result = $query->result_array();
			$rowArray = array();
			foreach ( $Result as $val )
			{
				if ($val['created_at'] instanceof MongoDate)
				{
					$val['created_at'] = $val['created_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s');
				}
				else
				{
					$val['created_at'] = $val['created_at'];
				}
				if ( array_key_exists('read_at', $val) )
				{
					if ($val['read_at'] instanceof MongoDate)
					{
						$val['read_at'] = $val['read_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s');
					}
					else
					{
						$val['read_at'] = $val['read_at'];
					}
				}
				else
				{
					$val['read_at'] = '';
				}

				if ( $val['expired_at'] == null ) $val['expired_at'] = new MongoDate( strtotime('2099-12-31 23:59:59') );
				$ex = new MongoDate($val['expired_at']->sec, $val['expired_at']->usec);
				$ex = $ex->toDatetime()->setTimezone(new DateTimeZone('Asia/Seoul'));

				if ( $val['r'] == 1 )
				{
					$rString = '수령';
					$readString = ( $val['read_at'] instanceof MongoDate ? $val['read_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s') : $val['read_at'] );
				}
				else if ( $val['r'] == 0 )
				{
					if ( $ex > new DateTime('now') )
					{
						$rString = '미수령';
						$readString = '<button class="btn btn-xs btn-primary btnUndo" data-objectid="'.$val['_id'].'"><i class="fa fa-undo"></i></button>';

					}
					else
					{
						$rString = '기간만료';
						$readString = '(없음)';
					}
				}
				else if ( $val['r'] == 2 )
				{
					$rString = '기간만료';
					$readString = '(없음)';
				}
				else if ( $val['r'] == 3 )
				{
					$rString = '삭제(회수)';
					$readString = ( $val['read_at'] instanceof MongoDate ? $val['read_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s') : $val['read_at'] );
				}

				$arrayItem = $this->cimongo->get('rs_table_item')->result_array();
				$key = array_search($val['type'], array_column($arrayItem, 'mail_type'));
				if ( $key !== false )
				{
					if ( array_key_exists('t_name', $arrayItem[$key]) )
					{
						$strType = $arrayItem[$key]['t_name'];
					}
					else
					{
						$strType = '???';
					}
				}
				else
				{
					$strType = '???';
				}

				if ( $val['expired_at'] == new MongoDate( strtotime('2099-12-31 23:59:59') ) ) $val['expired_at'] = '(무제한)';

				$strValue = '';
				if ( array_key_exists('t1', $val) )
				{
					if ( $strValue != '' )
					{
						$strValue .= '<br />';
					}
					$strValue .= 't1 => '.$val['t1'];
				}
				if ( array_key_exists('t2', $val) )
				{
					if ( $strValue != '' )
					{
						$strValue .= '<br />';
					}
					$strValue .= 't2 => '.$val['t2'];
				}
				if ( array_key_exists('t3', $val) )
				{
					if ( $strValue != '' )
					{
						$strValue .= '<br />';
					}
					$strValue .= 't3 => '.$val['t3'];
				}
				if ( array_key_exists('v2', $val) )
				{
					if ( $strValue != '' )
					{
						$strValue .= '<br />';
					}
					$strValue .= 'v2 => '.$val['v2'];
				}
				if ( array_key_exists('v3', $val) )
				{
					if ( $strValue != '' )
					{
						$strValue .= '<br />';
					}
					$strValue .= 'v3 => '.$val['v3'];
				}

				array_push( $rowArray, array( '_id' => $val['_id'], 'type' => $strType, 'nickname' => (array_key_exists( 'nickname', $val ) ? $val['nickname'] : '(시스템)'), 'created_at' => ( $val['created_at'] instanceof MongoDate ? $val['created_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s') : $val['created_at'] ), 'logc' => $val['logc'], 'logt' => $val['logt'], 'amount' => $val['v1'], 'value' => $strValue, 'isRead' => $rString, 'read_at' => $readString, 'expired_at' => ( $val['expired_at'] instanceof MongoDate ? $val['expired_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s') : $val['expired_at'] )
				) );
			}
			echo json_encode( $rowArray, JSON_UNESCAPED_UNICODE );
		}
		else
		{
			echo '[]';
		}
	}

	public function setBlock()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '블럭처리', 'account_block_end_at => '.$this->input->post('account_block_end_at'), $this->input->post('uid') );
		echo boolval( $this->cimongo->where( array( 'uid' => $this->input->post( 'uid' ) ) )->set(
						array(
							'account_block_end_at' => new MongoDate( strtotime( $this->input->post('account_block_end_at') ) )
						)
		)->update('user') );
	}

	public function setFree()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '블럭해제', '', $this->input->post('uid') );
		echo boolval( $this->cimongo->where( array( 'uid' => $this->input->post( 'uid' ) ) )->unset_field( array( 'account_block_end_at' ) )->update('user') );
	}

	public function dupnick()
	{
		echo $this->cimongo->where( array( 'nickname' => $this->input->post('nickname') ) )->count_all_results('user');
	}

	public function setgold()
	{
		$gold = $this->cimongo->where( array( 'uid' => $this->input->post( 'uid' ) ) )->get('user')->result_array()[0]['gold'];
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '골드변경', $gold.' => '.( $gold + $this->input->post('change_amount') ), $this->input->post('uid') );
		echo boolval( $this->cimongo->where( array( 'uid' => $this->input->post( 'uid' ) ) )->set(
						array(
							'gold' => new MongoInt32( $gold + $this->input->post('change_amount') )
						)
		)->update('user') );
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

	public function setnickname()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '닉네임변경', 'nickname => '.$this->input->post('change_nickname'), $this->input->post('uid') );
		echo boolval( $this->cimongo->where( array( 'uid' => $this->input->post( 'uid' ) ) )->set(
						array(
							'nickname' => $this->input->post('change_nickname')
						)
		)->update('user') );
	}

	public function setlevel()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '경험치레벨변경', 'lv => '.$this->input->post('change_level').'\nexp => '.$this->input->post('change_exp'), $this->input->post('uid') );
		echo boolval( $this->cimongo->where( array( 'uid' => $this->input->post( 'uid' ) ) )->set(
						array(
							'lv' => new MongoInt32( $this->input->post('change_level') ),
							'exp' => new MongoInt32( $this->input->post('change_exp') )
						)
		)->update('user') );
	}

	public function setrecall()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '메일회수', '_id => '.$this->input->post( '_id' ), $this->session->userdata('searchuid') );
		echo boolval( $this->cimongo->where( array( '_id' => new MongoID( $this->input->post( '_id' ) ) ) )->set(
						array(
							'r' => new MongoInt32( 3 ),
							'read_at' => new MongoDate()
						)
		)->update('mail') );
	}

	public function setrecallre()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '메일복원', '_id => '.$this->input->post( '_id' ), $this->session->userdata('searchuid') );
		echo boolval( $this->cimongo->where( array( '_id' => new MongoID( $this->input->post( '_id' ) ) ) )->set(
						array(
							'r' => new MongoInt32( 0 )
						)
		)->unset_field( array( 'read_at' ) )->update('mail') );
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
		$this->dbAdmin->adminLoginsert( '메일발송', 'type => '.$this->input->post( 'type' ).'\nv1 => '.$this->input->post('v1').'\nlogt => '.$this->input->post('logt').'\nlogc => '.$this->input->post('logc').'\nexpire => '.$this->input->post('expire').'\nmsg_obj_id => '.$id, $this->input->post('uid') );
		echo boolval( $query = $this->cimongo->insert( 'mail', array(
							'uid' => $this->input->post('uid'),
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
	}

	public function playlog()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'));

		$this->load->view('playlog', $arrayParam);
	}

	public function playloglist()
	{
		$logtype = 'game';
		if ( $this->session->userdata('searchuid') == '' || $this->input->post('start_date') == '' || $this->input->post('end_date') == ''
			|| $this->session->userdata('searchuid') == null || $this->input->post('start_date') == null || $this->input->post('end_date') == null
		)
		{
			echo json_encode( array(), JSON_UNESCAPED_UNICODE );
			exit;
		}

		$this->load->model('Model_Log', 'dbLog');
		$arrTable = $this->dbLog->tablelist( $logtype, str_replace( '-', '', $this->input->post('start_date') ), str_replace( '-', '', $this->input->post('end_date') ) )->result_array();
		if ( empty( $arrTable ) )
		{
			echo '[]';
		}
		else
		{
			$arrResult = $this->dbLog->loglist( $arrTable, $this->session->userdata('searchuid'), $logtype )->result_array();
			echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
		}
	}

	public function cashlog()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'));

		$this->load->view('cashlog', $arrayParam);
	}

	public function cashloglist()
	{
		$logtype = 'cash';
		if ( $this->session->userdata('searchuid') == '' || $this->input->post('start_date') == '' || $this->input->post('end_date') == ''
			|| $this->session->userdata('searchuid') == null || $this->input->post('start_date') == null || $this->input->post('end_date') == null
		)
		{
			echo json_encode( array(), JSON_UNESCAPED_UNICODE );
			exit;
		}

		$this->load->model('Model_Log', 'dbLog');
		$arrTable = $this->dbLog->tablelist( $logtype, str_replace( '-', '', $this->input->post('start_date') ), str_replace( '-', '', $this->input->post('end_date') ) )->result_array();
		if ( empty( $arrTable ) )
		{
			echo '[]';
		}
		else
		{
			$arrResult = $this->dbLog->loglist( $arrTable, $this->session->userdata('searchuid'), $logtype )->result_array();
			echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
		}
	}

	public function goldlog()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'));

		$this->load->view('goldlog', $arrayParam);
	}

	public function goldloglist()
	{
		$logtype = 'gold';
		if ( $this->session->userdata('searchuid') == '' || $this->input->post('start_date') == '' || $this->input->post('end_date') == ''
			|| $this->session->userdata('searchuid') == null || $this->input->post('start_date') == null || $this->input->post('end_date') == null
		)
		{
			echo json_encode( array(), JSON_UNESCAPED_UNICODE );
			exit;
		}

		$this->load->model('Model_Log', 'dbLog');
		$arrTable = $this->dbLog->tablelist( $logtype, str_replace( '-', '', $this->input->post('start_date') ), str_replace( '-', '', $this->input->post('end_date') ) )->result_array();
		if ( empty( $arrTable ) )
		{
			echo '[]';
		}
		else
		{
			$arrResult = $this->dbLog->loglist( $arrTable, $this->session->userdata('searchuid'), $logtype )->result_array();
			echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
		}
	}

	public function characterlog()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'));

		$this->load->view('characterlog', $arrayParam);
	}

	public function characterloglist()
	{
		$logtype = 'common';
		if ( $this->session->userdata('searchuid') == '' || $this->input->post('start_date') == '' || $this->input->post('end_date') == ''
			|| $this->session->userdata('searchuid') == null || $this->input->post('start_date') == null || $this->input->post('end_date') == null
		)
		{
			echo json_encode( array(), JSON_UNESCAPED_UNICODE );
			exit;
		}

		$this->load->model('Model_Log', 'dbLog');
		$arrTable = $this->dbLog->tablelist( $logtype, str_replace( '-', '', $this->input->post('start_date') ), str_replace( '-', '', $this->input->post('end_date') ) )->result_array();
		if ( empty( $arrTable ) )
		{
			echo '[]';
		}
		else
		{
			$arrResult = $this->dbLog->loglist( $arrTable, $this->session->userdata('searchuid'), $logtype )->result_array();
			echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
		}
	}

	public function herolog()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'));

		$this->load->view('herolog', $arrayParam);
	}

	public function herologlist()
	{
		$logtype = 'hero';
		if ( $this->session->userdata('searchuid') == '' || $this->input->post('start_date') == '' || $this->input->post('end_date') == ''
			|| $this->session->userdata('searchuid') == null || $this->input->post('start_date') == null || $this->input->post('end_date') == null
		)
		{
			echo json_encode( array(), JSON_UNESCAPED_UNICODE );
			exit;
		}

		$this->load->model('Model_Log', 'dbLog');
		$arrTable = $this->dbLog->tablelist( $logtype, str_replace( '-', '', $this->input->post('start_date') ), str_replace( '-', '', $this->input->post('end_date') ) )->result_array();
		if ( empty( $arrTable ) )
		{
			echo '[]';
		}
		else
		{
			$arrResult = $this->dbLog->loglist( $arrTable, $this->session->userdata('searchuid'), $logtype )->result_array();
			echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
		}
	}

	public function itemlog()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'));

		$this->load->view('itemlog', $arrayParam);
	}

	public function itemloglist()
	{
		$logtype = 'item';
		if ( $this->session->userdata('searchuid') == '' || $this->input->post('start_date') == '' || $this->input->post('end_date') == ''
			|| $this->session->userdata('searchuid') == null || $this->input->post('start_date') == null || $this->input->post('end_date') == null
		)
		{
			echo json_encode( array(), JSON_UNESCAPED_UNICODE );
			exit;
		}

		$this->load->model('Model_Log', 'dbLog');
		$arrTable = $this->dbLog->tablelist( $logtype, str_replace( '-', '', $this->input->post('start_date') ), str_replace( '-', '', $this->input->post('end_date') ) )->result_array();
		if ( empty( $arrTable ) )
		{
			echo '[]';
		}
		else
		{
			$arrResult = $this->dbLog->loglist( $arrTable, $this->session->userdata('searchuid'), $logtype )->result_array();
			echo json_encode( $arrResult, JSON_UNESCAPED_UNICODE );
		}
	}

	public function heroinfo()
	{
		$heroArray = $this->cimongo->where( array( "b" => new MongoInt32(1) ) )->get('rs_table_hero_g')->result_array();
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'),
		'heroArray' => $heroArray );

		$this->load->view('heroinfo', $arrayParam);
	}

	public function gradelist()
	{
		$basehid = substr($this->input->post('hid'), 0, strlen($this->input->post('hid')) - 2 );
		$skillArray = $this->cimongo->where_between( 'hid', new MongoInt32( $basehid.'00' ), new MongoInt32( $basehid.'09' ) )->get('rs_table_hero_g_skill')->result_array();

		echo json_encode( $skillArray, JSON_UNESCAPED_UNICODE );
	}

	public function herolist()
	{
		$rowArray = $this->cimongo->where( array( 'uid' => $this->session->userdata('searchuid') ) )->get('hero')->result_array();

		if ( empty( $rowArray ) )
		{
			echo '[]';
		}
		else
		{
			foreach ( $rowArray as $key => $val )
			{
				$basehid = substr($val['hid'], 0, strlen($val['hid']) - 2 ).'00';
				$heroArray = $this->cimongo->where( array( 'hid' => new MongoInt32($basehid) ) )->get('rs_table_hero_g')->result_array();
				$invenArray = $this->cimongo->where( array( 'uid' => $this->session->userdata('searchuid') ) )->get('inventory')->result_array();

				if ( !empty( $heroArray ) )
				{
					if ( array_key_exists('t_name', $heroArray[0]) )
					{
						$rowArray[$key]['t_name'] = $heroArray[0]['t_name'];
						$rowArray[$key]['grade'] = $heroArray[0]['r'];
					}
					else
					{
						$rowArray[$key]['t_name'] = '무명씨('.$val['hid'].')';
						$rowArray[$key]['grade'] = $heroArray[0]['r'];
					}
				}
				else
				{
					$rowArray[$key]['t_name'] = '무명씨('.$val['hid'].')';
					$rowArray[$key]['grade'] = $heroArray[0]['r'];
				}

				if ( !empty( $invenArray[0]['items'] ) )
				{
					if ( array_key_exists($basehid, $invenArray[0]['items']) )
					{
						$rowArray[$key]['soulstone'] = $invenArray[0]['items'][$basehid];
					}
					else
					{
						$rowArray[$key]['soulstone'] = 0;
					}
				}
				else
				{
					$rowArray[$key]['soulstone'] = 0;
				}
				$rowArray[$key]['ability'] = $heroArray[0]['b_sk_n'];
				if ( array_key_exists('sk_n', $heroArray[0]) )
				{
					$rowArray[$key]['sk_n'] = $heroArray[0]['sk_n'];
				}
				else
				{
					$rowArray[$key]['sk_n'] = '-';
				}
			}
			echo json_encode( $rowArray, JSON_UNESCAPED_UNICODE );
		}
	}

	public function heroleveledit()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '히어로레벨변경', 'hero_id => '.$this->input->post('id').' lv => '.$this->input->post('lv').' admin_memo => '.$this->input->post('admin_memo'), $this->session->userdata('searchuid') );
		echo boolval( $this->cimongo->where( array( '_id' => new MongoID( $this->input->post( 'id' ) ) ) )->set(
						array(
							'lv' => new MongoInt32( $this->input->post('lv') )
						)
		)->update('hero') );
	}

	public function soulstoneedit()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( ( $this->input->post('amount') >= 0 ? '영혼석지급' : '영혼석회수' ), 'hid => '.$this->input->post('hid').' amount => '.$this->input->post('amount').' admin_memo => '.$this->input->post('admin_memo'), $this->session->userdata('searchuid') );
		$invenArr = $this->cimongo->where( array( 'uid' => $this->session->userdata('searchuid') ) )->get('inventory')->result_array();
		if ( !empty( $invenArr ) )
		{
			$isExist = false;
			foreach ( $invenArr[0]['items'] as $key => $val )
			{
				if ( $key == $this->input->post('hid') )
				{
					$isExist = true;
					$invenArr[0]['items'][$key] += $this->input->post('amount');
				}

				$invenArr[0]['items'][$key] = new MongoInt32( $invenArr[0]['items'][$key] );
			}

			if ( $isExist === false )
			{
				$invenArr[0]['items'][$this->input->post('hid')] = 0;
				$invenArr[0]['items'][$this->input->post('hid')] += $this->input->post('amount');
				$invenArr[0]['items'][$this->input->post('hid')] = new MongoInt32( $invenArr[0]['items'][$this->input->post('hid')] );
			}
		}
		else
		{
			echo 0;
		}

		echo boolval( $this->cimongo->where( array( 'uid' => $this->session->userdata('searchuid') ) )->set( array( 'items' => $invenArr[0]['items'] ) )->update('inventory') );
	}

	public function recallhero()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '히어로회수', 'id => '.$this->input->post('id').' admin_memo => '.$this->input->post('admin_memo'), $this->session->userdata('searchuid') );
		$this->cimongo->where(array( '_id' => new MongoID($this->input->post( 'id' ) ) ));
		echo boolval( $this->cimongo->delete( 'hero' ) );
	}

	public function sendhero()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '히어로지급', 'hid => '.$this->input->post('hid').' admin_memo => '.$this->input->post('admin_memo'), $this->session->userdata('searchuid') );
		$query = $this->cimongo->insert( 'hero', array(
				'uid' => $this->session->userdata('searchuid'), 'hid' => new MongoInt32( $this->input->post('hid') ), 'lv' => new MongoInt32('1'), 'exp' => new MongoInt32('0'),
				'created_at' => new MongoDate()
		) );
		echo boolval($query);
	}

	public function stageinfo()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'));

		$this->load->view('stageinfo', $arrayParam);
	}

	public function stagelist()
	{
		$query = $this->cimongo->where( array('uid' => $this->session->userdata('searchuid'), 'th' => new MongoInt32(1)) )->get('stage_clear')->result_array();

		$rowArray = array();
		foreach ( $query as $row )
		{
			if ( !array_key_exists('u_at', $row) )
			{
				$row['u_at'] = '-';
			}
			else
			{
				$row['u_at'] = $row['u_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s');
			}
			$stage_id = intval( substr($row['tid'], -4) );
			$subRow = $this->cimongo->where( array('id' => $stage_id) )->get('rs_table_stage_list_'.$row['th'])->result_array();
			foreach( $subRow[0] as $key => $val )
			{
				$row[$key] = $val;
			}
			$subRow2 = $this->cimongo->where( array('id' => $stage_id) )->get('rs_table_stage_lv_'.$row['th'])->result_array();
			if ( !empty( $subRow2 ) )
			{
				foreach( $subRow2[0] as $key => $val )
				{
					$row[$key] = $val;
				}
			}
			array_push($rowArray, $row);
		}

		echo json_encode( $rowArray, JSON_UNESCAPED_UNICODE );
	}

	public function freeinfo()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'), 'freemode' => FREEMODEARRAY );

		$this->load->view('freeinfo', $arrayParam);
	}

	public function freelist()
	{
		$freeMode = array_filter( FREEMODEARRAY );
		foreach ( $freeMode as $key => $val )
		{
			$freeMode[$key] = new MongoInt32( intval($val) );
		}
		$query = $this->cimongo->where( array('uid' => $this->session->userdata('searchuid')) )->where_in('th', array_values( $freeMode ))->get('stage_clear')->result_array();
		$rowArray = array();
		foreach ( $query as $row )
		{
			if ( !array_key_exists('u_at', $row) )
			{
				$row['u_at'] = '-';
			}
			else
			{
				$row['u_at'] = $row['u_at']->toDateTime()->format('Y-m-d H:i:s');
			}
			$stage_id = intval( substr($row['tid'], -4) );
			$subRow = $this->cimongo->where( array('id' => $stage_id) )->get('rs_table_stage_list_'.$row['th'])->result_array();
			foreach( $subRow[0] as $key => $val )
			{
				$row[$key] = $val;
			}
			array_push($rowArray, $row);
		}

		echo json_encode( $rowArray, JSON_UNESCAPED_UNICODE );
	}

	public function freestagelist()
	{
		$query = $this->cimongo->where( array('uid' => $this->session->userdata('searchuid'), 'th' => new MongoInt32( intval($this->input->post('th')) )) )->get('stage_clear')->result_array();
		$query = array_column( $query, 'tid' );
		foreach ( $query as $key => $val )
		{
			$query[$key] = new MongoInt32( intval( str_replace( $this->input->post('th'), '', $val ) ) );
		}

		echo json_encode( $this->cimongo->where_not_in( 'id', $query )->get('rs_table_stage_list_'.$this->input->post('th'))->result_array(), JSON_UNESCAPED_UNICODE );
	}

	public function sendfreestage()
	{
		$stage_id = ( intval($this->input->post('th')) * 10000 ) + intval( $this->input->post('tid') );
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '자유모드해금', 'tid => '.$stage_id.' admin_memo => '.$this->input->post('admin_memo'), $this->session->userdata('searchuid') );
		echo boolval( $this->cimongo->insert( 'stage_clear', array(
				'uid' => $this->session->userdata('searchuid'),
				'th' => new MongoInt32( $this->input->post('th') ),
				'tid' => new MongoInt32( ( intval($this->input->post('th')) * 10000 ) + intval( $this->input->post('tid') ) ),
				'st' => new MongoInt32(0), 'tp' => new MongoInt32(0), 'c_at' => new MongoDate(), 'pc' => new MongoInt32(0),
				'tc' => new MongoInt32(0), 'cc' => new MongoInt32(0), 'fc' => new MongoInt32(0), 'cfc' => new MongoInt32(0),
				'cg' => new MongoInt32(0), 'gi' => new MongoInt32(0), 'h1' => new MongoInt32(0), 'h2' => new MongoInt32(0),
				'h3' => new MongoInt32(0), 'h1s' => new MongoInt32(0), 'h2s' => new MongoInt32(0), 'h3s' => new MongoInt32(0),
				'hs' => new MongoInt32(0), 'a' => floatval(0.0), 'cb' => new MongoInt32(0), 'gds' => array(0, 0, 0, 0, 0, 0, 0),
				'wc' => new MongoInt32(0), 'ec' => new MongoInt32(0), 'lp' => new MongoInt32(0), 'uct' => new MongoInt64(0),
				'ver' => new MongoInt64(0)
		) ) );
	}

	public function schoolinfo()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'));

		$this->load->view('schoolinfo', $arrayParam);
	}

	public function schooldata()
	{
		if ( $this->session->userdata('searchuid') != null && $this->session->userdata('searchuid') != '' )
		{
			$query = $this->cimongo->where( array( 'uid' => $this->session->userdata('searchuid') ) )->get('user')->result_array();

			if ( empty( $query ) )
			{
				echo json_encode( array(), JSON_UNESCAPED_UNICODE );
			}
			else
			{
				$result = $this->cimongo->where( array( 'name' => $query[0]['school'] ) )->get('school')->result_array();

				if ( empty( $result ) )
				{
					echo json_encode( array(), JSON_UNESCAPED_UNICODE );
				}
				else
				{
					$result[0]['created_at'] = $result[0]['created_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s');
					$this->redis = new CI_Redis();
					$this->reflection = new ReflectionMethod('CI_Redis', '_encode_request');
					$this->reflection->setAccessible(TRUE);
					$this->redis->command('SELECT 10');

					if ( ENVIRONMENT != 'production' )
					{
//						$rdResult['st'] = $this->redis->get('rs_dev\|school_rank_star\|'.$result[0]['_id']);
//						$rdResult['tp3'] = $this->redis->get('rs_dev\|school_rank_trophy\|'.$result[0]['_id'].'\:3');
//						$rdResult['tp4'] = $this->redis->get('rs_dev\|school_rank_trophy\|'.$result[0]['_id'].'\:4');
//						$rdResult['tp5'] = $this->redis->get('rs_dev\|school_rank_trophy\|'.$result[0]['_id'].'\:5');
//						$rdResult['tp6'] = $this->redis->get('rs_dev\|school_rank_trophy\|'.$result[0]['_id'].'\:6');
//						$rdResult['tp9'] = $this->redis->get('rs_dev\|school_rank_trophy\|'.$result[0]['_id'].'\:9');
						$rdResult['st'] = $this->redis->command( 'ZREVRANK rs_dev|school_rank_star '.$result[0]['_id']->__toString() ) + 1;
						$rdResult['tp3'] = $this->redis->command( 'ZREVRANK rs_dev|school_rank_trophy|3 '.$result[0]['_id']->__toString() ) + 1;
						$rdResult['tp4'] = $this->redis->command( 'ZREVRANK rs_dev|school_rank_trophy|4 '.$result[0]['_id']->__toString() ) + 1;
						$rdResult['tp5'] = $this->redis->command( 'ZREVRANK rs_dev|school_rank_trophy|5 '.$result[0]['_id']->__toString() ) + 1;
						$rdResult['tp6'] = $this->redis->command( 'ZREVRANK rs_dev|school_rank_trophy|6 '.$result[0]['_id']->__toString() ) + 1;
						$rdResult['tp9'] = $this->redis->command( 'ZREVRANK rs_dev|school_rank_trophy|9 '.$result[0]['_id']->__toString() ) + 1;
					}
					else
					{
						$rdResult['st'] = $this->redis->command( 'ZREVRANK rs|school_rank_star '.$result[0]['_id']->__toString() ) + 1;
						$rdResult['tp3'] = $this->redis->command( 'ZREVRANK rs|school_rank_trophy|3 '.$result[0]['_id']->__toString() ) + 1;
						$rdResult['tp4'] = $this->redis->command( 'ZREVRANK rs|school_rank_trophy|4 '.$result[0]['_id']->__toString() ) + 1;
						$rdResult['tp5'] = $this->redis->command( 'ZREVRANK rs|school_rank_trophy|5 '.$result[0]['_id']->__toString() ) + 1;
						$rdResult['tp6'] = $this->redis->command( 'ZREVRANK rs|school_rank_trophy|6 '.$result[0]['_id']->__toString() ) + 1;
						$rdResult['tp9'] = $this->redis->command( 'ZREVRANK rs|school_rank_trophy|9 '.$result[0]['_id']->__toString() ) + 1;
					}
					$result[0]['rank'] = $rdResult;

					echo json_encode( $result, JSON_UNESCAPED_UNICODE );
				}
			}
		}
		else
		{
			echo json_encode( array(), JSON_UNESCAPED_UNICODE );
		}
	}
}
?>