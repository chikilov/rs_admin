<?php
class Model_Log extends MY_Model {
	public function __construct()
	{
		parent::__construct();
		$this->DB = $this->load->database("rs_log", TRUE);
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

	public function tablelist( $logtype, $start_date, $end_date )
	{
		$query = "select table_name from information_schema.tables where table_schema = '".$this->DB->database."' ";
		$query .= "and table_name between '".$logtype."_log_".$start_date."' and '".$logtype."_log_".$end_date."' ";

		return $this->DB->query($query);
	}

	public function loglist( $arrTable, $uid, $logtype )
	{
		$query = "";
		foreach ( $arrTable as $row )
		{
			$query .= "select ".implode ( ", " , LOGCOLUMNARRAY[$logtype] )." from ".$row['table_name']." where uid = '".$uid."' ";
			if ( end($arrTable) != $row )
			{
				$query .= "union all ";
			}
		}

		return $this->DB->query($query);
	}

	public function purchase_loglist( $uid, $start_date, $end_date )
	{
		$query = "";
		$query .= "select id, created_at, lv, market, order_id, cash, pcash, fcash, price, v1, v2, edited_at, edited_info from purchase_log where uid = '".$uid."' and v2 = 'finish_purchase'";
		$query .= "and created_date >= '".$start_date."' ";
		$query .= "and created_date <= '".$end_date."' order by created_at desc";

		return $this->DB->query($query);
	}

	public function purchase_refund( $arr )
	{
		$date = date('Ymd', time());
		$query = "";
		$query .= "insert into cash_log_".$date." (uid, lv, lang, created_at, created_date, cash, fcash, pcash, total_cash, total_fcash, total_pcash, category, description, value1, value2, value3) values ";
		$query .= "(?,?,'ko',now(),?,?,?,?,?,?,?,'refund',?,?,'','')";

		$this->DB->query($query,
			array(
				$arr['uid']
				,$arr['lv']
				,$date
				,$arr['cash']
				,$arr['fcash']
				,$arr['pcash']
				,$arr['total_cash']
				,$arr['total_fcash']
				,$arr['total_pcash']
				,$arr['admin_id']
				,$arr['order_id']
			)
		);

		$query = "";
		$query .= "update purchase_log set edited_at = now(), edited_info = '".$this->session->userdata('admin_id')."' where id = ".$arr['id'];

		$this->DB->query($query);

		return $this->DB->affected_rows();
	}

	public function purchase_refund_cancel( $arr )
	{
		$date = date('Ymd', time());
		$query = "";
		$query .= "insert into cash_log_".$date." (uid, lv, lang, created_at, created_date, cash, fcash, pcash, total_cash, total_fcash, total_pcash, category, description, value1, value2, value3) values ";
		$query .= "(?,?,'ko',now(),?,?,?,?,?,?,?,'refund_cancel',?,?,'','')";

		$this->DB->query($query,
			array(
				$arr['uid']
				,$arr['lv']
				,$date
				,$arr['cash']
				,$arr['fcash']
				,$arr['pcash']
				,$arr['total_cash']
				,$arr['total_fcash']
				,$arr['total_pcash']
				,$arr['admin_id']
				,$arr['order_id']
			)
		);

		$query = "";
		$query .= "update purchase_log set edited_at = null, edited_info = null where id = ".$arr['id'];

		$this->DB->query($query);
		$this->DB->affected_rows();

		return $this->DB->affected_rows();
	}

	public function getminlimit( $table_name )
	{
		$query = "select min(table_name) as table_name from information_schema.tables where table_schema = '".$this->DB->database."' ";
		$query .= "and table_name like '".$table_name."%' ";

		return $this->DB->query($query);
	}

	public function statinfo1_1( $date )
	{
		$query = "select count(uid) as cnt from rs.game_log_".$date." where action = 'stage_finish' and value1 <= 19999 ";

		return $this->DB->query($query);
	}

	public function statinfo1_2( $date )
	{
		$query = "select count(uid) as cnt from rs.game_log_".$date." where action = 'stage_finish' and value1 >= 80000000 and value1 <= 90099999 ";

		return $this->DB->query($query);
	}

	public function statinfo2( $date )
	{
		$sdate = DateTime::createFromFormat('Ymd', $date);
		$query = "select '".$sdate->format('Y-m-d')."' as date, last_stage, count(uid) as cnt from rs.userinfo_backup_".$date." group by last_stage ";

		return $this->DB->query($query);
	}

	public function statinfo3( $date )
	{
		$sdate = DateTime::createFromFormat('Ymd', $date);
		$query = "select '".$sdate->format('Y-m-d')."' as date, last_stage, count(uid) as cnt from rs.userinfo_backup_".$date." ";
		$query .= "where login_at >= '".$sdate->format('Y-m-d')." 00:00:00' and login_at < '".$sdate->add( new DateInterval( 'P1D' ) )->format('Y-m-d')."' group by last_stage ";

		return $this->DB->query($query);
	}

	public function statinfo4( $date )
	{
		$sdate = DateTime::createFromFormat('Ymd', $date);
		$query = "select total.stage, total.total_try, total.clear_count, u_clear.unique_try, u_clear.unique_clear ";
		$query .= "from ( select a.stage as stage, sum(a.total_try) as total_try, sum(a.clear_count) as clear_count ";
		$query .= "from ( select value1 as stage, 1 as total_try, if((value2 = 0), 1, 0)  as clear_count ";
		$query .= "from rs.game_log_".$date." where action = 'stage_finish' and ((value1 >= 10000 and value1 <= 19999) or (value1 >= 80000000 and value1 <= 90099999)) and value2 in ('-1', '0') ) as a ";
		$query .= "group by a.stage ) as total, ( select value1 as stage, count(uid) as unique_try, sum(unique_clear) as unique_clear ";
		$query .= "from ( select a.value1, a.uid, if(sum(a.unique_clear) >= 1, 1, 0) as unique_clear from ( ";
		$query .= "select value1, uid, if(value2 = -1, 0, 1) as unique_clear from rs.game_log_".$date." where action = 'stage_finish' ";
		$query .= "and ((value1 >= 10000 and value1 <= 19999) or (value1 >= 80000000 and value1 <= 90099999)) and value2 in ('-1', '0') group by value1, uid, value2 ";
		$query .= ") as a group by a.value1, uid ) as b group by b.value1 ) as u_clear where total.stage = u_clear.stage ";

		return $this->DB->query($query);
	}

	public function statinfo5( $date )
	{
		$sdate = DateTime::createFromFormat('Ymd', $date);
		$query = "select '".$sdate->format('Y-m-d')."' as date, lv, count(uid) as cnt from rs.userinfo_backup_".$date." group by lv ";

		return $this->DB->query($query);
	}

	public function statinfo6( $date )
	{
		$sdate = DateTime::createFromFormat('Ymd', $date);
		$query = "select '".$sdate->format('Y-m-d')."' as date, lv, count(uid) as cnt from rs.userinfo_backup_".$date." ";
		$query .= "where login_at >= '".$sdate->format('Y-m-d')." 00:00:00' and login_at < '".$sdate->add( new DateInterval( 'P1D' ) )->format('Y-m-d')."' group by lv ";

		return $this->DB->query($query);
	}
}
?>