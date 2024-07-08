<?php
namespace um_ext\um_messaging\admin\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Messaging_Admin
 * @package um_ext\um_messaging\admin\core
 */
class Messaging_Admin {

	/**
	 * Messaging_Admin constructor.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		add_filter( 'um_admin_role_metaboxes', array( &$this, 'role_metabox' ) );
		add_filter( 'um_settings_structure', array( &$this, 'extend_settings' ) );
	}

	/**
	 * Admin Scripts.
	 */
	public function enqueue_scripts( $hook ) {
		$suffix = UM()->admin()->enqueue()::get_suffix();
		if ( 'ultimate-member_page_um_options' === $hook ) {
			wp_enqueue_script( 'um_messaging_admin', um_messaging_url . 'assets/js/admin/um-messaging' . $suffix . '.js', array( 'um_admin_forms' ), um_messaging_version, true );
			wp_enqueue_script( 'um_messaging_admin' );
		}
	}

	/**
	 * Creates options in Role page
	 *
	 * @param array $roles_metaboxes
	 *
	 * @return array
	 */
	public function role_metabox( $roles_metaboxes ) {
		$roles_metaboxes[] = array(
			'id'       => 'um-admin-form-messaging{' . um_messaging_path . '}',
			'title'    => __( 'Private Messages', 'um-messaging' ),
			'callback' => array( UM()->metabox(), 'load_metabox_role' ),
			'screen'   => 'um_role_meta',
			'context'  => 'normal',
			'priority' => 'default',
		);

		return $roles_metaboxes;
	}

	/**
	 * Extend UM settings
	 *
	 * @param $settings
	 *
	 * @return mixed
	 */
	public function extend_settings( $settings ) {
		$settings['licenses']['fields'][] = array(
			'id'        => 'um_messaging_license_key',
			'label'     => __( 'Private Messaging License Key', 'um-messaging' ),
			'item_name' => 'Private Messages',
			'author'    => 'Ultimate Member',
			'version'   => um_messaging_version,
		);

		$settings_fields = array(
			array(
				'id'    => 'show_pm_button',
				'type'  => 'checkbox',
				'label' => __( 'Show messages button in member directory', 'um-messaging' ),
			),
			array(
				'id'    => 'hide_pm_button_for_guests',
				'type'  => 'checkbox',
				'label' => __( 'Hide messages button for not logged-in users', 'um-messaging' ),
			),
			array(
				'id'    => 'pm_unread_first',
				'type'  => 'checkbox',
				'label' => __( 'Show unread messages first', 'um-messaging' ),
			),
			array(
				'id'    => 'pm_hide_history',
				'type'  => 'checkbox',
				'label' => __( 'Hide a "Download Chats History" link', 'um-messaging' ),
			),
			array(
				'id'       => 'pm_char_limit',
				'type'     => 'text',
				'label'    => __( 'Message character limit', 'um-messaging' ),
				'validate' => 'numeric',
				'size'     => 'small',
			),
			array(
				'id'      => 'pm_block_users',
				'type'    => 'text',
				'label'   => __( 'Block users from sending/receiving messages', 'um-messaging' ),
				'tooltip' => __( 'A comma seperated list of user IDs that cannot send/receive messages on the site.', 'um-messaging' ),
				'size'    => 'medium',
			),
			array(
				'id'          => 'pm_active_color',
				'type'        => 'color',
				'label'       => __( 'Primary color', 'um-messaging' ),
				'validate'    => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'pm_coversation_refresh_timer',
				'type'     => 'text',
				'label'    => __( 'How often do you want the AJAX refresh conversation (in seconds)', 'um-messaging' ),
				'validate' => 'numeric',
				'size'     => 'small',
			),
			array(
				'id'          => 'pm_notify_period',
				'type'        => 'select',
				'label'       => __( 'Send email notifications If user did not login for', 'um-messaging' ),
				'tooltip'     => __( 'Send email notifications about new messages if the user\'s last login time exceeds that period.', 'um-messaging' ),
				'options'     => array(
					3600    => __( '1 Hour', 'um-messaging' ),
					86400   => __( '1 Day', 'um-messaging' ),
					604800  => __( '1 Week', 'um-messaging' ),
					2592000 => __( '1 Month', 'um-messaging' ),
				),
				'placeholder' => __( 'Select...', 'um-messaging' ),
				'size'        => 'small',
			),
			array(
				'id'          => 'pm_remind_period',
				'type'        => 'text',
				'label'       => __( 'Send email notifications If user didn\'t read message for [n] hours', 'um-messaging' ),
				'tooltip'     => __( 'Send email notifications about unread message if the user didn\'t read it during that period.', 'um-messaging' ),
				'placeholder' => __( '[n] hours', 'um-messaging' ),
				'validate'    => 'numeric',
				'size'        => 'small',
			),
			array(
				'id'          => 'pm_remind_limit',
				'type'        => 'text',
				'label'       => __( 'Send email notifications not more then [m] times.', 'um-messaging' ),
				'tooltip'     => __( 'Email notifications about unread message will be send every [n] hours but no more then [m] times.', 'um-messaging' ),
				'placeholder' => __( '[m] times', 'um-messaging' ),
				'validate'    => 'numeric',
				'size'        => 'small',
				'max'         => 9,
			),
		);
		$settings_fields = apply_filters( 'um_messaging_settings_fields', $settings_fields );

		$settings['extensions']['sections']['messaging'] = array(
			'title'  => __( 'Private Messaging', 'um-messaging' ),
			'fields' => $settings_fields,
		);

		return $settings;
	}
}
