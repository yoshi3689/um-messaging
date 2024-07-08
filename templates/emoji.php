<?php
/**
 * Template for the UM Private Messages.
 * Used on the "Profile" page, "Messages" tab. Display emoji popup menu in the message textarea.
 *
 * Parent template: conversation.php
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/um-messaging/emoji.php
 *
 * @see     https://docs.ultimatemember.com/article/1516-templates-map
 * @package um_ext\um_messaging\templates
 * @version 2.1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="um-message-emoji">
	<a href="javascript:void(0);" class="um-message-emo um-tip-s" title="<?php esc_attr_e( 'Add emoji', 'um-messaging' ); ?>">
		<i class="um-faicon-smile-o"></i>
	</a>
	<span class="um-message-emolist">

		<?php foreach ( UM()->Messaging_API()->api()->emoji as $emoji_code => $emoji_url ) { ?>

			<span class="um-message-insert-emo" data-emo="<?php echo esc_attr( $emoji_code ); ?>" title="<?php echo esc_attr( $emoji_code ); ?>">
				<img class="emoji" src="<?php echo esc_url( $emoji_url ); ?>" title="<?php echo esc_attr( $emoji_code ); ?>" alt="<?php echo esc_attr( $emoji_code ); ?>" />
			</span>

		<?php } ?>

	</span>
</div>
