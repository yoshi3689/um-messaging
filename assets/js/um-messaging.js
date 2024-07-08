if (typeof (window.UM) !== 'object') {
	window.UM = {};
}

/**
 * Main object for the extension "Ultimate Member - Private Messages"
 * @since 2.2.2  [2020-03-05]
 * @type  object
 */
window.UM.messaging = {
	sending: false
}

var UM_Conv_Ajax = false;

//used for delete cookie on login form
jQuery(document.body).on( 'click', '.um-login #um-submit-btn', function () {
	document.cookie = 'um_messaging_invite_login=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
});

function um_Hide_Emobox() {
	var emolist = jQuery('span.um-message-emolist');
	if ( emolist.is(':visible') ) {
		emolist.hide();
	}
}

function um_Chatbox( chatbox ) {
	var Length = chatbox.val().length;
	var maxLen = chatbox.attr('data-maxchar');
	var AmountLeft = maxLen - Length;

	jQuery('.um-message-limit:visible').html( AmountLeft );
	if ( chatbox.val() != '' ) {
		jQuery('.um-message-send:visible').removeClass('disabled');
		window.UM.messaging.sending = false;
	} else {
		jQuery('.um-message-send:visible').addClass('disabled');
	}
	if ( Length > maxLen ) {
		jQuery('.um-message-limit:visible').addClass('exceed');
		jQuery('.um-message-send:visible').addClass('disabled');
	} else {
		jQuery('.um-message-limit:visible').removeClass('exceed');
		if ( chatbox.val() != '' ) {
			jQuery('.um-message-send:visible').removeClass('disabled');
			window.UM.messaging.sending = false;
		}
	}
}

var um_conversations_loaded = false;

function um_messaging_init_conversations_list() {
	var conversations_block = jQuery('.um-message-conv');

	if ( conversations_block.length ) {

		if ( jQuery('.um-profile-nav-item.um-profile-nav-messages.active').length > 0 ) {
			if ( typeof um_messages_get_url_vars()['conversation_id'] !== 'undefined' ) {
				var conversation_id = um_messages_get_url_vars()['conversation_id'];
				jQuery('.um-message-conv-item[data-conversation_id=' + conversation_id + ']').trigger('click');
			} else {
				jQuery('.um-message-conv-item[data-conversation_id]').first().trigger('click');
			}
		}

		conversations_block.each( function() {
			jQuery(this).css({
				'max-height': '500px'
			});

			var simplebar_el = new SimpleBar( this );

			simplebar_el.recalculate();

			simplebar_el.getScrollElement().addEventListener( 'scroll', function() {
				var scrollHandling = {
					allow: true,
					reallow: function() {
						scrollHandling.allow = true;
					},
					delay: 400 //(milliseconds) adjust to the highest acceptable value
				};

				var wrapper = jQuery(this).parents('[data-simplebar]');
				var load_block = wrapper.find('.um-message-conv-load-more');

				if( ! um_conversations_loaded && scrollHandling.allow ) {
					scrollHandling.allow = false;

					if ( load_block.length ) {
						setTimeout( scrollHandling.reallow, scrollHandling.delay );

						var scroll_container = jQuery(this);

						var offset = jQuery( this ).offset().top - load_block.offset().top - jQuery(this).scrollTop();
						var max_offset = wp.hooks.applyFilters( 'um_messaging_conversations_scroll_max_offset', 200 );

						if ( max_offset > offset ) {

							var user_id = wrapper.data( 'user' );
							offset = wrapper.find('.um-message-conv-item').length;
							var url = window.location.href;

							um_conversations_loaded = true;
							load_block.show();

							wp.ajax.send( 'um_conversations_load', {
								data: {
									user_id: user_id,
									offset: offset,
									url: url,
									nonce: um_scripts.nonce
								},
								success: function( data ) {
									if ( data.length > 0 ) {
										var template = wp.template( 'um_messages_convesations' );
										var load = load_block.detach();
										var template_content = template({
											conversations: data
										});
										scroll_container.append( template_content ).append( load );

									} else {
										load_block.remove();
									}

									um_conversations_loaded = false;
								},
								error: function(e) {
									console.log(e);

									um_conversations_loaded = false;
								}
							});
						}
					}
				}
			});
		});
	}
}


function UM_Refresh_Conv() {
	var ajax_wrapper = jQuery('.um-message-ajax');
	if ( ajax_wrapper.length && ajax_wrapper.is(':visible') && ! UM_Conv_Ajax ) {
		var user_id = ajax_wrapper.data('message_from');
		var message_to = ajax_wrapper.data('message_to');
		var conversation_id = ajax_wrapper.data('conversation_id');
		var last_updated = ajax_wrapper.data('last_updated');

		if ( conversation_id === 'new' ) {
			return;
		}
		if ( UM_Refresh_Conv.state && UM_Refresh_Conv.state === 'run' ) {
			return;
		}

		wp.ajax.send( 'um_messaging_update', {
			data: {
				user_id: user_id,
				message_to: message_to,
				conversation_id: conversation_id,
				last_updated: last_updated,
				nonce: um_scripts.nonce
			},
			success: function( data ) {
				if ( data ) {
					UM_Update_UTC_to_LocalTime();

					if ( ajax_wrapper.find('.um-message-item[data-message_id="'+data.message_id+'"]').length == 0 ) {

						if ( data.response !== 'nothing_new' ) {
							jQuery('.um-message-ajax').append( data.response );

							jQuery('.um-popup-autogrow')[0].SimpleBar.getScrollElement().scrollTo( 0, jQuery('.um-popup-autogrow').find('.simplebar-content').outerHeight() + jQuery('.um-popup-autogrow')[0].scrollHeight );

							ajax_wrapper.data( 'last_updated', data.last_updated );
						}
					}
				}
			},
			error: function(e) {
				console.log(e);
			},
			beforeSend: function(e) {
				UM_Refresh_Conv.state = 'run';
			},
			complete: function(e) {
				UM_Refresh_Conv.state = 'ready';
			}
		});
	}
}

function UM_Update_UTC_to_LocalTime() {
	if ( 'undefined' === typeof moment.tz ) {
		return;
	}
	jQuery('.um-message-item-time').each( function() {
		let oldTitle = jQuery(this).attr('title');
		let UTCTime  = jQuery(this).data('um-message-utc-time');
		if ( ( '' === oldTitle || 'undefined' === typeof oldTitle ) && 'undefined' !== typeof UTCTime && '' !== UTCTime ) {
			let title = moment.tz( UTCTime, moment.tz.guess() ).format('LLLL');
			jQuery(this).attr('title', title);
		}
	});
}


/**
 * Get URL variables
 *
 * @returns {Array}
 */
function um_messages_get_url_vars() {
	var vars = [], hash;
	var hashes = window.location.href.slice( window.location.href.indexOf('?') + 1 ).split('&');
	for ( var i = 0; i < hashes.length; i++ ) {
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	return vars;
}


/**
 * Get cursor position
 *
 * @param el
 * @returns {*}
 */
function um_getCaret( el ) {
	if ( el.selectionStart ) {
		return el.selectionStart;
	} else if ( document.selection ) {
		el.trigger('focus');

		var r = document.selection.createRange();
		if ( r == null ) {
			return 0;
		}

		var re = el.createTextRange(),
			rc = re.duplicate();

		re.moveToBookmark( r.getBookmark() );
		rc.setEndPoint( 'EndToStart', re );

		return rc.text.length;
	}

	return 0;
}


/**
 * Get position in row
 *
 * @param el
 * @returns {number}
 */
function um_getPosInRow( el ) {
	var caret = um_getCaret(el);
	var text = el.value.substr(0, caret).replace(/^(.*[\n\r])*([^\n\r]*)$/, '$2' );
	return text.length;
}


/**
 * Set cursor position after insert smile
 *
 * @param el
 * @param current_position
 */
function um_setCaretPosition( el, current_position ) {
	el.setSelectionRange( current_position, current_position );
	el.umCaretPosition = {
		start: current_position,
		end: current_position
	};
	jQuery(el).trigger('focus');
}


/**
 * Get current selection position or cursor position
 *
 * @param		HTMLTextAreaElement	el
 * @returns	{Number|Object}
 */
function um_getCaretPosition(el) {

	if ( "selectionStart" in el && document.activeElement === el ) {
		return {
			start: el.selectionStart,
			end: el.selectionEnd
		};
	} else if (el.createTextRange) {
		var sel = document.selection.createRange();
		if (sel.parentElement() === el) {
			var rng = el.createTextRange();
			rng.moveToBookmark(sel.getBookmark());
			for (var len = 0;
							rng.compareEndPoints("EndToStart", rng) > 0;
							rng.moveEnd("character", -1)) {
				len++;
			}
			rng.setEndPoint("StartToStart", el.createTextRange());
			for (var pos = {start: 0, end: len};
							rng.compareEndPoints("EndToStart", rng) > 0;
							rng.moveEnd("character", -1)) {
				pos.start++;
				pos.end++;
			}
			return pos;
		}
	}
	return -1;
}


/* End of custom functions */

jQuery(document).ready(function() {

	// show or hide the "Remove" message icon on mobile devices.
	jQuery(document.body).on( 'touchstart', '.um-message-item', function( e ) {
		var $target = jQuery(e.currentTarget);
		$target.find('.um-message-item-show-on-hover').toggle();
		$target.siblings().find('.um-message-item-show-on-hover').hide();
	});

	/* unblocking a user */
	jQuery(document.body).on('click', '.um-message-unblock',function(e) {
		e.preventDefault();
		var user_id = jQuery(this).attr('data-user_id');
		jQuery(this).parents('.um-message-blocked').fadeOut('fast');
		wp.ajax.send( 'um_messaging_unblock_user', {
			data: {
				user_id: user_id,
				nonce: um_scripts.nonce
			},
			success: function( data ) {
				UM_Update_UTC_to_LocalTime();
			},
			error: function(e){
				console.log(e);
			}
		});
		return false;
	});

	/* blocking a user */
	jQuery(document.body).on('click', '.um-message-blocku:not(.um-message-blocked-true)',function(e){
		e.preventDefault();

		var confirm_text = jQuery(this).attr("data-confirm_text");
		if ( confirm( confirm_text ) ) {

			jQuery(this).addClass('um-message-blocked-true');
			var conversation_id = jQuery(this).attr('data-conversation_id');
			var other_user = jQuery(this).attr('data-other_user');

			UM.common.tipsy.hide();

			jQuery('.um-message-body,.um-message-footer,.um-message-header-left').css({'opacity': 0.5});
			jQuery('.um-message-conv-item[data-conversation_id="'+conversation_id+'"]').remove();
			jQuery('.um-message-footer').empty();
			jQuery('.um-message-item-remove').remove();
			jQuery('a.um-message-delconv').addClass('disabled');
			wp.ajax.send( 'um_messaging_block_user', {
				data: {
					other_user: other_user,
					nonce: um_scripts.nonce
				},
				success: function(data) {

				},
				error: function(e) {
					console.log(e);
				}
			});

		}


		return false;
	});

	/* Delete conversation (disabled) */
	jQuery(document.body).on('click', '.um-message-delconv.disabled',function(e){
		e.preventDefault();
		return false;
	});

	/* Delete conversation */
	jQuery(document.body).on('click', '.um-message-delconv',function(e){
		e.preventDefault();
		var conversation_id = jQuery(this).attr('data-conversation_id');
		var other_user = jQuery(this).attr('data-other_user');

		UM.common.tipsy.hide();

		if ( jQuery('.um-message-conv-view').length ) {

			jQuery('.um-message-conv-item[data-conversation_id='+conversation_id+']').remove();
			if ( jQuery('.um-message-conv-item').length && jQuery('.um-message-conv-view').is(':visible') ) {
				jQuery('.um-message-conv-item:first').trigger('click');
			}

			jQuery('.um-message-conv-view').empty();

		} else {

			remove_Modal();

		}

		// No more chats?
		if ( jQuery('.um-message-conv').find('.um-message-conv-item').length == 0 ) {
			jQuery('.um-profile-body.messages').append('<div class="um-message-noconv"><i class="um-icon-android-chat"></i>' + wp.i18n.__( 'No chats found here', 'um-messaging' ) + '</div>');
			jQuery('.um-profile-body.messages').find('.um-message-conv, .um-message-conv-view').hide();
		}

		// Ajax request to delete conversation
		wp.ajax.send( 'um_messaging_delete_conversation', {
			data: {
				conversation_id: conversation_id,
				other_user: other_user,
				nonce: um_scripts.nonce
			},
			success: function(data){
			},
			error: function(e){
				console.log(e);
			}
		});
		return false;
	});

	/* Close modal */
	jQuery(document.body).on('click', '.um-message-hide',function(e){
		e.preventDefault();
		remove_Modal();
		return false;
	});


	/**
	 * Show modal login form
	 */
	jQuery(document.body).on('click', '.um-login-to-msg-btn', function(e) {
		e.preventDefault();

		var $btn = jQuery(e.currentTarget).css({cursor: 'wait'});
		var $popup = jQuery('#um_messaging_hidden_login .um-modal');
		var message_to = $btn.attr('data-message_to');

		if ( ! $popup.length ) {
			window.location.assign( $btn.attr('href') );
			return;
		}

		if ( jQuery('body').hasClass('um-page-members') ) {
			var page_id, matches = document.body.className.match(/(^|\s)page-id-(\d+)(\s|$)/);
			if ( matches ) {
				page_id = matches[2];
			}

			var members_current_page = jQuery('.um-members-pagi .current').text();
		}

		wp.ajax.send( 'um_messaging_login_modal', {
			data: {
				message_to: message_to,
				page_id: page_id,
				current_page: members_current_page,
				nonce: um_scripts.nonce
			},
			success: function( data ) {
				if ( typeof data.content === 'string' ) {
					$popup.find( '.um-message-header' ).remove();
					$popup.find( '.um-message-modal' ).prepend( data.content );
					$popup.find( '.um-message-hide' ).show();
					$popup.siblings( '.um-modal-overlay' ).remove();
					$popup.removeClass( 'um-modal-hidden' ).show().after( '<div class="um-modal-overlay"></div>');
				}
				if ( typeof data.redirect_url === 'string' ) {
					$popup.find('#redirect_to').val( data.redirect_url );
				}

				if ( $popup.find('.g-recaptcha:not(:empty)').length ) {
					typeof grecaptcha === 'object' && grecaptcha.reset();
				}

				if ( typeof um_modal_responsive === 'function') {
					um_modal_responsive();
				} else if ( typeof responsive_Modal === 'function' ) {
					responsive_Modal();
				}
				setTimeout(function () {
					jQuery(document.body).trigger( 'resize' );
				}, 200);

				jQuery(document).trigger( 'um_messaging_open_login_form' );
			},
			error: function( e ) {
				console.log( e );
			}
		});

		return false;
	});


	/**
	 * Hide modal login form
	 */
	jQuery('#um_messaging_hidden_login').on('click', '.um-modal-overlay, .um-message-hide', function (e) {
		e.stopPropagation();

		jQuery(e.delegateTarget).find('.um-modal').addClass('um-modal-hidden').hide().siblings('.um-modal-overlay').remove();
		jQuery( '.um-login-to-msg-btn' ).css({cursor: 'pointer'});

		jQuery( document ).trigger( 'um_messaging_close_login_form' );
	});


	/* Display a conversation */
	jQuery( document.body ).on('click', '.um-message-conv-item', function(e){
		e.preventDefault();

		if ( jQuery(this).attr('data-trigger_modal') && jQuery('.um-message-conv-view').is(':hidden') )
			return false;

		if ( jQuery(this).hasClass('active') || UM_Conv_Ajax )
			return false;

		UM_Conv_Ajax = true;

		var link = jQuery(this);
		var savehtml = jQuery(this).html();
		jQuery(this).find('img').replaceWith('<span class="um-message-cssload"><i class="um-faicon-circle-o-notch"></i></span>');

		var message_to = jQuery(this).attr('data-message_to');

		window.history.pushState("string", "Conversation",  jQuery(this).attr('href') );

		wp.ajax.send( 'um_messaging_start', {
			data: {
				message_to: message_to,
				nonce: um_scripts.nonce
			},
			success: function(data){
				if ( data ) {
					UM_Update_UTC_to_LocalTime();

					// update conversations menu.
					link.html( savehtml ).addClass('active').siblings('.um-message-conv-item').removeClass('active');

					// add conversation to the document.
					var view = jQuery('.um-message-conv-view').html( data );

					// enable "autosize" feature in profile.
					var $textarea = view.find('textarea.um_message_text');
					1 === $textarea.length && 'function' === typeof autosize && autosize($textarea);

					var messages_block = view.find('.um-message-autoheight');
					if ( messages_block.length ) {
						messages_block.each( function() {
							jQuery(this).css({
								'max-height': '500px'
							});

							var simplebar_el = new SimpleBar( this );
							simplebar_el.recalculate();
						});
					}

					UM.common.tipsy.init();

					UM_Conv_Ajax = false;

					setTimeout( function(){
						if ( jQuery('.um-popup-autogrow:visible').length ) {
							jQuery('.um-popup-autogrow:visible')[0].SimpleBar.getScrollElement().scrollTo( 0, jQuery('.um-popup-autogrow:visible').find('.simplebar-content').outerHeight() + jQuery('.um-popup-autogrow:visible')[0].scrollHeight );
						}
					}, 1000 );

				}
			},
			error: function(e) {
				console.log(e);
			}
		});


		return false;
	});

	/* Remove a message */
	jQuery(document.body).on('click touchend', '.um-message-item-remove', function(e){
		e.preventDefault();
		var $target = jQuery(e.target);
		var message_id = $target.parents('.um-message-item').attr('data-message_id');
		var conversation_id = $target.parents('.um-message-item').attr('data-conversation_id');
		UM.common.tipsy.hide();
		$target.parents('.um-message-item').fadeOut('fast');
		wp.ajax.send( 'um_messaging_remove', {
			data: {
				message_id: message_id,
				conversation_id: conversation_id,
				nonce: um_scripts.nonce
			},
			success: function( data ) {
				if ( data ) {
					if ( data.count_messages < 1 ) {
						jQuery('.um-message-header-right .um-gdpr-donwload-link').hide();
					}
				}
			},
			error: function(e){
				console.log(e);
			}
		});
		return false;
	});

	/* Show emoji list */
	jQuery(document.body).on('click', '.um-message-emo',function() {
		if ( jQuery('span.um-message-emolist').is(':visible') ) {
			um_Hide_Emobox();
		} else {
			jQuery('span.um-message-emolist').show();
		}
	});

	/* Insert a smiley */
	jQuery(document.body).on('click', '.um-message-emolist span.um-message-insert-emo', function(e){
		var code = jQuery(this).attr('data-emo');
		var chatbox = jQuery(e.target).closest('.um-message-footer').find('textarea.um_message_text');
		var old_pos = chatbox.prop('umCaretPosition') ? chatbox.prop('umCaretPosition').end : 0;

		var first_str = chatbox.val().substr( 0, old_pos );
		var last_str = chatbox.val().substr( old_pos, chatbox.val().length );
		var new_pos = ( first_str + ' ' + code + ' ' ).length;

		chatbox.val( first_str + ' ' + code + ' ' + last_str );
		um_setCaretPosition( chatbox.get(0), new_pos );

		um_Hide_Emobox();
		um_Chatbox( chatbox );
		chatbox.trigger('focus');
	});

	/* Show message modal */
	jQuery(document.body).on('click', '.um-message-btn:not(.um-login-to-msg-btn), *[data-trigger_modal="conversation"]',function(e){

		e.preventDefault();

		if ( jQuery(this).attr('data-trigger_modal') && jQuery('.um-message-conv-view').is(':visible') ) return false;


		var message_to = jQuery(this).attr('data-message_to');

		jQuery('.um-message-conv-item').removeClass('active');
		jQuery(this).addClass('active');

		prepare_Modal();
		wp.ajax.send( 'um_messaging_start', {
			data: {
				message_to: message_to,
				nonce: um_scripts.nonce
			},
			success: function( data ) {
				if ( data ) {
					show_Modal( data );
					responsive_Modal();

					// do not enable "autosize" feature in popup, because it may push the submit button out of the popup.

					UM.common.tipsy.init();

					setTimeout( function(){
						if ( jQuery('.um-popup-autogrow:visible').length ) {
							jQuery('.um-popup-autogrow:visible')[0].SimpleBar.getScrollElement().scrollTo( 0, jQuery('.um-popup-autogrow:visible').find('.simplebar-content').outerHeight() + jQuery('.um-popup-autogrow:visible')[0].scrollHeight );
						}
					}, 1000 );

				} else {
					remove_Modal();
				}
			},
			error: function(e) {
				console.log(e);
			}
		});
		return false;
	});

	/* Send message */
	jQuery(document.body).on('click', '.um-message-send',function() {
		if ( false !== window.UM.messaging.sending ) {
			return;
		}

		window.UM.messaging.sending = true;

		var obj     = jQuery(this);
		let chatBox = obj.parents('.um-message-footer').find('.um_message_text:visible');
		if ( jQuery(this).hasClass( 'disabled' ) ) {
			return;
		}
		obj.addClass('disabled');

		var message_to = obj.parents('.um-message-footer').siblings('.um-message-body').data('message_to');
		var content = chatBox.val();
		wp.ajax.send( 'um_messaging_send', {
			data: {
				message_to: message_to,
				content: content,
				nonce: um_scripts.nonce
			},
			success: function(data) {
				//var textarea = jQuery('.um-message-textarea textarea:visible');
				UM_Update_UTC_to_LocalTime();
				chatBox.val('');
				chatBox.get(0).dispatchEvent(new Event('autosize.update'));

				jQuery('.um-message-body:visible').find('.um-message-ajax:visible').html( data.messages ).data( 'last_updated', data.last_updated );

				if ( jQuery('[data-conversation_id="' + data.conversation_id + '"]:not(.um-message-item)').length ) {
					jQuery('[data-conversation_id="' + data.conversation_id + '"]:not(.um-message-item)').show();
				} else {
					jQuery('[data-conversation_id="new"]').data( 'conversation_id', data.conversation_id ).show();
				}

				jQuery('.um-gdpr-donwload-link:visible').attr('href', data.chat_history_download );

				if ( data.limit_hit ) {
					jQuery('.um-message-footer:visible').html( jQuery('.um-message-footer:visible').data('limit_hit') );
				}

				jQuery('.um-message-footer:visible').find('.um-message-limit').html( chatBox.data('maxchar') );

				jQuery('.um-popup-autogrow:visible')[0].SimpleBar.getScrollElement().scrollTo( 0, jQuery('.um-popup-autogrow:visible').find('.simplebar-content').outerHeight() + jQuery('.um-popup-autogrow:visible')[0].scrollHeight );

				um_Chatbox( chatBox );
				window.UM.messaging.sending = false;
			},
			error: function(e){
				chatBox.val('');
				um_Chatbox( chatBox );
				window.UM.messaging.sending = false;
				console.log(e);
			}
		});
		return false;
	});

	/* Way to hide emo box */
	jQuery(document.body).on('click', 'textarea.um_message_text',function(event) {
		um_Hide_Emobox();
	});

	/* Message char limit */
	jQuery(document.body).on('keyup keydown keypress', 'textarea.um_message_text', function(event) {
		um_Hide_Emobox();
		um_Chatbox( jQuery(this) );
	}).on('click touchend keyup', 'textarea.um_message_text', function(event) {
		event.target.umCaretPosition = um_getCaretPosition( event.target );
	});


	// Send a message on the ENTER keypress. Add a new line on Ctrl+ENTER or Shift+ENTER.
	jQuery( document.body ).on( 'keypress', 'textarea.um_message_text', function ( event ) {
		if ( event.keyCode && event.keyCode === 13 || event.which === 13 ) {
			if ( true === event.ctrlKey || true === event.shiftKey ) {
				event.preventDefault();
				event.target.value = event.target.value + '\n';
			} else {
				if ( false !== window.UM.messaging.sending ) {
					event.preventDefault();
					return;
				}

				event.preventDefault();
				jQuery( event.target ).closest( '.um-message-footer' ).find( '.um-message-send:visible:not(.disabled)' ).trigger( 'click' );
			}
		}
	} );


	jQuery(document.body).on('paste', 'textarea.um_message_text',function(e) {
		var chatbox = jQuery(this);
		var pastedData = e.originalEvent.clipboardData.getData('text');
		um_Hide_Emobox();

		var Length = chatbox.val().length + pastedData.length;
		var maxLen = chatbox.attr('data-maxchar');
		var AmountLeft = maxLen - Length;

		jQuery('.um-message-limit:visible').html(AmountLeft);
		if ( chatbox.val() + pastedData != '' ) {
			jQuery('.um-message-send:visible').removeClass('disabled');
		} else {
			jQuery('.um-message-send:visible').addClass('disabled');
		}
		if ( Length > maxLen ) {
			jQuery('.um-message-limit:visible').addClass('exceed');
			jQuery('.um-message-send:visible').addClass('disabled');
		} else {
			jQuery('.um-message-limit:visible').removeClass('exceed');
			if ( chatbox.val() + pastedData != '' ) {
				jQuery('.um-message-send:visible').removeClass('disabled');
			}
		}
	});

	jQuery(document).on('click', '#um_messaging_hidden_login .um-modal a', function(e){
		jQuery('#um_messaging_hidden_login .um-modal a').unbind('click');
		var url = jQuery(this).attr('href');
		window.location.replace(url);
	});


	setTimeout( function(){
		if ( jQuery('body.um-page-user .um-popup-autogrow:visible').length ) {
			jQuery('body.um-page-user .um-popup-autogrow:visible')[0].SimpleBar.getScrollElement().scrollTo( 0, jQuery('.um-popup-autogrow:visible').find('.simplebar-content').outerHeight() + jQuery('.um-popup-autogrow:visible')[0].scrollHeight );
		}
	}, 1000 );

	if ( um_messages.can_read ) {
		setInterval( UM_Refresh_Conv, um_messages.interval );
	}

	/* Height of conversation */
	um_messaging_init_conversations_list();
	UM_Update_UTC_to_LocalTime();
});
