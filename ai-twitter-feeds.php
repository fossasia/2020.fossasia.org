<?php
/*
Plugin Name: AI Twitter Feeds (Twitter widget & shortcode)
Plugin URI: http://www.augustinfotech.com
Description: Replaces a shortcode such as [AIGetTwitterFeeds ai_username='Your Twitter Name(Without the "@" symbol)' ai_numberoftweets='Number Of Tweets' ai_tweet_title='Your Title'], or a widget, with a tweets display 
Version: 1.1
Text Domain: aitwitterfeeds
Author: August Infotech
Author URI: http://www.augustinfotech.com
*/

add_action('plugins_loaded', 'ai_tweets_init');

/* Make Admin Menu Item*/
add_action('admin_menu','ai_twitter_setting');

/*Register Twitter Specific Options*/
add_action('admin_init','ai_init');

add_action('wp_dashboard_setup', 'ai_add_dashboard_tweets_feed' );

# Load the language files
function ai_tweets_init() {
	load_plugin_textdomain( 'aitwitterfeeds', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

/*
 * Setup Admin menu item
*/
function ai_twitter_setting()
{
	add_options_page('AI Twitter Settings','AI Twitter Settings','manage_options','ai-plugin','ai_option_page');
	

}

function ai_add_dashboard_tweets_feed() {
	wp_add_dashboard_widget('ai_dashboard_widget', 'AI Twitter Feeds', 'ai_get_twitter_feeds');
}

/*
 * Register Twitter Specific Options
*/

function ai_init(){
	register_setting('ai_options','ai_consumer_screen_name');//todo - add sanitization function ", 'functionName'"
	register_setting('ai_options','ai_consumer_key');
	register_setting('ai_options','ai_consumer_secret');
	register_setting('ai_options','ai_access_token');
	register_setting('ai_options','ai_access_token_secret');
	register_setting('ai_options','ai_display_number_of_tweets');
	register_setting('ai_options','ai_show_image');
	register_setting('ai_options','ai_display_username');
	register_setting('ai_options','ai_display_timestamps');
	register_setting('ai_options','ai_reply_link');
	register_setting('ai_options','ai_retweet_link');
	register_setting('ai_options','ai_favorite_link');
	register_setting('ai_options','ai_background_color');
	register_setting('ai_options','ai_link_color');
	register_setting('ai_options','ai_link_hover_color');
	register_setting('ai_options','ai_border_color');
	register_setting('ai_options','ai_text_color');
	register_setting('ai_options','ai_header_name_color');
	register_setting('ai_options','ai_header_username_color');
	register_setting('ai_options','ai_header_username_hover_color');
	register_setting('ai_options','ai_follow_button');
} 

if ( function_exists('register_uninstall_hook') )
        register_uninstall_hook(__FILE__,'ai_twitterfeed_uninstall');   

function ai_twitterfeed_uninstall()
{
	 delete_option('ai_consumer_screen_name'); 
	 delete_option('ai_consumer_key');
	 delete_option('ai_consumer_secret');
	 delete_option('ai_access_token');
	 delete_option('ai_access_token_secret');
	 delete_option('ai_display_number_of_tweets');
	 delete_option('ai_show_image');
	 delete_option('ai_display_username');
	 delete_option('ai_display_timestamps');
	 delete_option('ai_reply_link');
	 delete_option('ai_retweet_link');
	 delete_option('ai_favorite_link');
	 delete_option('ai_background_color');
	 delete_option('ai_link_color');
	 delete_option('ai_link_hover_color');
	 delete_option('ai_border_color');
	 delete_option('ai_text_color');
	 delete_option('ai_header_name_color');
	 delete_option('ai_header_username_color');
	 delete_option('ai_header_username_hover_color');
	 delete_option('ai_follow_button');
}		
/*
 * Display the Options form for AI Twitter Feed
*/

function ai_option_page()
{
	?>

<div class="wrap"> <img src="<?php echo plugins_url('ai-twitter-feeds/css/augustinfotech.jpg'); ?>" class="icon32" />
  <h2>
    <?php _e('AI Twitter Feed Options','aitwitterfeeds');?>
  </h2>
  <p>
    <?php _e('Here you can set or edit the fields needed for the plugin.','aitwitterfeeds');?>
  </p>
  <p>
    <?php _e('You can find these settings here: <a href="https://dev.twitter.com/apps" target="_blank">Twitter API</a>','aitwitterfeeds');?>
  </p>
  <form action="options.php" method="post" id="ai-options-form">
    <?php settings_fields('ai_options'); ?>
    <table class="form-table">
      <tr class="even" valign="top">
        <th scope="row"><label for="ai_consumer_screen_name">
            <?php _e('Twitter Screen(User) Name or  Hashtags/keywords:','aitwitterfeeds');?>
          </label></th>
        <td><input type="text" id="ai_consumer_screen_name" name="ai_consumer_screen_name" class="regular-text" value="<?php echo esc_attr(get_option('ai_consumer_screen_name')); ?>" />
          <p class="description">
            <?php _e('(Without the "@" / "#" symbol)','aitwitterfeeds');?>
          </p></td>
      </tr>
      <tr class="odd" valign="top">
        <th scope="row"><label for="ai_consumer_key">
            <?php _e('Consumer Key:','aitwitterfeeds');?>
          </label></th>
        <td><input type="text" id="ai_consumer_key" name="ai_consumer_key" class="regular-text" value="<?php echo esc_attr(get_option('ai_consumer_key')); ?>" />
          <p></p></td>
      </tr>
      <tr class="even" valign="top">
        <th scope="row"><label for="ai_consumer_secret">
            <?php _e('Consumer Secret:','aitwitterfeeds');?>
          </label></th>
        <td><input type="text" id="ai_consumer_secret" name="ai_consumer_secret" class="regular-text" value="<?php echo esc_attr(get_option('ai_consumer_secret')); ?>" />
          <p></p></td>
      </tr>
      <tr class="odd" valign="top">
        <th scope="row"><label for="ai_access_token">
            <?php _e('Access Token:','aitwitterfeeds');?>
          </label></th>
        <td><input type="text" id="ai_access_token" name="ai_access_token" class="regular-text" value="<?php echo esc_attr(get_option('ai_access_token')); ?>" />
          <p></p></td>
      </tr>
      <tr class="even" valign="top">
        <th scope="row"><label for="ai_access_token_secret">
            <?php _e('Access Token Secret:','aitwitterfeeds');?>
          </label></th>
        <td><input type="text" id="ai_access_token_secret" name="ai_access_token_secret" class="regular-text" value="<?php echo esc_attr(get_option('ai_access_token_secret')); ?>" />
          <p></p></td>
      </tr>
      <tr class="odd" valign="top">
        <th scope="row"><label for="ai_display_number_of_tweets">
            <?php _e('Number Of Tweets:','aitwitterfeeds');?>
          </label></th>
        <td><input type="text" id="ai_display_number_of_tweets" name="ai_display_number_of_tweets" class="regular-text" value="<?php echo esc_attr(get_option('ai_display_number_of_tweets')); ?>" />
          <p></p></td>
      </tr>
      <tr class="even" valign="top">
        <th scope="row"><label for="ai_display_username">
            <?php _e('Display username:','aitwitterfeeds');?>
          </label></th>
        <td><?php 
						$ai_yesno=array('Yes'=>'Yes','No'=>'No');
						$ai_display_username_current=esc_attr(get_option('ai_display_username'));
					?>
          <select name="ai_display_username" id="ai_display_username">
            <?php foreach($ai_yesno as $ai_k=>$ai_v){?>
            <option value="<?php echo $ai_k; ?>" <?php selected( $ai_v, $ai_display_username_current);?> ><?php echo $ai_v; ?></option>
            <?php } ?>
          </select>
          <p></p></td>
      </tr>
      <tr class="odd" valign="top">
        <th scope="row"><label for="ai_show_image">
            <?php _e('Display avatars:','aitwitterfeeds');?>
          </label></th>
        <td><?php 
						$ai_show_image_current=esc_attr(get_option('ai_show_image'));
					?>
          <select name="ai_show_image" id="ai_show_image">
            <?php foreach($ai_yesno as $ai_k=>$ai_v){?>
            <option value="<?php echo $ai_k; ?>" <?php selected( $ai_v, $ai_show_image_current);?> ><?php echo $ai_v; ?></option>
            <?php } ?>
          </select>
          <p></p></td>
      </tr>
      <tr class="even" valign="top">
        <th scope="row"><label for="ai_display_timestamps">
            <?php _e('Display timestamps:','aitwitterfeeds');?>
          </label></th>
        <td><?php 
						$ai_display_timestamps_current=esc_attr(get_option('ai_display_timestamps'));
					?>
          <select name="ai_display_timestamps" id="ai_display_timestamps">
            <?php foreach($ai_yesno as $ai_k=>$ai_v){?>
            <option value="<?php echo $ai_k; ?>" <?php selected( $ai_v, $ai_display_timestamps_current);?> ><?php echo $ai_v; ?></option>
            <?php } ?>
          </select>
          <p></p></td>
      </tr>
      <tr class="odd" valign="top">
        <th scope="row"><label for="ai_reply_link">
            <?php _e('Reply link:','aitwitterfeeds');?>
          </label></th>
        <td><?php 
						$ai_reply_link_current=esc_attr(get_option('ai_reply_link'));
					?>
          <select name="ai_reply_link" id="ai_reply_link">
            <?php foreach($ai_yesno as $ai_k=>$ai_v){?>
            <option value="<?php echo $ai_k; ?>" <?php selected( $ai_v, $ai_reply_link_current);?> ><?php echo $ai_v; ?></option>
            <?php } ?>
          </select>
          <p></p></td>
      </tr>
      <tr class="even" valign="top">
        <th scope="row"><label for="ai_retweet_link">
            <?php _e('Retweet link:','aitwitterfeeds');?>
          </label></th>
        <td><?php 
						$ai_retweet_link_current=esc_attr(get_option('ai_retweet_link'));
					?>
          <select name="ai_retweet_link" id="ai_retweet_link">
            <?php foreach($ai_yesno as $ai_k=>$ai_v){?>
            <option value="<?php echo $ai_k; ?>" <?php selected( $ai_v, $ai_retweet_link_current);?> ><?php echo $ai_v; ?></option>
            <?php } ?>
          </select>
          <p></p></td>
      </tr>
      <tr class="odd" valign="top">
        <th scope="row"><label for="ai_favorite_link">
            <?php _e('Favorite link:','aitwitterfeeds');?>
          </label></th>
        <td><?php 
						$ai_favorite_link_current=esc_attr(get_option('ai_favorite_link'));
					?>
          <select name="ai_favorite_link" id="ai_favorite_link">
            <?php foreach($ai_yesno as $ai_k=>$ai_v){?>
            <option value="<?php echo $ai_k; ?>" <?php selected( $ai_v, $ai_favorite_link_current);?> ><?php echo $ai_v; ?></option>
            <?php } ?>
          </select>
          <p></p></td>
      </tr>
      <tr class="odd" valign="top">
        <th scope="row"><label for="ai_follow_button">
            <?php _e('Show "Follow @username" links:','aitwitterfeeds');?>
          </label></th>
        <td><?php 
						$ai_follow_link_current=esc_attr(get_option('ai_follow_button'));
					?>
          <select name="ai_follow_button" id="ai_follow_button">
            <?php foreach($ai_yesno as $ai_fk=>$ai_fv){?>
            <option value="<?php echo $ai_fk; ?>" <?php selected( $ai_v, $ai_follow_link_current);?> ><?php echo $ai_fv; ?></option>
            <?php } ?>
          </select>
          <p></p></td>
      </tr>
      <tr class="even" valign="top">
        <th scope="row"><label for="ai_background_color">
            <?php _e('Background color:','aitwitterfeeds');?>
          </label></th>
        <td><input type="text" id="ai_background_color" name="ai_background_color" class="regular-text ai-color-field" value="<?php echo esc_attr(get_option('ai_background_color')); ?>" />
          <p></p></td>
      </tr>
      <tr class="odd" valign="top">
        <th scope="row"><label for="ai_link_color">
            <?php _e('Link color:','aitwitterfeeds');?>
          </label></th>
        <td><input type="text" id="ai_link_color" name="ai_link_color" class="regular-text ai-color-field" value="<?php echo esc_attr(get_option('ai_link_color')); ?>" />
          <p></p></td>
      </tr>
      <tr class="even" valign="top">
        <th scope="row"><label for="ai_link_hover_color">
            <?php _e('Link hover color:','aitwitterfeeds');?>
          </label></th>
        <td><input type="text" id="ai_link_hover_color" name="ai_link_hover_color" class="regular-text ai-color-field" value="<?php echo esc_attr(get_option('ai_link_hover_color')); ?>" />
          <p></p></td>
      </tr>
      <tr class="odd" valign="top">
        <th scope="row"><label for="ai_border_color">
            <?php _e('Border color:','aitwitterfeeds');?>
          </label></th>
        <td><input type="text" id="ai_border_color" name="ai_border_color" class="regular-text ai-color-field" value="<?php echo esc_attr(get_option('ai_border_color')); ?>" />
          <p></p></td>
      </tr>
      <tr class="even" valign="top">
        <th scope="row"><label for="ai_text_color">
            <?php _e('Text color:','aitwitterfeeds');?>
          </label></th>
        <td><input type="text" id="ai_text_color" name="ai_text_color" class="regular-text ai-color-field" value="<?php echo esc_attr(get_option('ai_text_color')); ?>" />
          <p></p></td>
      </tr>
      <tr class="odd" valign="top">
        <th scope="row"><label for="ai_header_name_color">
            <?php _e('Header name color:','aitwitterfeeds');?>
          </label></th>
        <td><input type="text" id="ai_header_name_color" name="ai_header_name_color" class="regular-text ai-color-field" value="<?php echo esc_attr(get_option('ai_header_name_color')); ?>" />
          <p></p></td>
      </tr>
      <tr class="even" valign="top">
        <th scope="row"><label for="ai_header_username_color">
            <?php _e('Header username color:','aitwitterfeeds');?>
          </label></th>
        <td><input type="text" id="ai_header_username_color" name="ai_header_username_color" class="regular-text ai-color-field" value="<?php echo esc_attr(get_option('ai_header_username_color')); ?>" />
          <p></p></td>
      </tr>
      <tr class="odd" valign="top">
        <th scope="row"><label for="ai_header_username_hover_color">
            <?php _e('Header username on hover color:','aitwitterfeeds');?>
          </label></th>
        <td><input type="text" id="ai_header_username_hover_color" name="ai_header_username_hover_color" class="regular-text ai-color-field" value="<?php echo esc_attr(get_option('ai_header_username_hover_color')); ?>" />
          <p></p></td>
      </tr>
    </table>
    <p class="submit">
      <input type="submit" name="submit" class="button-primary" value="Save Settings" />
    </p>
  </form>
</div>
<?php
}

function ai_makeLink($ai_tweet_con) {
	$ai_tweet_con = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $ai_tweet_con);
	$ai_tweet_con = preg_replace( '/@([a-zA-Z0-9]+)/', '<a href="https://twitter.com/\1" target="_blank">@\1</a>', $ai_tweet_con ); 
	$ai_tweet_con = preg_replace( '/#([a-zA-Z0-9-]+)/', '<a href="https://twitter.com/search?q=%23\1&src=hash" target="_blank">#\1</a>', $ai_tweet_con ); 
	return $ai_tweet_con;
}
		
// parse time in a twitter style
function ai_getTime($ai_date)
{
	$ai_timediff = time() - strtotime($ai_date);
	if($ai_timediff < 60)
		return $ai_timediff . 's';
	else if($ai_timediff < 3600)
		return intval(date('i', $ai_timediff)) . 'm';
	else if($ai_timediff < 86400)
		return round($ai_timediff/60/60) . 'h';
	else
		return date_i18n('M d', strtotime($ai_date));
}	

function ai_twitter_formatter($ai_date)
{
	$ai_epoch_timestamp = strtotime( $ai_date );
	$ai_twitter_time = human_time_diff($ai_epoch_timestamp, current_time('timestamp') ) . ' ago';
	return $ai_twitter_time;
}

require_once("twitteroauth/twitteroauth.php"); //Path to twitteroauth library

function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret)
{
	  $ai_connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
	  return $ai_connection;
}

function get_connect($ai_consumerkey_gt, $ai_consumersecret_gt, $ai_accesstoken_gt, $ai_accesstokensecret_gt,$ai_twitteruser_gt,$ai_notweets_gt)
{
	//session_start();
	$ai_connection = getConnectionWithAccessToken($ai_consumerkey_gt, $ai_consumersecret_gt, $ai_accesstoken_gt, $ai_accesstokensecret_gt);
	$ai_tweets_all = $ai_connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$ai_twitteruser_gt."&count=".$ai_notweets_gt);
	return $ai_tweets_all;
}

/* Short code */
add_shortcode( 'AIGetTwitterFeeds' , 'ai_get_twitter_feeds' );

function ai_get_twitter_feeds($atts)
{
	extract( shortcode_atts( array(
		'ai_username' => '',
		'ai_numberoftweets' => '',
		'ai_tweet_title' =>''
	), $atts ) );

	$ai_get_twitteruser=$ai_username ? $ai_username : get_option('ai_consumer_screen_name');
	$ai_get_notweets=$ai_numberoftweets ? $ai_numberoftweets : get_option('ai_display_number_of_tweets');
	$ai_get_tweetstitle=$ai_tweet_title ? $ai_tweet_title:'Latest Twetter Feeds';

	$ai_twitteruser = $ai_get_twitteruser;
	$ai_notweets = $ai_get_notweets;
	$ai_consumerkey = get_option('ai_consumer_key');
	$ai_consumersecret = get_option('ai_consumer_secret');
	$ai_accesstoken = get_option('ai_access_token');
	$ai_accesstokensecret = get_option('ai_access_token_secret');
	$ai_img_display=esc_attr(get_option('ai_show_image'));
	$ai_username_display=esc_attr(get_option('ai_display_username'));
	$ai_timestamp_display=esc_attr(get_option('ai_display_timestamps'));
	$ai_reply_display=esc_attr(get_option('ai_reply_link'));
	$ai_retweet_display=esc_attr(get_option('ai_retweet_link'));
	$ai_favorite_display=esc_attr(get_option('ai_favorite_link'));
	$ai_get_background_color=esc_attr(get_option('ai_background_color'));
	$ai_get_link_color=esc_attr(get_option('ai_link_color'));
	$ai_get_link_hover_color=esc_attr(get_option('ai_link_hover_color'));
	$ai_get_border_color=esc_attr(get_option('ai_border_color'));
	$ai_get_text_color=esc_attr(get_option('ai_text_color'));
	$ai_get_header_name_color=esc_attr(get_option('ai_header_name_color'));
	$ai_get_header_username_color=esc_attr(get_option('ai_header_username_color'));
	$ai_get_header_username_hover_color=esc_attr(get_option('ai_header_username_hover_color'));
	$ai_get_follow_button=esc_attr(get_option('ai_follow_button'));
		
			
	if($ai_twitteruser!='' && $ai_notweets !='' && $ai_consumerkey!='' && $ai_consumersecret!='' && $ai_accesstoken!='' && $ai_accesstokensecret!='')
	{
		
		$ai_tweets = get_connect($ai_consumerkey, $ai_consumersecret, $ai_accesstoken, $ai_accesstokensecret,$ai_twitteruser,$ai_notweets);
		$styles = '';
		if($ai_get_background_color != '' || $ai_get_border_color != '' || $ai_get_text_color != '')
		$styles .= '.aiwidgetscss {background-color: ' . $ai_get_background_color . ';
								   border-color:' . $ai_get_border_color . ';
								   color: ' . $ai_get_text_color . ';}';
		if($ai_get_link_color != '')
			$styles .= '.aiwidgetscss .imgdisplay a {color: ' . $ai_get_link_color . '}';
		if($ai_get_link_hover_color != '')
			$styles .= '.aiwidgetscss .imgdisplay a:hover {color: ' . $ai_get_link_hover_color . '}';
		if($ai_get_header_name_color != '')
			$styles .= '.aiwidgetscss .widget-title {color: ' . $ai_get_header_name_color . '}';
		if($ai_get_header_username_color != '')
			$styles .= '.aiwidgetscss .aiwidget-title a {color: ' . $ai_get_header_username_color . '}';
		if($ai_get_header_username_hover_color != '')
			$styles .= '.aiwidgetscss .aiwidget-title a:hover {color: ' . $ai_get_header_username_hover_color . '}';
		
		wp_register_style('aitwitter', plugins_url('css/aitwitter.css', __FILE__));
		wp_enqueue_style('aitwitter');
		wp_add_inline_style('aitwitter', $styles);
		if(is_admin())
		{
			$screen = get_current_screen(); 
			if($screen->id == 'dashboard')
			{
				 $ai_wid_title="";
				 $ai_class="";
			}
			else
			{
				 $ai_wid_title="<h3 class='widget-title'>".$ai_get_tweetstitle."</h3>";
				 $ai_class="aiwidgetscss widget";
			}
		}
		else
		{
			$ai_wid_title="<h3 class='widget-title'>".$ai_get_tweetstitle."</h3>";	
			$ai_class="aiwidgetscss widget";
		}
		
			
		$ai_output="<div class='".$ai_class."'>
					".$ai_wid_title."					
					<div class='aiwidget-title'>".$ai_twitteruser."&nbsp;<span><a href='https://twitter.com/$ai_twitteruser' target='_blank'>@".$ai_twitteruser."</a><span></div>";
					
		for($i=0;$i<count($ai_tweets);$i++)
		{
			
			if($ai_img_display=='Yes'){$ai_img_html='<img src="'.$ai_tweets[$i]->user->profile_image_url_https.'" class="imgalign"/>';}else{$ai_img_html='';}
			
			if($ai_username_display=='Yes'){
				$ai_username_html='<strong>
									<a href="https://twitter.com/intent/user?screen_name='.$ai_tweets[$i]->user->screen_name.'" target="_blank">'.$ai_tweets[$i]->user->name.'</a>
									</strong>';
			}else{$ai_username_html='';}
			
			if($ai_timestamp_display=='Yes'){
				$ai_timestamp_html='<a href="https://twitter.com/'.$ai_tweets[$i]->user->screen_name.'/status/'.$ai_tweets[$i]->id_str.'" target="_blank">'.ai_getTime($ai_tweets[$i]->created_at).'</a>';
			}else{$ai_timestamp_html='';}
			
			if($ai_reply_display=='Yes'){$ai_replay_html='<a target="_blank" href="https://twitter.com/intent/tweet?in_reply_to='.$ai_tweets[$i]->id_str.'">reply</a>';}else{$ai_replay_html='';}
			
			if($ai_retweet_display=='Yes'){$ai_retweet_html='<a target="_blank" href="https://twitter.com/intent/retweet?tweet_id='.$ai_tweets[$i]->id_str.'">retweet</a>';}else{$ai_retweet_html='';}
			
			if($ai_favorite_display=='Yes'){$ai_favorite_html='<a target="_blank" href="https://twitter.com/intent/favorite?tweet_id='.$ai_tweets[$i]->id_str.'">favorite</a>';}else{$ai_favorite_html='';}
			
			if($ai_get_follow_button=='Yes'){
				
				$ai_follow_html='<p class="thinkTwitFollow"><a href="https://twitter.com/'. $ai_twitteruser.'" class="twitter-follow-button" data-show-count="false" data-dnt="true">Follow @'.$username.'</a></p>';
				
				$ai_follow_html.='<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");twttr.widgets.load();</script>';
				
			}else{$ai_follow_html='';}
			
			
			$ai_output.='<div class="imgdisplay">'.$ai_img_html.'
							<div class="tweettxts">
							<div class="tweettext">'.$ai_username_html.'
							&nbsp;'.ai_makeLink($ai_tweets[$i]->text).'&nbsp
							</div> 
							<div class="tweetlink">
								'.$ai_timestamp_html.'
								'.$ai_replay_html.'
								'.$ai_retweet_html.'
								'.$ai_favorite_html.'
								'.ai_twitter_formatter($ai_tweets[$i]->created_at).'
							</div>
							</div>
						</div>';
		}	
		
		$ai_output.=$ai_follow_html."</div>";
		
	
		echo $ai_output;
	}
	else
	{
		$ai_output="<div id='aiwidgetscss'>
					<h1>".$ai_get_tweetstitle."</h1>
						<div>Please Fill All Required Value
						</div>
					<div>";
		echo $ai_output;			
	}
}

/*
 * AI Twitter Widget Widget
 * enables the ability to use a widget to place the tweet feed in the widget areas 
 * of a theme.
 */
 class AI_Twitter_Widget extends WP_Widget
 {
 		
 	/*
	 * Register the widget for use in WordPress
	*/ 
 	public function AI_Twitter_Widget()
 	{
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
		$control_ops = array('width' => 400);
		parent::WP_Widget('ai_widget','AI Twiiter Feeds',$widget_options,$control_ops);
 	}
	
	public function widget($args, $instance)
	{
		
		$ai_get_widget_twitteruser=$instance['ai_widget_username'] ? $instance['ai_widget_username'] : get_option('ai_consumer_screen_name');
		$ai_get_widget_notweets=$instance['ai_widget_count'] ? $instance['ai_widget_count'] : get_option('ai_display_number_of_tweets');
		$title = ($instance['ai_widget_title']) ? $instance['ai_widget_title'] : 'Latest Twitter Feeds';
		
		$ai_wid_twitteruser = $ai_get_widget_twitteruser;
		$ai_wid_notweets = $ai_get_widget_notweets;
			
		extract($args, EXTR_SKIP);	
		
		$atts_arr=array('ai_username' => $ai_get_widget_twitteruser,
		'ai_numberoftweets' => $ai_get_widget_notweets,
		'ai_tweet_title' =>$title);
		ai_get_twitter_feeds($atts_arr);
	}
	
	function update($new_instance, $old_instance) {                

       return $new_instance;

   }
   
	public function form($instance)
	{
		if(empty($instance)) {
			foreach($this->options as $val) {
				if ($val['type'] == 'separator') {
					continue;
				}
				$instance[$val['name']] = $val['default'];
			}
		}					
	
		if (!is_callable('curl_init')) {
			echo __('Your PHP doesn\'t have cURL extension enabled. Please contact your host and ask them to enable it.');
			return;
		}
		
		foreach ($this->options as $val) {
			$title = '';
			if(!empty($val['tooltip'])) {
				$title = ' title="' . $val['tooltip'] . '"';
			}
			if($val['type'] == 'separator') {
				echo $val['label'] . '<br/ >';
			}
			else if($val['type'] == 'text') {
				$label = '<label for="' . $this->get_field_id($val['name']) . '" ' . $title . '>' . $val['label'] . '</label>';
				$value = $val['default'];
				if(isset($instance[$val['name']]))
					$value = esc_attr($instance[$val['name']]);
				echo '<p>' . $label . '<br />';
				echo '<input class="widefat" id="' . $this->get_field_id($val['name']) . '" name="' . $this->get_field_name($val['name']) . '" type="text" value="' . $value . '" ' . $title . '/></p>';
			}
		}
		echo "<a href='".admin_url()."options-general.php?page=ai-plugin'> Go to More Settings</a>";
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
function ai_widget_init()
{
	register_widget('AI_Twitter_Widget');
}
add_action('widgets_init', 'ai_widget_init');

