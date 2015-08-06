<?php
/*
Plugin Name: WP tlk.io
Plugin URI: http://vagrantcode.com
Description: A plugin to integrate <a href="http://tlk.io">tlk.io chat</a> on any page or post on your website using a shortcode. Insert a shortcode with the shortcode generator located in the WYSIWYG editor. There is currently no options page for this plugin.
Version: 0.9.1
Author URI: http://vagrantcode.com/
Author: Vagrant Code
Author Email: support@vagrantcode.com
License: GPL2

  Copyright 2014 Brad Bodine, Luke Howell (support@vagrantcode.com)

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

// Defines for plugin functionality
define( 'WP_TLKIO_SLUG', 'wp_tlkio' );
define( 'WP_TLKIO_VERSION', 0.6 );
define( 'WP_TLKIO_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_TLKIO_URL',  plugin_dir_url( __FILE__ ) );

// Default shortcode options
$wp_tlkio_shortcode_defaults = array(
	'channel'     => 'lobby',
	'width'       => '100%',
	'height'      => '400px',
	'float'       => 'left',
	'stylesheet'  => '',
	'offclass'    => 'offmessage',
	'activated'   => __( 'The chat has been activated.', WP_TLKIO_SLUG ),
	'deactivated' => __( 'The chat has been deactivated.', WP_TLKIO_SLUG ),
	'starton'     => '',
	'alwayson'    => ''
);

// Options no included in the shortcode
$wp_tlkio_options_default = array(
	'default_content' => __( 'Chat is currently off.<br>Check back later.', WP_TLKIO_SLUG ),
	'ison' => null
);

// Combine the shortcodes
array_merge( $wp_tlkio_options_default, $wp_tlkio_shortcode_defaults );

/**
 * Base class for operating the plugin
 *
 * @package WordPress
 * @subpackage WP_TlkIo
 */
class WP_TlkIo {

	/**
	 * Constructor
	 */
	function __construct() {
		// Hook to the init action in WordPress
		add_action( 'init', array( &$this, 'init_wp_tlkio' ) );
	}

	/**
	 * Runs when the plugin is initialized
	 */
	function init_wp_tlkio() {
		// Require necessary files
		require_once( WP_TLKIO_PATH . 'inc/tinymce.php' );
		require_once( WP_TLKIO_PATH . 'inc/ajax.php' );
		require_once( WP_TLKIO_PATH . 'inc/shortcode.php' );

		// Objects for functioning
		$tinymce   = new WP_TlkIo_TinyMce_Plugin;
		$ajax      = new WP_TlkIo_AJAX;
		$shortcode = new WP_TlkIo_Shortcode;

		// Setup localization
		load_plugin_textdomain( WP_TLKIO_SLUG, false, WP_TLKIO_PATH . 'lang' );

		// Load JavaScript and stylesheets
		$this->scripts_and_styles();

		// Hook AJAX calls
		$this->ajax_hooks( $ajax );

		// Register the shortcode [tlkio]
		add_shortcode( 'tlkio', array( &$shortcode, 'render_tlkio_shortcode' ) );

		// Add code to the admin footer
		add_action( 'in_admin_footer', array( &$shortcode, 'add_shortcode_form' ) );

		// Load the tinymce extras if the user can edit things and has rich editing enabled
		if( is_admin() && ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) && get_user_option( 'rich_editing' ) ) {
			add_filter( 'mce_external_plugins',   array( &$tinymce, 'register_plugin' ) );
			add_filter( 'mce_buttons',            array( &$tinymce, 'register_button' ) );
		}
	}	

	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	function scripts_and_styles() {
		if ( is_admin() )
		{
			wp_register_style( WP_TLKIO_SLUG . '-admin-style', WP_TLKIO_URL . 'css/admin-style.css' );
			wp_enqueue_style( WP_TLKIO_SLUG . '-admin-style' );
		}
		else {
			wp_register_style( WP_TLKIO_SLUG . '-style', WP_TLKIO_URL . 'css/style.css' );
			wp_enqueue_style( WP_TLKIO_SLUG . '-style' );

			wp_register_script( WP_TLKIO_SLUG . '-script', WP_TLKIO_URL . 'js/script.js', array( 'jquery' ) );
			wp_enqueue_script( WP_TLKIO_SLUG . '-script' );
			wp_localize_script( WP_TLKIO_SLUG . '-script', 'WP_TlkIo', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			));
		}
	}

	/**
	 * Registers AJAX hooks
	 */
	function ajax_hooks( $ajax ) {
		// Add AJAX hook to update the chat
		add_action( 'wp_ajax_wp_tlkio_update_channel_state', array( &$ajax, 'update_channel_state' ) );
		add_action( 'wp_ajax_nopriv_wp_tlkio_update_channel_state', array( &$ajax, 'update_channel_state' ) );

		// Add AJAX hook to check for updated state
		add_action( 'wp_ajax_wp_tlkio_check_state', array( &$ajax, 'channel_state' ) );
		add_action( 'wp_ajax_nopriv_wp_tlkio_check_state', array( &$ajax, 'channel_state' ) );

		// Add AJAX hook to update the chat
		add_action( 'wp_ajax_wp_tlkio_refresh_channel', array( &$ajax, 'refresh_channel' ) );
		add_action( 'wp_ajax_nopriv_wp_tlkio_refresh_channel', array( &$ajax, 'refresh_channel' ) );
	}
}
new WP_TlkIo;