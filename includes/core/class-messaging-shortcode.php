<?php
namespace um_ext\um_messaging\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Messaging_Shortcode
 * @package um_ext\um_messaging\core
 */
class Messaging_Shortcode {

	/**
	 * Messaging_Shortcode constructor.
	 */
	public function __construct() {
		add_shortcode( 'ultimatemember_messages', array( &$this, 'ultimatemember_messages' ) );
		add_shortcode( 'ultimatemember_message_button', array( &$this, 'ultimatemember_message_button' ) );
		add_shortcode( 'ultimatemember_message_count', array( &$this, 'ultimatemember_message_count' ) );
	}

	/**
	 * Conversations list shortcode.
	 *
	 * @return string
	 */
	public function ultimatemember_messages() {
		wp_enqueue_script( 'um-messaging' );
		wp_enqueue_style( 'um-messaging' );

		$user_id = get_current_user_id();
		if ( empty( $user_id ) ) {
			return '';
		}

		$conversations = UM()->Messaging_API()->api()->get_conversations( $user_id );

		if ( ! empty( $conversations ) ) {
			$show_conversations = array();

			foreach ( $conversations as $conversation ) {

				if ( $user_id === (int) $conversation->user_a ) {
					$user = $conversation->user_b;
				} else {
					$user = $conversation->user_a;
				}

				if ( UM()->Messaging_API()->api()->blocked_user( $user ) ) {
					continue;
				}

				if ( UM()->Messaging_API()->api()->hidden_conversation( $conversation->conversation_id ) ) {
					continue;
				}

				$show_conversations[] = $conversation;
			}

			$conversations = $show_conversations;
		} else {
			$conversations = array();
		}

		$t_args = array(
			'user_id'       => $user_id,
			'conversations' => $conversations,
		);

		if ( isset( $_GET['conversation_id'] ) ) {
			$c_id = absint( $_GET['conversation_id'] );
			if ( $c_id ) {
				foreach ( $conversations as $conversation ) {
					if ( (int) $conversation->conversation_id === $c_id ) {
						$t_args['current_conversation'] = $c_id;
						break;
					}
				}
			}
		}

		return UM()->get_template( 'conversations.php', um_messaging_plugin, $t_args );
	}

	/**
	 * Start conversation button shortcode.
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public function ultimatemember_message_button( $args = array() ) {
		global $post;

		$hide_button = UM()->options()->get( 'hide_pm_button_for_guests' );
		if ( ! empty( $hide_button ) && ! is_user_logged_in() ) {
			return '';
		}

		$defaults = array(
			'user_id' => isset( $post ) && is_a( $post, 'WP_Post' ) ? $post->post_author : 0,
			'title'   => __( 'Message', 'um-messaging' ),
		);
		$args     = shortcode_atts( $defaults, $args, 'ultimatemember_message_button' );

		if ( empty( $args['user_id'] ) || ! UM()->Messaging_API()->api()->can_message( $args['user_id'] ) ) {
			return '';
		}

		wp_enqueue_script( 'um-messaging' );
		wp_enqueue_style( 'um-messaging' );

		UM()->Messaging_API()->enqueue()->need_hidden_login = true;

		return UM()->get_template( 'button.php', um_messaging_plugin, $args );
	}

	/**
	 * Unread messages' shortcode.
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public function ultimatemember_message_count( $args = array() ) {
		if ( ! is_user_logged_in() ) {
			return '';
		}

		wp_enqueue_script( 'um-messaging' );
		wp_enqueue_style( 'um-messaging' );

		$defaults = array(
			'user_id' => get_current_user_id(),
		);
		$args     = shortcode_atts( $defaults, $args, 'ultimatemember_message_count' );

		$count = UM()->Messaging_API()->api()->get_unread_count( $args['user_id'] );
		return ( $count > 10 ) ? 10 . '+' : $count;
	}
}
