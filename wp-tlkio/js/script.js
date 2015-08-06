/**
 * Copy of loading function from tlk.io/embed.js
 */
function tlkio_refresh() {
	var target_element  = document.getElementById('tlkio'),
	    channel_name    = target_element.getAttribute('data-channel'),
	    custom_css_path = target_element.getAttribute('data-theme'),
	    iframe          = document.createElement('iframe');

	var iframe_src = 'http://embed.tlk.io/' + channel_name;

	if (custom_css_path && custom_css_path.length > 0) {
	  iframe_src += ('?custom_css_path=' + custom_css_path);
	}

	iframe.setAttribute('src', iframe_src);
	iframe.setAttribute('width', '100%');
	iframe.setAttribute('height', '100%');
	iframe.setAttribute('frameborder', '0');
	iframe.setAttribute('style', 'margin-bottom: -6px;');

	var current_style = target_element.getAttribute('style');
	target_element.setAttribute('style', 'overflow: auto; -webkit-overflow-scrolling: touch;' + current_style);

	target_element.appendChild(iframe);	
}

// DOM is ready
jQuery(function($) {
	// tlk.io on/off switch is changed.
	$( '.tlkio-switch input[type="radio"]' ).live( 'change', function() {
		channel = $( this ).attr( 'name' );
		state = $( this ).attr( 'value' );
		$.post(
			WP_TlkIo.ajaxurl,
			{
				'action': 'wp_tlkio_update_channel_state',
				'channel': channel,
				'noadmin': true,
				'state': state
			},
			function( response ) {
				result        = $.parseJSON( response );
				channel       = result.channel;
				shortcode     = result.shortcode;
				currentstate  = result.state;
				previousstate = currentstate == 'on' ? 'off' : 'on';
				$( "#wp-tlkio-channel-" + channel ).removeClass( previousstate );
								$( "#wp-tlkio-channel-" + channel ).addClass( currentstate );
				$( '#wp-tlkio-channel-' + channel + ' .chat-content' ).replaceWith( shortcode );
				if( 'on' == state ) {
					tlkio_refresh();
				}
			}
		);
		return false;
	});

	// Refresh the window when the chat state has changed
	setInterval(function() {
		$( '.tlkio-channel' ).each(function() {
			var channel = $( this ).attr( 'id' ).split( 'wp-tlkio-channel-' )[1];
			$.post(
				WP_TlkIo.ajaxurl,
				{
					'action': 'wp_tlkio_check_state',
					'channel': channel
				},
				function( response ) {
					result  = $.parseJSON( response );
					channel = result.channel;
					state   = result.state;
					if( !$( "#wp-tlkio-channel-" + channel ).hasClass( state ) ) {
						$.post(
							WP_TlkIo.ajaxurl,
							{
								'action': 'wp_tlkio_refresh_channel',
								'channel': result.channel
							},
							function( response ) {
								result        = $.parseJSON( response );
								channel       = result.channel;
								state         = result.state;
								shortcode     = result.shortcode;
								message       = result.message;
								$( '#wp-tlkio-channel-' + channel ).replaceWith( shortcode );
								if( 'on' == state )
									tlkio_refresh();
								$( '#wp-tlkio-channel-' + channel ).prepend( '<div id="tlkio-' + channel + '-message" class="tlkio-alert-message">' + message + '</div>' );
								opening_timeout = 'on' == state ? 1000 : 250;
								setTimeout(function() {
									$( '#tlkio-' + channel + '-message' ).slideDown(function() {
										setTimeout(function() {
											$( '#tlkio-' + channel + '-message'  ).slideUp();
										}, 5000);	
									});
								}, opening_timeout);
							}
						);
					}
				}
			);
		})
	}, 5000);
});