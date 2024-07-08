<?php
/**
 * Template for the UM Private Messages.
 * Used on the "Profile" page, "Messages" tab, single message
 *
 * Caller: method Messaging_Main_API->get_conversation()
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/um-messaging/message.php
 *
 * @see     https://docs.ultimatemember.com/article/1516-templates-map
 * @package um_ext\um_messaging\templates
 * @version 2.3.5
 *
 * @var string $class
 * @var string $status
 * @var bool   $can_remove
 * @var object $message
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="um-message-item <?php echo esc_attr( $class . ' ' . $status ); ?>" data-message_id="<?php echo esc_attr( $message->message_id ); ?>" data-conversation_id="<?php echo esc_attr( $message->conversation_id ); ?>">
	<div class="um-message-item-data">
		<div class="um-message-item-content"><?php echo wp_kses_post( UM()->Messaging_API()->api()->chatize( $message->content ) ); ?></div>
		<div class="um-message-item-metadata"><?php echo wp_kses_post( UM()->Messaging_API()->api()->beautiful_time( $message->time, $class ) ); ?></div>
	</div>
	<div class="um-message-item-actions">
		<?php if ( $can_remove ) { ?>
			<a href="javascript:void(0);" class="um-message-item-remove um-message-item-show-on-hover um-tip-s" title="<?php esc_attr_e( 'Remove', 'um-messaging' ); ?>"></a>
		<?php } ?>
	</div>
</div>
