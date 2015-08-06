<?php
/**
 * Base class for operating the plugin
 *
 * @package WordPress
 * @subpackage WP_TlkIo
 */
class WP_TlkIo_AJAX {
	/**
	 * Generate fresh shortcode
	 */
	function refresh_shortcode( $option_name ) {
		global $wp_tlkio_options_default;
		$channel_options = get_option( $option_name, $wp_tlkio_options_default );
		return do_shortcode( '[tlkio channel="' . $channel_options[ 'channel' ]  . '" 
											     width="' . $channel_options[ 'width' ] . '" 
											     height="' . $channel_options[ 'height' ] . '" 
											     stylesheet="' . $channel_options[ 'stylesheet' ] .'"
											     offclass="' . $channel_options[ 'offclass' ] . '"
											     activated="' . $channel_options[ 'activated' ] . '"
											     deactivated="' . $channel_options[ 'deactivated' ] . '"
											     ]' . $channel_options[ 'default_content' ] . '[/tlkio]' );
	}

	/**
	 * Turn chat room on or off
	 */
	function update_channel_state() {
		global $wp_tlkio_options_default;
		$channel_option_name = WP_TLKIO_SLUG . '_' . $_POST[ 'channel' ];
		$channel_options = get_option( $channel_option_name, $wp_tlkio_options_default );
		$channel_options[ 'ison' ] = 'on' == $_POST[ 'state' ] ? true : false;
		update_option( $channel_option_name, $channel_options );
		$result[ 'shortcode' ] = $this->refresh_shortcode( $channel_option_name );
		$result[ 'state' ] = $channel_options[ 'ison' ] ? 'on' : 'off';
		$result[ 'channel' ] = $_POST[ 'channel' ];
		echo json_encode( $result );
		die();
	}

	/**
	 * Get state of channel
	 */
	function channel_state() {
		global $wp_tlkio_options_default;
		$channel_option_name = WP_TLKIO_SLUG . '_' . $_POST[ 'channel' ];
		$channel_options = get_option( $channel_option_name, $wp_tlkio_options_default );
		$result[ 'state' ] = $channel_options[ 'ison' ] ? 'on' : 'off';
		$result[ 'channel' ] = $_POST[ 'channel' ];
		echo json_encode( $result );
		die();
	}

	/**
	 * Get refresh of the shortcode
	 */
	function refresh_channel() {
		global $wp_tlkio_options_default;
		$channel_option_name = WP_TLKIO_SLUG . '_' . $_POST[ 'channel' ];
		$channel_options = get_option( $channel_option_name, $wp_tlkio_options_default );
		$result[ 'shortcode' ] = $this->refresh_shortcode( $channel_option_name );
		$result[ 'channel' ]   = $_POST[ 'channel' ];
		$result[ 'state' ]     = $channel_options[ 'ison' ] ? 'on' : 'off';
		$result[ 'message' ]   = $channel_options[ 'ison' ] ? $channel_options[ 'activated' ] : $channel_options[ 'deactivated' ];
		echo json_encode( $result );
		die();
	}
}