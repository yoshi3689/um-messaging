<?php if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Unread messages count in menu
 *
 * @param $tags
 *
 * @return array
 */
function um_messaging_allowed_user_tags( $tags ) {
	$tags[] = '{new_messages}';
	return $tags;
}
add_filter( 'um_allowed_user_tags_patterns', 'um_messaging_allowed_user_tags', 10, 1 );