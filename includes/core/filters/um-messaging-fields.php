<?php if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Add account privacy options
 *
 * @param $output
 *
 * @return string
 */
function um_messaging_privacy_setting( $output ) {
	wp_enqueue_script( 'um-messaging' );
	wp_enqueue_style( 'um-messaging' );

	$blocked = get_user_meta( get_current_user_id(), '_pm_blocked', true );
	if( is_array( $blocked ) ) {
		$blocked = array_filter( $blocked );
	}

	if ( $blocked ) {
		$output .= UM()->get_template( 'account_privacy.php', um_messaging_plugin, array(
			'blocked' => $blocked,
		) );
	}

	return $output;
}
add_filter( 'um_edit_field_account_private_message', 'um_messaging_privacy_setting', 10, 1 );


/**
 * @param $fields
 *
 * @return array
 */
function um_messaging_account_privacy_fields_add( $fields ) {

	$options = apply_filters( 'um_messaging_privacy_options', array(
		'everyone'  => __( 'Everyone', 'um-messaging' ),
		'nobody'    => __( 'Nobody', 'um-messaging' ),
	) );

	$fields['_pm_who_can'] = array(
		'title'         => __( 'Who can send me private messages?', 'um-messaging' ),
		'metakey'       => '_pm_who_can',
		'type'          => 'select',
		'label'         => __( 'Who can send me private messages?', 'um-messaging' ),
		'required'      => 0,
		'public'        => 1,
		'editable'      => true,
		'default'       => 'everyone',
		'options'       => $options,
		'allowclear'    => 0,
		'account_only'  => true,
	);

	UM()->account()->add_displayed_field( '_pm_who_can', 'privacy' );

	$fields['_pm_blocked'] = array(
		'metakey'       => '_pm_blocked',
		'type'          => 'private_message',
		'show_anyway'   => true,
		'custom'        => true,
		'account_only'  => true
	);

	return $fields;
}
add_filter( 'um_predefined_fields_hook', 'um_messaging_account_privacy_fields_add', 100, 1 );


/**
 * Shows the online field in account page
 *
 * @param string $args
 * @param array $shortcode_args
 *
 * @return string
 */
function um_activity_account_private_message_fields( $args, $shortcode_args ) {
	$args = $args . ',_pm_who_can,_pm_blocked';
	return $args;
}
add_filter( 'um_account_tab_privacy_fields', 'um_activity_account_private_message_fields', 10, 2 );
