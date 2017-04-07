<?php
/*
 * Plugin Name: FM Google Analytics
 * Plugin URI: http://www.freewebmentor.com/2016/09/google-analytics.html
 * Description: Add google analytics code in WordPress Blogs or websites.
 * Version: 1.0.0
 * Author: Prem Tiwari
 * Author URI: http://freeewebmentor.com
 */

if (!defined('ABSPATH')){ exit; }
    
add_action('admin_menu', 'fmga_google_analytics_settings');

function fmga_google_analytics_settings() {  
    add_submenu_page( "options-general.php", 'Google Analytics settings', 'FM Google Analytics', 'manage_options', 'fmga-google-analytics', 'fmga_google_analytics_init');
}

function fmga_google_analytics_init() {

    $submited = 0;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Submit'])) {
        $fm_enabled = sanitize_text_field($_REQUEST['fm_enabled']);	
        $fm_property_id = sanitize_text_field($_REQUEST['fm_property_id']);
        update_option('fm_enabled', $fm_enabled);
        update_option('fm_property_id', $fm_property_id);                
        $submited = 1;
    }
?>

    <div>   
        <h2 class="smsb_pluginheader"><?php _e("Google Analytics - Settings", "fm_google_analytics"); ?></h2>
        <?php if (isset($submited) && $submited == 1) { ?>
            <div id="setting-error-settings_updated" class="updated settings-error"> 
                <p><strong><?php _e("Your settings have been saved.", "fm_google_analytics"); ?></strong></p></div>
        <?php } ?>
        <?php _e("<p>Enables google analytics code on all pages.</p>", "fm_google_analytics"); ?>

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
                                    <input type="checkbox" name="fm_enabled" id="fm_enabled" value="true" <?php echo (get_option('fm_enabled') == 'true' ? 'checked' : ''); ?>> Enable google analytics code</label><br>
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

if(get_option('fm_enabled')){ 
    add_action('wp_head', 'fmga_analytics_code');
}