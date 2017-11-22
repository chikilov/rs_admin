<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server extends MY_Controller {

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

	public function versioninfo()
	{
		$tAppver = $this->cimongo->get('patch_version_info')->result_array();
		$arrAppver = array();
		foreach( $tAppver as $key => $val )
		{
			array_push($arrAppver, $val['app_ver']);
		}
		$arrAppver = array_unique($arrAppver);
		$arrMessage = $this->cimongo->get('rs_table_server_text')->result_array();
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname'), 'arrAppver' => $arrAppver );

		$this->load->view('versioninfo', $arrayParam);
	}

	public function versionlog()
	{
		$rowArray = $this->cimongo->get('patch_info')->result_array();

		echo json_encode( $rowArray, JSON_UNESCAPED_UNICODE );
	}

	public function versioninsert()
	{
    	if ( array_key_exists('json_str', $this->input->post()) ) {
            $versionInfo = json_decode( $this->input->post('json_str'), true );
            $addedCount = 0;
            foreach ( $versionInfo as $row ) {
                $searchArr = $this->cimongo->where( array('app_ver' => $row['app_ver'] ) )->get('patch_version_info')->result_array();
        		$this->load->model('Model_Admin', 'dbAdmin');
        		$existsCheck = $this->dbAdmin->selectVersion( $row['app_ver'], $row['name'], $row['md5'], $row['size'] );
        		if ( $existsCheck === 0 ) {
            		if ( empty($searchArr) )
            		{
            			$this->cimongo->insert( 'patch_info', array(
            							'app_ver' => $row['app_ver'],
            							'name' => $row['name'],
            							'md5' => $row['md5'],
            							'version'=> new MongoInt32(1),
            							'size' => new MongoInt64($row['size'])
            			));

            			$this->cimongo->insert( 'patch_version_info', array(
            							'app_ver' => $row['app_ver'],
            							'cur_version'=> new MongoInt32(1)
            			));

            			$this->dbAdmin->insertVersion( $row['app_ver'], $row['name'], $row['md5'], $row['size'], 1, '일괄등록' );
            			$row['version'] = 1;
            		}
            		else
            		{
            			$version = intval($searchArr[0]['cur_version']) + 1;
            			$this->cimongo->insert( 'patch_info', array(
            							'app_ver' => $row['app_ver'],
            							'name' => $row['name'],
            							'md5' => $row['md5'],
            							'version'=> new MongoInt32($version),
            							'size' => new MongoInt64($row['size'])
            			));

            			$this->cimongo->where( array( 'app_ver' => $row['app_ver'] ) )->update('patch_version_info', array('cur_version' => new MongoInt32($version)));
            			$this->dbAdmin->insertVersion( $row['app_ver'], $row['name'], $row['md5'], $row['size'], $version, '일괄등록' );
            			$row['version'] = $version;
            		}
            		$this->load->model('Model_Admin', 'dbAdmin');
            		$this->dbAdmin->adminLoginsert( '버전관리등록', 'app_ver => '.$row['app_ver'].'\nname => '.$row['name'].'\nmd5 => '.$row['md5'].'\nversion => '.$row['version'].'\nsize => '.$row['size'] );
            		$addedCount++;
        		}
            }
            echo $addedCount;
    	} else {
    		$searchArr = $this->cimongo->where( array('app_ver' => $this->input->post('app_ver') ) )->get('patch_version_info')->result_array();
    		$this->load->model('Model_Admin', 'dbAdmin');
    		if ( empty($searchArr) )
    		{
    			$this->cimongo->insert( 'patch_info', array(
    							'app_ver' => $this->input->post('app_ver'),
    							'name' => $this->input->post('name'),
    							'md5' => $this->input->post('md5'),
    							'version'=> new MongoInt32(1),
    							'size' => new MongoInt64($this->input->post('size'))
    			));

    			$this->cimongo->insert( 'patch_version_info', array(
    							'app_ver' => $this->input->post('app_ver'),
    							'cur_version'=> new MongoInt32(1)
    			));

    			$this->dbAdmin->insertVersion( $this->input->post('app_ver'), $this->input->post('name'), $this->input->post('md5'), $this->input->post('size'), 1, $this->input->post('admin_memo') );
    		}
    		else
    		{
    			$version = intval($searchArr[0]['cur_version']) + 1;
    			$this->cimongo->insert( 'patch_info', array(
    							'app_ver' => $this->input->post('app_ver'),
    							'name' => $this->input->post('name'),
    							'md5' => $this->input->post('md5'),
    							'version'=> new MongoInt32($version),
    							'size' => new MongoInt64($this->input->post('size'))
    			));

    			$this->cimongo->where( array( 'app_ver' => $this->input->post('app_ver') ) )->update('patch_version_info', array('cur_version' => new MongoInt32($version)));
    			$this->dbAdmin->insertVersion( $this->input->post('app_ver'), $this->input->post('name'), $this->input->post('md5'), $this->input->post('size'), $version, $this->input->post('admin_memo') );

    		}
    		$this->load->model('Model_Admin', 'dbAdmin');
    		$this->dbAdmin->adminLoginsert( '버전관리등록', 'app_ver => '.$this->input->post('app_ver').'\nname => '.$this->input->post('name').'\nmd5 => '.$this->input->post('md5').'\nversion => '.$this->input->post('version').'\nsize => '.$this->input->post('size') );
            echo 'true';
		}
	}

	public function versiondel()
	{
		$query = $this->cimongo->where(array( 'app_ver' => $this->input->post('app_ver') ))->get('patch_info')->result_array();
		$result = 0;
		foreach( $query as $key => $val )
		{
			if ( intval($val['version']) == $this->input->post('version') )
			{
				if ( $this->cimongo->where( array( '_id' => $val['_id'] ) )->delete('patch_info') )
				{
					$result = 1;
				}
				break;
			}

		}
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->adminLoginsert( '버전관리삭제', 'app_ver => '.$this->input->post('app_ver').'\nversion => '.$this->input->post('version') );
		echo $result;
	}

	public function statusinfo()
	{
		$arrayParam = array('searchval' => $this->session->userdata('searchval'), 'searchuid' => $this->session->userdata('searchuid'), 'searchname' => $this->session->userdata('searchname') );

		$this->load->view('statusinfo', $arrayParam);
	}

	public function checkinsert()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->insertCheck( 'insert', $this->input->post('inspection_text'), $this->input->post('confirm_url'), $this->input->post('begin_at'), $this->input->post('end_at') );

		echo boolval( $this->cimongo->insert( 'maintenance_notice', array(
						'active' => new MongoInt32(1),
						'text' => $this->input->post('inspection_text'),
						'url' => $this->input->post('confirm_url'),
						'begin_at'=> new MongoDate( strtotime( $this->input->post('begin_at') ) ),
						'end_at' => new MongoDate( strtotime( $this->input->post('end_at') ) )
		)) );
		$this->dbAdmin->adminLoginsert( '점검관리등록', 'text => '.$this->input->post('inspection_text').'\nurl => '.$this->input->post('confirm_url').'\nbegin_at => '.$this->input->post('begin_at').'\nend_at => '.$this->input->post('end_at') );
	}

	public function checklist()
	{
		$query = $this->cimongo->get('maintenance_notice')->result_array();
		foreach ( $query as $key => $val )
		{
			foreach ( $val as $skey => $sval )
			{
				if ( $sval instanceof MongoDate )
				{
					$query[$key][$skey] = $sval->toDateTime()->setTimezone(new DateTimeZone('Asia/Seoul'))->format('Y-m-d H:i:s');
				}
			}
		}

		echo json_encode($query, JSON_UNESCAPED_UNICODE);
	}

	public function checkupdate()
	{
		$this->load->model('Model_Admin', 'dbAdmin');
		$this->dbAdmin->insertCheck( 'update', $this->input->post('inspection_text'), $this->input->post('confirm_url'), $this->input->post('begin_at'), $this->input->post('end_at') );
		echo boolval( $this->cimongo->where( array( '_id' => new MongoId($this->input->post('edit_id')) ) )->set( array(
						'active' => new MongoInt32( $this->input->post('active') ),
						'text' => $this->input->post('inspection_text'),
						'url' => $this->input->post('confirm_url'),
						'begin_at'=> new MongoDate( strtotime( $this->input->post('begin_at') ) ),
						'end_at' => new MongoDate( strtotime( $this->input->post('end_at') ) )
		))->update('maintenance_notice') );
		$this->dbAdmin->adminLoginsert( '점검관리수정', 'active => '.$this->input->post('active').'\ntext => '.$this->input->post('inspection_text').'\nurl => '.$this->input->post('confirm_url').'\nbegin_at => '.$this->input->post('begin_at').'\nend_at => '.$this->input->post('end_at') );
	}
}
