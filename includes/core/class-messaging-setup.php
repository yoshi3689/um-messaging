<?php
namespace um_ext\um_messaging\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Messaging_Setup
 * @package um_ext\um_messaging\core
 */
class Messaging_Setup {


	/**
	 * @var array
	 */
	public $settings_defaults;


	/**
	 * Messaging_Setup constructor.
	 */
	public function __construct() {
		//settings defaults
		$this->settings_defaults = array(
			'show_pm_button'               => 1,
			'hide_pm_button_for_guests'    => 0,
			'profile_tab_messages'         => 1,
			'pm_unread_first'              => 0,
			'pm_hide_history'              => 0,
			'pm_char_limit'                => 200,
			'pm_block_users'               => '',
			'pm_active_color'              => '#0085ba',
			'pm_coversation_refresh_timer' => 5,
			'pm_notify_period'             => 86400,
			'pm_remind_period'             => 3,
			'pm_remind_limit'              => 1,
			'pm_encryption'                => 0,
			'new_message_on'               => 1,
			'new_message_sub'              => '{sender} has messaged you on {site_name}!',
			'new_message'                  => 'Hi {recipient},<br /><br />' .
											'{sender} has just sent you a new private message on {site_name}.<br /><br />' .
											'To view your new message(s) click the following link:<br />' .
											'{message_history}<br /><br />' .
											'This is an automated notification from {site_name}. You do not need to reply.',
			'new_message_reminder_on'      => 0,
			'new_message_reminder_sub'     => 'You have unread message from {sender} on {site_name}!',
			'new_message_reminder'         => 'Hi {recipient},<br /><br />' .
											'{sender} has sent you a private message on {site_name}.<br /><br />' .
											'To view your new message(s) click the following link:<br />' .
											'{message_history}<br /><br />' .
											'This is an automated notification from {site_name}. ' .
											'You do not need to reply.',
		);

		$notification_types_templates = array(
			'new_pm' => __( '<strong>{member}</strong> has just sent you a private message.', 'um-messaging' ),
		);

		foreach ( $notification_types_templates as $k => $template ) {
			$this->settings_defaults[ 'log_' . $k ]               = 1;
			$this->settings_defaults[ 'log_' . $k . '_template' ] = $template;
		}
	}

	/**
	 * SQL DB alter
	 * @global \wpdb $wpdb
	 * @test UM()->classes['Messaging_API']->setup()->sql_alter()
	 * @return array
	 */
	public function sql_alter() {
		global $wpdb;

		$columns = $wpdb->get_col(
			"SELECT `COLUMN_NAME`
			FROM `INFORMATION_SCHEMA`.`COLUMNS`
			WHERE `TABLE_NAME`='{$wpdb->prefix}um_messages'
			AND `TABLE_SCHEMA`='{$wpdb->dbname}' "
		);

		if ( ! in_array( 'reminded', $columns ) ) {
			$wpdb->query(
				"ALTER TABLE `{$wpdb->prefix}um_messages`
				ADD COLUMN `reminded` TINYINT(2) DEFAULT 0 NOT NULL;"
			);
		}

		return $columns;
	}

	/**
	 * SQL DB setup
	 * @global \wpdb $wpdb
	 */
	public function sql_setup() {
		global $wpdb;

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( get_option( 'ultimatemember_messaging_db2' ) === um_messaging_version ) {
			return;
		}

		$charset_collate = $wpdb->get_charset_collate();

		/*
		 * Pay an attention if the customer has active strict mode in the database
		 * the table cannot be created. The reason for this not supporting strict mode by WordPress by default.
		 * see ticket https://core.trac.wordpress.org/ticket/8857#comment:19
		 *
		 * For strict mode the datetime value can be in the range from 1000-01-01 00:00:00 to 9999-12-31 23:59:59
		 * ref.: https://www.mysqltutorial.org/mysql-datetime/
		 *
		 * We support wp.org logic because it's plugin for WordPress. So please temporarily disable strict-mode or create DB table
		 * manually via hosting CPanel
		 */
		$sql = "CREATE TABLE {$wpdb->prefix}um_conversations (
conversation_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
user_a bigint(20) UNSIGNED DEFAULT 0 NOT NULL,
user_b bigint(20) UNSIGNED DEFAULT 0 NOT NULL,
last_updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
PRIMARY KEY  (conversation_id),
KEY user_a_user_b (user_a,user_b),
KEY user_a (user_a),
KEY user_b (user_b)
) $charset_collate\n;
CREATE TABLE {$wpdb->prefix}um_messages (
message_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
conversation_id bigint(20) UNSIGNED DEFAULT 0 NOT NULL,
time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
content longtext DEFAULT '' NOT NULL,
status int(11) DEFAULT 0 NOT NULL,
reminded TINYINT(2) DEFAULT 0 NOT NULL,
author bigint(20) UNSIGNED DEFAULT 0 NOT NULL,
recipient bigint(20) UNSIGNED DEFAULT 0 NOT NULL,
PRIMARY KEY  (message_id),
KEY recipient_author_status (recipient,author,status),
KEY conversation_id_author (conversation_id,author),
KEY recipient_author (recipient,author),
KEY recipient_status (recipient,status),
KEY conversation_id (conversation_id),
KEY recipient (recipient),
KEY status (status),
KEY author (author)
) $charset_collate\n;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		update_option( 'ultimatemember_messaging_db2', um_messaging_version );
	}


	/**
	 *
	 */
	public function set_default_settings() {
		$options = get_option( 'um_options', array() );

		foreach ( $this->settings_defaults as $key => $value ) {
			//set new options to default
			if ( ! isset( $options[ $key ] ) ) {
				$options[ $key ] = $value;
			}
		}

		update_option( 'um_options', $options );
	}


	/**
	 *
	 */
	public function run_setup() {
		$this->single_site_activation();
		if ( is_multisite() ) {
			if ( is_plugin_active_for_network( um_messaging_plugin ) ) {
				update_network_option( get_current_network_id(), 'um_messaging_maybe_network_wide_activation', 1 );
			}
		}
	}


	/**
	 * Maybe need multisite activation process
	 *
	 */
	public function maybe_network_activation() {
		$maybe_activation = get_network_option( get_current_network_id(), 'um_messaging_maybe_network_wide_activation' );

		if ( $maybe_activation ) {

			delete_network_option( get_current_network_id(), 'um_messaging_maybe_network_wide_activation' );

			if ( is_plugin_active_for_network( um_messaging_plugin ) ) {
				// get all blogs
				$blogs = get_sites();
				if ( ! empty( $blogs ) ) {
					foreach ( $blogs as $blog ) {
						switch_to_blog( $blog->blog_id );
						//make activation script for each sites blog
						$this->single_site_activation();
						restore_current_blog();
					}
				}
			}
		}
	}


	/**
	 * Single site plugin activation handler
	 */
	public function single_site_activation() {
		$this->sql_setup();
		$this->set_default_settings();
	}
}
