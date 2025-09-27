=== Email Domain Blacklist for WooCommerce and EDD ===
Contributors: kowsar89
Tags: woocommerce, woo, email, domain, block, blacklist, checkout, easy, digital, downloads, edd
Requires at least: 3.0.1
Tested up to: 5.2
Stable tag: 2.0.0
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A lightweight plugin to block any email domain from WooCommerce and Easy Digital Download checkout page

== Description ==
Ever wanted to prevent users using temporary or disposable emails in checkout page? With this plugin, you can!

There are many websites (eg. 10minutemail.net, guerrillamail.com etc) which provides temporary email service. These websites use many different domain names in their temporary email addresses. All you have to do is, put these domain names in this plugin's settings page. After that when a user will try to place an order using the blacklisted email domain, checkout process will be interrupted and user will see an error notice.

You can configure the plugin settings from "Settings>Woo EDD Email Blacklist" menu from admin panel.

If you have no idea how many temporary domain names exists out there and you want to block all of them anyway, you can enable the option "External blacklist" from plugin settings. I have already created a list of temporary domain names and kept it in my server, enabling this option will pull that list from my server and store it in your database. I will try to update this list in regular intervals. For more information, please read the [FAQ](https://wordpress.org/plugins/woo-email-domain-blacklist/faq/) section.

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins > Add New'
2. Search for 'Email Domain Blacklist for WooCommerce and EDD'
3. Activate 'Email Domain Blacklist for WooCommerce and EDD' from your Plugins page.

= From WordPress.org =

1. Download 'Email Domain Blacklist for WooCommerce and EDD'.
2. Upload the 'woo-email-domain-blacklist' folder to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...)
3. Activate 'Email Domain Blacklist for WooCommerce and EDD' from your Plugins page.

After that you can configure the plugin settings from "Settings>Woo EDD Email Blacklist" menu from admin panel.

== Frequently Asked Questions ==

= Is this plugin on Github? =

Yes, here it is: [Github](https://github.com/kowsar89/woo-email-domain-blacklist)

= How can i update my external blacklist from your server? =

Just go to plugin settings page and click the SAVE button. Every time you save options it'll sync your external blacklist database with the updated list from my server. Also an automatic update will take place once in a week by WordPress cron job.

= How can i see this list? =

It's on Github, you can find it [here](https://github.com/kowsar89/temporary-email-domains/)

= Many temporary email domains are misssing in your list. When will you add them? =

I'm just a human, it's not possible for me to google all the temporary domains alone. Besides I have not much free time. If you have temporary email domain suggesions, please make a list and send it to me, I'll update it as soon as i can.

= How can i make suggesions? =

Please use the support section. Alternatively you can contribute on [this Github](https://github.com/kowsar89/temporary-email-domains/) repository too.
**Important Note: When you send me temporary email domain list, please also mention the website name where you found them**

== Screenshots ==
1. From admin panel, Click on "Settings>Woo EDD Email Blacklist" to visit the plugin settings page.
2. In checkout page, when users will use blacklisted email, they'll see an error notice.

== Changelog ==
= 2.0.0: December 12, 2015 =
* New: Easy Digital Download support added

= 1.0.1: December 10, 2015 =
* New: Cron job added
* Tweak: Language updated

= 1.0.0: December 2, 2015 =
* Initial release