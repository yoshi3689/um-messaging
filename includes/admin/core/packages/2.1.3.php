<?php
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'um_ext\um_messaging\core\Messaging_Setup' ) ) {
	require_once um_messaging_path . 'includes/core/class-messaging-setup.php';
}
UM()->classes['Messaging_API']->setup()->sql_alter();

wp_cache_flush();