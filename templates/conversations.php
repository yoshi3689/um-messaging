<?php
/**
 * Template for the UM Private Messages.
 * Used on the "Profile" page, "Messages" tab.
 *
 * Shortcode: [ultimatemember_messages]
 * Caller: method Messaging_Shortcode->ultimatemember_messages()
 * @version 2.3.5
 *
 * This template can be overridden by copying it to yourtheme/ultimate-member/um-messaging/conversations.php
 * @var int $user_id
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<script type="text/template" id="tmpl-um_messages_convesations">
	<# _.each( data.conversations, function( conversation, key ) { #>
		<a href="{{{conversation.url}}}" class="um-message-conv-item" data-message_to="{{{conversation.user}}}" data-trigger_modal="conversation" data-conversation_id="{{{conversation.conversation_id}}}">

			<span class="um-message-conv-name">{{{conversation.user_name}}}</span>

			<span class="um-message-conv-pic">{{{conversation.avatar}}}</span>

			<# if ( conversation.new_conv ) { #>
				<span class="um-message-conv-new"><i class="um-faicon-circle"></i></span>
			<# } #>

			<?php do_action( 'um_messaging_conversation_list_name_js' ); ?>
		</a>
	<# }); #>
</script>

<?php if ( ! empty( $conversations ) ) { ?>

	<div class="um um-viewing">
		<div class="um-message-conv" data-user="<?php echo esc_attr( $user_id ); ?>">

			<?php $i = 0;
			$profile_can_read = um_user( 'can_read_pm' );
			foreach ( $conversations as $conversation ) {

				if ( (int) $conversation->user_a === $user_id ) {
					$user = $conversation->user_b;
				} else {
					$user = $conversation->user_a;
				}

				$i++;

				um_fetch_user( $user );

				$user_name = ( um_user( 'display_name' ) ) ? um_user( 'display_name' ) : __( 'Deleted User', 'um-messaging' );

				$is_unread = UM()->Messaging_API()->api()->unread_conversation( $conversation->conversation_id, $user_id ); ?>

				<a href="<?php echo esc_url( add_query_arg( 'conversation_id', $conversation->conversation_id ) ); ?>" class="um-message-conv-item" data-message_to="<?php echo esc_attr( $user ); ?>" data-trigger_modal="conversation" data-conversation_id="<?php echo esc_attr( $conversation->conversation_id ); ?>">

					<span class="um-message-conv-name"><?php echo esc_html( $user_name ); ?></span>

					<span class="um-message-conv-pic"><?php echo get_avatar( $user, 40 ); ?></span>

					<?php if ( $is_unread && $profile_can_read ) { ?>
						<span class="um-message-conv-new"><i class="um-faicon-circle"></i></span>
					<?php }

					do_action( 'um_messaging_conversation_list_name' ); ?>

				</a>

			<?php } ?>
			<div data-user="<?php echo esc_attr( $user_id ); ?>" class="um-message-conv-load-more"></div>
		</div>

		<div class="um-message-conv-view"></div>
		<div class="um-clear"></div>
	</div>

	<?php do_action( 'um_messaging_after_conversations_list' );

} else { ?>

	<div class="um-message-noconv">
		<i class="um-icon-android-chat"></i>
		<?php _e( 'No chats found here', 'um-messaging' ); ?>
	</div>

<?php }
