=== WP tlk.io ===
Contributors: snumb130, bbodine1
Donate link: 
Tags: chat, tlk.io, tlkio
Requires at least: 2.8
Tested up to: 4.0
Stable tag: 0..1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin to integrate tlk.io chat on any page of your website. tlk.io ("talk·eeo") is a web chat that is open to anyone.

== Description ==

A plugin to integrate [tlk.io chat](http://tlk.io) on any page of your website.  The plugin will allow users to insert a tlk.io chatroom in a post or page with a shortcode. There is currently no options page to adjust settings. All customs settings are done through the shortcode generator located in the WYSIWYG editor of all pages and posts. Look for the blue tlk.io logo icon (blue cloud) in the editor.

For more information about tlk.io chat visit the [tlk.io](http://tlk.io) website.

== Installation ==

1. Upload `wp-tlkio` folder to the `/wp-content/plugins/` directory
1. Activate the plugin 'WP tlk.io' through the 'Plugins' menu in WordPress
1. Place `[tlkio]` in your pages or posts

== Frequently asked questions ==

= What short code do I use? =

`[tlkio]`
or
`[tlkio channel="lobby" width="100%" height="500px" css="http://yourdomain.com/pathtoyour.css" activated="The chat has been activated." deactivated="The chat has been deactivated."]Chat is currently off. Check back later.[/tlkio]`

= What short code options do I have? =

* _channel_         - The name of the channel that you want to use. ex. 'lobby' or 'somethingrandom21'
* _width_           - How wide will the chat window be? use percentage or pixel width. ex. '100%' or '500px'
* _height_          - How high will the chat window be? use percentage or pixel width. ex. '100%' or '500px'
* _float_           - Float the chat window either 'right' or 'none'. Default is left.
* _css_             - Link to an external stylesheet to easily add custom style to the embedded tlk.io chat. ex. 'http://yourdomain.com/custom.css'
* _offclass_        - Class to use for the message displayed when chat is off.  The default class is `offmessage`
* _activated_       - Message to show if the chat is activated while users are on the page
* _deactivated_     - Message to show if the chat is deactivated while users are on the page
* _starton_         - When option is set to "yes" the chat will default to on
* _alwayson_        - When option is set to "yes" the chat will always be on and the admin bar will not appear.
* _Offline Message_ - This can tell the users of your webpage that you currently have the on page chat turned off. ex. 'Chat is scheduled for this/date/year. Come back then.'

== Screenshots ==

1. Admin View w/ chat enabled
2. Admin View w/ chat disabled
3. Client View w/ chat enabled
4. Client View w/ chat disabled
5. Shortcode Generator button on WYSIWYG editor
6. Shortcode Options

== Changelog ==

= 0.9.1 =
* Fix styling on thickbox in admin menu.

= 0.9 =
* Added Styling changes to the frontend admin bar
* Fixed a css error with the admin on/off switch

= 0.8 =
* Added option to have chat start on initially.
* Added option to have chat be always on.

= 0.7 =
* Prevent conflicts with other plugins and themes.

= 0.6 =
* Changed default float on chat container from none to left.
* Added margin around container to help separate text when floated.
* Fixed bug preventing scrolling of chat on touch devices.
* Fixed bug causing admin bar note to disappear after clicking on/off switch.

= 0.5 =
* Added a note to the admin bar clarifying that the bar is only visible to editors.
* Added float option to the shortcode to specify a css float on the chat container.
* Fixed bug causing chat window to overflow into content.
* Fixed bug causing chat window size to display incorrect width when percentage of less than 100% is used.

= 0.4 =
* Adding AJAX to turn the chats on and off.
* Adding AJAX to refresh users page if the chat is turned off during session.
* Reorganized the files and variables.
* Added option to specify message to show if the chat is activated while users are on the page
* Added option to specify message to show if the chat is deactivated while users are on the page

= 0.3 =
* Fixed shortcode error that was echoing output instead of returning.
* Changed the on/off switch from link to a form(POST method).

= 0.2 =
* Update to the readme.txt with better instructions for use.

= 0.1 =
* Initial version

== Upgrade notice ==

= 0.9 =
* UI improvements. Fix for a css error for admins.

= 0.8 =
* Added option to have chat start on initially and option to have chat be always on.

= 0.7 =
* Prevent conflicts with other plugins and themes.

= 0.6 =
* The default option for float has been chagned to 'left' instead of 'none'. If you want none use shortcode option `float="none"`.

= 0.5 =
* Float option has been added to the shortcode.

= 0.4 =
* Styling has been added to the message displayed when chat is off.  If you want to remove the styling add a shortcode option of `offclass=""`.  You can alternatively add a custom class to that option and style it how you want.
* AJAX has been added to the plugin for controlling the chat room state.
* Users currently on the page will have chat autorefresh after admin changes the state.
* New shortcode option (activated) to show a message to the users if the chat is activated while they are on the page.
* New shortcode option (deactivated) to show a message to the users if the chat is deactivated while they are on the page.

= 0.3 =
* Fixes possible error in the output of shortcodes.

= 0.2 =
* Minor update. No functionality changes. Only instructional changes.

= 0.1 =
* Initial version