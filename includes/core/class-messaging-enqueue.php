<?php
namespace um_ext\um_messaging\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class Messaging_Enqueue {

	/**
	 * Should we print hidden login form or not
	 * @var boolean
	 */
	public $need_hidden_login = false;


	/**
	 * The class constructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( &$this, 'wp_enqueue_scripts' ), 9999 );
		add_action( 'enqueue_block_assets', array( &$this, 'block_editor' ), 11 );
		add_action( 'wp_footer', array( &$this, 'footer_login_form' ), 5 );

		add_action( 'um_after_login_fields', array( $this, 'login_form_field' ), 10 );
	}


	public function login_form_field() {
		if ( UM()->Messaging_API()->enqueue()->need_hidden_login ) {
			?>
			<input type="hidden" name="um_messaging_invite_login" value="1" />
			<?php
		}
	}

	/**
	 * Insert Login form to hidden block
	 */
	public function footer_login_form() {
		if ( !$this->need_hidden_login ) {
			return;
		}
		if ( is_user_logged_in() ) {
			return;
		}
		if ( empty( UM()->options()->get( 'show_pm_button' ) ) ) {
			return;
		}

		if ( ! empty( $_COOKIE['um_messaging_invite_login'] ) ) {
			$_POST = array_merge( json_decode( wp_unslash( $_COOKIE['um_messaging_invite_login'] ), true ), $_POST );
			UM()->form()->form_init();

			unset( $_COOKIE['um_messaging_invite_login'] );
			setcookie( "um_messaging_invite_login", null, -1, '/' );
		}

		add_filter( 'um_browser_url_redirect_to__filter', array( UM()->Messaging_API()->api(), 'set_redirect_to' ), 10, 1 );
		?>

		<div id="um_messaging_hidden_login" class="um_messaging_hidden_login">
			<div class="um-modal um-modal-hidden">
				<div class="um-message-header um-popup-header"></div>
				<div class="um-message-modal">
					<div class="um-message-body um-popup-autogrow2 um-message-autoheight" data-simplebar>
						<?php echo apply_shortcodes( '[ultimatemember form_id="' . UM()->shortcodes()->core_login_form() . '" /]' ); ?>
					</div>
				</div>
			</div>
		</div>

		<?php
	}

	/**
	 * Frontend Scripts
	 */
	public function wp_enqueue_scripts() {
		$suffix = UM()->frontend()->enqueue()::get_suffix();

		wp_register_script( 'um_scrollbar', um_messaging_url . 'assets/libs/simplebar/simplebar' . $suffix . '.js', array( 'jquery' ), '4.0.0-alpha.5', true );
		wp_register_style( 'um_scrollbar', um_messaging_url . 'assets/libs/simplebar/simplebar' . $suffix . '.css', array(), '4.0.0-alpha.5' );

		wp_register_script( 'um-messaging-autosize', um_messaging_url . 'assets/libs/autosize/autosize' . $suffix . '.js', array( 'jquery' ), '6.0.1', true );

		wp_register_script( 'um-messaging', um_messaging_url . 'assets/js/um-messaging' . $suffix . '.js', array( 'wp-date', 'moment', 'um_scripts', 'um_modal', 'um_responsive', 'jquery-ui-datepicker', 'um_scrollbar', 'um-messaging-autosize' ), um_messaging_version, true );
		wp_set_script_translations( 'um-messaging', 'um-messaging' );

		// Localize time
		wp_localize_script(
			'um-messaging',
			'um_message_timezone',
			array(
				'string' => get_option( 'timezone_string' ),
				'offset' => get_option( 'gmt_offset' ),
			)
		);

		$interval = UM()->options()->get( 'pm_coversation_refresh_timer' );
		$interval = ( ! empty( $interval ) && is_numeric( $interval ) ) ? $interval * 1000 : 5000;

		$can_read = false;

		if ( is_user_logged_in() ) {
			um_fetch_user( get_current_user_id() );

			if ( um_user( 'can_read_pm' ) ) {
				$can_read = true;
			}

			um_reset_user();
		}

		wp_localize_script(
			'um-messaging',
			'um_messages',
			array(
				'can_read' => $can_read,
				'interval' => $interval,
			)
		);

		wp_register_style( 'um-messaging', um_messaging_url . 'assets/css/um-messaging' . $suffix . '.css', array( 'um_scrollbar', 'um_modal', 'um_responsive' ), um_messaging_version );

		$color_hex = UM()->options()->get( 'pm_active_color' );
		$color_rgb = UM()->Messaging_API()->api()->hex_to_rgb( $color_hex );

		$css = '
			.um-message-item-content a { color:' . $color_hex . '; text-decoration: underline !important;}
			.um-message-item-content a:hover {color: rgba(' . $color_rgb . ', 0.9);}
			.um-message-item.left_m .um-message-item-content a {color: #fff}
			.um-message-send, .um-message-send.disabled:hover { background-color:' . $color_hex . '; }
			.um-message-send:hover { background-color: rgba(' . $color_rgb . ', 0.9) }
			.um-message-item.left_m .um-message-item-content { background-color: rgba(' . $color_rgb . ', 0.8);}
			.um-message-footer { background: rgba(' . $color_rgb . ', 0.03); border-top: 1px solid rgba(' . $color_rgb . ', 0.2);}
			.um-message-textarea textarea, div.um div.um-form .um-message-textarea textarea {border: 2px solid rgba(' . $color_rgb . ', 0.3) !important}
			.um-message-textarea textarea:focus,  div.um div.um-form .um-message-textarea textarea:focus {border: 2px solid rgba(' . $color_rgb . ', 0.6) !important}
			.um-message-emolist { border: 1px solid rgba(' . $color_rgb . ', 0.25);}
			.um-message-conv-item.active {color: ' . $color_hex . ';}
			.um-message-conv-view {border-left: 1px solid rgba(' . $color_rgb . ', 0.2);}
		';

		wp_add_inline_style( 'um-messaging', wp_strip_all_tags( $css ) );
	}

	public function block_editor() {
		$suffix = UM()->frontend()->enqueue()::get_suffix();
		wp_register_style( 'um-messaging', um_messaging_url . 'assets/css/um-messaging' . $suffix . '.css', array(), um_messaging_version );
		wp_enqueue_style( 'um-messaging' );
	}
}
