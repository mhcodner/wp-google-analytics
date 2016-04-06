<?php

/*
Plugin Name: Google Analytics by MhCodner
Plugin URI: https://github.com/mhcodner/wp-google-analytics
Description: Adds the necessary javascript for Google Analytics
Version: 15
Author: Michael Codner
Author URI: http://mhcodner.me
License: GPL2
*/

function mc_analytics_js() {
    ?>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', '<?php echo get_option('ga_code'); ?>', 'auto');

</script>

<?php }

add_action( 'wp_footer', 'mc_analytics_js', 10 );

function mc_analytics_admin(){
    if (isset($_POST['ga_code'])) {
        $ga_code = $_POST['ga_code'];
        update_option('ga_code', $ga_code);
        ?>
        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
        <?php
    }
    else {
        $ga_code = get_option('ga_code');
    }
    ?>
<div class="wrap">
    <h2>Configure Google Analytics</h2>
    <form name="mc_analytics_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <table class="form-table">
            <tbody>
            <tr valign="top">
                <th scope="row">
                    <label for="ga_code">Google Analytics Tracking Code</label>
                </th>
                <td>
                    <input type="text" class="regular-text code" name="ga_code" id="ga_code" value="<?php echo $ga_code; ?>"
                </td>
            </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" class="button button-primary" name="Submit" value="Save Changes" />
        </p>
    </form>
</div>
<?php }
function mc_analytics_admin_actions(){
    add_options_page('Google Analytics', 'Google Analytics', 'manage_options', 'mc-google-analytics', 'mc_analytics_admin');
}
add_action('admin_menu', 'mc_analytics_admin_actions');
