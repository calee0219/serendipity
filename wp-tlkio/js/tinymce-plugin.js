jQuery(function($) {
    tinymce.create('tinymce.plugins.wp_tlkio', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            ed.addButton('wp_tlkio', {
                title : 'WP Tlk.Io',
                cmd : 'wp_tlkio',
                image : url + '/../img/tinymce-button.png'
            });
 
            ed.addCommand('wp_tlkio', function() {
                // triggers the thickbox
                var width = $(window).width(), H = $(window).height(), W = ( 720 < width ) ? 720 : width;
                W = W - 80;
                H = H - 120;
                tb_show( 'WP tlk.io Plugin', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=wp-tlkio-popup' );
            });
        },
 
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'TlkIo Chat Room Button',
                author : 'Luke Howell & Brad Bodine',
                authorurl : 'http://www.truemediaconcepts.com',
                version : "0.1"
            };
        }
    });
 
    // Register plugin
    tinymce.PluginManager.add( 'wp_tlkio', tinymce.plugins.wp_tlkio );

    // executes this when the DOM is ready
    $(function(){
        var form = $( '#wp-tlkio-popup' );
        
        var table = form.find('table');
        form.appendTo('body').hide();
        
        // handles the click event of the submit button
        form.find('#wp-tlkio-submit').click(function(){
            // defines the options and their default values
            // again, this is not the most elegant way to do this
            // but well, this gets the job done nonetheless
            var options = { 
                'channel'     : '',
                'width'       : '',
                'height'      : '',
                'float'       : '',
                'css'         : '',
                'offclass'    : '',
                'activated'   : '',
                'starton'     : '',
                'alwayson'    : '',
                'deactivated' : ''
                };
            var shortcode = '[tlkio';
            
            for( var index in options) {
                var value = table.find('#wp-tlkio-' + index).val();
                
                // attaches the attribute to the shortcode only if it's different from the default value
                if ( value !== options[index] )
                    shortcode += ' ' + index + '="' + value + '"';
            }
            
            var value = $( '#wp-tlkio-off-message' ).val();
            shortcode += ']';
            if( '' != value )
                shortcode += value + '[/tlkio]';
            
            // inserts the shortcode into the active editor
            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

            // Clear all the values
            for( var index in options) {
                var value = table.find('#wp-tlkio-' + index).val( '' );
            }
            
            // closes Thickbox
            tb_remove();
        });
    });
});