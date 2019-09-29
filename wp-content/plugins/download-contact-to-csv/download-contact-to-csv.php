<?php
/**
 * @package download-contact-to-csv
 */
/*
 Plugin Name: download-contact-to-csv
  Plugin URI: http://www.download-contact-to-csv.com/
  Description: Download csv file from contact page.
  Version: 1.0.0
  Author: Rajendra Kumar Manandhar
  Author URI: http://www.download-contact-to-csv.com
  License: GPLv2 or later
  Text Domain: download-contact-to-csv
 */


// define('ABSPATH') or die('You cant access this file');

// class DownloadContactToCSV
// {
// 	__construct($arg1){
// 		echo $arg1;
// 	}


// }

// $downloadContactToCSV = new DownloadContactToCSV();


// if(class_exists('DownloadContactToCSV')){
// 	$downloadContactToCSV = new DownloadContactToCSV();
// }


//for settings
  
 // create custom plugin settings menu
add_action('admin_menu', 'my_cool_plugin_create_menu');

function my_cool_plugin_create_menu() {

	//create new top-level menu
	// add_menu_page('My Cool Plugin Settings', 'Cool Settings', 'administrator', __FILE__, 'my_cool_plugin_settings_page' , plugins_url('/images/icon.png', __FILE__) );
	add_menu_page('My Twitter Plugin Settings', 'Twitter settings', 'administrator', __FILE__, 'my_cool_plugin_settings_page' , plugins_url('/images/icon.png', __FILE__) );

	//call register settings function
	add_action( 'admin_init', 'register_my_cool_plugin_settings' );
}


function register_my_cool_plugin_settings() {
	//register our settings
	register_setting( 'my-cool-plugin-settings-group', 'screenName' );
	register_setting( 'my-cool-plugin-settings-group', 'tweetsToShow' );
	register_setting( 'my-cool-plugin-settings-group', 'oauthAccessToken' );
	register_setting( 'my-cool-plugin-settings-group', 'oauthAccessTokenSecret' );
	register_setting( 'my-cool-plugin-settings-group', 'oauthConsumerKey' );
	register_setting( 'my-cool-plugin-settings-group', 'oauthConsumerSecret' );
}

function my_cool_plugin_settings_page() {
?>
<div class="wrap">
<h1>Feed My Tweet</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'my-cool-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'my-cool-plugin-settings-group' ); ?>
    <table class="form-table">

        <tr valign="top">
	        <th scope="row">Screen Name</th>
	        <td><input type="text" name="screenName" value="<?php echo esc_attr( get_option('screenName') ); ?>" /></td>
        </tr>
        <tr valign="top">
	        <th scope="row">Tweets to show</th>
	        <td><input type="text" name="tweetsToShow" value="<?php echo esc_attr( get_option('tweetsToShow') ); ?>" /></td>
        </tr>

        <tr valign="top">
	        <th scope="row">oauth Access Token</th>
	        <td><input type="text" name="oauthAccessToken" value="<?php echo esc_attr( get_option('oauthAccessToken') ); ?>" /></td>
        </tr>

        <tr valign="top">
	        <th scope="row">oauth Access Secret</th>
	        <td><input type="text" name="oauthAccessTokenSecret" value="<?php echo esc_attr( get_option('oauthAccessTokenSecret') ); ?>" /></td>
        </tr>

        <tr valign="top">
	        <th scope="row">oauth Consumer Key</th>
	        <td><input type="text" name="oauthConsumerKey" value="<?php echo esc_attr( get_option('oauthConsumerKey') ); ?>" /></td>
        </tr>

        <tr valign="top">
	        <th scope="row">oauth Consumer Secret</th>
	        <td><input type="text" name="oauthConsumerSecret" value="<?php echo esc_attr( get_option('oauthConsumerSecret') ); ?>" /></td>
        </tr>
         
    </table>
    
    <?php submit_button(); ?>

</form>

</div>
<?php } 

// twitter code

add_shortcode( 'mi-twitter-feed', 'twitter_feed_shortcode');
function twitter_feed_shortcode($atts)
{
    ob_start();
    extract(shortcode_atts(array(
        'tweets_to_show'=> '',
    ), $atts));
    $count = get_option('tweetsToShow'); // How many tweets to output
    $retweets = 1; // 0 to exclude, 1 to include
    $screen_name = get_option('screenName');
    // Populate these with the keys/tokens you just obtained
    $oauthAccessToken = get_option('oauthAccessToken');
    $oauthAccessTokenSecret = get_option('oauthAccessTokenSecret');
    $oauthConsumerKey = get_option('oauthConsumerKey');
    $oauthConsumerSecret = get_option('oauthConsumerSecret');

    // First we populate an array with the parameters needed by the API
    $oauth = array(
        'count' => $count,
        'include_rts' => $retweets,
        'oauth_consumer_key' => $oauthConsumerKey,
        'oauth_nonce' => time(),
        'oauth_signature_method' => 'HMAC-SHA1',
        'oauth_timestamp' => time(),
        'oauth_token' => $oauthAccessToken,
        'oauth_version' => '1.0',
        'tweet_mode' => 'extended'
    );

    $arr = array();
    foreach($oauth as $key => $val)
        $arr[] = $key.'='.rawurlencode($val);

    // Then we create an encypted hash of these values to prove to the API that they weren't tampered with during transfer
    $oauth['oauth_signature'] = base64_encode(hash_hmac('sha1', 'GET&'.rawurlencode('https://api.twitter.com/1.1/statuses/user_timeline.json').'&'.rawurlencode(implode('&', $arr)), rawurlencode($oauthConsumerSecret).'&'.rawurlencode($oauthAccessTokenSecret), true));

    $arr = array();
    foreach($oauth as $key => $val)
        $arr[] = $key.'="'.rawurlencode($val).'"';

    // Next we use Curl to access the API, passing our parameters and the security hash within the call
    $tweets = curl_init();
    curl_setopt_array($tweets, array(
        CURLOPT_HTTPHEADER => array('Authorization: OAuth '.implode(', ', $arr), 'Expect:'),
        CURLOPT_HEADER => false,
        CURLOPT_URL => 'https://api.twitter.com/1.1/statuses/user_timeline.json?tweet_mode=extended&count='.$count.'&include_rts='.$retweets,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
    ));
    $json = curl_exec($tweets);
    curl_close($tweets);
    $statuses = json_decode($json);

    $testing = wp_remote_get("https://api.twitter.com/1.1/statuses/user_timeline.json?tweet_mode=extended&count=".$count."&include_rts=".$retweets);
    // $json now contains the response from the Twitter API, which should include however many tweets we asked for.
    if( $show_in_slider == "true"){
        $slider_class = "twitter-slider";
    } else {
        $slider_class = "";
    }
        ?>
        <div class="container">
            <div class="row">
                <div class="twitter-wrap <?php echo $slider_class; ?>">
                    <?php
                    // Loop through them for output
                    foreach(json_decode($json) as $status) {
                     // Convert links back into actual links, otherwise they're just output as text
                        $enhancedStatus = htmlentities($status->full_text, ENT_QUOTES, 'UTF-8');
                        $enhancedStatus = preg_replace('/http:\/\/t.co\/([a-zA-Z0-9]+)/i', '<a href="http://t.co/$1">http://$1</a>', $enhancedStatus);
                        $enhancedStatus = preg_replace('/https:\/\/t.co\/([a-zA-Z0-9]+)/i', '<a href="https://t.co/$1">http://$1</a>', $enhancedStatus);
                        // Finally, output a simple paragraph containing the tweet and a link back to the Twitter account itself. You can format/style this as you like.
                        ?>
                        <div class="twitter-details">
                            <div class="twitter-feed">
                                <p>
                                    &quot;<?php echo $enhancedStatus; ?>&quot;<br />
                                    <a href="https://twitter.com/intent/user?screen_name=<?php echo $screen_name; ?>" target="_blank">@<?php echo $screen_name; ?></a>
                                </p>
                            </div>
                            <div class="twitter-user">
                                <p><?php echo $status->user->name; ?></p>
                                <span>via Twitter</span>
                                <img src="<?php echo $status->user->profile_image_url_https; ?>">
                            </div>
                        </div> <!-- twitter-details -->
                        <?php
                    } ?>
                </div><!-- .twitter-slider -->
            </div> <!-- .row -->
        </div> <!-- .container -->
        <?php
    $content = ob_get_clean();
    return $content;
}


?>