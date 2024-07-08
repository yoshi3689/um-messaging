<?php
namespace um_ext\um_messaging\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Messaging_Main_API
 * @package um_ext\um_messaging\core
 */
class Messaging_Main_API {

	var $perms;

	/**
	 * @var array
	 */
	public $emoji = array();

	/**
	 * Messaging_Main_API constructor.
	 */
	function __construct() {
		$this->emoji[':)'] = 'https://s.w.org/images/core/emoji/72x72/1f604.png';
		$this->emoji[':smiley:'] = 'https://s.w.org/images/core/emoji/72x72/1f603.png';
		$this->emoji[':D'] = 'https://s.w.org/images/core/emoji/72x72/1f600.png';
		$this->emoji[':$'] = 'https://s.w.org/images/core/emoji/72x72/1f60a.png';
		$this->emoji[':relaxed:'] = 'https://s.w.org/images/core/emoji/72x72/263a.png';
		$this->emoji[';)'] = 'https://s.w.org/images/core/emoji/72x72/1f609.png';
		$this->emoji[':heart_eyes:'] = 'https://s.w.org/images/core/emoji/72x72/1f60d.png';
		$this->emoji[':kissing_heart:'] = 'https://s.w.org/images/core/emoji/72x72/1f618.png';
		$this->emoji[':kissing_closed_eyes:'] = 'https://s.w.org/images/core/emoji/72x72/1f61a.png';
		$this->emoji[':kissing:'] = 'https://s.w.org/images/core/emoji/72x72/1f617.png';
		$this->emoji[':kissing_smiling_eyes:'] = 'https://s.w.org/images/core/emoji/72x72/1f619.png';
		$this->emoji[';P'] = 'https://s.w.org/images/core/emoji/72x72/1f61c.png';
		$this->emoji[':P'] = 'https://s.w.org/images/core/emoji/72x72/1f61b.png';
		$this->emoji[':stuck_out_tongue_closed_eyes:'] = 'https://s.w.org/images/core/emoji/72x72/1f61d.png';
		$this->emoji[':flushed:'] = 'https://s.w.org/images/core/emoji/72x72/1f633.png';
		$this->emoji[':grin:'] = 'https://s.w.org/images/core/emoji/72x72/1f601.png';
		$this->emoji[':apensive:'] = 'https://s.w.org/images/core/emoji/72x72/1f614.png';
		$this->emoji[':relieved:'] = 'https://s.w.org/images/core/emoji/72x72/1f60c.png';
		$this->emoji[':unamused'] = 'https://s.w.org/images/core/emoji/72x72/1f612.png';
		$this->emoji[':('] = 'https://s.w.org/images/core/emoji/72x72/1f61e.png';
		$this->emoji[':persevere:'] = 'https://s.w.org/images/core/emoji/72x72/1f623.png';
		$this->emoji[":'("] = 'https://s.w.org/images/core/emoji/72x72/1f622.png';
		$this->emoji[':joy:'] = 'https://s.w.org/images/core/emoji/72x72/1f602.png';
		$this->emoji[':sob:'] = 'https://s.w.org/images/core/emoji/72x72/1f62d.png';
		$this->emoji[':sleepy:'] = 'https://s.w.org/images/core/emoji/72x72/1f62a.png';
		$this->emoji[':disappointed_relieved:'] = 'https://s.w.org/images/core/emoji/72x72/1f625.png';
		$this->emoji[':cold_sweat:'] = 'https://s.w.org/images/core/emoji/72x72/1f630.png';
		$this->emoji[':sweat_smile:'] = 'https://s.w.org/images/core/emoji/72x72/1f605.png';
		$this->emoji[':sweat:'] = 'https://s.w.org/images/core/emoji/72x72/1f613.png';
		$this->emoji[':weary:'] = 'https://s.w.org/images/core/emoji/72x72/1f629.png';
		$this->emoji[':tired_face:'] = 'https://s.w.org/images/core/emoji/72x72/1f62b.png';
		$this->emoji[':fearful:'] = 'https://s.w.org/images/core/emoji/72x72/1f628.png';
		$this->emoji[':scream:'] = 'https://s.w.org/images/core/emoji/72x72/1f631.png';
		$this->emoji[':angry:'] = 'https://s.w.org/images/core/emoji/72x72/1f620.png';
		$this->emoji[':rage:'] = 'https://s.w.org/images/core/emoji/72x72/1f621.png';
		$this->emoji[':triumph'] = 'https://s.w.org/images/core/emoji/72x72/1f624.png';
		$this->emoji[':confounded:'] = 'https://s.w.org/images/core/emoji/72x72/1f616.png';
		$this->emoji[':laughing:'] = 'https://s.w.org/images/core/emoji/72x72/1f606.png';
		$this->emoji[':yum:'] = 'https://s.w.org/images/core/emoji/72x72/1f60b.png';
		$this->emoji[':mask:'] = 'https://s.w.org/images/core/emoji/72x72/1f637.png';
		$this->emoji[':cool:'] = 'https://s.w.org/images/core/emoji/72x72/1f60e.png';
		$this->emoji[':sleeping:'] = 'https://s.w.org/images/core/emoji/72x72/1f634.png';
		$this->emoji[':dizzy_face:'] = 'https://s.w.org/images/core/emoji/72x72/1f635.png';
		$this->emoji[':astonished:'] = 'https://s.w.org/images/core/emoji/72x72/1f632.png';
		$this->emoji[':worried:'] = 'https://s.w.org/images/core/emoji/72x72/1f61f.png';
		$this->emoji[':frowning:'] = 'https://s.w.org/images/core/emoji/72x72/1f626.png';
		$this->emoji[':anguished:'] = 'https://s.w.org/images/core/emoji/72x72/1f627.png';
		$this->emoji[':smiling_imp:'] = 'https://s.w.org/images/core/emoji/72x72/1f608.png';
		$this->emoji[':imp:'] = 'https://s.w.org/images/core/emoji/72x72/1f47f.png';
		$this->emoji[':open_mouth:'] = 'https://s.w.org/images/core/emoji/72x72/1f62e.png';
		$this->emoji[':grimacing:'] = 'https://s.w.org/images/core/emoji/72x72/1f62c.png';
		$this->emoji[':neutral_face:'] = 'https://s.w.org/images/core/emoji/72x72/1f610.png';
		$this->emoji[':confused:'] = 'https://s.w.org/images/core/emoji/72x72/1f615.png';
		$this->emoji[':hushed:'] = 'https://s.w.org/images/core/emoji/72x72/1f62f.png';
		$this->emoji[':no_mouth:'] = 'https://s.w.org/images/core/emoji/72x72/1f636.png';
		$this->emoji[':innocent:'] = 'https://s.w.org/images/core/emoji/72x72/1f607.png';
		$this->emoji[':smirk:'] = 'https://s.w.org/images/core/emoji/72x72/1f60f.png';
		$this->emoji[':expressionless:'] = 'https://s.w.org/images/core/emoji/72x72/1f611.png';

		$this->emoji = apply_filters( 'um_messaging_emoji', $this->emoji );
	}

	/**
	 * @param $user_id
	 * @return bool|array
	 */
	public function get_perms( $user_id ) {
		if ( ! method_exists( UM()->roles(), 'role_data' ) ) {
			return false;
		}

		$role = UM()->roles()->get_priority_user_role( $user_id );
		/** This filter is documented in ultimate-member/includes/core/class-roles-capabilities.php */
		return apply_filters( 'um_user_permissions_filter', UM()->roles()->role_data( $role ), $user_id );
	}

	/**
	 * Blocked a user?
	 *
	 * @param $user_id
	 * @param bool $who_blocked
	 *
	 * @return bool
	 */
	function blocked_user( $user_id, $who_blocked = false ) {
		if ( ! $who_blocked ) {
			$who_blocked = get_current_user_id();
		}

		$blocked = get_user_meta( $who_blocked, '_pm_blocked', true );
		if ( is_array( $blocked ) && in_array( $user_id, $blocked ) ) {
			return true;
		}

		return false;
	}


	/**
	 * Is it a hidden conversation?
	 *
	 * @param $conversation_id
	 *
	 * @return bool
	 */
	function hidden_conversation( $conversation_id ) {
		$hidden = (array) get_user_meta( get_current_user_id(), '_hidden_conversations', true );
		if ( in_array( $conversation_id, $hidden ) ) {
			return true;
		}
		return false;
	}


	/**
	 * Hides a conversation
	 *
	 * @param int $user_id
	 * @param int $conversation_id
	 */
	function hide_conversation( $user_id, $conversation_id ) {
		$hidden = (array) get_user_meta( $user_id, '_hidden_conversations', true );
		if ( ! in_array( $conversation_id, $hidden ) ) {
			$hidden[] = $conversation_id;
			update_user_meta( $user_id, '_hidden_conversations', $hidden );
		}
	}


	/**
	 * Can download conversation history?
	 *
	 * @global \wpdb $wpdb
	 * @param int $user_id
	 * @param int $conversation_id
	 * @return boolean
	 */
	public function can_download( $user_id, $conversation_id ) {
		global $wpdb;


		if ( 'all' == $conversation_id ) {
			if ( current_user_can( 'administrator' ) || current_user_can( 'manage_options' ) ) {
				return true;
			} else {
				return false;
			}
		} else {
			$results = $wpdb->get_var( $wpdb->prepare(
				"SELECT COUNT(*)
				FROM {$wpdb->prefix}um_conversations um_c
				WHERE um_c.conversation_id = %d AND
					  ( um_c.user_b = %d OR um_c.user_a = %d )",
				$conversation_id,
				$user_id,
				$user_id
			) );

			return ! empty( $results );
		}
	}


	/**
	 * Can start messages?
	 *
	 * @param $recipient
	 * @return bool
	 */
	function can_message( $recipient ) {
		$can = true;

		if ( UM()->options()->get( 'pm_block_users' ) ) {
			$users = str_replace(' ', '', UM()->options()->get( 'pm_block_users' ) );
			$array = explode( ',', $users );
			if ( in_array( $recipient, $array ) || ( is_user_logged_in() && in_array( get_current_user_id(), $array ) ) ) {
				$can = false;
			}
		}

		$check_recipient = apply_filters( 'um_messaging_check_recipient_caps', true, $recipient );

		if ( $check_recipient ) {
			$role = UM()->roles()->get_priority_user_role( $recipient );
			$role_data = UM()->roles()->role_data( $role );
			/** This filter is documented in ultimate-member/includes/core/class-roles-capabilities.php */
			$role_data = apply_filters( 'um_user_permissions_filter', $role_data, $recipient );
			if ( ! $role_data['enable_messaging'] || ! $role_data['can_read_pm'] ) {
				$can = false;
			}
		}

		if ( is_user_logged_in() ) {
			$role = UM()->roles()->get_priority_user_role( get_current_user_id() );
			$role_data = UM()->roles()->role_data( $role );
			/** This filter is documented in ultimate-member/includes/core/class-roles-capabilities.php */
			$role_data = apply_filters( 'um_user_permissions_filter', $role_data, get_current_user_id() );
			if ( ! $role_data['enable_messaging'] ) {
				$can = false;
			}
		}

		if ( is_user_logged_in() &&
			 ( $this->blocked_user( $recipient ) || $this->blocked_user( get_current_user_id(), $recipient ) ) ) {
			$can = false;
		}

		$who_can_pm = get_user_meta( $recipient, '_pm_who_can', true );
		if ( $who_can_pm == 'nobody' ) {
			$can = false;
		}

		$custom_restrict = apply_filters( 'um_messaging_can_message_restrict', false, $who_can_pm, $recipient );
		if ( $custom_restrict ) {
			$can = false;
		}

		return $can;
	}


	/**
	 * Check if conversation has unread messages
	 *
	 * @param int $conversation_id
	 * @param int $user_id
	 * @return bool
	 */
	function unread_conversation( $conversation_id, $user_id ) {
		global $wpdb;

		$count = wp_cache_get( "um_unread_messages:$conversation_id:$user_id", 'um_messaging' );
		if ( false === $count ) {
			$count = $wpdb->get_var( $wpdb->prepare(
				"SELECT COUNT( message_id )
				FROM {$wpdb->prefix}um_messages
				WHERE conversation_id = %d AND
					  recipient = %d AND
					  status = 0",
				$conversation_id,
				$user_id
			) );
			wp_cache_set( "um_unread_messages:$conversation_id:$user_id", $count, 'um_messaging' );
		}

		return ( $count ) ? true : false;
	}


	/**
	 * Get conversations with unread messages
	 * @global wpdb $wpdb
	 * @param array $args
	 *	int 'reminded',
	 *	string 'reminded_rel',
	 *	int|string 'time_from',
	 *	int|string 'time_to'
	 * @return array
	 */
	function get_unread_conversations( $args = array() ){
		global $wpdb;

		$um_m_where = "`um_m`.`status` = 0";
		if( isset( $args['reminded'] ) && is_numeric( $args['reminded'] ) ){
			$rel = empty( $args['reminded_rel'] ) ? '=' : $args['reminded_rel'];
			$um_m_where .= " AND `um_m`.`reminded` $rel {$args['reminded']}";
		}
		if( !empty($args['time_from']) && !empty($args['time_to']) ){
			$from = is_numeric( $args['time_from'] ) ? date('Y-m-d H:i:s', $args['time_from']) : $args['time_from'];
			$to = is_numeric( $args['time_to'] ) ? date('Y-m-d H:i:s', $args['time_to']) : $args['time_to'];
			$um_m_where .= " AND (`um_m`.`time` BETWEEN '$from' AND '$to')";
		}else
		if( !empty($args['time_from']) ){
			$from = is_numeric( $args['time_from'] ) ? date('Y-m-d H:i:s', $args['time_from']) : $args['time_from'];
			$um_m_where .= " AND `um_m`.`time` > '$from'";
		}else
		if( !empty($args['time_to']) ){
			$to = is_numeric( $args['time_to'] ) ? date('Y-m-d H:i:s', $args['time_to']) : $args['time_to'];
			$um_m_where .= " AND `um_m`.`time` < '$to'";
		}

		$conversations = $wpdb->get_results( "
			SELECT *
			FROM `{$wpdb->prefix}um_messages` AS `um_m`
			WHERE $um_m_where
			GROUP BY `um_m`.`conversation_id`;" );

		return $conversations;
	}


	/**
	 * Get unread messages count
	 *
	 * @param int $user_id
	 * @return int
	 */
	function get_unread_count( $user_id ) {
		global $wpdb;

		$count = wp_cache_get( "um_unread_messages:{$user_id}", 'um_messaging' );
		if ( false === $count ) {

			$blocked = get_user_meta( $user_id, '_pm_blocked', true );
			$blocked = is_array( $blocked ) ? array_filter( $blocked, 'intval' ) : [];

			if ( count( $blocked ) ) {
				$count = $wpdb->get_var( $wpdb->prepare(
					"SELECT COUNT( message_id )
					FROM {$wpdb->prefix}um_messages
					WHERE recipient = %d AND
						  author NOT IN('" . implode( "','", $blocked ) . "') AND
						  status = 0
					LIMIT 11",
					$user_id
				) );
			} else {
				$count = $wpdb->get_var( $wpdb->prepare(
					"SELECT COUNT( message_id )
					FROM {$wpdb->prefix}um_messages
					WHERE recipient = %d AND
						  status = 0
					LIMIT 11",
					$user_id
				) );
			}

			wp_cache_set( "um_unread_messages:{$user_id}", $count, 'um_messaging' );
		}

		return (int) $count;
	}


	/**
	 * Remove a message
	 *
	 * @param $message_id
	 * @param $conversation_id
	 */
	function remove_message( $message_id, $conversation_id ) {
		global $wpdb;

		$user_id = get_current_user_id();

		$recipient_id = $wpdb->get_var( $wpdb->prepare(
			"SELECT recipient
			FROM {$wpdb->prefix}um_messages
			WHERE conversation_id = %d AND
				  message_id = %d AND
				  author = %d",
			$conversation_id,
			$message_id,
			$user_id
		) );

		$wpdb->delete(
			"{$wpdb->prefix}um_messages",
			array(
				'conversation_id'   => $conversation_id,
				'message_id'        => $message_id,
				'author'            => $user_id
			)
		);

		if ( ! empty( $recipient_id ) ) {
			wp_cache_delete( "um_unread_messages:{$conversation_id}:{$user_id}", 'um_messaging' );
			wp_cache_delete( "um_unread_messages:$user_id", 'um_messaging' );
			wp_cache_delete( "um_messages:$user_id", 'um_messaging' );
		}
		wp_cache_delete( "um_new_messages:{$conversation_id}", 'um_messaging' );
		wp_cache_delete( "um_conversation_messages_limit:{$conversation_id}", 'um_messaging' );
		wp_cache_delete( "um_conversation_messages:{$conversation_id}", 'um_messaging' );
		wp_cache_delete( "um_messages:all", 'um_messaging' );
	}


	/**
	 * Get messages count
	 *
	 * @since  2.2.9 [2020-10-16]
	 *
	 * @global \wpdb   $wpdb
	 * @param  array   $filters [
	 *   int 'conversation_id',
	 *   int 'status',
	 *   int 'author',
	 *   int 'recipient',
	 *   int|string 'time_from',
	 *   int|string 'time_to'
	 * ]
	 * @return integer|boolean
	 */
	function count_messages( $filters = [] ) {
		global $wpdb;

		if ( is_array( $filters ) ) {
			$filters = array_merge( array(
				'conversation_id'   => 0,
				'status'            => null,
				'author'            => 0,
				'recipient'         => 0,
				'time_from'         => '',
				'time_to'           => '',
			), $filters );
		} else {
			return false;
		}

		$where = $args = [];

		if ( ! empty( $filters['conversation_id'] ) && is_int( $filters['conversation_id'] ) ) {
			$where[] = 'conversation_id = %d';
			$args[] = $filters['conversation_id'];
		}

		if ( isset( $filters['status'] ) && is_int( $filters['status'] ) ) {
			$where[] = 'status = %d';
			$args[] = $filters['status'];
		}

		if ( ! empty( $filters['author'] ) && is_int( $filters['author'] ) ) {
			$where[] = 'author = %d';
			$args[] = $filters['author'];
		}

		if ( ! empty( $filters['recipient'] ) && is_int( $filters['recipient'] ) ) {
			$where[] = 'recipient = %d';
			$args[] = $filters['recipient'];
		}

		if ( ! empty( $filters['time_from'] ) ) {
			$time_from = is_numeric( $filters['time_from'] ) ? $filters['time_from'] : strtotime( $filters['time_from'] );
			$time = date( 'Y-m-d H:i:s', $time_from );
			$where[] = "time > '%s'";
			$args[] = $time;
		}

		if ( ! empty( $filters['time_to'] ) ) {
			$time_to = is_numeric( $filters['time_to'] ) ? $filters['time_to'] : strtotime( $filters['time_to'] );
			$time = date( 'Y-m-d H:i:s', $time_to );
			$where[] = "time <= '%s'";
			$args[] = $time;
		}

		$query = "SELECT COUNT( message_id ) FROM {$wpdb->prefix}um_messages";
		if ( $where && count( $where ) === count( $args ) ) {
			$query .= ' WHERE ' . implode( ' AND ', $where ) . ';';
		}

		$count = $wpdb->get_var( $wpdb->prepare( $query, $args ) );

		return (int) $count;
	}


	/**
	 * Check whether limit reached for sending msg
	 *
	 * @version  2.2.9 [2020-10-16]
	 *
	 * @return bool
	 */
	function limit_reached() {
		$this->perms = $this->get_perms( get_current_user_id() );

		// if there is no limits
		if ( empty( $this->perms['pm_max_messages'] ) ) {
			return false;
		}

		$user_id = get_current_user_id();
		$last_send = (int) get_user_meta( $user_id, '_um_pm_last_send', true );
		$msgs_sent = (int) get_user_meta( $user_id, '_um_pm_msgs_sent', true );

		// if there is no sent messages
		if ( empty( $last_send ) && empty( $msgs_sent ) ) {
			return false;
		}

		// if last sent message is older than limited period
		if ( $last_send && ! empty( $this->perms['pm_max_messages_tf'] ) && ( $last_send < current_time( 'timestamp' ) - DAY_IN_SECONDS * $this->perms['pm_max_messages_tf'] ) ) {
			return false;
		}

		// if total count of messages is lower than a limit
		if ( $msgs_sent && $msgs_sent < $this->perms['pm_max_messages'] ) {
			return false;
		}

		$count = $this->count_messages( [
			'author'    => $user_id,
			'time_from' => empty( $this->perms['pm_max_messages_tf'] ) ? '' : ( current_time( 'timestamp' ) - DAY_IN_SECONDS * $this->perms['pm_max_messages_tf']),
		] );

		// if count of recent messages is greater than a limit
		if ( $count && $count >= $this->perms['pm_max_messages'] ) {
			return true;
		}

		return false;
	}


	/**
	 * Get conversations
	 *
	 * @param int $user_id
	 * @return array|null|object|string
	 */
	function get_conversations( $user_id ) {
		global $wpdb;
		$unread_first = UM()->options()->get( 'pm_unread_first' );
		$results = wp_cache_get( "um_conversations:{$user_id}", 'um_messaging' );
		$limit = apply_filters( 'um_messaging_get_conversations_limit', 50, $user_id );

		if ( false === $results ) {
			if ( $unread_first == 1 ) {
				$results = $wpdb->get_results( $wpdb->prepare(
					"SELECT um_c.*
					FROM {$wpdb->prefix}um_conversations um_c
					LEFT JOIN {$wpdb->prefix}um_messages um_m ON um_c.conversation_id = um_m.conversation_id AND
						um_m.recipient = %d AND
						um_m.status = 0
					WHERE um_c.user_b = %d OR
						  um_c.user_a = %d
					GROUP BY um_c.conversation_id
					ORDER BY um_m.status DESC,
							 um_c.last_updated DESC
					LIMIT $limit",
					$user_id,
					$user_id,
					$user_id
				) );
			} else {
				$results = $wpdb->get_results( $wpdb->prepare(
					"SELECT *
				FROM {$wpdb->prefix}um_conversations
				WHERE user_a = %d OR
					  user_b = %d
				ORDER BY last_updated DESC
				LIMIT $limit",
					$user_id,
					$user_id
				) );
			}

			wp_cache_set( "um_conversations:{$user_id}", $results, 'um_messaging' );
		}

		if ( $results ) {
			foreach ( $results as $key => $result ) {
				if ( get_userdata( $result->user_b ) === false || get_userdata( $result->user_a ) === false ) {
					unset( $results[ $key ] );
				}
			}
			return $results;
		}

		return '';
	}


	/**
	 * Get a conversation ID
	 *
	 * @param int $user1
	 * @param int $user2
	 * @return null
	 */
	function get_conversation_id( $user1, $user2 ) {
		global $wpdb;

		$response = null;
		$conversation = wp_cache_get( "um_conversation:{$user1}:{$user2}", 'um_messaging' );
		if ( false === $conversation ) {
			$conversation = wp_cache_get( "um_conversation:{$user2}:{$user1}", 'um_messaging' );
		}
		if ( false === $conversation ) {
			$conversation = $wpdb->get_row( $wpdb->prepare(
				"SELECT conversation_id,
					last_updated
				FROM {$wpdb->prefix}um_conversations
				WHERE ( user_a = %d AND user_b = %d ) OR
					  ( user_a = %d AND user_b = %d )
				LIMIT 1",
				$user1,
				$user2,
				$user2,
				$user1
			) );
			wp_cache_set( "um_conversation:{$user1}:{$user2}", $conversation, 'um_messaging', 30 * MINUTE_IN_SECONDS );
		}

		if ( isset( $conversation->conversation_id ) ) {
			$response['conversation_id'] = $conversation->conversation_id;
			$response['last_updated'] = $conversation->last_updated;
		}

		return $response;
	}


	/**
	 * Get a conversation
	 *
	 * @param int $user1
	 * @param int $user2
	 * @param int $conversation_id
	 * @return null|string
	 */
	function get_conversation( $user1, $user2, $conversation_id ) {
		global $wpdb;

		$hidden_conversations = get_user_meta( $user2, '_hidden_conversations', true );
		$hidden_conversations = ! empty( $hidden_conversations ) ? $hidden_conversations : array();

		$limit = apply_filters( 'um_messaging_get_messages_limit', 1000, $conversation_id );
		$limit = absint( $limit );

		$loop_user = um_user( 'ID' );
		um_fetch_user( $user2 );

		ob_start();

		if ( in_array( $conversation_id, $hidden_conversations ) ) {
			?>
			<span class="um-message-notice">
				<?php esc_html_e( 'This conversation is hidden.', 'um-messaging' ); ?>
			</span>
			<?php
		} else {
			if ( ! um_user( 'can_read_pm' ) ) {
				if ( um_user( 'can_start_pm' ) ) {
					// Get conversation ordered by time and show only 1000 messages
					$first_answer_id = $wpdb->get_var( $wpdb->prepare(
						"SELECT message_id
						FROM {$wpdb->prefix}um_messages
						WHERE conversation_id = %d AND
							  author = %d
						ORDER BY time ASC
						LIMIT 1",
						$conversation_id,
						$user1
					) );

					if ( ! empty( $first_answer_id ) ) {
						$messages = $wpdb->get_results( $wpdb->prepare(
							"SELECT *
							FROM {$wpdb->prefix}um_messages
							WHERE conversation_id = %d AND
								  author = %d AND
								  message_id < %d
							ORDER BY time ASC
							LIMIT %d;",
							$conversation_id,
							$user2,
							$first_answer_id,
							$limit
						) );

					} else {
						$messages = $wpdb->get_results( $wpdb->prepare(
							"SELECT *
							FROM {$wpdb->prefix}um_messages
							WHERE conversation_id = %d AND
								  author = %d
							ORDER BY time ASC
							LIMIT %d;",
							$conversation_id,
							$user2,
							$limit
						) );

					}

					foreach ( $messages as $message ) {
						$message = apply_filters( 'um_messaging_get_message', $message );

						UM()->get_template( 'message.php', um_messaging_plugin, array(
							'class'         => 'right_m',
							'status'        => '',
							'message'       => $message,
							'can_remove'    => true,
						), true );
					}
				} ?>
				<span class="um-message-notice">
					<?php _e( 'Your membership level does not allow you to view conversations.', 'um-messaging' ) ?>
				</span>
			<?php } else {
				$messages = wp_cache_get( "um_conversation_messages_limit:$conversation_id", 'um_messaging' );
				if ( false === $messages ) {
					// Get conversation ordered by time and show only 1000 messages
					$messages = $wpdb->get_results( $wpdb->prepare(
						"SELECT *
						FROM {$wpdb->prefix}um_messages
						WHERE conversation_id = %d
						ORDER BY time ASC
						LIMIT %d;",
						$conversation_id,
						$limit
					) );
					wp_cache_set( "um_conversation_messages_limit:$conversation_id", $messages, 'um_messaging' );
				}

				$update_query = false;
				foreach ( $messages as $message ) {
					$message = apply_filters( 'um_messaging_get_message', $message );

					$status = 'read';
					if ( $message->status == 0 && $user2 == get_current_user_id() ) {
						$update_query = true;
						$status = 'unread';
					}

					$class = 'left_m';
					$can_remove = false;
					if ( $message->author == get_current_user_id() ) {
						$class = 'right_m';
						$can_remove = true;
					}

					UM()->get_template( 'message.php', um_messaging_plugin, array(
						'class'         => $class,
						'message'       => $message,
						'status'        => $status,
						'can_remove'    => $can_remove,
					), true );
				}

				if ( $update_query ) {
					$wpdb->query( $wpdb->prepare( "
						UPDATE {$wpdb->prefix}um_messages
						SET status = 1
						WHERE conversation_id = %d
						AND author = %d;",
						$conversation_id,
						$user1
					) );

					//user2 because user1 is author not recipient
					wp_cache_delete( "um_conversation_messages_limit:{$conversation_id}", 'um_messaging' );
					wp_cache_delete( "um_conversation_messages:{$conversation_id}", 'um_messaging' );
					wp_cache_delete( "um_new_messages:{$conversation_id}", 'um_messaging' );
					wp_cache_delete( "um_unread_messages:{$conversation_id}:{$user2}", 'um_messaging' );
					wp_cache_delete( "um_unread_messages:$user2", 'um_messaging' );
					wp_cache_delete( "um_messages:$user2", 'um_messaging' );
					wp_cache_delete( 'um_messages:all', 'um_messaging' );
				}
			}
		}

		um_fetch_user( $loop_user );

		$response = ob_get_clean();
		return $response;
	}


	/**
	 * Chatize a message content
	 *
	 * @param $content
	 *
	 * @return string
	 */
	function chatize( $content ) {
		$content = stripslashes( $content );

		// autolink
		$content = preg_replace('$(\s|^)(https?://[a-z0-9_./?=&#-:]+)(?![^<>]*>)$i', '<a href="$2" target="_blank" rel="nofollow">$2</a> ', $content." ");
		$content = preg_replace('$(\s|^)(www\.[a-z0-9_./?=&#-:]+)(?![^<>]*>)$i', '<a target="_blank" href="http://$2"  target="_blank" rel="nofollow">$2</a> ', $content." ");


		foreach( $this->emoji as $code => $val ) {
			if( strpos( $code, ')' ) !== false ){
				$code = str_replace(')','\)', $code );
			}

			if( strpos( $code, '(' ) !== false ){
				$code = str_replace('(','\(', $code );
			}

			if( strpos( $code, '$' ) !== false ){
				$code = str_replace('$','\$', $code );
			}

			if( strpos($content,':pensive:') !== false ){
				$content = str_replace(':pensive:', ':apensive:', $content );
			}

			$pattern = "~(?i)<a.*?</a>(*SKIP)(*F)|{$code}~";
			$content = preg_replace($pattern, '<img src="'.$val.'" alt="'.$code.'" title="'.$code.'" class="emoji" />', $content);

		}



		return nl2br( $content );
	}


	/**
	 * Nice time difference
	 *
	 * @deprecated 2.3.7
	 *
	 * @param $from
	 * @param string $to
	 *
	 * @return mixed|void
	 */
	public function human_time_diff( $from, $to = '' ) {
		_deprecated_function( __METHOD__, '2.3.7', 'UM()->datetime()_>time_diff()' );
		return UM()->datetime()->time_diff( $from, $to );
	}

	/**
	 * Show time beautifully
	 *
	 * @param $time
	 * @param $pos
	 *
	 * @return string
	 */
	public function beautiful_time( $time, $pos ) {
		$from_time = strtotime( $time );

		$nice_time = UM()->datetime()->time_diff( $from_time );

		// DATE_RFC2822 is required format for the moment.js library.
		$clean_date_time = wp_date( DATE_RFC2822, $from_time, new \DateTimeZone( 'UTC' ) );
		$clean_date_time = apply_filters( 'um_messages_time_clean', $clean_date_time, $from_time );

		$pos = apply_filters( 'um_messages_time_position', $pos );

		$tip_class = 'right_m' === $pos ? 'um-tip-e' : 'um-tip-w';
		return '<span class="um-message-item-time ' . esc_attr( $tip_class ) . '" title="" data-um-messsage-timestamp="' . esc_attr( $from_time ) . '" data-um-message-utc-time="' . esc_attr( $clean_date_time ) . '">' . $nice_time . '</span>';
	}

	/**
	 * Checks if user enabled email notification
	 *
	 * @param $user_id
	 *
	 * @return bool|int
	 */
	function enabled_email( $user_id, $key ) {
		$_enable_new_pm = true;
		if ( get_user_meta( $user_id, $key, true ) == 'yes' ) {
			$_enable_new_pm = 1;
		} elseif ( get_user_meta( $user_id, $key, true ) == 'no' ) {
			$_enable_new_pm = 0;
		}
		return $_enable_new_pm;
	}


	/**
	 * Create a conversation between both parties
	 *
	 * @param int $user1
	 * @param int $user2
	 * @return bool|int|null|string
	 */
	function create_conversation( $user1, $user2 ) {
		global $wpdb;

		// Test for previous conversation
		$conversation_id = $wpdb->get_var( $wpdb->prepare(
			"SELECT conversation_id
			FROM {$wpdb->prefix}um_conversations
			WHERE ( user_a = %d AND user_b = %d ) OR
				  ( user_a = %d AND user_b = %d )
			LIMIT 1",
			$user1,
			$user2,
			$user2,
			$user1
		) );

		um_fetch_user( $user2 );

		// Build new conversation
		if ( ! $conversation_id ) {

			if ( ! um_user( 'can_start_pm' ) ) {
				return false;
			}

			$conversation_data = array(
				'user_a'       => $user1,
				'user_b'       => $user2,
				'last_updated' => current_time( 'mysql', true )
			);

			$data = apply_filters( 'um_messaging_insert_conversation', $conversation_data );

			$wpdb->insert( "{$wpdb->prefix}um_conversations", $data );

			$conversation_id = $wpdb->insert_id;

			do_action('um_after_new_conversation', $user1, $user2, $conversation_id );

		} else {

			$other_message = $wpdb->get_var( $wpdb->prepare(
				"SELECT message_id
				FROM {$wpdb->prefix}um_messages
				WHERE conversation_id = %d AND
					  author = %d
				ORDER BY time ASC
				LIMIT 1",
				$conversation_id,
				$user1
			) );

			if ( ! ( um_user( 'can_reply_pm' ) || ( um_user( 'can_start_pm' ) && empty( $other_message ) ) ) ) {
				return false;
			}

			$wpdb->update(
				"{$wpdb->prefix}um_conversations",
				array(
					'last_updated'  => current_time( 'mysql', true ),
				),
				array(
					'conversation_id'   => $conversation_id,
				)
			);

			do_action('um_after_existing_conversation', $user1, $user2, $conversation_id );
		}

		$message_data = array(
			'conversation_id' => $conversation_id,
			'time'            => current_time( 'mysql', true ),
			'content'         => strip_tags( $_POST['content'] ),
			'status'          => 0,
			'author'          => $user2,
			'recipient'       => $user1,
		);

		$data = apply_filters( 'um_messaging_insert_message', $message_data );

		// Insert message
		$wpdb->insert( "{$wpdb->prefix}um_messages", $data );

		wp_cache_delete( 'um_conversations:all', 'um_messaging' );
		wp_cache_delete( "um_conversations:{$user1}", 'um_messaging' );
		wp_cache_delete( "um_conversations:{$user2}", 'um_messaging' );
		wp_cache_delete( "um_all_conversations:{$user1}", 'um_messaging' );
		wp_cache_delete( "um_all_conversations:{$user2}", 'um_messaging' );
		wp_cache_delete( "um_conversation:{$user1}:{$user2}", 'um_messaging' );
		wp_cache_delete( "um_conversation:{$user2}:{$user1}", 'um_messaging' );
		wp_cache_delete( "um_new_messages:{$conversation_id}", 'um_messaging' );
		wp_cache_delete( "um_conversation_messages_limit:{$conversation_id}", 'um_messaging' );
		wp_cache_delete( "um_conversation_messages:{$conversation_id}", 'um_messaging' );
		wp_cache_delete( "um_unread_messages:{$conversation_id}:{$user1}", 'um_messaging' );
		wp_cache_delete( "um_unread_messages:{$conversation_id}:{$user2}", 'um_messaging' );
		wp_cache_delete( 'um_messages:all', 'um_messaging' );
		wp_cache_delete( "um_unread_messages:$user1", 'um_messaging' );
		wp_cache_delete( "um_unread_messages:$user2", 'um_messaging' );
		wp_cache_delete( "um_messages:$user1", 'um_messaging' );
		wp_cache_delete( "um_messages:$user2", 'um_messaging' );

		$this->update_user( $user2 );

		$hidden = (array) get_user_meta( $user1, '_hidden_conversations', true );
		if ( in_array( $conversation_id, $hidden ) ) {
			$hidden = array_diff( $hidden, array( $conversation_id ) );
			update_user_meta( $user1, '_hidden_conversations', $hidden );
		}

		$hidden = (array) get_user_meta( $user2, '_hidden_conversations', true );
		if ( in_array( $conversation_id, $hidden ) ) {
			$hidden = array_diff( $hidden, array( $conversation_id ) );
			update_user_meta( $user2, '_hidden_conversations', $hidden );
		}

		do_action('um_after_new_message', $user1, $user2, $conversation_id, $message_data );

		return $conversation_id;
	}


	/**
	 * Update user
	 *
	 * @param $user_id
	 */
	function update_user( $user_id ) {
		update_user_meta( $user_id, '_um_pm_last_send', current_time( 'timestamp' ) );
		$msgs_sent = get_user_meta( $user_id, '_um_pm_msgs_sent', true );
		update_user_meta( $user_id, '_um_pm_msgs_sent', (int) $msgs_sent + 1 );
	}


	/**
	 * Hex to RGB
	 *
	 * @param $hex
	 *
	 * @return string
	 */
	function hex_to_rgb( $hex ) {
		list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
		return "$r, $g, $b";
	}


	/**
	 * @param $url
	 *
	 * @return bool|string
	 */
	public function set_redirect_to( $url ) {
		return ! empty( $_SESSION['um_social_login_redirect'] ) ? $_SESSION['um_social_login_redirect'] : ' ';
	}


	/**
	 * @param int $conversation_id
	 *
	 * @return array
	 */
	function get_conversation_messages( $conversation_id ) {
		global $wpdb;

		$messages = wp_cache_get( "um_conversation_messages:{$conversation_id}", 'um_messaging' );

		if ( false === $messages ) {

			$messages = $wpdb->get_results( $wpdb->prepare(
				"SELECT *
				FROM {$wpdb->prefix}um_messages
				WHERE conversation_id = %d
				ORDER BY time ASC",
				$conversation_id
			), ARRAY_A );

			wp_cache_set( "um_conversation_messages:{$conversation_id}", $messages, 'um_messaging' );
		}

		return $messages;
	}


	/**
	 * Unblock a user via AJAX
	 */
	function ajax_messaging_unblock_user() {
		UM()->check_ajax_nonce();

		if ( ! isset( $_POST['user_id'] ) || ! is_numeric( sanitize_key( $_POST['user_id'] ) ) || ! is_user_logged_in() ) {
			wp_send_json_error();
		}

		$blocked = (array) get_user_meta( get_current_user_id(), '_pm_blocked', true );
		if ( ! in_array( sanitize_key( $_POST['user_id'] ), $blocked ) ) {
			wp_send_json_error();
		}

		$blocked = array_diff( $blocked, array( sanitize_key( $_POST['user_id'] ) ) );
		update_user_meta( get_current_user_id(), '_pm_blocked', $blocked );

		wp_send_json_success();
	}


	/**
	 * block a user via AJAX
	 */
	function ajax_messaging_block_user() {
		UM()->check_ajax_nonce();

		if ( ! isset( $_POST['other_user'] ) || ! is_numeric( $_POST['other_user'] ) || ! is_user_logged_in() ) {
			wp_send_json_error();
		}

		$blocked = (array)get_user_meta( get_current_user_id(), '_pm_blocked', true );
		$blocked[] = $_POST['other_user'];
		update_user_meta( get_current_user_id(), '_pm_blocked', $blocked );

		wp_send_json_success();
	}


	/**
	 * Delete a conversation via AJAX
	 */
	function ajax_messaging_delete_conversation() {
		global $wpdb;

		UM()->check_ajax_nonce();

		if ( ! isset( $_POST['conversation_id'] ) || ! is_numeric( sanitize_key( $_POST['conversation_id'] ) ) || ! is_user_logged_in() ) {
			wp_send_json_error();
		}
		if ( ! isset( $_POST['other_user'] ) || ! is_numeric( $_POST['other_user'] ) || ! is_user_logged_in() ) {
			wp_send_json_error();
		}

		$current_user = get_current_user_id();
		$other_user = sanitize_text_field( $_POST['other_user'] );

		$conversation = wp_cache_get( "um_conversation:$current_user:$other_user", 'um_messaging' );
		if ( false === $conversation ) {
			$conversation = wp_cache_get( "um_conversation:$other_user:$current_user", 'um_messaging' );
		}
		if ( false === $conversation ) {
			$conversation = $wpdb->get_row( $wpdb->prepare(
				"SELECT conversation_id,
						last_updated
					FROM {$wpdb->prefix}um_conversations
					WHERE ( user_a = %d AND user_b = %d ) OR
						  ( user_a = %d AND user_b = %d )
					LIMIT 1",
				$current_user,
				$other_user,
				$other_user,
				$current_user
			) );
			wp_cache_set( "um_conversation:$current_user:$other_user", $conversation, 'um_messaging', 30 * MINUTE_IN_SECONDS );
		}

		if ( empty( $conversation->conversation_id ) ) {
			wp_send_json_error();
		}

		$other_user_hidden_conversations = get_user_meta( $other_user, '_hidden_conversations', true );

		if ( is_array( $other_user_hidden_conversations ) && in_array( $conversation->conversation_id, $other_user_hidden_conversations ) ) {
			$wpdb->query( $wpdb->prepare(
				"DELETE
				FROM {$wpdb->prefix}um_conversations
				WHERE conversation_id = %d",
				$conversation->conversation_id
			) );
			$wpdb->query( $wpdb->prepare(
				"DELETE
				FROM {$wpdb->prefix}um_messages
				WHERE conversation_id = %d",
				$conversation->conversation_id
			) );

			if ( false !== ( $searched = array_search( $conversation->conversation_id, $other_user_hidden_conversations ) ) ) {
				unset( $other_user_hidden_conversations[ $searched ] );
				update_user_meta( $other_user, '_hidden_conversations', $other_user_hidden_conversations );
			}
		} else {
			$this->hide_conversation( get_current_user_id(), $conversation->conversation_id );
		}

		wp_send_json_success();
	}


	/**
	 * Remove a message via AJAX
	 */
	function ajax_messaging_remove() {
		UM()->check_ajax_nonce();

		if ( ! isset( $_POST['message_id'] ) || !is_numeric( sanitize_key( $_POST['message_id'] ) ) || !is_user_logged_in() ) {
			wp_send_json_error();
		}
		if ( ! isset( $_POST['conversation_id'] ) || !is_numeric( sanitize_key( $_POST['conversation_id'] ) ) || !is_user_logged_in() ) {
			wp_send_json_error();
		}

		$this->remove_message( sanitize_key( $_POST['message_id'] ), sanitize_key( $_POST['conversation_id'] ) );

		wp_send_json_success();
	}


	/**
	 * Send a message via AJAX
	 */
	function ajax_messaging_send() {
		UM()->check_ajax_nonce();

		if ( ! isset( $_POST['message_to'] ) || ! is_numeric( sanitize_key( $_POST['message_to'] ) ) || ! is_user_logged_in() ) {
			wp_send_json_error();
		}
		if ( ! isset( $_POST['content'] ) || trim( $_POST['content'] ) == '' ) {
			wp_send_json_error();
		}

		if ( ! UM()->Messaging_API()->api()->can_message( sanitize_key( $_POST['message_to'] ) ) ) {
			wp_send_json_error();
		}

		// Create/Update conversation and add message
		$conversation_id = $this->create_conversation( sanitize_key( $_POST['message_to'] ), get_current_user_id() );
		if ( empty( $conversation_id ) ) {
			wp_send_json_error();
		}

		$response = $this->get_conversation_id( sanitize_key( $_POST['message_to'] ), get_current_user_id() );
		$output['conversation_id'] = $response['conversation_id'];
		$output['last_updated'] = $response['last_updated'];
		$output['messages'] = $this->get_conversation( sanitize_key( $_POST['message_to'] ), get_current_user_id(), $conversation_id );
		$output['limit_hit'] = $this->limit_reached() ? 1 : 0;
		$output['chat_history_download'] = UM()->Messaging_API()->gdpr()->get_download_url( $response['conversation_id'] );

		wp_send_json_success( $output );
	}


	/**
	 * Login Modal
	 */
	function ajax_messaging_login_modal() {
		UM()->check_ajax_nonce();

		if ( is_user_logged_in() ) {
			wp_send_json_error();
		}

		$message_to = absint( sanitize_key( $_POST['message_to'] ) );
		um_fetch_user( $message_to );

		$url = um_user_profile_url();

		$_SESSION['um_messaging_message_to'] = $message_to;
		$_SESSION['um_social_login_redirect'] = $url;

		ob_start(); ?>

		<div class="um-message-header um-popup-header">
			<div class="um-message-header-left">
				<?php printf( __( '%s Please login to message <strong>%s</strong>', 'um-messaging' ), get_avatar( $message_to, 40 ), um_user( 'display_name' ) ); ?>
			</div>
			<div class="um-message-header-right">
				<a href="javascript:void(0);" class="um-message-hide"><i class="um-icon-android-close"></i></a>
			</div>
		</div>

		<?php $output = ob_get_clean();
		wp_send_json_success( array( 'content' => $output, 'redirect_url' => $url ) );
	}


	/**
	 * Coming from send message button
	 */
	function ajax_messaging_start() {
		UM()->check_ajax_nonce();

		if ( ! isset( $_POST['message_to'] ) || ! is_numeric( sanitize_key( $_POST['message_to'] ) ) || ! is_user_logged_in() ) {
			wp_send_json_error();
		}

		ob_start(); ?>

		<div class="um-message-modal">
			<?php UM()->get_template( 'conversation.php', um_messaging_plugin, array(
				'message_to' => sanitize_key( $_POST['message_to'] ),
				'user_id' => get_current_user_id(),
			), true ); ?>
		</div>

		<?php $output = ob_get_clean();
		wp_send_json_success( $output );
	}


	/**
	 * Auto refresh of chat messages
	 */
	function ajax_messaging_update() {
		global $wpdb;

		UM()->check_ajax_nonce();

		$output['errors'] = array();
		if ( ! isset( $_POST['message_to'] ) || ! is_numeric( sanitize_key( $_POST['message_to'] ) ) || ! is_user_logged_in() ) {
			wp_send_json_error( esc_js( __( 'Invalid target user_ID or user is not logged in', 'um-messaging' ) ) );
		}

		if ( empty( $_POST['user_id'] ) || absint( $_POST['user_id'] ) != get_current_user_id() ) {
			wp_send_json_error( esc_js( __( 'Invalid sender user_ID or user is not logged in', 'um-messaging' ) ) );
		}

		um_fetch_user( get_current_user_id() );
		if ( ! um_user( 'can_read_pm' ) ) {

			$output['response'] = 'nothing_new';

		} else {
			$conversation_id = absint( sanitize_key( $_POST['conversation_id'] ) );
			$last_updated_result = $wpdb->get_var( $wpdb->prepare(
				"SELECT last_updated
				FROM {$wpdb->prefix}um_conversations
				WHERE conversation_id = %d AND
					  ( ( user_a = %d AND user_b = %d ) OR
					  ( user_a = %d AND user_b = %d ) )
				LIMIT 1",
				$conversation_id,
				get_current_user_id(),
				absint( $_POST['message_to'] ),
				absint( $_POST['message_to'] ),
				get_current_user_id()
			) );

			if ( ! $last_updated_result ) {
				wp_send_json_error( esc_js( __( 'UM Messaging - No result found', 'um-messaging' ) ) );
			}

			$last_updated = sanitize_text_field( $_POST['last_updated'] );

			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				$output['debug']['last_updated_from_query'] = $last_updated_result;
				$output['debug']['last_updated_from_post'] = $last_updated;
				$output['debug']['last_updated'] = ( strtotime( $last_updated_result ) > strtotime( $last_updated ) ) ? true : false;
			}

			if ( strtotime( $last_updated_result ) > strtotime( $last_updated ) ) {
				// get new messages
				$messages_query = $wpdb->prepare(
					"SELECT *
					FROM {$wpdb->prefix}um_messages as tn2
					WHERE tn2.conversation_id = %d AND
						  tn2.time > %s
					ORDER BY tn2.time ASC",
					$conversation_id,
					$last_updated
				);

				$messages = wp_cache_get( "um_new_messages:{$conversation_id}", 'um_messaging' );
				if ( false === $messages ) {
					$messages = $wpdb->get_results( $messages_query );
					wp_cache_set( "um_new_messages:{$conversation_id}", $messages, 'um_messaging' );
				}

				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					$output['debug']['messages_query']          = $messages_query;
					$output['debug']['messages_query_results']  = $messages;
					$output['debug']['messages_query_num_rows'] = $wpdb->num_rows;
				}

				$response = '';
				foreach ( $messages as $message ) {
					$message = apply_filters( 'um_messaging_get_message', $message );

					$status = 'read';
					if ( 0 === (int) $message->status ) {
						$status = 'unread';
					}

					$class      = 'left_m';
					$can_remove = false;
					if ( get_current_user_id() === (int) $message->author ) {
						$class      = 'right_m';
						$can_remove = true;
					}

					$response .= UM()->get_template(
						'message.php',
						um_messaging_plugin,
						array(
							'class'      => $class,
							'status'     => $status,
							'message'    => $message,
							'can_remove' => $can_remove,
						),
						false
					);

					$output['message_id']   = $message->message_id;
					$output['last_updated'] = $message->time;
				}
				/**
				 * Fires after updating conversation.
				 *
				 * @since 2.3.3
				 * @hook um_ajax_messaging_after_update
				 *
				 * @param {int} $user_id current User ID.
				 * @param {int} $conversation_id Conversation ID.
				 */
				do_action( 'um_ajax_messaging_after_update', get_current_user_id(), $conversation_id );

				$output['response'] = $response;
			} else {

				$output['response'] = 'nothing_new';

			}
		}

		wp_send_json_success( $output );
	}


	/**
	 * AJAX Pagination
	 */
	function ajax_conversations_load() {
		UM()->check_ajax_nonce();

		global $wpdb;
		$user_id = sanitize_key( $_POST['user_id'] );
		$offset = sanitize_key( $_POST['offset'] );
		$url = sanitize_text_field( $_POST['url'] );
		$unread_first = UM()->options()->get( 'pm_unread_first' );

		if ( $unread_first == 1 ) {
			$conversations = $wpdb->get_results( $wpdb->prepare(
				"SELECT um_c.*
				FROM {$wpdb->prefix}um_conversations um_c
				LEFT JOIN {$wpdb->prefix}um_messages um_m ON um_c.conversation_id = um_m.conversation_id AND
					um_m.recipient = %d AND
					um_m.status = 0
				WHERE um_c.user_b = %d OR
					  um_c.user_a = %d
				GROUP BY um_c.conversation_id
				ORDER BY um_m.status DESC,
						 um_c.last_updated DESC
				LIMIT 20 OFFSET $offset",
				$user_id,
				$user_id,
				$user_id
			) );
		} else {
			$conversations = $wpdb->get_results( $wpdb->prepare(
				"SELECT *
				FROM {$wpdb->prefix}um_conversations
				WHERE user_a = %d OR
					  user_b = %d
				ORDER BY last_updated DESC
				LIMIT 20 OFFSET $offset",
				$user_id,
				$user_id
			) );
		}

		$results = array();
		$profile_can_read = um_user( 'can_read_pm' );

		if ( ! empty( $conversations ) ) {
			foreach ( $conversations as $conversation ) {
				$array = array();

				if ( $conversation->user_a == um_profile_id() ) {
					$user = $conversation->user_b;
				} else {
					$user = $conversation->user_a;
				}
				um_fetch_user( $user );

				$user_name = ( um_user( 'display_name' ) ) ? um_user( 'display_name' ) : __( 'Deleted User', 'um-messaging' );

				$is_unread = UM()->Messaging_API()->api()->unread_conversation( $conversation->conversation_id, um_profile_id() );

				$array['url'] = add_query_arg( array( 'profiletab' => 'messages', 'conversation_id' => $conversation->conversation_id ), $url );
				$array['user'] = $user;
				$array['user_name'] = $user_name;
				$array['avatar'] = get_avatar( $user, 40 );
				$array['conversation_id'] = $conversation->conversation_id;
				$array['new_conv'] = ( $is_unread && $profile_can_read );

				$array = apply_filters( 'um_messaging_conversation_json_data', $array, $conversation );

				array_push( $results, $array );
			}
		}

		wp_send_json_success( $results );
	}
}
