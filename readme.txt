=== AI Twitter Feeds (Twitter widget & shortcode) ===
Contributors: augustinfotech
Tags: Twitter, Twitter API, Twitter 1.1, Twitter authentication, Feed, Twitter Shortcode, Twitter tweet, tweets, twitter, widget, twitter connect, twitter follow, twitter follow button, twitter share, twitter share button
Requires at least: 3.2
Tested up to: 3.5.2
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

As traditional version of twitter API is no longer working now, this plugin provides facility to display twitter tweets on your website using Twitter 1.1 API with authentication.

== Description ==

Features:

* Embed timelines using only username.
* Show tweets which contain a keyword.
* Highly configurable, many visual options.
* Using Twitter 1.1 API with authentication in Admin.
* No JavaScript embedded.
* You can manage tweets limits, twitter profile image,date, retweet link, reply link, favourite link and username from admin panel.
* You can manage color scheme such as background color, link color, link hover color, border color, text color, header text color, header username color, header hover color on username.


== Installation ==

Important

To use this one, please follow the steps bellow:

1) Register at https://dev.twitter.com/apps/new and create a new app.

2) After registering, fill in App name, e.g. "_domain name_ App", description, e.g "My Twitter App", and write    the address of your website. Check "I agree" next to their terms of service and click "create your Twitter    application"

3) After this you app will be created. Click "Create my access token" and you should see at the bottom "access    token" and "access token secret". Refresh the page if you don't see them.

4) Copy to widget settings "Consumer key", "Consumer secret", "Access token" and "Access secret"

Steps

1. Upload 'AI-Twitter-Feeds folder' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set Options for Twitter from the 'Settings/AI Twitter Settings' Admin Menu Link
4. Place PHP code '< ? php do_shortcode("[AIGetTwitterFeeds ai_username='Your Twitter Name(Without the "@" symbol)' ai_numberoftweets='Number Of Tweets' ai_tweet_title='Your Title']"); ? >' in your php templates.
5. Place shortcode '[AIGetTwitterFeeds ai_username='Your Twitter Name(Without the "@" symbol)' ai_numberoftweets='Number Of Tweets' ai_tweet_title='Your Title']' in your post(s)
6. Use the widget to place it in your sidebar or other areas!

== Frequently Asked Questions ==
No Questions

== Screenshots ==

1. Widget Setting example in admin.
2. Widget view on front side.
3. Use Shortcode OR PHP code in Post/Template.
4. Settings Screen from WordPress Admin.

== Changelog ==
= 1.0 =
* First version.

== Upgrade Notice ==
No Upgrade
