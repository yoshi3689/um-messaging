<?php
/**
 * Template for the UM Private Messages.
 * Used on the "Account" page, "Notifications" tab
 *
 * Caller: method Messaging_Account->account_tab()
 * @version 2.3.5
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/um-messaging/account_notifications.php
 * @var bool $show_new_pm
 * @var bool $show_reminder_pm
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="um-field" data-key="">
	<div class="um-field-label"><strong><?php _e( 'Messages', 'um-messaging' ); ?></strong></div>

	<?php if ( $show_new_pm ) { ?>
		<div class="um-field-area">
			<label class="um-field-checkbox<?php if ( ! empty( $_enable_new_pm ) ) { ?> active<?php } ?>">
				<input type="checkbox" name="_enable_new_pm" value="1" <?php checked( ! empty( $_enable_new_pm ) ) ?> />
				<span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-<?php if ( ! empty( $_enable_new_pm ) ) { ?>outline<?php } else { ?>outline-blank<?php } ?>"></i></span>
				<span class="um-field-checkbox-option"><?php _e( 'Someone sends me a private message', 'um-messaging' ); ?></span>
			</label>

			<div class="um-clear"></div>
		</div>
	<?php }

	if ( $show_reminder_pm ) { ?>
		<div class="um-field-area">
			<label class="um-field-checkbox<?php if ( ! empty( $_enable_reminder_pm ) ) { ?> active<?php } ?>">
				<input type="checkbox" name="_enable_reminder_pm" value="1" <?php checked( ! empty( $_enable_reminder_pm ) ) ?> />
				<span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-<?php if ( ! empty( $_enable_reminder_pm ) ) { ?>outline<?php } else { ?>outline-blank<?php } ?>"></i></span>
				<span class="um-field-checkbox-option"><?php _e( 'I have an unread message', 'um-messaging' ); ?></span>
			</label>

			<div class="um-clear"></div>
		</div>
	<?php } ?>
</div>
