<?php
/**
 * Template for the UM Private Messages.
 * Used on the "Account" page, "Privacy" tab
 *
 * Caller: function um_messaging_privacy_setting()
 * @version 2.3.5
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/um-messaging/account_privacy.php
 * @var array $blocked
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>


<div class="um-field" data-key="">

	<div class="um-field-label">
		<label for=""><?php _e( 'Blocked Users', 'um-messaging' ); ?></label>
		<div class="um-clear"></div>
	</div>

	<div class="um-field-area">

		<?php foreach ( $blocked as $blocked_user ) {
			if ( ! $blocked_user ) {
				continue;
			}

			um_fetch_user( $blocked_user ); ?>

			<div class="um-message-blocked">
				<?php echo get_avatar( $blocked_user, 40 ); ?>
				<div><?php echo esc_html( um_user( 'display_name' ) ); ?></div>
				<a href="javascript:void(0);" class="um-message-unblock" data-user_id="<?php echo esc_attr( $blocked_user ); ?>">
					<?php _e( 'Unblock', 'um-messaging' ); ?>
				</a>
			</div>

		<?php }

		um_reset_user(); ?>

		<div class="um-clear"></div>
	</div>
</div>
