<?php
/*
Plugin Name: JM Simple QR code Widget
Plugin URI: http://www.tweetpress.fr
Description: Meant to add a widget with simple QR code for your posts
Author: Julien Maury
Author URI: http://www.julien-maury.com
Version: 1.4.5
Text Domain: jm-sqrw
Domain Path: /langs/
License: GPL2++
*/
/*  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// source : http://goqr.me/api/doc/create-qr-code/

defined('ABSPATH') or die('No no, no no no no, there\'s a limit !');

// Constants
define( 'SQRW_VERSION', 	'1.4.5' );
define( 'SQRW_DIR', 		plugin_dir_path( __FILE__ ));
define( 'SQRW_DIR_LIB', 	trailingslashit(plugin_dir_path( __FILE__ ) .'/inc/lib'));
define( 'SQRW_URL', 		plugin_dir_url( __FILE__ ));
define( 'SQRW_LANG_DIR', 	dirname(plugin_basename(__FILE__)) . '/langs/' );


// Init
add_action( 'plugins_loaded', 'jm_sqrw_init' );
function jm_sqrw_init() {

	require( SQRW_DIR . 'inc/qr_widget.class.php' );
	
	// Widget
	add_action( 'widgets_init', create_function('', 'return register_widget("JM_SQR_Widget");') );
	
	// Lang
	load_plugin_textdomain('jm-sqrw', FALSE, SQRW_LANG_DIR);
	
}
