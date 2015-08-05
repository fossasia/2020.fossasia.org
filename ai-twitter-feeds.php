<?php
/*
Plugin Name: AI Twitter Feeds (Twitter widget & shortcode)
Plugin URI: http://www.augustinfotech.com
Description: Replaces a shortcode such as [AIGetTwitterFeeds ai_username='Your Twitter Name(Without the "@" symbol)' ai_numberoftweets='Number Of Tweets' ai_tweet_title='Your Title'], or a widget, with a tweets display.<strong style="color:red;">As per twitter API 1.1 developer display requirements policy new version is updated. PLEASE DO NOT USE OLDER VERSIONS.</strong>
Version: 2.2
Text Domain: aitwitterfeeds
Author: August Infotech
Author URI: http://www.augustinfotech.com
*/

add_action('plugins_loaded', 'ai_tweets_init');

/* 
*Make Admin Menu Item
*/
add_action('admin_menu','ai_twitter_setting');

/*
*Register Twitter Specific Options
*/
add_action('admin_init','ai_init');
add_action('wp_dashboard_setup', 'ai_add_dashboard_tweets_feed' );

/** Start Upgrade Notice **/
global $pagenow;
if ( 'plugins.php' === $pagenow ) {

    // Better update message
    $file   = basename( __FILE__ );
    $folder = basename( dirname( __FILE__ ) );
    $hook = "in_plugin_update_message-{$folder}/{$file}";
    add_action( $hook, 'ai_twitter_update_notification_message', 20, 2 );
}

function ai_twitter_update_notification_message( $plugin_data, $r ) {
    $data = file_get_contents( 'http://plugins.trac.wordpress.org/browser/ai-twitter-feeds/trunk/readme.txt?format=txt' );
	$upgradetext = stristr( $data, '== Upgrade Notice ==' );	
	$upgradenotice = stristr( $upgradetext, '*' );	
	$output = "<div style='color:#EEC2C1;font-weight: normal;background: #C92727;padding: 10px;border: 1px solid #eed3d7;border-radius: 4px;'><strong style='color:rgb(253, 230, 61)'>Update Notice : </strong> ".$upgradenotice."</div>";
    return print $output;
}
/** End Upgrade Notice **/

# Load the language files
function ai_tweets_init() {
	load_plugin_textdomain( 'aitwitterfeeds', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

}

/* 
*Setup Admin menu item 
*/
function ai_twitter_setting() {
	add_options_page('AI Twitter Settings','AI Twitter Settings','manage_options','ai-plugin','ai_option_page');
}

function ai_add_dashboard_tweets_feed() {
	wp_add_dashboard_widget('ai_dashboard_widget', 'AI Twitter Feeds', 'ai_get_twitter_feeds');
}

/* 
*Register Twitter Specific Options 
*/
function ai_init(){
	register_setting('ai_options','ai_consumer_screen_name');//todo - add sanitization function ", 'functionName'"
	register_setting('ai_options','ai_consumer_key');
	register_setting('ai_options','ai_consumer_secret');
	register_setting('ai_options','ai_access_token');
	register_setting('ai_options','ai_access_token_secret');
	register_setting('ai_options','ai_display_number_of_tweets');
	register_setting('ai_options','ai_twitter_css');	
} 

if( function_exists('register_uninstall_hook') )
	register_uninstall_hook(__FILE__,'ai_twitterfeed_uninstall');   

function ai_twitterfeed_uninstall(){
	delete_option('ai_consumer_screen_name'); 
	delete_option('ai_consumer_key');
	delete_option('ai_consumer_secret');
	delete_option('ai_access_token');
	delete_option('ai_access_token_secret');
	delete_option('ai_display_number_of_tweets');
	delete_option('ai_twitter_css');
}		


/* 
*Display the Options form for AI Twitter Feed 
*/
function ai_option_page(){ ?>
	<div class="wrap"> 
		<img src="<?php echo plugins_url('ai-twitter-feeds/css/augustinfotech.jpg'); ?>" class="icon32" />
		<h2 style="padding:5px 15px 5px 0;"><?php _e('AI Twitter Feed Options','aitwitterfeeds');?></h2>	
		<p><?php _e('Here you can set or edit the fields needed for the plugin.','aitwitterfeeds');?></p>
		<p><?php _e('You can find these settings here: <a href="https://dev.twitter.com/apps" target="_blank">Twitter API</a>','aitwitterfeeds');?></p>

		<form action="options.php" method="post" id="ai-options-form">
			<?php settings_fields('ai_options'); ?>
			<table class="form-table">
				<tr class="even" valign="top">
					<th scope="row">
						<label for="ai_consumer_screen_name">
							<?php _e('Twitter Screen(User) Name or  Hashtags/keywords:','aitwitterfeeds');?>
						</label>
					</th>
					<td>
						<input type="text" id="ai_consumer_screen_name" name="ai_consumer_screen_name" class="regular-text" value="<?php echo esc_attr(get_option('ai_consumer_screen_name')); ?>" />
						<p class="description">
							<?php _e('(Without the "@" / "#" symbol)','aitwitterfeeds');?>
						</p>
					</td>
				</tr>
				<tr class="odd" valign="top">
					<th scope="row">
						<label for="ai_consumer_key">
							<?php _e('Consumer Key:','aitwitterfeeds');?>
						</label>
					</th>
					<td>
						<input type="text" id="ai_consumer_key" name="ai_consumer_key" class="regular-text" value="<?php echo esc_attr(get_option('ai_consumer_key')); ?>" />
						<p></p>
					</td>
				</tr>
				<tr class="even" valign="top">
					<th scope="row">
						<label for="ai_consumer_secret">
							<?php _e('Consumer Secret:','aitwitterfeeds');?>
						</label>
					</th>
					<td>
						<input type="text" id="ai_consumer_secret" name="ai_consumer_secret" class="regular-text" value="<?php echo esc_attr(get_option('ai_consumer_secret')); ?>" />
						<p></p>
					</td>
				</tr>
				<tr class="odd" valign="top">
					<th scope="row">
						<label for="ai_access_token">
							<?php _e('Access Token:','aitwitterfeeds');?>
						</label>
					</th>
					<td>
						<input type="text" id="ai_access_token" name="ai_access_token" class="regular-text" value="<?php echo esc_attr(get_option('ai_access_token')); ?>" />
						<p></p>
					</td>
				</tr>
				<tr class="even" valign="top">
					<th scope="row">
						<label for="ai_access_token_secret">
							<?php _e('Access Token Secret:','aitwitterfeeds');?>
						</label>
					</th>
					<td>
						<input type="text" id="ai_access_token_secret" name="ai_access_token_secret" class="regular-text" value="<?php echo esc_attr(get_option('ai_access_token_secret')); ?>" />
						<p></p>
					</td>
				</tr>
				<tr class="odd" valign="top">
					<th scope="row">
						<label for="ai_display_number_of_tweets">
							<?php _e('Number Of Tweets:','aitwitterfeeds');?>
						</label>
					</th>
					<td>
						<input type="text" id="ai_display_number_of_tweets" name="ai_display_number_of_tweets" class="regular-text" value="<?php echo esc_attr(get_option('ai_display_number_of_tweets')); ?>" />
						<p></p>
					</td>
				</tr>	
				<tr class="even" valign="top">
					<th scope="row">
						<label for="ai_twitter_css">
							<?php _e('Custom CSS:','aitwitterfeeds');?>
						</label>
					</th>
					<td>
						<textarea id="ai_twitter_css" name="ai_twitter_css" class="regular-text" cols="37" rows="12" > <?php echo esc_attr(get_option('ai_twitter_css')); ?></textarea>
						<p></p>
					</td>
				</tr>					
			</table>
			<p class="submit">
				<input type="submit" name="submit" class="button-primary" value="Save Settings" />
			</p>
		</form>
	</div>
<?php }

function ai_makeLink($ai_tweet_con){
	$ai_tweet_con = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $ai_tweet_con);
	$ai_tweet_con = preg_replace( '/@([a-zA-Z0-9]+)/', '<a href="https://twitter.com/\1" target="_blank">@\1</a>', $ai_tweet_con ); 
	$ai_tweet_con = preg_replace( '/#([a-zA-Z0-9-]+)/', '<a href="https://twitter.com/search?q=%23\1&src=hash" target="_blank">#\1</a>', $ai_tweet_con ); 
	return $ai_tweet_con;
}

// parse time in a twitter style
function ai_getTime($ai_date){
	$ai_timediff = time() - strtotime($ai_date);
	if($ai_timediff < 60) return $ai_timediff . 's';
	else if($ai_timediff < 3600) return intval(date('i', $ai_timediff)) . 'm';
	else if($ai_timediff < 86400) return round($ai_timediff/60/60) . 'h';
	else return date_i18n('M d', strtotime($ai_date));
}	

function ai_twitter_formatter($ai_date){
	$ai_epoch_timestamp = strtotime( $ai_date );
	$ai_twitter_time = human_time_diff($ai_epoch_timestamp, current_time('timestamp') ) . ' ago';
	return $ai_twitter_time;
}

require_once("twitteroauth/twitteroauth.php"); //Path to twitteroauth library

function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret){
	$ai_connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
	return $ai_connection;
}

function get_connect($ai_consumerkey_gt, $ai_consumersecret_gt, $ai_accesstoken_gt, $ai_accesstokensecret_gt,$ai_twitteruser_gt,$ai_notweets_gt){
	$ai_connection = getConnectionWithAccessToken($ai_consumerkey_gt, $ai_consumersecret_gt, $ai_accesstoken_gt, $ai_accesstokensecret_gt);
	$ai_tweets_all = $ai_connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$ai_twitteruser_gt."&count=".$ai_notweets_gt);
	return $ai_tweets_all;
}

/* Short code */
add_shortcode( 'AIGetTwitterFeeds' , 'ai_get_twitter_feeds' );
function ai_get_twitter_feeds($atts){
	extract( shortcode_atts( array(
				'ai_username' => '',
				'ai_numberoftweets' => '',
				'ai_tweet_title' =>''
	), $atts));

	$ai_get_twitteruser=$ai_username ? $ai_username : get_option('ai_consumer_screen_name');
	$ai_get_notweets=$ai_numberoftweets ? $ai_numberoftweets : get_option('ai_display_number_of_tweets');
	$ai_get_tweetstitle=$ai_tweet_title ? $ai_tweet_title:'Latest Twetter Feeds';
	$ai_twitteruser = $ai_get_twitteruser;
	$ai_notweets = $ai_get_notweets;
	$ai_consumerkey = get_option('ai_consumer_key');
	$ai_consumersecret = get_option('ai_consumer_secret');
	$ai_accesstoken = get_option('ai_access_token');
	$ai_accesstokensecret = get_option('ai_access_token_secret');
	$ai_twitter_css = get_option('ai_twitter_css');

	if($ai_twitteruser!='' && $ai_notweets !='' && $ai_consumerkey!='' && $ai_consumersecret!='' && $ai_accesstoken!='' && $ai_accesstokensecret!='') {
		$ai_tweets = get_connect($ai_consumerkey, $ai_consumersecret, $ai_accesstoken, $ai_accesstokensecret,$ai_twitteruser,$ai_notweets);

		wp_register_style('aitwitter', plugins_url('css/aitwitter.css', __FILE__));
		wp_enqueue_style('aitwitter');

		if(!empty($ai_twitter_css)) {
			wp_add_inline_style( 'aitwitter', $ai_twitter_css );
		}

		if(is_admin()) {
			$screen = get_current_screen(); 
			if($screen->id == 'dashboard'){
				$ai_wid_title="";
				$ai_class="";
			} else {
				$ai_wid_title="<h3 class='widget-title'>".$ai_get_tweetstitle."</h3>";
				$ai_class="aiwidgetscss widget";
			}
		} else {
			$ai_wid_title="<h3 class='widget-title'>".$ai_get_tweetstitle."</h3>";	
			$ai_class="aiwidgetscss widget";
		}

		$ai_output="<div class='".$ai_class."'>
		".$ai_wid_title."					
		<div class='aiwidget-title'><span class='tweet_author_name'>".$ai_twitteruser."</span>&nbsp;<span class='tweet_author_heading'><a href='https://twitter.com/$ai_twitteruser' target='_blank'>@".$ai_twitteruser."</a></span></div>";

		for($i=0; $i<count($ai_tweets); $i++) {
			if(!empty($ai_tweets->errors)) {
				$ai_output .= '<p>'.$ai_tweets->errors[$i]->message.'</p>';
			} else {
				$ai_img_html='<a href="https://twitter.com/'.$ai_twitteruser.'" target="_blank"><img src="'.$ai_tweets[$i]->user->profile_image_url_https.'" class="imgalign"/></a>';

				$ai_username_html='<span class="tweet_author_name">
				<a href="https://twitter.com/'.$ai_twitteruser.'" target="_blank">'.$ai_tweets[$i]->user->name.'</a>
				</span>&nbsp;<span class="tweet_author"><a href="https://twitter.com/'.$ai_twitteruser.'" target="_blank">@'.$ai_twitteruser.'</a></span><br />';
				$ai_timestamp_html='<a href="https://twitter.com/'.$ai_tweets[$i]->user->screen_name.'/status/'.$ai_tweets[$i]->id_str.'" target="_blank">'.ai_getTime($ai_tweets[$i]->created_at).'</a>';

				$ai_replay_html='<a target="_blank" href="https://twitter.com/intent/tweet?in_reply_to='.$ai_tweets[$i]->id_str.'">reply</a>';
				
				$ai_retweet_html='<a target="_blank" href="https://twitter.com/intent/retweet?tweet_id='.$ai_tweets[$i]->id_str.'">retweet</a>';

				$ai_favorite_html='<a target="_blank" href="https://twitter.com/intent/favorite?tweet_id='.$ai_tweets[$i]->id_str.'">favorite</a>';

				$ai_follow_html='<p class="thinkTwitFollow"><a href="https://twitter.com/'. $ai_twitteruser.'" class="twitter-follow-button" data-show-count="false" data-dnt="true">Follow @'.$ai_twitteruser.'</a></p>';

				$ai_follow_html.="<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>";

				$ai_output.='<div class="imgdisplay">'.$ai_img_html.'
				<div class="tweettxts">
				<div class="tweettext">'.$ai_username_html.''.ai_makeLink($ai_tweets[$i]->text).'&nbsp
				</div> 
				<div class="tweetlink">
				'.$ai_timestamp_html.'
				'.$ai_replay_html.'
				'.$ai_retweet_html.'
				'.$ai_favorite_html.'
				<a href="https://twitter.com/'.$ai_twitteruser.'" target="_blank">'.ai_twitter_formatter($ai_tweets[$i]->created_at).'</a>
				</div>
				</div>
				</div>';
			}
		}	
		$ai_output.=$ai_follow_html."</div>";
		//echo $ai_output;
	} else {
		$ai_output="<div id='aiwidgetscss'>
		<h1>".$ai_get_tweetstitle."</h1>
		<div>Please Fill All Required Value</div>
		</div>";
		//echo $ai_output;			
	}
	return $ai_output;
}

/* 
*AI Twitter Widget Widget
* enables the ability to use a widget to place the tweet feed in the widget areas 
* of a theme.
*/
class AI_Twitter_Widget extends WP_Widget {

	/*
		* Register the widget for use in WordPress
	*/ 
	public function AI_Twitter_Widget(){
		$this->options = array(
			array(
				'label' => '<div style="background-color: #ddd; padding: 5px; text-align:center; color: red; font-weight:bold;">AI Widget settings</div>',
				'type'	=> 'separator'),
			array(
				'name'	=> 'ai_widget_title',	'label'	=> 'Widget title',
				'type'	=> 'text',	'default' => 'Latest Tweets', 'tooltip' => 'Title of the widget'),
			array(
				'name'	=> 'ai_widget_username',	'label'	=> 'Username (Without the "@" symbol)',
				'type'	=> 'text',	'default' => 'twitter', 'tooltip' => 'Twitter username for which you want to display tweets if widget type is set to Timeline'),
			array(
				'name'	=> 'ai_widget_count',	'label'	=> 'Tweet number',
				'type'	=> 'text',	'default' => '5', 'tooltip' => 'Number of Tweets to display'),
		);

		/* Widget settings. */
		$widget_options = array(
			'classname' => 'ai_widget',
			'description' => 'AI Simple Twitter Feed Widget, Displays your latest Tweet',
		);

		/* Widget control settings. */
		$control_ops = array('width' => 250);
		parent::WP_Widget('ai_widget','AI Twiiter Feeds',$widget_options,$control_ops);

	}

	public function widget($args, $instance) {
		$ai_get_widget_twitteruser=$instance['ai_widget_username'] ? $instance['ai_widget_username'] : get_option('ai_consumer_screen_name');
		$ai_get_widget_notweets=$instance['ai_widget_count'] ? $instance['ai_widget_count'] : get_option('ai_display_number_of_tweets');
		$title = ($instance['ai_widget_title']) ? $instance['ai_widget_title'] : 'Latest Twitter Feeds';
		$ai_wid_twitteruser = $ai_get_widget_twitteruser;
		$ai_wid_notweets = $ai_get_widget_notweets;
		extract($args, EXTR_SKIP);	
		$atts_arr=array('ai_username' => $ai_get_widget_twitteruser,
			'ai_numberoftweets' => $ai_get_widget_notweets,
			'ai_tweet_title' =>$title);
		echo ai_get_twitter_feeds($atts_arr);
	}

	function update($new_instance, $old_instance) {                
		return $new_instance;
	}

	public function form($instance) {
		if(empty($instance)) {
			foreach($this->options as $val) {
				if($val['type'] == 'separator') {
					continue;
				}
				$instance[$val['name']] = $val['default'];
			}
		}					

		if(!is_callable('curl_init')) {
			echo __('Your PHP doesn\'t have cURL extension enabled. Please contact your host and ask them to enable it.');
			return;
		}

		foreach($this->options as $val) {
			$title = '';
			if(!empty($val['tooltip'])) {
				$title = ' title="' . $val['tooltip'] . '"';
			}

			if($val['type'] == 'separator') {
				echo $val['label'] . '<br/ >';
			} else if($val['type'] == 'text') {
				$label = '<label for="' . $this->get_field_id($val['name']) . '" ' . $title . '>' . $val['label'] . '</label>';
				$value = $val['default'];
				
				if(isset($instance[$val['name']]))
					$value = esc_attr($instance[$val['name']]);

				echo '<p>' . $label . '<br />';
				echo '<input class="widefat" id="' . $this->get_field_id($val['name']) . '" name="' . $this->get_field_name($val['name']) . '" type="text" value="' . $value . '" ' . $title . '/></p>';
			}
		}
		echo "<a href='".admin_url()."options-general.php?page=ai-plugin'>More Settings</a>";
	}
}

add_action('admin_enqueue_scripts', 'ai_loadjs');
function ai_loadjs() {
	wp_enqueue_style('wp-color-picker');
	wp_enqueue_script('aisettings', plugins_url('/js/aisettings.js', __FILE__ ), array('jquery', 'wp-color-picker'));
}

/*
* Register the AI_Twitter_Widget widget
*/
function ai_widget_init() {
	register_widget('AI_Twitter_Widget');
}
add_action('widgets_init', 'ai_widget_init');