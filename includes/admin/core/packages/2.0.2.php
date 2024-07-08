<?php if ( ! defined( 'ABSPATH' ) ) exit;

global $wpdb;

$user_ids = get_users( array(
	'fields' => 'ids'
) );

$wpdb->query(
	"DELETE
	FROM {$wpdb->prefix}um_conversations
	WHERE user_a NOT IN( '" . implode( "','", $user_ids ) . "' ) OR
		  user_b NOT IN( '" . implode( "','", $user_ids ) . "' )"
);

$wpdb->query(
	"DELETE
	FROM {$wpdb->prefix}um_messages
	WHERE recipient NOT IN( '" . implode( "','", $user_ids ) . "' ) OR
		  author NOT IN( '" . implode( "','", $user_ids ) . "' )"
);

wp_cache_flush();