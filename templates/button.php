<?php
/**
 * Template for the UM Private Messages.
 * Used to display 'Message' button.
 *
 * Shortcode: [ultimatemember_message_button]
 * Caller: method Messaging_Shortcode->ultimatemember_message_button()
 * @version 2.3.5
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/um-messaging/button.php
 * @var int    $user_id
 * @var string $title
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$current_url = UM()->permalinks()->get_current_url();
if ( um_get_core_page( 'user' ) ) {
	do_action( 'um_messaging_button_in_profile', $current_url, $user_id );
}


if ( ! is_user_logged_in() ) {
	$redirect = um_get_core_page( 'login' );

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		if ( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
			$redirect = add_query_arg( 'redirect_to', urlencode( $_SERVER['HTTP_REFERER'] ), $redirect );
		}
	} else {
		$redirect = add_query_arg( 'redirect_to', $current_url, $redirect );
	} ?>

	<div class="um-members-messaging-btn um-members-list-footer-button-wrapper">
		<a href="<?php echo esc_url( $redirect ) ?>" class="um-login-to-msg-btn um-message-btn um-button" data-message_to="<?php echo esc_attr( $user_id ) ?>" title="<?php echo esc_attr( $title ) ?>">
			<?php echo esc_html( $title ) ?>
		</a>
	</div>

<?php } elseif ( $user_id != get_current_user_id() ) { ?>

	<div class="um-members-messaging-btn um-members-list-footer-button-wrapper">
		<a href="javascript:void(0);" class="um-message-btn um-button" data-message_to="<?php echo esc_attr( $user_id ) ?>" title="<?php echo esc_attr( $title ) ?>">
			<span><?php echo esc_html( $title ) ?></span>
		</a>
	</div>

<?php }
