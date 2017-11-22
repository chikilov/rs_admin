<?php
class Model_Admin extends MY_Model {
	public function __construct()
	{
		parent::__construct();
		$this->DB = $this->load->database("rs_admin", TRUE);
		/**
		 * 기본적으로 CodeIgniter 는 트랜잭션을 완벽모드(Strict Mode)로 실행합니다.
		 * 완벽모드가 활성화된 상태에서는 여러그룹의 트랜잭션을 실행했을때 단하나라도 실패하게되면 전체는 롤백됩니다.
		 * 만약 완벽모드가 비활성화라면, 여러그룹의 트랜잭션을 실행했을때
		 * 각각의 그룹은 독립적으로 실행되기때문에 각 그룹내에서만 성공여부에따라서 커밋,롤백 하게 됩니다.
		 * 즉 그룹간에는 서로 영향이 없습니다.
		 */
		$this->DB->trans_strict(FALSE);
		$this->DB->query("SET NAMES utf8");
	}
	public function __destruct() {
		$this->DB->close();
	}
	/************************* 트랜젝션 자동 처리용********************/
	/************************* 주의 : 트랜젝션 자동 처리용 함수와 수동 처리용 함수에 대해 섞어서 사용하면 안됨.********************/
	/**
	 * 트랜젝션 시작
	 */
	public function onStartTransaction()
	{
		$this->DB->trans_start();
	}
	/**
	 * 트랜젝션 종료
	 *start/complete 함수사이에 원하는 수 만큼의 쿼리를 실행하면 전체의 성공여부에따라 함수들이 알아서 커밋 혹은 롤백을 수행합니다.
	*/
	public function onCompleteTransaction()
    {
        $this->DB->trans_complete();
    }
	/************************* 트랜젝션 수동 처리용********************/
	/*
	 * 트랜젝션에 대한 처리를 수동으로 처리할때 사용하는 함수
	*/
	public function onBeginTransaction()
	{
		$this->DB->trans_begin();
	}
	/*
	 * 예외 상황 발생시 처리용
	*/
	public function onRollbackTransaction()
	{
		$this->DB->trans_rollback();
	}
	/*
	 * 로직이 끝나는 시점에서 호출해서 쿼리 수행에 문제가 있었는지 판단하여 롤벡 또는 커밋 시켜주는 함수.
	*/
	public function onEndTransaction()
	{
		if ($this->DB->trans_status() === FALSE)
		{
			$this->DB->trans_rollback();
		}
		else
		{
			$this->DB->trans_commit();
		}
	}

	public function select_user_by_email( $email )
	{
		$query = "select _username, _password, _name from tb_admin_master where _email = ? ";

		return $this->DB->query( $query, array( $email ) );
	}

	public function insert_user_pass_temp( $email, $rand_string )
	{
		$query = "insert into admin_user_pass_temp ( admin_email, rand_string, is_used ) values ( ?, ?, 0 ) ";
		$this->DB->query( $query, array( $email, $rand_string ) );

		return $this->DB->affected_rows();
	}

	public function select_change_log_by_email( $email )
	{
		$query = "select idx, rand_string from admin_user_pass_temp where admin_email = ? ";

		return $this->DB->query( $query, array( $email ) );
	}

	public function update_admin_user_password( $idx, $password )
	{
		$query = "update tb_admin_master a inner join admin_user_pass_temp b on a._email = b.admin_email set a._password = password(?), b.is_used = 1 where b.idx = ? ";
		$this->DB->query( $query, array( $password, $idx ) );

		return $this->DB->affected_rows();
	}

	public function select_admin_user_with_id_password( $admin_id, $admin_pass )
	{
		$query = "select _username, _auth from tb_admin_master where _username = ? and _password = password(?) and _deleted = 0 and _approved = 1 ";

		return $this->DB->query( $query, array( $admin_id, $admin_pass ) );
	}

	public function presentLogging( $begin_at, $end_at, $item_id, $sendtext, $admin_memo, $count, $key )
	{
		$query = "insert into present_log ( begin_at, end_at, item_id, sendtext, admin_memo, count, admin_id, reg_at, mongo_key ) values ( ?, ?, ?, ?, ?, ?, ?, now(), ? ) ";

		$this->DB->query( $query, array( $begin_at, $end_at, $item_id, $sendtext, $admin_memo, $count, $this->session->userdata('admin_id'), $key ) );
		return $this->DB->affected_rows();
	}

	public function presentlog( $start_date, $end_date )
	{
		$query = "select idx, begin_at, end_at, item_id, sendtext, admin_memo, count, admin_id, reg_at, mongo_key from present_log ";
		$query .= "where reg_at between '".$start_date." 00:00:00' and '".$end_date." 23:59:59' ";

		return $this->DB->query( $query, array() );
	}

	public function presentLoggingedit( $begin_at, $end_at, $item_id, $sendtext, $admin_memo, $count, $idx )
	{
		$query = "update present_log set begin_at = ?, end_at = ?, item_id = ?, sendtext = ?, admin_memo = ?, count = ?, admin_id = ?, reg_at = NOW() where idx = ? ";

		$this->DB->query( $query, array( $begin_at, $end_at, $item_id, $sendtext, $admin_memo, $count, $this->session->userdata('admin_id'), $idx ) );
		return $this->DB->affected_rows();
	}

	public function presentLoggingdelete( $idx )
	{
		$query = "delete from present_log where idx = ? ";

		$this->DB->query( $query, array( $idx ) );
		return $this->DB->affected_rows();
	}

	public function presentmultilog( $uid, $expired_at, $item_id, $sendtext, $admin_memo, $logc, $count, $mongo_key )
	{
		$query = "insert into presentmulti_log ( uid, expired_at, item_id, sendtext, admin_memo, count, admin_id, reg_at, mongo_key, logc ) values ";
		$query .= "( '".implode( ',', $uid )."', '".$expired_at."', '".$item_id."', '".$sendtext."', '".$admin_memo."', '".$count."', '".$this->session->userdata('admin_id')."', now(), '".$mongo_key."', '".$logc."' )";

		$this->DB->query( $query, array() );
		return $this->DB->affected_rows();
	}

	public function presentmultiloginfo( $start_date, $end_date )
	{
		$query = "select uid, expired_at, item_id, sendtext, admin_memo, logc, count, admin_id, reg_at, mongo_key from presentmulti_log ";
		if ( $start_date != '' && $end_date != '' )
		{
			$query .= "where reg_at between '".$start_date." 00:00:00' and '".$end_date." 23:59:59' ";
		}

		return $this->DB->query($query);
	}

	public function selectVersion( $app_ver, $name, $md5, $size )
	{
		$query = "select * from patch_version_info where app_ver = ? and name = ? and md5 = ? and size = ? ";

		$this->DB->query( $query, array( $app_ver, $name, $md5, $size ) );
		return $this->DB->affected_rows();
	}

	public function insertVersion( $app_ver, $name, $md5, $size, $version, $admin_memo )
	{
		$query = "insert into patch_version_info (app_ver, name, md5, size, version, admin_memo) values ( ?, ?, ?, ?, ?, ? ) ";

		return $this->DB->query( $query, array( $app_ver, $name, $md5, $size, $version, $admin_memo ) );
	}

	public function insertCheck( $action, $text, $url, $begin_at, $end_at )
	{
		$query = "insert into check_reg_info (inspection_text, confirm_url, begin_at, end_at, action, created_at, reg_id) values ( ?, ?, ?, ?, ?, now(), ? ) ";

		return $this->DB->query( $query, array( $text, $url, $begin_at, $end_at, $action, $this->session->userdata('admin_id') ) );
	}

	public function adminLoginsert( $action, $details, $uid = null )
	{
		$query = "insert into admin_log ( admin_id, action, details, uid, created_at ) value ( ?, ?, ?, ?, NOW() )";

		$this->DB->query( $query, array( $this->session->userdata('admin_id'), $action, $details, $uid ) );
		return $this->DB->affected_rows();
	}

	public function pushloginsert( $push_id, $message, $push_time )
	{
		$query = "insert into push_log (push_id, message, push_time) values ( ?, ?, ? )";

		$this->DB->query( $query, array( $push_id, $message, $push_time ) );
		return $this->DB->affected_rows();
	}

	public function pushlogselect( $push_id )
	{
		$query = "select message, push_time from push_log where push_id = ? ";

		return $this->DB->query( $query, array( $push_id ) );
	}

	public function massblockins( $block_type, $end_at, $block_reason )
	{
		$query = "insert into block_list ( block_type, end_at, block_reason, created_at, admin_id ) values ";
		$query .= "( '".$block_type."', '".$end_at."', '".$block_reason."', now(), '".$this->session->userdata('admin_id')."' ) ";

		$this->DB->query( $query, array() );
		return $this->DB->insert_id();
	}

	public function massblockdetins( $insert_id, $row, $result )
	{
		$query = "insert into block_detail_list ( pidx, uid, is_proc ) values ( '".$insert_id."', '".$row."', ".$result." ) ";

		$this->DB->query( $query, array() );
		return $this->DB->affected_rows();
	}

	public function blockinfo()
	{
		$query = "select a.idx, a.block_type, a.end_at, a.block_reason, a.created_at, a.admin_id, ";
		$query .= "sum(b.is_proc) as succ, count(b.uid) - sum(b.is_proc) as fail ";
		$query .= "from block_list as a inner join block_detail_list as b on a.idx = b.pidx ";
		$query .= "group by a.idx, a.block_type, a.end_at, a.block_reason, a.created_at, a.admin_id ";

		return $this->DB->query( $query, array() );
	}

	public function blockdetail( $idx )
	{
		$query = "select uid, is_proc from block_detail_list where pidx = '".$idx."' ";

		return $this->DB->query( $query, array() );
	}

	public function menulist()
	{
		$query = "select a._title_kr as _title, a._controller, a._view, a._icon, a._require_login, a._parent_id ";
		$query .= "from tb_admin_menu as a ";
		$query .= "inner join tb_admin_auth as b on b._group_id = '".$this->session->userdata('admin_auth')."' and a._id = b._menu_id ";
		$query .= "where a._active = 1 and b._auth_view = 1 and a._id = a._parent_id order by a._order asc ";

		return $this->DB->query( $query, array() );
	}

	public function menusublist( $parent_id )
	{
		$query = "select a._title_kr as name, concat( '/', a._controller, '/', a._view ) as url, a._icon, a._require_login, a._parent_id ";
		$query .= "from tb_admin_menu as a ";
		$query .= "inner join tb_admin_auth as b on b._group_id = '".$this->session->userdata('admin_auth')."' and a._id = b._menu_id ";
		$query .= "where a._active = 1 and b._auth_view = 1 and a._id != a._parent_id and a._parent_id = '".$parent_id."' order by a._order asc ";

		return $this->DB->query( $query, array() );
	}

	public function grouplist()
	{
		$query = "select _id, _title_kr from tb_admin_menu ";
		$query .= "where _controller is null and _view is null group by _id, _title_kr ";

		return $this->DB->query( $query, array() );
	}

	public function menufulllist()
	{
		$query = "select a._id, a._title_kr, a._controller, a._view, a._icon, a._order, a._require_login, a._parent_id, ";
		$query .= "a._active, b._title_kr as _group_name_kr, count(c._id) as _sub_count ";
		$query .= "from tb_admin_menu as a ";
		$query .= "left outer join tb_admin_menu as b on a._parent_id = b._id ";
		$query .= "left outer join tb_admin_menu as c on a._id = c._parent_id ";
		$query .= "group by a._id, a._title_kr, a._controller, a._view, a._icon, a._order, a._require_login, a._parent_id, ";
		$query .= "a._active, b._title_kr order by a._order asc ";

		return $this->DB->query( $query, array() );
	}

	public function menudetails( $id )
	{
		$query = "select _id, _title_kr, _controller, _view, _icon, _order, _parent_id, _active ";
		$query .= "from tb_admin_menu ";
		$query .= "where _id = '".$id."' ";

		return $this->DB->query( $query, array() );
	}

	public function menudel( $id )
	{
		$query = "update tb_admin_menu set _active = 0 where _id = '".$id."' ";

		$this->DB->query( $query, array() );
		return $this->DB->affected_rows();
	}

	public function menuinsert( $_title_kr, $_controller, $_view, $_icon, $_group_id, $_active )
	{
		$query = "insert into tb_admin_menu ( _title_kr, _controller, _view, _icon, _order, _require_login, _parent_id, _active ) ";
		$query .= "values ( '".$_title_kr."', if( '".$_controller."' = '', null, '".$_controller."'), if( '".$_view."' = '', null, '".$_view."'), ";
		$query .= "if( '".$_icon."' = '', null, '".$_icon."'), 100, 1, ";
		$query .= "if( '".$_group_id."' = '', null, if( '".$_group_id."' = '0', ( ";
		$query .= "select auto_increment from information_schema.tables where table_name = 'tb_admin_menu' and table_schema = '".$this->config->item('db_prefix')."base' ";
		$query .= "), '".$_group_id."' ) ), '".$_active."' ) ";

		$this->DB->query( $query, array() );
		return $this->DB->insert_id();
	}

	public function menuupdate( $_title_kr, $_controller, $_view, $_icon, $_group_id, $_active, $_id )
	{
		$query = "update tb_admin_menu set ";
		$query .= "_title_kr = '".$_title_kr."', _controller = if( '".$_controller."' = '', null, '".$_controller."'), ";
		$query .= "_view = if( '".$_view."' = '', null, '".$_view."'), _icon = if( '".$_icon."' = '', null, '".$_icon."'), ";
		$query .= "_require_login = 1, _parent_id = '".$_group_id."', _active = '".$_active."' ";
		$query .= "where _id = '".$_id."' ";

		$this->DB->query( $query, array() );
		return $this->DB->affected_rows();
	}

	public function menuorder( $_id, $_order )
	{
		$query = "update tb_admin_menu set ";
		$query .= "_order = '".$_order."' where _id = '".$_id."' ";

		$this->DB->query( $query, array() );
		return $this->DB->affected_rows();
	}

	public function accountlist()
	{
		$query = "select a._username, a._name, a._depart, a._regdate, a._approved, a._ipaddr, b._group_name, a._deleted from tb_admin_master as a ";
		$query .= "left outer join tb_admin_group as b on a._auth = b._group_id ";

		return $this->DB->query( $query, array() );
	}

	public function accountdetails( $account )
	{
		$query = "select _username, _name, _depart, _auth, _reason, _approved, _deleted from tb_admin_master where _username = '".$account."' ";

		return $this->DB->query( $query, array() );
	}

	public function admingrouplist()
	{
		$query = "select _group_id, _group_name, _group_applies from tb_admin_group ";

		return $this->DB->query( $query, array() );
	}

	public function accountupdate( $_username, $_name, $_reason, $_depart, $_auth, $_approved, $_deleted )
	{
		$query = "update tb_admin_master set ";
		$query .= "_username = '".$_username."', ";
		$query .= "_name = '".$_name."', ";
		$query .= "_reason = '".$_reason."', ";
		$query .= "_depart = '".$_depart."', ";
		$query .= "_auth = '".$_auth."', ";
		if ( $_deleted == '1' )
		{
			$query .= "_deleted = '".$_deleted."', ";
			$query .= "_deldate = now(), ";
		}
		$query .= "_approved = '".$_approved."' ";
		$query .= "where _username = '".$_username."' ";

		$this->DB->query( $query, array() );
		return $this->DB->affected_rows();
	}

	public function accountpassword( $_username )
	{
		$query = "update tb_admin_master set ";
		$query .= "_password = password('".date('Ymd')."'), ";
		$query .= "_lastchange = date_add(now(), interval -3 month) ";
		$query .= "where _username = '".$_username."' ";

		$this->DB->query( $query, array() );
		return $this->DB->affected_rows();
	}

	public function admingroupauth( $group_id )
	{
		$query = "select b._id, a._title_kr as _mtitle_kr, b._title_kr as _stitle_kr, ";
		$query .= "ifnull(c._auth_view, 0) as _auth_view, ifnull(c._auth_write, 0) as _auth_write ";
		$query .= "from tb_admin_menu as a ";
		$query .= "inner join tb_admin_menu as b on a._id = b._parent_id and b._id != b._parent_id ";
		$query .= "left outer join tb_admin_auth as c on b._id = c._menu_id and c._group_id = ? order by b._order asc ";

		return $this->DB->query( $query, array( $group_id ) );
	}

	public function adminauthupdate( $group_id, $id, $view, $write )
	{
		$query = "insert into tb_admin_auth values ( ?, ?, if( ? = 'true', 1, 0), if( ? = 'true', 1, 0), now() ) ";
		$query .= "on duplicate key update _auth_view = if( ? = 'true', 1, 0), _auth_write = if( ? = 'true', 1, 0), _regdate = now() ";

		$this->DB->query( $query, array( $group_id, $id, $view, $write, $view, $write ) );
		return $this->DB->affected_rows();
	}

	public function adminauthparentupdate( $group_id, $id, $view, $write )
	{
		$query = "insert into tb_admin_auth values ";
		$query .= "( ?, ( select _parent_id from tb_admin_menu where _id = ? ), if( ? = 'true', 1, 0), if( ? = 'true', 1, 0), now() ) ";
		$query .= "on duplicate key update _auth_view = if( ? = 'true', 1, 0), _auth_write = if( ? = 'true', 1, 0), _regdate = now() ";

		$this->DB->query( $query, array( $group_id, $id, $view, $write, $view, $write ) );
		return $this->DB->affected_rows();
	}

	public function adminauthparentvalue( $group_id )
	{
		$query = "select a._parent_id, sum(b._auth_view) as sumval from tb_admin_menu as a inner join tb_admin_auth as b on a._id = b._menu_id ";
		$query .= "where b._group_id = ? and a._id != a._parent_id group by a._parent_id ";

		return $this->DB->query( $query, array( $group_id ) );
	}

	public function groupnamecheck( $group_name )
	{
		$query = "select _group_id from tb_admin_group where _group_name = ? ";

		$this->DB->query( $query, array( $group_name ) );
		return $this->DB->affected_rows();
	}

	public function authgroupinsert( $group_name, $group_applies )
	{
		$query = "insert into tb_admin_group ( _group_name, _group_applies, _regdate, _admin_id ) values ( ?, ?, now(), ? ) ";

		$this->DB->query( $query, array( $group_name, $group_applies, $this->session->userdata('admin_id') ) );
		return $this->DB->insert_id();
	}

	public function authdelete( $group_id )
	{
		$query = "delete from tb_admin_auth where _group_id = ? ";

		$this->DB->query( $query, array( $group_id ) );
		return $this->DB->affected_rows();
	}

	public function loadauth( $uri )
	{
		$query = "select a._auth_view, a._auth_write ";
		$query .= "from tb_admin_auth as a ";
		$query .= "left outer join tb_admin_master as b on a._group_id = b._auth ";
		$query .= "left outer join tb_admin_menu as c on a._menu_id = c._id ";
		$query .= "where b._username = ? and c._controller = ? and c._view = ? ";

		return $this->DB->query( $query, array( $this->session->userdata('admin_id'), $uri[0], $uri[1] ) );
	}

	public function authgroupdelete( $group_id )
	{
		$query = "delete from tb_admin_group where _group_id = ? ";

		$this->DB->query( $query, array( $group_id ) );
		return $this->DB->affected_rows();
	}

	public function adminlog( $start_date, $end_date, $search_type, $search_value )
	{
		$query = "select idx, admin_id, uid, action, details, created_at from admin_log ";
		$query .= "where created_at between '".$start_date." 00:00:00' and '".$end_date." 23:59:59' and ".$search_type." = '".$search_value."' ";

		return $this->DB->query( $query, array() );
	}

	public function selectUsername( $username )
	{
		$query = "select _username from tb_admin_master where _username = ? ";

		$this->DB->query( $query, array( $username ) );
		return $this->DB->affected_rows();
	}

	public function insertUser( $username, $password, $name, $_email, $depart, $reason )
	{
		$query = "insert into tb_admin_master ( _username, _password, _name, _email, _depart, _reason, _ipaddr, _lastchange, _regdate ) value ";
		$query .= "( ?, password(?), ?, ?, ?, ?, ?, now(), now() ) ";

		$this->DB->query( $query, array( $username, $password, $name, $_email, $depart, $reason, $this->input->server('REMOTE_ADDR') ) );
		return $this->DB->affected_rows();
	}
}
?>