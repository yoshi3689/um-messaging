<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Send notification for future messages
 *
 * @param $to
 * @param $from
 * @param $conversation_id
 */
function um_messaging_user_got_message( $to, $from, $conversation_id ) {
	if ( ! UM()->Messaging_API()->api()->enabled_email( $to, '_enable_reminder_pm' ) ) {
		return;
	}

	$get_ts = um_user_last_login_timestamp( $to );
	if ( $get_ts > 0 ) {
		if ( ( time() - $get_ts ) <= UM()->options()->get( 'pm_notify_period' ) ) {
			return;
		}
	}

	// send a mail notification
	um_fetch_user( $to );
	$recipient_e = um_user('user_email');
	$recipient = um_user('display_name');
	$message_history = add_query_arg('profiletab', 'messages', um_user_profile_url() );

	// who sends the message
	um_fetch_user( $from );
	$sender = um_user('display_name');

	UM()->mail()->send( $recipient_e, 'new_message', array(
		'plain_text' => 1,
		'path' => um_messaging_path . 'templates/email/',
		'tags' => array(
			'{recipient}',
			'{message_history}',
			'{sender}'
		),
		'tags_replace' => array(
			$recipient,
			$message_history,
			$sender
		)
	) );
}
add_action( 'um_after_existing_conversation', 'um_messaging_user_got_message', 20, 3 );


/**
 * Send a mail notification
 *
 * @param $to
 * @param $from
 * @param $conversation_id
 * @param $template
 */
function um_messaging_mail_notification( $to, $from, $conversation_id, $template = 'new_message' ) {
	if ( ! UM()->Messaging_API()->api()->enabled_email( $to, '_enable_new_pm' ) ) {
		return;
	}

	// send a mail notification
	um_fetch_user( $to );
	$recipient_e = um_user('user_email');
	$recipient = um_user('display_name');
	$message_history = add_query_arg('profiletab', 'messages', um_user_profile_url() );

	// who sends the message
	um_fetch_user( $from );
	$sender = um_user('display_name');

	UM()->mail()->send( $recipient_e, $template, array(
		'plain_text' => 1,
		'path' => um_messaging_path . 'templates/email/',
		'tags' => array(
			'{recipient}',
			'{message_history}',
			'{sender}'
		),
		'tags_replace' => array(
			$recipient,
			$message_history,
			$sender
		)
	) );
}
add_action( 'um_after_new_conversation', 'um_messaging_mail_notification', 20, 3 );


/**
 * Send messages by Cron
 *
 * @return array|null
 */
function um_messaging_cron_messages() {
	global $wpdb;

	// Send email notifications If user didn\'t read message for [n] hours
	if ( UM()->options()->get( 'new_message_reminder_on' ) && is_numeric( UM()->options()->get( 'pm_remind_limit' ) ) ) {
		$m = UM()->options()->get( 'pm_remind_limit' );
		$n = UM()->options()->get( 'pm_remind_period' );
		$to = current_time( 'timestamp', true ) - $n * HOUR_IN_SECONDS;
		//$to = strtotime( "- $n hour" );

		$conversations = UM()->Messaging_API()->api()->get_unread_conversations( array(
			'reminded'      => $m,
			'reminded_rel'  => '<',
			'time_to'       => $to,
		) );

		foreach ( $conversations as $conversation ) {
			um_messaging_mail_notification( $conversation->recipient, $conversation->author, $conversation->conversation_id, 'new_message_reminder' );

			$wpdb->query( $wpdb->prepare(
				"UPDATE {$wpdb->prefix}um_messages
				SET reminded = reminded + 1
				WHERE conversation_id = %d AND
				      message_id = %d",
				$conversation->conversation_id,
				$conversation->message_id
			) );
		}

		return $conversations;
	}

	return null;
}
add_action( 'um_hourly_scheduled_events', 'um_messaging_cron_messages' );
