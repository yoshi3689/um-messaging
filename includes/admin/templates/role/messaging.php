<div class="um-admin-metabox">

	<?php $role = $object['data'];

	UM()->admin_forms( array(
		'class'		=> 'um-role-messages um-half-column',
		'prefix_id'	=> 'role',
		'fields' => array(
			array(
				'id'            => '_um_enable_messaging',
				'type'          => 'checkbox',
				'label'         => __( 'Enable Messaging feature?', 'um-messaging' ),
				'tooltip'       => __( 'Enable or disable messaging feature for this role', 'um-messaging' ),
				'value'         => isset( $role['_um_enable_messaging'] ) ? $role['_um_enable_messaging'] : 1,
			),
			array(
				'id'            => '_um_can_start_pm',
				'type'          => 'checkbox',
				'label'         => __( 'Can start conversations?','um-messaging' ),
				'tooltip'       => __( 'Can this role start conversation with other users?', 'um-messaging' ),
				'value'         => isset( $role['_um_can_start_pm'] ) ? $role['_um_can_start_pm'] : 1,
				'conditional'   => array( '_um_enable_messaging', '=', 1 )
			),
			array(
				'id'            => '_um_can_start_access',
				'type'          => 'select',
				'label'         => __( 'Can start conversations with', 'ultimate-member' ),
				'options'       => array(
					'0'         => __( 'Everyone', 'ultimate-member' ),
					'1'         => __( 'Only specific user roles', 'ultimate-member' ),
				),
				'value'         => ! empty( $role['_um_can_start_access'] ) ? $role['_um_can_start_access'] : 0,
				'conditional'   => array( '_um_can_start_pm', '=', '1' )
			),
			array(
				'id'            => '_um_can_start_roles',
				'type'          => 'select',
				'label'         => __( 'Can start conversations with selected user roles', 'ultimate-member' ),
				'options'       => UM()->roles()->get_roles(),
				'multi'         => true,
				'value'         => ! empty( $role['_um_can_start_roles'] ) ? $role['_um_can_start_roles'] : array(),
				'conditional'   => array( '_um_can_start_access', '=', '1' )
			),
			array(
				'id'            => '_um_can_read_pm',
				'type'          => 'checkbox',
				'label'         => __( 'Can read private messages?','um-messaging' ),
				'tooltip'       => __( 'Can this role read private messages from other users?', 'um-messaging' ),
				'value'         => isset( $role['_um_can_read_pm'] ) ? $role['_um_can_read_pm'] : 1,
				'conditional'   => array( '_um_enable_messaging', '=', 1 )
			),
			array(
				'id'            => '_um_can_reply_pm',
				'type'          => 'checkbox',
				'label'         => __( 'Can reply private messages?','um-messaging' ),
				'tooltip'       => __( 'Turn this off to disable reply ability for this role', 'um-messaging' ),
				'value'         => isset( $role['_um_can_reply_pm'] ) ? $role['_um_can_reply_pm'] : 1,
				'conditional'   => array( '_um_can_read_pm', '=', 1 )
			),
			array(
				'id'            => '_um_can_reply_access',
				'type'          => 'select',
				'label'         => __( 'Can reply private messages to', 'ultimate-member' ),
				'options'       => array(
					'0'         => __( 'Everyone', 'ultimate-member' ),
					'1'         => __( 'Only specific user roles', 'ultimate-member' ),
				),
				'value'         => ! empty( $role['_um_can_reply_access'] ) ? $role['_um_can_reply_access'] : 0,
				'conditional'   => array( '_um_can_reply_pm', '=', '1' )
			),
			array(
				'id'            => '_um_can_reply_roles',
				'type'          => 'select',
				'label'         => __( 'Can reply private messages to selected user roles', 'ultimate-member' ),
				'options'       => UM()->roles()->get_roles(),
				'multi'         => true,
				'value'         => ! empty( $role['_um_can_reply_roles'] ) ? $role['_um_can_reply_roles'] : array(),
				'conditional'   => array( '_um_can_reply_access', '=', '1' )
			),
			array(
				'id1'           => '_um_pm_max_messages',
				'id2'           => '_um_pm_max_messages_tf',
				'type'          => 'inline_texts',
				'size'          => 'small',
				'mask'          => '%s ' . __( 'per', 'um-messaging' ) . ' %s ' . __( 'Days', 'um-messaging' ),
				'label'         => __( 'Maximum number of messages they can send', 'um-messaging' ),
				'value1'        => isset( $role['_um_pm_max_messages'] ) ? $role['_um_pm_max_messages'] : '',
				'value2'        => isset( $role['_um_pm_max_messages_tf'] ) ? $role['_um_pm_max_messages_tf'] : '',
				'conditional'   => array( '_um_enable_messaging', '=', 1 )
			)
		)
	) )->render_form(); ?>

	<div class="clear"></div>
</div>
