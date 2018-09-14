<?php
/*
 * Plugin Name: FM Google Analytics
 * Plugin URI: https://www.freewebmentor.com/2016/09/google-analytics.html
 * Description: Add google analytics code in WordPress Blogs or websites.
 * Version: 1.0.3
 * Author: Prem Tiwari
 * Author URI: https://www.freeewebmentor.com
 */

if (!defined('ABSPATH')){ exit; }

//Add external css file
add_action( 'admin_head', 'fm_style' );
function fm_style() {
  echo '<link rel="stylesheet" href="'.plugins_url("fm-google-analytics/css/fm-style.css", dirname(__FILE__) ).'" type="text/css" media="all" />';
}

add_action( 'admin_menu', 'fmga_google_analytics_settings' );

function fmga_google_analytics_settings() {
    add_submenu_page( "options-general.php", 'Google Analytics settings', 'FM Google Analytics', 'manage_options', 'fmga-google-analytics', 'fmga_google_analytics_init' );
}

function fmga_google_analytics_init() {

    $submited = 0;

    if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['Submit'] ) ) {
        $fm_enabled = sanitize_text_field( $_REQUEST['fm_enabled'] );
        $fm_property_id = sanitize_text_field( $_REQUEST['fm_property_id'] );
        update_option( 'fm_enabled', $fm_enabled );
        update_option( 'fm_property_id', $fm_property_id );
        $submited = 1;
    }
?>
        <h2 class="smsb_pluginheader"><?php _e( "Google Analytics - Settings", "fm_google_analytics" ); ?></h2>

        <?php if ( isset( $submited ) && $submited == 1 ) { ?>
          <div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
          <p><strong><?php _e("Your settings have been saved.", "fm_google_analytics"); ?></strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
        <?php } ?>
        <br>
        <div id="mm-panel-overview" class="postbox">
						<h2>Overview</h2>
							<div class="mm-panel-overview">
                <?php _e("<p>It will enables the Google Analytic Tracking code on all frontend pages of your website.</p>", "fm_google_analytics"); ?>
								<p>
									If you like this plugin, please
									<a target="_blank" href="https://wordpress.org/support/plugin/fm-google-analytics/reviews/?rate=5#new-post" title="THANK YOU for supporting us!">
										give it a 5-star rating&nbsp;»
									</a>
								</p>
							</div>
					</div>

        <div id="mm-panel-overview" class="postbox">
        <form method="post">
            <table class="form-table">
                <tbody>
                <tr valign="top">
                        <th scope="row" class="titledesc">
                            <label for="fm_enabled">Enable/Disable</label>
                        </th>
                        <td class="forminp">
                            <fieldset>
                                <legend class="screen-reader-text"><span>Enable/Disable</span></legend>
                                <label for="fm_enabled">
                                    <label class="switch">
                                    <input type="checkbox" name="fm_enabled" id="fm_enabled" value="true" <?php echo (get_option('fm_enabled') == 'true' ? 'checked' : ''); ?>>
                                    <span class="slider round"></span>
                                  </label>
                            </fieldset>
                        </td>
                    </tr>
                  <tr valign="top">
                        <th scope="row" class="titledesc">
                            <label for="fm_property_id">Property ID</label>
                        <td class="forminp">
                            <fieldset>
                                <input class="regular-input" type="text" name="fm_property_id" id="fm_property_id" value="<?php echo get_option('fm_property_id');?>" placeholder="UA-012345678-1">
                            </fieldset>
                        </td>
                    </tr>
                </tbody></table>
            <p>&nbsp;</p>
            <p><input type="submit" name="Submit" class="button-primary" value="<?php _e("Save Settings", "fm_google_analytics"); ?>"></p>
        </form>
    </div>
    </div>

<?php }

/**
* Add google anatics code on all pages.
* @author Prem Tiwari
*/

function fmga_analytics_code() {

$html = "<script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o), m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
            ga('create', '".get_option('fm_property_id')."', 'auto');
            ga('send', 'pageview');
         </script>";
echo $html;
}

if( get_option( 'fm_enabled' ) ) {
    add_action( 'wp_head', 'fmga_analytics_code' );
}
