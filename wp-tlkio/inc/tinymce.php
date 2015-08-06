<?php
/**
 * Base class for operating the plugin
 *
 * @package WordPress
 * @subpackage WP_TlkIo
 */
class WP_TlkIo_TinyMce_Plugin {
	/**
	 * Registers the tinymce plugin for the shortcode form
	 */
	function register_plugin( $plugin_array ) {
		$plugin_array[ WP_TLKIO_SLUG ] = WP_TLKIO_URL . 'js/tinymce-plugin.js';
		return $plugin_array;
	}

	/**
	 * Adds the tinymce button for the shortcode form
	 */
	function register_button( $buttons ) {
		array_push( $buttons, WP_TLKIO_SLUG );
		return $buttons;
	}	
}