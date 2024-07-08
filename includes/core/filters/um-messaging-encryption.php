<?php
/**
 * Messaging encryption feature.
 *
 * @package um_ext\um_messaging\core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! defined( 'SODIUM_LIBRARY_VERSION' ) || '1.0.8' < SODIUM_LIBRARY_VERSION ) {
	return;
}


/**
 * Decodes data encoded with Sodium and converted to hex.
 *
 * @param  string $string The encoded data.
 * @return boolean|string The decoded data or false on failure.
 */
function um_messaging_decode( $string ) {
	if ( 64 > strlen( $string ) ) {
		return false;
	}
	try {
		$decoded = hex2bin( $string );
		if ( false === $decoded ) {
			return false;
		}
	} catch ( Exception $e ) {
		return false;
	}
	$ciphertext = mb_substr( $decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit' );
	$nonce      = mb_substr( $decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit' );
	$key        = defined( 'UM_MESSAGING_KEY' ) && 32 === strlen( UM_MESSAGING_KEY ) ? UM_MESSAGING_KEY : md5( NONCE_KEY );
	return sodium_crypto_secretbox_open( $ciphertext, $nonce, $key );
}


/**
 * Encodes data with Sodium and converts to hex.
 *
 * @param  string $string The data to encode.
 * @return boolean|string The encoded data, as a string. Or false on failure.
 */
function um_messaging_encode( $string ) {
	if ( 64 < strlen( $string ) && false !== @hex2bin( $string ) ) {
		return false;
	}
	$plaintext  = wp_strip_all_tags( $string );
	$nonce      = random_bytes( SODIUM_CRYPTO_SECRETBOX_NONCEBYTES );
	$key        = defined( 'UM_MESSAGING_KEY' ) && 32 === strlen( UM_MESSAGING_KEY ) ? UM_MESSAGING_KEY : md5( NONCE_KEY );
	$ciphertext = sodium_crypto_secretbox( $plaintext, $nonce, $key );
	return bin2hex( $nonce . $ciphertext );
}

/**
 * Process messages encode or decode AJAX request.
 * Administrator must run this process when the "Enable encryption" setting is changed.
 *
 * @global wpdb   $wpdb
 * @param  string $cb_func
 */
function um_same_page_upgrade_encrypt_messages( $cb_func ) {
	UM()->admin()->check_ajax_nonce();
	global $wpdb;
	$per_page = 1000;

	// Statr update process. Count messages.
	if ( 'um_encrypt_messages_start' === $cb_func ) {
		update_option( 'um_pm_encryption_update_start_time', time() );

		$count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}um_messages" );

		$data = array(
			'count'    => $count,
			'per_page' => $per_page,
		);

		wp_send_json_success( $data );
	}

	// Itarate a step of the messages update process.
	if ( 'um_encrypt_messages_update' === $cb_func ) {
		// phpcs:disable WordPress.Security.NonceVerification
		if ( ! array_key_exists( 'page', $_POST ) ) {
			wp_send_json_error( __( 'Invalid input: ', 'um-messaging' ) . 'page' );
		}
		if ( ! array_key_exists( 'pages', $_POST ) ) {
			wp_send_json_error( __( 'Invalid input: ', 'um-messaging' ) . 'pages' );
		}
		if ( ! array_key_exists( 'checked', $_POST ) ) {
			wp_send_json_error( __( 'Invalid input: ', 'um-messaging' ) . 'checked' );
		}

		$page    = absint( wp_unslash( $_POST['page'] ) );
		$pages   = absint( wp_unslash( $_POST['pages'] ) );
		$checked = absint( wp_unslash( $_POST['checked'] ) );
		$offset  = ( $page - 1 ) * $per_page;
		$current = $offset;
		$updated = 0;
		$failed  = 0;
		// phpcs:enable WordPress.Security.NonceVerification

		$messages = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT message_id, content
				FROM {$wpdb->prefix}um_messages
				LIMIT %d OFFSET %d",
				$per_page,
				$offset
			)
		);

		foreach ( $messages as $message ) {
			$current++;

			$content = $checked ? um_messaging_encode( $message->content ) : um_messaging_decode( $message->content );
			if ( false === $content ) {
				$failed++;
				continue;
			}

			$res = $wpdb->update(
				$wpdb->prefix . 'um_messages',
				array(
					'content' => $content,
				),
				array(
					'message_id' => $message->message_id,
				)
			);

			if ( $res && is_numeric( $res ) ) {
				$updated += $res;
			} else {
				$failed++;
			}
		}

		if ( $per_page > count( $messages ) || $page === $pages ) {
			update_option( 'um_pm_encryption_update_finish_time', time() );
			delete_option( 'um_pm_encryption_update_start_time' );
			UM()->options()->update( 'pm_encryption', $checked );
		}

		$data = array(
			// translators: %1$s is the offset, %2$s is the current number of messages.
			'message' => sprintf( __( 'Messages from %1$s to %2$s was updated...', 'um-messaging' ), $offset + 1, $current ),
			'updated' => $updated,
			'failed'  => $failed,
		);

		wp_send_json_success( $data );
	}
}
add_action( 'um_same_page_update_ajax_action', 'um_same_page_upgrade_encrypt_messages', 10, 1 );


/**
 * Extend UM settings.
 *
 * @param  array $settings_fields Settings.
 * @return array                  Settings.
 */
function um_messaging_settings_fields_encryption( $settings_fields ) {

	$same_page_update = array(
		'id'          => 'pm_encryption',
		'type'        => 'same_page_update',
		'label'       => __( 'Enable encryption', 'um-messaging' ),
		'description' => __( 'Encrypts messages in the database. You may define a constant UM_MESSAGING_KEY to override the default key. The key length must be 256-bit (32 bytes).', 'um-messaging' ),
	);

	$update_start_time  = get_option( 'um_pm_encryption_update_start_time', false );
	$update_finish_time = get_option( 'um_pm_encryption_update_finish_time', false );

	if ( empty( $update_start_time ) || $update_start_time > $update_finish_time ) {
		$same_page_update['upgrade_cb']          = 'encrypt_messages';
		$same_page_update['upgrade_description'] = '<p>'
			. __( '<strong>Warning:</strong> Do not exit the page until the update process is complete.', 'um-messaging' ) . __( 'We recommend creating a backup of your site before running the update process.', 'um-messaging' )
			. '</p>'
			. '<p>'
			. __( 'After clicking the <strong>"Run"</strong> button, the update process will start. All information will be displayed in the field below.', 'um-messaging' ) . ' ' . __( 'If the update is successful, you will see a corresponding message. Otherwise, contact technical support if the update failed.', 'um-messaging' )
			. '</p>';
	}

	$settings_fields[] = $same_page_update;
	return $settings_fields;
}
add_filter( 'um_messaging_settings_fields', 'um_messaging_settings_fields_encryption', 10, 1 );


/**
 * Encode the message content before passing it to the database.
 *
 * @param  array $message_data Message data.
 * @return array               Message data.
 */
function um_messaging_insert_message_encode( $message_data ) {
	if ( UM()->options()->get( 'pm_encryption' ) && function_exists( 'sodium_crypto_secretbox' ) ) {
		$message_data['content'] = um_messaging_encode( $message_data['content'] );
	}
	return $message_data;
}
add_filter( 'um_messaging_insert_message', 'um_messaging_insert_message_encode', 10, 1 );


/**
 * Maybe decode the message content before passing it to the template.
 *
 * @param  object $message Message data.
 * @return object          Message data.
 */
function um_messaging_get_message_decode( $message ) {
	if ( UM()->options()->get( 'pm_encryption' ) && function_exists( 'sodium_crypto_secretbox_open' ) ) {
		$plaintext = um_messaging_decode( $message->content );
		if ( false !== $plaintext ) {
			$message->content = $plaintext;
		}
	}
	return $message;
}
add_filter( 'um_messaging_get_message', 'um_messaging_get_message_decode', 10, 1 );
