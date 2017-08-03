<?php
/**
 * @package Websima Telegram Channel
 * @version 1.5.3
 */
/*
Plugin Name: Channeller Telegram Channel Admin
Plugin URI: http://websima.com/channeller
Description: Send Text, URL, Photo, Video and Audio from Wordpress to Telegram Channel using Telegram bot API.
Author: Websima Creative Agency
Version: 1.5.3
Author URI: http://websima.com
*/
add_action( 'plugins_loaded', 'tchannel_load_textdomain' );
function tchannel_load_textdomain() {
  load_plugin_textdomain( 'tchannel', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
}
add_action('admin_menu', 'tchannel_custom_menu_page');

function tchannel_custom_menu_page()
{
	add_menu_page(__('Channeller', 'tchannel'), __('Channeller', 'tchannel'), 'manage_options', 'channeller', 'channeller_options_page', plugins_url('channeller-telegram-channel-administrator/includes/dashicon.png') , 100);
	$options = get_option( 'tchannel_settings' );
    $logview = $options['tchannel_log'];
	if ($logview == 'yes'){
	add_submenu_page('channeller',__( 'Log', 'tchannel' ), __( 'Log', 'tchannel' ), 'manage_options', 'channeller_log', 'channeller_log_panel');		
	}
}

function channeller_log_panel()
{
	if (isset($_GET['tchannelclear'])) {
		delete_site_option('wp_channeller_log');
		exit;
	}
?>
	<div class="wrap"><h2><?php printf(__( "Messages History", "tchannel" )); ?><a href="admin.php?page=channeller_log&tchannelclear=1" class="add-new-h2"><?php printf(__( "Clear Log", "tchannel" )); ?></a></h2>
    <table class="widefat fixed" cellspacing="0">
    <thead>
    <tr>
        <th style="width: 15%;" class="manage-column" scope="col"><?php printf(__( "Type", "tchannel" )); ?></th>
        <th style="width: 15%;" class="manage-column" scope="col"><?php printf(__( "Date", "tchannel" )); ?></th>
        <th style="width: 15%;" class="manage-column" scope="col"><?php printf(__( "Channel/Group", "tchannel" )); ?></th>
        <th style="width: 15%;" class="manage-column" scope="col"><?php printf(__( "Status", "tchannel" )); ?></th>
        <th id="columnname" class="manage-column" scope="col"><?php printf(__( "Message", "tchannel" )); ?></th>
    </tr>
    </thead>

    <tbody><?php echo get_site_option('wp_channeller_log'); ?></tbody>
</table></div>
<?php
}
function channeller_log($action, $status,$channel, $text)
{
	$updated ='<tr>
            <td>' . $action . '</td>
            <td>' . date('m/d/Y H:i:s ', time()) . '</td>
            <td>' . sanitize_text_field($channel) . '</td>
            <td>' . sanitize_text_field($status) . '</td>
            <td>' . sanitize_text_field($text) . '</td>
        </tr>' . get_site_option('wp_channeller_log');
	update_site_option('wp_channeller_log', $updated);
}


include_once('includes/ch-send-functions.php');
include_once('includes/ch-api-settings.php');
include_once('includes/ch-publishsend.php');
include_once('includes/ch-notification-metabox.php');
function channeller_admin_scripts() {    
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('my-upload', WP_PLUGIN_URL.'/channeller-telegram-channel-administrator/channeller-script.js', array('jquery','media-upload','thickbox'));
    wp_enqueue_script('my-upload');
}

function truncate_channeller($text,$limit){
	$excerpt = $text;
	if (strlen ($excerpt) > $limit) {
		$the_str = mb_substr($excerpt, 0, $limit);
	} else {
		$the_str = $excerpt;
	}
	return $the_str;
 }
function channeller_admin_styles() {

    wp_enqueue_style('thickbox');
}
    add_action('admin_print_scripts', 'channeller_admin_scripts');
    add_action('admin_print_styles', 'channeller_admin_styles');

?>