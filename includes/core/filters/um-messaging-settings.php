<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_filter( 'um_email_notifications', 'um_messaging_email_notifications', 10, 1 );
function um_messaging_email_notifications( $email_notifications ) {
	$email_notifications['new_message']          = array(
		'key'            => 'new_message',
		'title'          => __( 'New Message Notification', 'um-messaging' ),
		'subject'        => '{sender} has messaged you on {site_name}!',
		'body'           => 'Hi {recipient},<br /><br />' .
			'{sender} has just sent you a new private message on {site_name}.<br /><br />' .
			'To view your new message(s) click the following link:<br />' .
			'{message_history}<br /><br />' .
			'This is an automated notification from {site_name}. You do not need to reply.',
		'description'    => __( 'Send a notification to user when he receives a new private message', 'um-messaging' ),
		'recipient'      => 'user',
		'default_active' => true,
	);
	$email_notifications['new_message_reminder'] = array(
		'key'            => 'new_message_reminder',
		'title'          => __( 'New Message Reminder', 'um-messaging' ),
		'subject'        => 'You have unread message from {sender} on {site_name}!',
		'body'           => 'Hi {recipient},<br /><br />' .
			'{sender} has sent you a private message on {site_name}.<br /><br />' .
			'To view your new message(s) click the following link:<br />' .
			'{message_history}<br /><br />' .
			'This is an automated notification from {site_name}. You do not need to reply.',
		'description'    => __( 'Send a notification to user when he has unread private message', 'um-messaging' ),
		'recipient'      => 'user',
		'default_active' => false,
	);

	return $email_notifications;
}


/**
 * Adds a notification type
 *
 * @param array $logs
 *
 * @return array
 */
function um_messaging_add_notification_type( $logs ) {
	$logs['new_pm'] = array(
		'title'        => __( 'User get a new private message', 'um-messaging' ),
		'account_desc' => __( 'When someone sends a private message to me', 'um-messaging' ),
	);

	return $logs;
}
add_filter( 'um_notifications_core_log_types', 'um_messaging_add_notification_type', 100 );


/**
 * Scan templates from extension
 *
 * @param $scan_files
 *
 * @return array
 */
function um_messaging_extend_scan_files( $scan_files ) {
	$extension_files['um-messaging'] = UM()->admin_settings()->scan_template_files( um_messaging_path . '/templates/' );
	$scan_files                      = array_merge( $scan_files, $extension_files );

	return $scan_files;
}
add_filter( 'um_override_templates_scan_files', 'um_messaging_extend_scan_files', 10, 1 );


/**
 * Get template paths
 *
 * @param $located
 * @param $file
 *
 * @return array
 */
function um_messaging_get_path_template( $located, $file ) {
	if ( file_exists( get_stylesheet_directory() . '/ultimate-member/um-messaging/' . $file ) ) {
		$located = array(
			'theme' => get_stylesheet_directory() . '/ultimate-member/um-messaging/' . $file,
			'core'  => um_messaging_path . 'templates/' . $file,
		);
	}

	return $located;
}
add_filter( 'um_override_templates_get_template_path__um-messaging', 'um_messaging_get_path_template', 10, 2 );
