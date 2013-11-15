<?php

// Set default options

$default = array( 'titles' => 'YouTube', 'id' => '', 'profile' => '', 'type' => '', 'template' => '', 'style' => '', 'start' => '', 'autoplay' => '', 'width' => '', 'height' => '', 'dynamic' => '', 'list' => '', 'loop' => '', 'stop' => '', 'id_type' => 'v' );
$instance = wp_parse_args( ( array ) $instance, $default );
$general = vye_set_general_defaults();

// Widget Title field

$field_id = $this -> get_field_id( 'titles' );
$field_name = $this -> get_field_name( 'titles' );
echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Widget Title', 'youtube-embed' ) . ': </label><input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'titles' ] ).'" /></p>';

// Video ID field

$field_id = $this -> get_field_id( 'id' );
$field_name = $this -> get_field_name( 'id' );
echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Video ID', 'youtube-embed' ) . ': </label><input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'id' ] ) . '" /></p>';

echo "<table>\n";

// ID Type

$field_id = $this -> get_field_id( 'id_type' );
$field_name = $this -> get_field_name( 'id_type' );
echo "\r\n" . '<tr><td width="100%">' . __( 'ID Type', 'youtube-embed' ) . '</td><td><select name="' . $field_name . '" id="' . $field_id . '"><option value="v"';
if ( attribute_escape( $instance[ 'id_type' ] ) == 'v' ) { echo " selected='selected'"; }
echo '>' . __( 'Video or Playlist', 'youtube-embed' ) . '</option><option value="s"';
if ( attribute_escape( $instance[ 'id_type' ] ) == 's' ) { echo " selected='selected'"; }
echo '>' . __( 'Search', 'youtube-embed' ) . '</option><option value="u"';
if ( attribute_escape( $instance[ 'id_type' ] ) == 'u' ) { echo " selected='selected'"; }
echo '>' . __( 'User', 'youtube-embed' ) . '</option></select></td></tr>';

echo "</table>\n";

// Profile field

$field_id = $this -> get_field_id( 'profile' );
$field_name = $this -> get_field_name( 'profile' );
echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Profile', 'youtube-embed' ) . ': </label><select name="' . $field_name . '" class="widefat" id="' . $field_id . '">';
vye_generate_profile_list( attribute_escape( $instance[ 'profile' ] ), $general[ 'profile_no' ]  );
echo '</select></p>';

// Template

$field_id = $this -> get_field_id( 'template' );
$field_name = $this -> get_field_name( 'template' );
echo "\r\n" . '<p><label for="' . $field_id . '">'.__( 'Template', 'youtube-embed' ).': </label><input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'template' ] ) . '" /></p>';

// Style

$field_id = $this -> get_field_id( 'style' );
$field_name = $this -> get_field_name( 'style' );
echo "\r\n" . '<p><label for="' . $field_id . '">'.__( 'Style', 'youtube-embed' ).': </label><input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'style' ] ) . '" /></p>';

// Size fields

$field_id = $this -> get_field_id( 'width' );
$field_name = $this -> get_field_name( 'width' );
echo "\r\n" . '<p><label for="' . $field_id . '">' . __( 'Size', 'youtube-embed' ) . ': </label><input type="text" size="3" maxlength="3" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'width' ] ) . '" />&nbsp;x&nbsp;';

$field_id = $this -> get_field_id( 'height' );
$field_name = $this -> get_field_name( 'height' );
echo '<input type="text" size="3" maxlength="3" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'height' ] ) . '" />&nbsp;pixels</p>';

echo "<table>\n";

// Dynamic Resize

$field_id = $this -> get_field_id( 'dynamic' );
$field_name = $this -> get_field_name( 'dynamic' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Dynamically Resize', 'youtube-embed' ) . '</td><td><select name="' . $field_name . '" id="' . $field_id . '"><option value=""';
if ( attribute_escape( $instance[ 'dynamic' ] ) == '' ) { echo " selected='selected'"; }
echo '>' . __( 'Profile default', 'youtube-embed' ) . '</option><option value="0"';
if ( attribute_escape( $instance[ 'dynamic' ] ) == '0' ) { echo " selected='selected'"; }
echo '>' . __( 'No', 'youtube-embed' ) . '</option><option value="1"';
if ( attribute_escape( $instance[ 'dynamic' ] ) == '1' ) { echo " selected='selected'"; }
echo '>' . __( 'Yes', 'youtube-embed' ) . '</option></select></td></tr>';

// Embed type field

$field_id = $this -> get_field_id( 'type' );
$field_name = $this -> get_field_name( 'type' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Embed Type', 'youtube-embed' ) . '</td><td><select name="' . $field_name . '" id="' . $field_id . '"><option value=""';
if ( attribute_escape( $instance[ 'type' ] ) == '' ) { echo " selected='selected'"; }
echo '>' . __( 'Profile default', 'youtube-embed' ) . '</option><option value="v"';
if ( attribute_escape( $instance[ 'type' ] ) == 'v' ) { echo " selected='selected'"; }
echo '>' . __( 'IFRAME', 'youtube-embed' ) . '</option><option value="p"';
if ( attribute_escape( $instance[ 'type' ] ) == 'p' ) { echo " selected='selected'"; }
echo '>' . __( 'OBJECT', 'youtube-embed' ) . '</option><option value="m"';
if ( attribute_escape( $instance[ 'type' ] ) == 'c' ) { echo " selected='selected'"; }
echo '>' . __( 'Chromeless', 'youtube-embed' ) . '</option><option value="c"';
if ( attribute_escape( $instance[ 'type' ] ) == 'm' ) { echo " selected='selected'"; }
echo '>' . __( 'EmbedPlus', 'youtube-embed' ) . '</option></select></td></tr>';

// Autoplay field

$field_id = $this -> get_field_id( 'autoplay' );
$field_name = $this -> get_field_name( 'autoplay' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Autoplay', 'youtube-embed' ) . '</td><td><select name="' . $field_name . '" id="' . $field_id . '"><option value=""';
if ( attribute_escape( $instance[ 'autoplay' ] ) == '' ) { echo " selected='selected'"; }
echo '>' . __( 'Profile default', 'youtube-embed' ) . '</option><option value="0"';
if ( attribute_escape( $instance[ 'autoplay' ] ) == '0' ) { echo " selected='selected'"; }
echo '>' . __( 'No', 'youtube-embed' ) . '</option><option value="1"';
if ( attribute_escape( $instance[ 'autoplay' ] ) == '1' ) { echo " selected='selected'"; }
echo '>' . __( 'Yes', 'youtube-embed' ) . '</option></select></td></tr>';

// Start field

$field_id = $this -> get_field_id( 'start' );
$field_name = $this -> get_field_name( 'start' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Start (seconds)', 'youtube-embed' ) . '</td><td><input type="text" size="3" maxlength="3" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'start' ] ) . '" /></td></tr>';

// Stop field

$field_id = $this -> get_field_id( 'stop' );
$field_name = $this -> get_field_name( 'stop' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Stop (seconds)', 'youtube-embed' ) . '</td><td><input type="text" size="3" maxlength="3" id="' . $field_id . '" name="' . $field_name . '" value="' . attribute_escape( $instance[ 'stop' ] ) . '" /></td></tr>';

echo "</table>\n";

?>
<h4><?php _e( 'Non-EmbedPlus Options', 'youtube-embed' ); ?></h4>
<?php

echo "<table>\n";

// List field

$field_id = $this -> get_field_id( 'list' );
$field_name = $this -> get_field_name( 'list' );
echo "\r\n" . '<tr><td width="100%">' . __( 'List Playback', 'youtube-embed' ) . '</td><td><select name="' . $field_name . '" id="' . $field_id . '"><option value=""';
if ( attribute_escape( $instance[ 'list' ] ) == '' ) { echo " selected='selected'"; }
echo '>' . __( 'Profile default', 'youtube-embed' ) . '</option><option value="order"';
if ( attribute_escape( $instance[ 'list' ] ) == 'order' ) { echo " selected='selected'"; }
echo '>' . __( 'Play each video in order', 'youtube-embed' ) . '</option><option value="random"';
if ( attribute_escape( $instance[ 'list' ] ) == 'random' ) { echo " selected='selected'"; }
echo '>' . __( 'Play videos randomly', 'youtube-embed' ) . '</option><option value="single"';
if ( attribute_escape( $instance[ 'list' ] ) == 'single' ) { echo " selected='selected'"; }
echo '>' . __( 'Play one random video', 'youtube-embed' ) . '</option></select></td></tr>';

// Loop video field

$field_id = $this -> get_field_id( 'loop' );
$field_name = $this -> get_field_name( 'loop' );
echo "\r\n" . '<tr><td width="100%">' . __( 'Loop Video', 'youtube-embed' ) . '</td><td><select name="' . $field_name . '" id="' . $field_id . '"><option value=""';
if ( attribute_escape( $instance[ 'loop' ] ) == '' ) { echo " selected='selected'"; }
echo '>' . __( 'Profile default', 'youtube-embed' ) . '</option><option value="0"';
if ( attribute_escape( $instance[ 'loop' ] ) == '0' ) { echo " selected='selected'"; }
echo '>' . __( 'No', 'youtube-embed' ) . '</option><option value="1"';
if ( attribute_escape( $instance[ 'loop' ] ) == '1' ) { echo " selected='selected'"; }
echo '>' . __( 'Yes', 'youtube-embed' ) . '</option></select></td></tr>';

echo "</table>\n";
?>