<?php
namespace um_ext\um_messaging\core;


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class Messaging_Member_Directory
 *
 * @package um_ext\um_messaging\core
 */
class Messaging_Member_Directory {


	/**
	 * Messaging_Member_Directory constructor.
	 */
	function __construct() {
		add_filter( 'um_admin_extend_directory_options_profile', array( &$this, 'member_directory_options' ), 10, 1 );
		add_action( 'um_pre_directory_shortcode', array( &$this, 'um_messaging_directory_enqueue_scripts' ), 10, 1 );

		// for grid
		add_action( 'um_members_just_after_name_tmpl', array( &$this, 'messaging_button' ), 103, 1 );
		//for list
		add_action( 'um_members_list_just_after_actions_tmpl', array( &$this, 'messaging_button' ), 103, 1 );

		add_filter( 'um_ajax_get_members_data', array( &$this, 'um_messaging_ajax_get_members_data' ), 50, 2 );

		add_action( 'um_members_directory_footer', array( &$this, 'um_members_directory_login_form_footer' ), 99, 3 );
		add_action( 'wp_footer', array( &$this, 'um_messaging_open_modal' ) );
	}


	/**
	 * Admin options in directory
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function member_directory_options( $fields ) {

		$fields = array_merge( array_slice( $fields, 0, 3 ), array(
			array(
				'id'    => '_um_hide_pm_button',
				'type'  => 'checkbox',
				'label' => __( 'Hide message button in directory?', 'um-messaging' ),
				'value' => UM()->query()->get_meta_value( '_um_hide_pm_button', null, 1 ),
			),
		), array_slice( $fields, 3, count( $fields ) - 1 ) );

		return $fields;
	}


	/**
	 * Enqueue scripts on member directory
	 *
	 * @param $args
	 */
	function um_messaging_directory_enqueue_scripts( $args ) {
		if ( empty( $args['hide_pm_button'] ) ) {
			$global_show_pm_button = UM()->options()->get( 'show_pm_button' );
			if ( empty( $global_show_pm_button ) ) {
				return;
			}

			wp_enqueue_script( 'um-messaging' );
			wp_enqueue_style( 'um-messaging' );
		}
	}



	/**
	 * Add a message button to directory
	 *
	 * @param $args
	 */
	function messaging_button( $args ) {
		$global_hide_pm_button = ! empty( $args['hide_pm_button'] ) ? $args['hide_pm_button'] : ! UM()->options()->get( 'show_pm_button' );

		if ( empty( $global_hide_pm_button ) ) { ?>

			<# if ( user.my_messages != '' ) { #>
				<div class="um-members-messaging-btn um-members-list-footer-button-wrapper">
					<a href="{{{user.my_messages}}}" class="um-message-abtn um-button">
						<span><?php _e( 'My messages', 'um-messaging' ) ?></span>
					</a>
				</div>
			<# } else if ( user.message_button != '' ) { #>
				{{{user.message_button}}}
			<# } #>

		<?php }
	}


	/**
	 * @param $data_array
	 * @param $user_id
	 *
	 * @return mixed
	 */
	function um_messaging_ajax_get_members_data( $data_array, $user_id ) {
		$data_array['my_messages'] = '';
		$data_array['messages_button'] = '';

		if ( is_user_logged_in() ) {
			if ( $user_id == get_current_user_id() ) {
				if ( ! UM()->Messaging_API()->api()->can_message( $user_id ) ) {
					return $data_array;
				}

				um_fetch_user( $user_id );
				$data_array['my_messages'] = add_query_arg( 'profiletab', 'messages', um_user_profile_url() );
			} else {
				$data_array['message_button'] = apply_shortcodes( '[ultimatemember_message_button user_id="' . $user_id . '"]' );
			}

		} else {
			$data_array['message_button'] = apply_shortcodes( '[ultimatemember_message_button user_id="' . $user_id . '"]' );
		}

		return $data_array;
	}


	/**
	 * Insert Login form to hidden block
	 *
	 * @param array $args
	 * @param int $form_id
	 * @param $not_searched
	 */
	function um_members_directory_login_form_footer( $args, $form_id, $not_searched ) {
		if ( is_user_logged_in() ) {
			return;
		}
		if ( ! empty( $args['hide_pm_button'] ) ) {
			return;
		}
		if ( empty( UM()->options()->get( 'show_pm_button' ) ) ) {
			return;
		}

		UM()->Messaging_API()->enqueue()->need_hidden_login = true;
	}


	/**
	 * Open modal if $_SESSION is not empty
	 */
	function um_messaging_open_modal() {

		if ( ! is_user_logged_in() ) {
			return;
		}

		if ( ! isset( $_SESSION['um_messaging_message_to'] ) ) {
			return;
		} ?>

		<script type="text/javascript">
			jQuery('document').ready( function(){
				<?php $message_to = $_SESSION['um_messaging_message_to']; ?>
				setTimeout( function(){
					if ( jQuery('.um-message-btn[data-message_to="<?php echo esc_js( $message_to ); ?>"]').length ) {
						jQuery('.um-message-btn[data-message_to="<?php echo esc_js( $message_to ); ?>"]')[0].click();
					}
				},1000) ;

			});
		</script>

		<?php unset( $_SESSION['um_messaging_message_to'] );
	}

}
