<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

const PLATFORM_URL = (ENVIRONMENT !== 'production' ? 'http://dev.platform.perplelab.com/5000' : 'http://172.31.16.12:3000/5000');

const MENUARRAY = array(
	array(
		'seq' => 0,
		'name' => '캐릭터조회',
		'submenu' => array(
			array(
				'subseq' => 0,
				'subname' => '기본정보',
				'viewauthor' => 0
			),array(
				'subseq' => 1,
				'subname' => '선물함',
				'viewauthor' => 0
			),array(
				'subseq' => 2,
				'subname' => '메세지함',
				'viewauthor' => 0
			),array(
				'subseq' => 3,
				'subname' => '히어로',
				'viewauthor' => 0
			),array(
				'subseq' => 4,
				'subname' => '스테이지',
				'viewauthor' => 0
			),array(
				'subseq' => 5,
				'subname' => '자유모드',
				'viewauthor' => 0
			),array(
				'subseq' => 6,
				'subname' => '학교',
				'viewauthor' => 0
			)
		),
		'viewauthor' => 0
	), array(
		'seq' => 1,
		'name' => '학교',
		'submenu' => array(),
		'viewauthor' => 0
	), array(
		'seq' => 2,
		'name' => '결제',
		'submenu' => array(
			array(
				'subseq' => 0,
				'subname' => '결제내역',
				'viewauthor' => 0
			),array(
				'subseq' => 1,
				'subname' => '재화사용',
				'viewauthor' => 0
			)
		),
		'viewauthor' => 0
	), array(
		'seq' => 3,
		'name' => '일괄지급',
		'submenu' => array(),
		'viewauthor' => 0
	), array(
		'seq' => 4,
		'name' => '전체유저지급',
		'submenu' => array(),
		'viewauthor' => 0
	), array(
		'seq' => 5,
		'name' => '일괄제재',
		'submenu' => array(),
		'viewauthor' => 0
	), array(
		'seq' => 6,
		'name' => '이벤트관리',
		'submenu' => array(),
		'viewauthor' => 0
	), array(
		'seq' => 7,
		'name' => '랭킹',
		'submenu' => array(
			array(
				'subseq' => 0,
				'subname' => 'TOP300',
				'viewauthor' => 0
			),array(
				'subseq' => 1,
				'subname' => '개인',
				'viewauthor' => 0
			)
		),
		'viewauthor' => 0
	), array(
		'seq' => 8,
		'name' => '동접그래프',
		'submenu' => array(),
		'viewauthor' => 0
	), array(
		'seq' => 9,
		'name' => '서버관리',
		'submenu' => array(
			array(
				'subseq' => 0,
				'subname' => '점검팝업',
				'viewauthor' => 0
			),array(
				'subseq' => 1,
				'subname' => '푸시관리',
				'viewauthor' => 0
			)
		),
		'viewauthor' => 0
	)
);

const ITEMARRAY = array(
		'cash' => '캐시',
		'heart' => '하트선물',
		'gold' => '골드',
		'normal_random_box_hero' => '일반히어로뽑기권',
		'premium_random_box_hero' => '고급히어로뽑기권',
		'event_random_box_hero' => '고급뽑기권',
		'item_free_ticket_1h' => '자유모드 1시간 이용권',
		'item_free_ticket_1d' => '자유모드 1일 이용권',
		'item_free_ticket_7d' => '자유모드 7일 이용권',
		'item_free_ticket_30d' => '자유모드 30일 이용권',
		'item_super_play' => '슈퍼 판정',
		'item_m_shield' => '미스 방패',
		'item_erase_option' => '옵션 제거',
		'item_strengthen_hp' => 'HP강화'
);

const LOGCOLUMNARRAY = array(
	'game' => array( 'created_at', 'lv', 'action', 'value1', 'value2', 'value3' ),
	'cash' => array( 'created_at', 'lv', 'category', 'description', 'cash', 'fcash', 'pcash', 'total_cash', 'value1', 'value2', 'value3' ),
	'gold' => array( 'created_at', 'lv', 'category', 'description', 'gold', 'total_gold', 'value1', 'value2', 'value3' ),
	'common' => array( 'created_at', 'lv', 'category', 'description', 't1', 'v1', 't2', 'v2', 't3', 'v3', 't4', 'v4' ),
	'hero' => array( 'created_at', 'lv', 'action', 'description', 'hid', 'value1', 'value2', 'value3', 'object_id', 'json' ),
	'item' => array( 'created_at', 'lv', 'action', 'iid', 'prev_count', 'curr_count', 'value1', 'value2', 'value3' )
);

const FREEMODEARRAY = array(
	'??? ???' => '1101', '3키 쉬움' => '1102', '??? ???' => '1103', '4키 쉬움' => '1104', '??? ???' => '1105', '5키 쉬움' => '1106', '??? ???' => '1107', '6키 쉬움' => '1108', '9키 쉬움' => '1109'
);

const ITEMNAMEARRAY = array(
	'1000' => '하트',
	'100' => '700골드',
	'200' => '1550골드',
	'300' => '3380골드',
	'400' => '7340골드',
	'500' => '15830골드',
	'9000' => '슈퍼판정',
	'9001' => '슈퍼판정',
	'4000' => '미스방패',
	'4001' => '미스방패',
	'8500' => 'HP강화',
	'8501' => 'HP강화',
	'9500' => '배속고정',
	'9501' => '배속고정',
	'8000' => '옵션제거',
	'8001' => '옵션제거',
	'3000' => '영웅 뽑기 - 골드',
	'3001' => '영웅 뽑기 - 다이아'
);

const SONGOPENARRAY = array(
	'8000 - 다이아' => '3키 - 다이아',
	'8000 - 골드' => '3키 - 골드',
	'8001 - 다이아' => '4키 - 다이아',
	'8001 - 골드' => '4키 - 골드',
	'8002 - 다이아' => '5키 - 다이아',
	'8002 - 골드' => '5키 - 골드',
	'9000 - 다이아' => '6키 - 다이아',
	'9000 - 골드' => '6키 - 골드',
	'9001 - 다이아' => '9키 - 다이아',
	'9001 - 골드' => '9키 - 골드'
);
