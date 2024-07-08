<?php
namespace um_ext\um_messaging\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Messaging_Account
 * @package um_ext\um_messaging\core
 */
class Messaging_Account {

	/**
	 * Messaging_Account constructor.
	 */
	public function __construct() {
		add_action( 'um_post_account_update', array( &$this, 'account_update' ) );

		add_filter( 'um_account_page_default_tabs_hook', array( &$this, 'account_notification_tab' ) );
		add_filter( 'um_account_content_hook_notifications', array( &$this, 'account_tab' ), 60, 2 );

		add_filter( 'um_account_notifications_tab_enabled', '__return_true' );
	}

	/**
	 * Update Account action
	 */
	public function account_update() {
		// phpcs:ignore WordPress.Security.NonceVerification -- already verified here
		$current_tab = isset( $_POST['_um_account_tab'] ) ? sanitize_key( $_POST['_um_account_tab'] ) : null;
		if ( 'notifications' !== $current_tab ) {
			return;
		}

		$user_id = um_user( 'ID' );

		// phpcs:ignore WordPress.Security.NonceVerification -- already verified here
		if ( isset( $_POST['_enable_new_pm'] ) ) {
			update_user_meta( $user_id, '_enable_new_pm', 'yes' );
		} else {
			update_user_meta( $user_id, '_enable_new_pm', 'no' );
		}

		// phpcs:ignore WordPress.Security.NonceVerification -- already verified here
		if ( isset( $_POST['_enable_reminder_pm'] ) ) {
			update_user_meta( $user_id, '_enable_reminder_pm', 'yes' );
		} else {
			update_user_meta( $user_id, '_enable_reminder_pm', 'no' );
		}
	}

	/**
	 * Add Notifications tab to account page
	 *
	 * @param array $tabs
	 * @return array
	 */
	public function account_notification_tab( $tabs ) {
		if ( defined( 'UM_DEV_MODE' ) && UM_DEV_MODE && UM()->options()->get( 'enable_new_ui' ) ) {
			return $tabs;
		}

		if ( empty( $tabs[400]['notifications'] ) ) {
			$tabs[400]['notifications'] = array(
				'icon'         => 'um-faicon-envelope',
				'title'        => __( 'Notifications', 'um-messaging' ),
				'submit_title' => __( 'Update Notifications', 'um-messaging' ),
			);
		}

		return $tabs;
	}

	/**
	 * Show a notification option in email tab
	 *
	 *
	 * @param string $output
	 * @param array $shortcode_args
	 * @return string
	 */
	public function account_tab( $output, $shortcode_args ) {
		if ( ! ( UM()->options()->get( 'new_message_on' ) || UM()->options()->get( 'new_message_reminder_on' ) ) ) {
			return $output;
		}

		if ( isset( $shortcode_args['_enable_new_pm'] ) && 0 == $shortcode_args['_enable_new_pm'] &&
		     isset( $shortcode_args['_enable_reminder_pm'] ) && 0 == $shortcode_args['_enable_reminder_pm'] ) {
			return $output;
		}

		$show_new_pm = false;
		if ( ! isset( $shortcode_args['_enable_new_pm'] ) || $shortcode_args['_enable_new_pm'] ) {
			if ( UM()->options()->get( 'new_message_on' ) ) {
				UM()->account()->add_displayed_field( '_enable_new_pm', 'notifications' );
				$show_new_pm = true;
			}
		}

		$show_reminder_pm = false;
		if ( ! isset( $shortcode_args['_enable_reminder_pm'] ) || $shortcode_args['_enable_reminder_pm'] ) {
			if ( UM()->options()->get( 'new_message_reminder_on' ) ) {
				UM()->account()->add_displayed_field( '_enable_reminder_pm', 'notifications' );
				$show_reminder_pm = true;
			}
		}

		$_enable_new_pm      = UM()->Messaging_API()->api()->enabled_email( get_current_user_id(), '_enable_new_pm' );
		$_enable_reminder_pm = UM()->Messaging_API()->api()->enabled_email( get_current_user_id(), '_enable_reminder_pm' );

		$t_args = compact( '_enable_new_pm', '_enable_reminder_pm', 'show_new_pm', 'show_reminder_pm' );

		$output .= UM()->get_template( 'account_notifications.php', um_messaging_plugin, $t_args );

		return $output;
	}
}
