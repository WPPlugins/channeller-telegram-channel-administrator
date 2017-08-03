=== Channeller - Telegram Channel Administrator ===
Contributors: websima
Donate link: http://websima.com
Tags: Telegram, Telegram Bot, Telegram Channel, Telegram API, translate ready
Requires at least: 3.0.1
Tested up to: 4.7
Stable tag: 1.5.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Send Text, Link, Photo, Video and Audio Files from Wordpress to Telegram Channels and Groups using bots.

== Description ==

Bots are special Telegram accounts designed to handle messages automatically. Telegram introduced that bots can be used as channel admins so they can send messages to channels if the bot has been assigned as channel administrator.

Channeller (Telegram Channel Admin) helps you to integrate Telegram bot and Telegram Channel to your Wordpress site and send newsletter to channel members.

Features:

*   Send to Multiple Channels
*	Log Activities
*	Support Custom Post Types
*	Send Url, short Url or Custom Message
*   Send Photo to channel
*	Ability to send featured image
*	Ability to send post content
*   Send Text and Photo Messages to Groups 
*	Supports Html Tags in Messages including a, b, strong, code, em and pre
*	Send Images from other sites
*	Send Video Files your Wordpress site
*	Send Audio Files from your Wordpress site
*	Set Default Settings for sending
*	Send Inline Buttons to channel
*	Send Messages as Future Posts

Notice: add @Channeller_Bot robot to your group to get the Group ID, your bot should be one of the Group members for sending messages.

how to create a new channel in Telegram (Persian): <a href="http://websima.com/%DA%A9%D8%A7%D9%86%D8%A7%D9%84-%D8%AA%D9%84%DA%AF%D8%B1%D8%A7%D9%85/" title="کانال تلگرام">کانال تلگرام</a>
Channeller Settings Help (Persian): <a href="http://websima.com/channeller" title="Channeller Plugin">Channeller Plugin</a>

== Installation ==
From your WordPress dashboard:

1. Visit 'Plugins > Add New'

2. Search for 'Channeller'

3. Activate Telegram Newsletter from your Plugins page. (You'll be greeted with a Welcome page.)

From WordPress.org:

1. Download Channeller.

2. Upload the 'Channeller' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...)
Activate Telegram Newsletter from your Plugins page.

Extra

Visit 'Channeller' on Wordpress admin panel and adjust your configuration.

== Frequently Asked Questions ==

= Does it send the message with every new post or update post? =

Yes you can send newsletter whenever you publish or update a post, but the newsletter will be sent if you click the check box named as "Send to Channels".

= Does it send photo, video or audio files? =

Yes, but your first message to any channel should be Text Message.

= can this plugin send message to groups? =

Yes, but you should have Group Unique ID. add @Channeller_Bot to Group and receive the ID, your bot should be one of the Group members for sending messages.

== Screenshots ==

1. Channeller Settings Page
2. Channeller Meta Box on posts, pages or custom post types
3. Log Archive

== Changelog ==
= 1.5.2 =
Future Posts Support for channels

= 1.5.2 =
Glass Button Send Message Fixed

= 1.5.1 =
Added Inline Keyboards (Glass Button) Support
Fixed send photo conflict on php 5.6

= 1.4.1 =
Fixed First Text Message Bug shown for some Users:

= 1.4.0 =
Fixed Bugs
Set Default Metabox Settings
Send Video Files if Uploaded to your wordpress 
Send Audio Files if Uploaded to your wordpress 
View Channel Id 

= 1.3.4 =
Ability to send Image from web urls
no need to file_info function anymore

= 1.3.3 =
Limit image captions to 200 characters and messages to 3000 characters

= 1.3.2 =
Supports Html Tags in Messages including a, b, strong, code, em and pre

= 1.3.1 =
Fix Upload Button and Menu Position

= 1.3 =
ability to Send Post Content and Featured Image

= 1.2 =
send text and photo to Telegram Groups.

= 1.1 =
send Photo to channels.
send to channels separately.

= 1 =
send messages to channels using telegram bot API.
