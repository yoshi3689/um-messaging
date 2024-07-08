=== Ultimate Member - Private Messages ===
Author URI: https://ultimatemember.com/
Plugin URI: https://ultimatemember.com/extensions/private-messages/
Contributors: ultimatemember, champsupertramp, nsinelnikov
Tags: private messaging, email, user, community
Requires at least: 5.5
Tested up to: 6.5
Stable tag: 2.3.9
License: GNU Version 2 or Any Later Version
License URI: http://www.gnu.org/licenses/gpl-3.0.txt
Requires UM core at least: 2.8.0

Add a private messaging system to your site and allow users to privately message each other. Perfect for websites where users need to interact one on one.

== Description ==

Add a private messaging system to your site and allow users to privately message each other. Perfect for websites where users need to interact one on one.

= Key Features: =

* Allows users to send private messages to other users
* Adds a message button to user profiles which lets users send a private message to that user via messages modal
* Adds a messages tab to each user profile so users can view all conversations and read/send private messages from profile
* Automatic refresh of private messages
* Ability to add emoticons to each private message easily
* Option to set a maximum number of characters allowed in each conversation reply
* Adds option to user account page for users to decide if they want to receive private messages or not
* Sends an e-mail notification to users when someone starts a new conversation with them
* Adds option to user account page so users can turn on/off receiving an e-mail notification for new conversations
* Control which user roles can use private messages
* Control which user roles can send or receive private messages
* Limit the number of new conversations a user role can create within a certain timeframe
* Includes block feature so users can block specific users from messaging them and also provides a way to unblock users from account page
* Messages accept plain text, with urls automatically converted into links (No other HTML is accepted in messages)
* Show unread messages count in your menu easily using the {new_messages} tag

= Integrations with other extensions: =

* Followers – Users can decide to let only users who follow them to message them.
* Real-time Notifications – Users can receive a notification when someone starts a new conversation with them.
* Online users – Shows a green dot next to user when user is online

= Development * Translations =

Want to add a new language to Ultimate Member? Great! You can contribute via [translate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/ultimate-member).

If you are a developer and you need to know the list of UM Hooks, make this via our [Hooks Documentation](https://docs.ultimatemember.com/article/1324-hooks-list).

= Documentation & Support =

Got a problem or need help with Ultimate Member? Head over to our [documentation](http://docs.ultimatemember.com/) and perform a search of the knowledge base. If you can’t find a solution to your issue then you can create a topic on the [support forum](https://wordpress.org/support/plugin/um-forumwp).

== Installation ==

1. Activate the plugin
2. That's it. Go to Ultimate Member > Settings > Extensions > Private Messaging to customize plugin options
3. For more details, please visit the official [Documentation](http://docs.ultimatemember.com/article/234-private-messages-setup) page.

== Changelog ==

= Important: 2.1.7+ version is compatible with UM: Online 2.0.5+ version =

= 2.3.9: May 22, 2024 =

* Fixed: Loading assets in block builder
* Fixed: Send button enabled after the limit is exceeded and deleting extra characters
* Tweak: Added Ultimate Member as required plugins

= 2.3.8: December 13, 2023 =

* Fixed: Using moment.js library

= 2.3.7: December 11, 2023 =

* Tweak: Frontend libraries refactored
  * Added: Simplebar.JS library because it's not used in UM core
  * Updated: autosize JS to 6.0.1 version
* Tweak: wp-admin scripts refactored
  * Tweak: Using enqueue scripts suffix from UM core class. Dependency from UM core 2.7.0
* Fixed: 'um_user_permissions_filter' hook attributes
* Tweak: Using `UM()->datetime()->time_diff()` function instead local registered functions duplicates

= 2.3.6: October 11, 2023 =

* Fixed: Displaying "Notifications Account Tab" setting
* Fixed: Double sending messages
* Fixed: Shift+Enter break line when user types a message
* Fixed: Case when extension isn't active based on dependency, but we can provide the license key field

= 2.3.5: August 29, 2023 =

* Added: Option for hide message button for guests
* Fixed: PHP warnings
* Fixed: Removed `extract()`
* Fixed: Issue with lack of the nonces
* Fixed: "editable" field data format in predefined fields
* Tweak: Template overwrite versioning
* Tweak: changed `input_filter` to WordPress native sanitize
* Tweak: Ultimate Member 2.6.7 compatibility

= 2.3.4: December 14, 2022 =

* Fixed: Layout issues related to the textarea auto-size and the conversation layout
* Fixed: Security issue related to the COOKIES using

* Templates required update:
  - conversation.php
  - emoji.php
  - message.php

* Cached and optimized/minified assets(JS/CSS) must be flushed/re-generated after upgrade

= 2.3.3: August 17, 2022 =

* Added: Refresh new real-time notifications on async query when conversation is refreshed

= 2.3.2: February 9, 2022 =

* Added: 'Hide a "Download Chats History" link' setting.
* Fixed: setCaretPosition when paste emoji in the message textarea
* Fixed: Extension settings structure
* Deprecated: user_id attribute for [ultimatemember_messages] shortcode. Messaging conversations list is displayed only for the current logged in user

= 2.3.1: December 20, 2021 =

* Added: Filter `um_messaging_get_messages_limit` for getting more than 1000 messages in 1 conversation via customization
* Added: Restriction settings for role who can start conversation/reply. There is possible to everyone or selected roles.
* Fixed: Multisite installation and tables creating when the plugin is active on the single site or network

* Templates required update:
  - conversation.php

= 2.3.0: March 29, 2021 =

* Fixed: Conversation block's horizontal scroll
* Tweak: jQuery v3 compatibility

= 2.2.9: December 8, 2020 =

* Added: `count_messages` method
* Added: CSS for messages button at the profile page
* Added: 3rd party settings integration hook
* Fixed: Typo shortcode on the messages profile tab
* Fixed: Security vulnerability with getting conversations content
* Fixed: URL including `#` links
* Fixed: `limit_reached` method

= 2.2.8: August 11, 2020 =

* Added: The default value for attribute "user_id" of the shortcode [ultimatemember_message_button]
* Added: *.pot translations file
* Added: CSS for messages button at the profile page
* Added: 3rd party integrations hook in settings section
* Fixed: Security vulnerability with getting conversations content
* Fixed: Modal Login form with reCAPTCHA
* Fixed: Modal windows links
* Fixed: URLs with # symbol
* Tweak: apply_shortcodes() function support

= 2.2.7: April 1, 2020 =

* Tweak: Optimized UM:Notifications integration
* Fixed: Old script breaks reCAPTCHA handler, so user can't login using the modal login form
* Fixed: Modal Login for not logged-in user who starts a chat

= 2.2.6: January 13, 2020 =

* Fixed: A bug with message tab if a user role disabled for private messages
* Changed: Account notifications layout

= 2.2.5: November 11, 2019 =

* Tweak: Compatibility with 2.1.0 UM core

= 2.2.4: July 16, 2019 =

* Fixed: Profile Tabs loop in some cases
* Fixed: Account Tab data saving

= 2.2.3: July 2, 2019 =

* Fixed: JS SimpleBar errors

= 2.2.2: May 29, 2019 =

* Added: Templates for all HTML layouts in plugin
* Fixed: AJAX conversation update
* Fixed: Timestamp for saving the message
* Fixed: Uninstall process when delete options checked

= 2.2.1: May 14, 2019 =

* Added: Template for Message button
* Fixed: Return empty content for undefined User ID

= 2.2.0: May 8, 2019 =

* Added: Confirmation before block user
* Fixed: Scrolling at mobile devices ( simplebar library for scrolling is included )
* Fixed: GDPR chats downloading
* Fixed: Cursor position after insert emoji

= 2.1.9: May 8, 2019 =

* Fixed: Vulnerability with Chat History

= 2.1.8: April 5, 2019 =

* Fixed: CSS style via wp_inline_add_script
* Fixed: Insert emoji in the message box
* Fixed: Show first conversation on load page
* Fixed: Email reminder about unread messages

= 2.1.7: March 12, 2019 =

* Optimized: JS template for conversations list

= 2.1.6: February 18, 2019 =

* Added: Conversations Pagination
* Added: Option to show unread conversations first

= 2.1.5: January 24, 2019 =

* Added: Filter for the displaying Start Conversation button

= 2.1.4: November 30, 2018 =

* Fixed: AJAX update conversation

= 2.1.3: November 23, 2018 =

* Added: Periodical new message notifier
* Fixed: AJAX vulnerabilities
* Fixed: JS handlers on paste message to the message-box

= 2.1.2: October 22, 2018 =

* Fixed: Messaging Notifier styles

= 2.1.1: October 22, 2018 =

* Fixed: Start Messaging from User Profile for not-logged in user
* Fixed: User Roles Capabilities

= 2.1.0: October 19, 2018 =

* Fixed: Start Conversations capabilities
* Optimized: JS/CSS enqueue

= 2.0.9: October 15, 2018 =

* Added: Option for Chat new messages requests interval
* Added: Custom tables integration with WP Cache
* Added: Indexing custom tables
* Fixed: Role Settings for Private Messages
* Fixed: Download History handlers
* Fixed: Conversations privacy

= 2.0.8: August 13, 2018 =

* Fixed: WP native AJAX

= 2.0.7: August 9, 2018 =

* Fixed: Privacy account settings for sites with different languages

= 2.0.6: July 8, 2018 =

* Fixed: JS issues on conversations tab

= 2.0.5: July 3, 2018 =

* Fixed: JS issues
* Fixed: Login Form on click "Message" in members directory
* Optimized: Leave $wpdb connection

= 2.0.4: July 3, 2018 =

* Added: GDPR compatibility for download conversations history
* Added: GDPR compatibility on users delete
* Fixed: User should be able to reply to message even if they cant start a conversation in conversations
* Fixed: Account Privacy tab field

= 2.0.3: April 27, 2018 =

* Added: Loading translation from "wp-content/languages/plugins/" directory

= 2.0.2: April 2, 2018 =

* Tweak: UM2.0 compatibility

= 1.1.2: December 8, 2016 =

* Tweak: Update EDD plugin updater
* Added: MomentJS Library
* Fixed: Timezone issue
* Fixed: Real-time replies
* Fixed: Remove notices

= 1.1.1: October 10, 2016 =

* Tweak: update EDD plugin updater
* Tweak: update English translation files.
* New: UM Friends extension integration
* New: allow conversations template to be customized in theme folder.
* Added: Brazil and French translation .mo and .po files
* Added: action hook `um_messaging_button_in_profile`
* Fixed: timezone UTC support
* Fixed: saving of privacy option
* Fixed: redirect url
* Fixed: message template in shortcode
* Fixed: message box styles
* Fixed: remove notices and fix sql prepare statement
* Fixed: refactor and optimize database query
* Fixed: count messages in SQL query
* Fixed: redirection after login

= 1.1.0: February 2, 2016 =

* Tweak: Update EDD_SL_Plugin_Updater.php
* Fixed: Fix new message notification

= 1.0.9: January 5, 2016 =

* Tweak: UI and CSS improved
* Tweak: exclude blocked users from unread messages
* Tweak: hides conversations from deleted users
* Fixed: db setup error

= 1.0.8: December 17, 2015 =

* Fixed: conflicts with WP-CLI and cron jobs

= 1.0.7: December 8, 2015 =

* Initial release

