jQuery( function () {
	var $pm_encryption_input = jQuery( '#um_options_pm_encryption' );
	if ( !$pm_encryption_input.length ) {
		return;
	}

	var pm_encryption_initial_state = $pm_encryption_input.is( ':checked' );
	$pm_encryption_input.on( 'change', function () {
		if ( pm_encryption_initial_state === $pm_encryption_input.is( ':checked' ) ) {
			$pm_encryption_input.siblings( '.um-same-page-update-encrypt_messages' ).hide();
		} else {
			$pm_encryption_input.siblings( '.um-same-page-update-encrypt_messages' ).show();
		}
	} );

	var pm_encryption_logObject = 'encrypt_messages';
	var pm_encryption_scope = {
		count: 0,
		current_page: 0,
		pages: 0,
		per_page: 0
	};

	/**
	 * @see /wp-content/plugins/ultimate-member/includes/admin/assets/js/um-admin-forms.js line 186
	 */
	wp.hooks.addAction( 'um_same_page_upgrade', 'um-messaging', um_same_page_upgrade_encrypt_messages, 10 );

	function um_same_page_upgrade_encrypt_messages( field_key ) {
		if ( field_key !== pm_encryption_logObject ) {
			return;
		}
		wp.ajax.send( 'um_same_page_update', {
			data: {
				cb_func: 'um_encrypt_messages_start',
				checked: +$pm_encryption_input.is( ':checked' ),
				nonce: um_admin_scripts.nonce
			},
			beforeSend: function () {
				um_add_same_page_log( pm_encryption_logObject, wp.i18n.__( 'Getting messages...', 'um-messaging' ) );
			},
			success: function ( response ) {
				if ( response ) {
					jQuery.extend( pm_encryption_scope, response );

					um_add_same_page_log( pm_encryption_logObject, wp.i18n.__( 'There are ', 'um-messaging' ) + pm_encryption_scope.count + wp.i18n.__( ' messages...', 'um-messaging' ) );
					um_add_same_page_log( pm_encryption_logObject, wp.i18n.__( 'Start messages updating...', 'um-messaging' ) );

					pm_encryption_scope.pages = Math.ceil( pm_encryption_scope.count / pm_encryption_scope.per_page );

					update_per_page();
				} else {
					um_same_page_wrong_ajax( pm_encryption_logObject );
				}
			},
			error: function () {
				um_same_page_something_wrong( pm_encryption_logObject );
			}
		});
	}

	function update_per_page() {
		pm_encryption_scope.current_page++;
		if ( pm_encryption_scope.current_page > pm_encryption_scope.pages ) {
			um_add_same_page_log( pm_encryption_logObject, wp.i18n.__( 'Done.', 'um-messaging' ) );
			window.location.reload();
			return;
		}
		wp.ajax.send( 'um_same_page_update', {
			data: {
				cb_func: 'um_encrypt_messages_update',
				checked: +$pm_encryption_input.is( ':checked' ),
				page: pm_encryption_scope.current_page,
				pages: pm_encryption_scope.pages,
				nonce: um_admin_scripts.nonce
			},
			success: function ( response ) {
				if ( response) {
					um_add_same_page_log( pm_encryption_logObject, response.message );
					update_per_page();
				} else {
					um_same_page_wrong_ajax( pm_encryption_logObject );
				}
			},
			error: function () {
				um_same_page_something_wrong( pm_encryption_logObject );
			}
		});
	}
} );
