<?php
/**
 * config.php
 *
 * Author: pixelcave
 *
 * Global configuration file
 *
 */

// Include Template class
require 'classes/Template.php';

// Create a new Template Object
$one                               = new Template('OneUI', '2.1', '/assets'); // Name, version and assets folder's name

// Global Meta Data
$one->author                       = 'pixelcave';
$one->robots                       = 'noindex, nofollow';
$one->title                        = 'Rythem Star - Admin';
$one->description                  = 'Rythem Star - Admin';

// Global Included Files (eg useful for adding different sidebars or headers per page)
$one->inc_side_overlay             = 'base_side_overlay.php';
$one->inc_sidebar                  = 'base_sidebar.php';
$one->inc_header                   = 'base_header.php';

// Global Color Theme
$one->theme                        = '';       // '' for default theme or 'amethyst', 'city', 'flat', 'modern', 'smooth'

// Global Cookies
$one->cookies                      = false;    // True: Remembers active color theme between pages (when set through color theme list), False: Disables cookies

// Global Body Background Image
$one->body_bg                      = '';       // eg 'assets/img/photos/photo10@2x.jpg' Useful for login/lockscreen pages

// Global Header Options
$one->l_header_fixed               = true;     // True: Fixed Header, False: Static Header

// Global Sidebar Options
$one->l_sidebar_position           = 'left';   // 'left': Left Sidebar and right Side Overlay, 'right': Flipped position
$one->l_sidebar_mini               = false;    // True: Mini Sidebar Mode (> 991px), False: Disable mini mode
$one->l_sidebar_visible_desktop    = true;     // True: Visible Sidebar (> 991px), False: Hidden Sidebar (> 991px)
$one->l_sidebar_visible_mobile     = false;    // True: Visible Sidebar (< 992px), False: Hidden Sidebar (< 992px)

// Global Side Overlay Options
$one->l_side_overlay_hoverable     = false;    // True: Side Overlay hover mode (> 991px), False: Disable hover mode
$one->l_side_overlay_visible       = false;    // True: Visible Side Overlay, False: Hidden Side Overlay

// Global Sidebar and Side Overlay Custom Scrolling
$one->l_side_scroll                = true;     // True: Enable custom scrolling (> 991px), False: Disable it (native scrolling)

// Global Active Page (it will get compared with the url of each menu link to make the link active and set up main menu accordingly)
$one->main_nav_active              = '/'.$this->uri->uri_string();

// Global Main Menu
$CI =& get_instance();
$CI->load->model('Model_Admin', 'dbAdmin');

//if ( $CI->session->userdata('language') == '' || $CI->session->userdata('language') == null ) $CI->session->set_userdata( array( 'language' => $CI->config->item('language') ) );
$arrMenu = $CI->dbAdmin->menulist()->result_array();
foreach( $arrMenu as $key => $val )
{
	$changerow = array();
	if ( $val['_controller'] === null && $val['_view'] === null )
	{
		$changerow['name'] = '<span class="sidebar-mini-hide">'.$val['_title'].'</span>';
		$changerow['sub'] = $CI->dbAdmin->menusublist($val['_parent_id'])->result_array();
	}
	else
	{
		$changerow['name'] = $val['_title'];
		$changerow['url'] = '/'.$val['_controller'].'/'.$val['_view'];
	}
	if ( $val['_icon'] !== null ) $changerow['icon'] = $val['_icon'];

	$arrMenu[$key] = $changerow;
}
$one->main_nav                     = $arrMenu;
