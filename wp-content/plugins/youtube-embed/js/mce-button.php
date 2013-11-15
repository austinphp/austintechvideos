// Function to add MCE button. Includes build of output text

(function() {
<?php

//  Get cookie of default shortcode to use

$cookie_name = 'vye_mce_shortcode';
if ( isset( $_COOKIE[ $cookie_name ] ) ) { $shortcode = $_COOKIE[ $cookie_name ]; } else { $shortcode = 'youtube'; }
?>
    var shortcode = "<?php echo $shortcode; ?>";
    tinymce.create('tinymce.plugins.youtube', {
        init : function(ed, url) {
            ed.addButton('YouTube', {
                title : 'YouTube Embed',
                onclick : function() {
                    if (ed.selection.getContent()=='') {
                        var yeOut = 'Insert video URL or ID here';
                    } else {
                        var yeOut = ed.selection.getContent();
                    }
                    ed.selection.setContent('[' + shortcode + ']' + yeOut + '[/' + shortcode + ']');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('YouTube', tinymce.plugins.youtube);
})();