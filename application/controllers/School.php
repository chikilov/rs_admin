<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('/var/www/html/application/libraries/Redis.php');
class School extends MY_Controller {

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

	public function schoolinfo()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname') );

		$this->load->view('schoollist', $arrayParam);
	}

	public function search()
	{
		$result = $this->cimongo->where( array( 'name' => $this->input->post('namesearch') ) )->get('school')->result_array();

		if ( empty( $result ) )
		{
			echo json_encode( array(), JSON_UNESCAPED_UNICODE );
		}
		else
		{
			if ( array_key_exists( 'ml', $result[0] ) )
			{
				foreach( $result[0]['ml'] as $key => $val )
				{
					$ml[$key] = $this->cimongo->where( array( 'uid' => $val ) )->get('user')->result_array()[0];
				}
			}
			$result[0]['ml'] = $ml;
			if ( array_key_exists( 'created_at', $result[0] ) )
			{
				$result[0]['created_at'] = $result[0]['created_at']->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s');
			}
			else
			{
				$result[0]['created_at'] = '0000-00-00 00:00:00';
			}
			$this->redis = new CI_Redis();
			$this->reflection = new ReflectionMethod('CI_Redis', '_encode_request');
			$this->reflection->setAccessible(TRUE);
			$this->redis->command('SELECT 10');

			if ( ENVIRONMENT != 'production' )
			{
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

	public function stdleave()
	{
		$query = $this->cimongo->where(array( 'name' => $this->input->post('school') ))->get('school')->result_array();
		$ml = array();
		foreach( $query[0]['ml'] as $row )
		{
			if ( $row != $this->input->post('uid') )
			{
				array_push($ml, $row);
			}
		}

		$uQuery = $this->cimongo->where(array( 'uid' => $this->input->post('uid') ))->get('user')->result_array();
		if ( array_key_exists('stats', $uQuery[0]) )
		{
			if ( array_key_exists('star_explore', $uQuery[0]['stats']) )
			{
				$st = new MongoInt64($query[0]['st'] - $uQuery[0]['stats']['star_explore']);
			}
			else
			{
				$st = new MongoInt64($query[0]['st']);
			}
			if ( array_key_exists('tp8000', $uQuery[0]['stats']) )
			{
				$tp3 = new MongoInt64($query[0]['tp3'] - $uQuery[0]['stats']['tp8000']);
			}
			else
			{
				$tp3 = new MongoInt64($query[0]['tp3']);
			}
			if ( array_key_exists('tp8001', $uQuery[0]['stats']) )
			{
				$tp4 = new MongoInt64($query[0]['tp4'] - $uQuery[0]['stats']['tp8001']);
			}
			else
			{
				$tp4 = new MongoInt64($query[0]['tp4']);
			}
			if ( array_key_exists('tp8002', $uQuery[0]['stats']) )
			{
				$tp5 = new MongoInt64($query[0]['tp5'] - $uQuery[0]['stats']['tp8002']);
			}
			else
			{
				$tp5 = new MongoInt64($query[0]['tp5']);
			}
			if ( array_key_exists('tp9000', $uQuery[0]['stats']) )
			{
				$tp6 = new MongoInt64($query[0]['tp6'] - $uQuery[0]['stats']['tp9000']);
			}
			else
			{
				$tp6 = new MongoInt64($query[0]['tp6']);
			}
			if ( array_key_exists('tp9001', $uQuery[0]['stats']) )
			{
				$tp9 = new MongoInt64($query[0]['tp9'] - $uQuery[0]['stats']['tp9001']);
			}
			else
			{
				$tp9 = new MongoInt64($query[0]['tp9']);
			}
		}
		else
		{
			$st = new MongoInt64($query[0]['st']);
			$tp3 = new MongoInt64($query[0]['tp3']);
			$tp4 = new MongoInt64($query[0]['tp4']);
			$tp5 = new MongoInt64($query[0]['tp5']);
			$tp6 = new MongoInt64($query[0]['tp6']);
			$tp9 = new MongoInt64($query[0]['tp9']);
		}



		$this->cimongo->where( array( 'name' => $this->input->post( 'school' ) ) )->set(
						array(
							'ml' => $ml,
							'st' => $st,
							'tp3' => $tp3,
							'tp4' => $tp4,
							'tp5' => $tp5,
							'tp6' => $tp6,
							'tp9' => $tp9
						)
		)->update('school');
		$this->cimongo->where( array( 'uid' => $this->input->post('uid') ) )->unset_field( array( 'school' ) )->update('user');

		$this->redis = new CI_Redis();
		$this->reflection = new ReflectionMethod('CI_Redis', '_encode_request');
		$this->reflection->setAccessible(TRUE);
		$this->redis->command('SELECT 10');

		if ( ENVIRONMENT != 'production' )
		{
			$this->redis->command( 'ZREM rs_dev|school_rank_star|'.$query[0]['_id']->__toString().' '.$this->input->post('uid') );
			$this->redis->command( 'ZREM rs_dev|school_rank_trophy|'.$query[0]['_id']->__toString().':3 '.$this->input->post('uid') );
			$this->redis->command( 'ZREM rs_dev|school_rank_trophy|'.$query[0]['_id']->__toString().':4 '.$this->input->post('uid') );
			$this->redis->command( 'ZREM rs_dev|school_rank_trophy|'.$query[0]['_id']->__toString().':5 '.$this->input->post('uid') );
			$this->redis->command( 'ZREM rs_dev|school_rank_trophy|'.$query[0]['_id']->__toString().':6 '.$this->input->post('uid') );
			$this->redis->command( 'ZREM rs_dev|school_rank_trophy|'.$query[0]['_id']->__toString().':9 '.$this->input->post('uid') );
		}
		else
		{
			$this->redis->command( 'ZREM rs|school_rank_star|'.$query[0]['_id']->__toString().' '.$this->input->post('uid') );
			$this->redis->command( 'ZREM rs|school_rank_trophy|'.$query[0]['_id']->__toString().':3 '.$this->input->post('uid') );
			$this->redis->command( 'ZREM rs|school_rank_trophy|'.$query[0]['_id']->__toString().':4 '.$this->input->post('uid') );
			$this->redis->command( 'ZREM rs|school_rank_trophy|'.$query[0]['_id']->__toString().':5 '.$this->input->post('uid') );
			$this->redis->command( 'ZREM rs|school_rank_trophy|'.$query[0]['_id']->__toString().':6 '.$this->input->post('uid') );
			$this->redis->command( 'ZREM rs|school_rank_trophy|'.$query[0]['_id']->__toString().':9 '.$this->input->post('uid') );
		}

		var_export(true);
	}
}
?>