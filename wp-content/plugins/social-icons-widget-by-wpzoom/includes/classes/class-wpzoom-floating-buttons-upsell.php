<?php
/**
 * Floating Buttons Upsell Page
 *
 * Displays a blurred preview of the Floating Buttons feature
 * to promote the Pro version.
 *
 * @package WPZOOM_Social_Icons
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WPZOOM_Floating_Buttons_Upsell
 */
class WPZOOM_Floating_Buttons_Upsell {

	/**
	 * The single class instance.
	 *
	 * @var $instance
	 */
	private static $instance = null;

	/**
	 * Main Instance
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu_item' ), 24 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	}

	/**
	 * Add menu item
	 */
	public function add_menu_item() {
		add_submenu_page(
			'edit.php?post_type=wpzoom-shortcode',
			__( 'Floating Icons', 'social-icons-widget-by-wpzoom' ),
			__( 'Floating Icons', 'social-icons-widget-by-wpzoom' ) . ' <span class="wpzoom-pro-badge">Pro</span>',
			'manage_options',
			'wpzoom-floating-buttons',
			array( $this, 'render_page' )
		);
	}

	/**
	 * Enqueue styles
	 *
	 * @param string $hook Current admin page.
	 */
	public function enqueue_styles( $hook ) {
		if ( 'wpzoom-shortcode_page_wpzoom-floating-buttons' !== $hook ) {
			return;
		}

		wp_enqueue_style(
			'wpzoom-admin-upsell',
			WPZOOM_SOCIAL_ICONS_PLUGIN_URL . 'assets/css/admin-upsell.css',
			array(),
			WPZOOM_SOCIAL_ICONS_PLUGIN_VERSION
		);
	}

	/**
	 * Render the upsell page
	 */
	public function render_page() {
		$upgrade_url = 'https://www.wpzoom.com/plugins/social-share/?utm_source=wpadmin&utm_medium=plugin&utm_campaign=social-icons-free&utm_content=floating-buttons-page';
		?>
		<div class="wrap wpzoom-floating-upsell-wrap">
			<h1><?php esc_html_e( 'Floating Buttons', 'social-icons-widget-by-wpzoom' ); ?> <span class="wpzoom-pro-badge"><?php esc_html_e( 'Pro', 'social-icons-widget-by-wpzoom' ); ?></span></h1>
			<p class="wpzoom-floating-description"><?php esc_html_e( 'Display social sharing icons as a fixed floating bar on your website.', 'social-icons-widget-by-wpzoom' ); ?></p>

			<div class="wpzoom-floating-preview-container">
				<!-- Blurred Preview -->
				<div class="wpzoom-floating-preview-blurred">

                    <!-- Visual Preview -->
                    <div class="wpzoom-floating-visual-preview">
                        <div class="wpzoom-floating-browser-frame">
                            <div class="wpzoom-floating-browser-header">
                                <span class="wpzoom-floating-browser-dot"></span>
                                <span class="wpzoom-floating-browser-dot"></span>
                                <span class="wpzoom-floating-browser-dot"></span>
                                <span class="wpzoom-floating-browser-url"><?php echo esc_html( home_url() ); ?></span>
                            </div>
                            <div class="wpzoom-floating-browser-content">
                                <div class="wpzoom-floating-page-header"></div>
                                <div class="wpzoom-floating-page-content">
                                    <div class="wpzoom-floating-content-line wpzoom-floating-content-title"></div>
                                    <div class="wpzoom-floating-content-line"></div>
                                    <div class="wpzoom-floating-content-line"></div>
                                    <div class="wpzoom-floating-content-line wpzoom-floating-content-short"></div>
                                    <div class="wpzoom-floating-content-line"></div>
                                    <div class="wpzoom-floating-content-line"></div>
                                </div>

                                <!-- Floating Bar Preview -->
                                <div class="wpzoom-floating-bar-preview">
                                    <div class="wpzoom-floating-icon wpzoom-floating-icon-fb">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="#fff"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </div>
                                    <div class="wpzoom-floating-icon wpzoom-floating-icon-x">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="#fff"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
                                    </div>
                                    <div class="wpzoom-floating-icon wpzoom-floating-icon-linkedin">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="#fff"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    </div>
                                    <div class="wpzoom-floating-icon wpzoom-floating-icon-pinterest">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="#fff"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/></svg>
                                    </div>
                                    <div class="wpzoom-floating-icon wpzoom-floating-icon-whatsapp">
                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

					<!-- Settings Panel Preview -->
					<div class="wpzoom-floating-settings-preview">
						<div class="wpzoom-floating-settings-header">
							<span class="dashicons dashicons-admin-settings"></span>
							<?php esc_html_e( 'Display Settings', 'social-icons-widget-by-wpzoom' ); ?>
						</div>

						<div class="wpzoom-floating-settings-group">
							<label><?php esc_html_e( 'Position', 'social-icons-widget-by-wpzoom' ); ?></label>
							<div class="wpzoom-floating-position-options">
								<div class="wpzoom-floating-option">
									<span class="wpzoom-floating-option-label"><?php esc_html_e( 'Horizontal:', 'social-icons-widget-by-wpzoom' ); ?></span>
									<div class="wpzoom-floating-radio-group">
										<label><input type="radio" checked disabled /> <?php esc_html_e( 'Left', 'social-icons-widget-by-wpzoom' ); ?></label>
										<label><input type="radio" disabled /> <?php esc_html_e( 'Right', 'social-icons-widget-by-wpzoom' ); ?></label>
									</div>
								</div>
								<div class="wpzoom-floating-option">
									<span class="wpzoom-floating-option-label"><?php esc_html_e( 'Vertical:', 'social-icons-widget-by-wpzoom' ); ?></span>
									<div class="wpzoom-floating-radio-group">
										<label><input type="radio" disabled /> <?php esc_html_e( 'Top', 'social-icons-widget-by-wpzoom' ); ?></label>
										<label><input type="radio" checked disabled /> <?php esc_html_e( 'Middle', 'social-icons-widget-by-wpzoom' ); ?></label>
										<label><input type="radio" disabled /> <?php esc_html_e( 'Bottom', 'social-icons-widget-by-wpzoom' ); ?></label>
									</div>
								</div>
							</div>
						</div>

						<div class="wpzoom-floating-settings-group">
							<label><?php esc_html_e( 'Layout', 'social-icons-widget-by-wpzoom' ); ?></label>
							<div class="wpzoom-floating-radio-group">
								<label><input type="radio" checked disabled /> <?php esc_html_e( 'Vertical', 'social-icons-widget-by-wpzoom' ); ?></label>
								<label><input type="radio" disabled /> <?php esc_html_e( 'Horizontal', 'social-icons-widget-by-wpzoom' ); ?></label>
							</div>
						</div>

						<div class="wpzoom-floating-settings-group">
							<label><?php esc_html_e( 'Show On', 'social-icons-widget-by-wpzoom' ); ?></label>
							<div class="wpzoom-floating-checkbox-group">
								<label><input type="checkbox" checked disabled /> <?php esc_html_e( 'Posts', 'social-icons-widget-by-wpzoom' ); ?></label>
								<label><input type="checkbox" checked disabled /> <?php esc_html_e( 'Pages', 'social-icons-widget-by-wpzoom' ); ?></label>
								<label><input type="checkbox" disabled /> <?php esc_html_e( 'Front Page', 'social-icons-widget-by-wpzoom' ); ?></label>
							</div>
						</div>

						<div class="wpzoom-floating-settings-group">
							<label><?php esc_html_e( 'Mobile Settings', 'social-icons-widget-by-wpzoom' ); ?></label>
							<div class="wpzoom-floating-checkbox-group">
								<label><input type="checkbox" checked disabled /> <?php esc_html_e( 'Show on mobile devices', 'social-icons-widget-by-wpzoom' ); ?></label>
							</div>
							<div class="wpzoom-floating-input-group">
								<span><?php esc_html_e( 'Mobile breakpoint:', 'social-icons-widget-by-wpzoom' ); ?></span>
								<input type="text" value="768" disabled /> px
							</div>
						</div>
					</div>


				</div>

				<!-- Upgrade Overlay -->
				<div class="wpzoom-pro-overlay">
					<div class="wpzoom-pro-overlay-content">
						<span class="wpzoom-pro-badge-large"><?php esc_html_e( 'Pro Feature', 'social-icons-widget-by-wpzoom' ); ?></span>
						<h2><?php esc_html_e( 'Unlock Floating Buttons', 'social-icons-widget-by-wpzoom' ); ?></h2>
						<p><?php esc_html_e( 'Display your social sharing icons as a fixed floating bar on the side of your website. Visitors can share your content from anywhere on the page without scrolling back to find the share buttons.', 'social-icons-widget-by-wpzoom' ); ?></p>
						<ul class="wpzoom-pro-features-list">
							<li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Fixed position on screen edge', 'social-icons-widget-by-wpzoom' ); ?></li>
							<li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Configurable position (left/right, top/middle/bottom)', 'social-icons-widget-by-wpzoom' ); ?></li>
							<li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Vertical or horizontal layout', 'social-icons-widget-by-wpzoom' ); ?></li>
							<li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Show on specific post types', 'social-icons-widget-by-wpzoom' ); ?></li>
							<li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Mobile-responsive with custom breakpoint', 'social-icons-widget-by-wpzoom' ); ?></li>
							<li><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Works with all sharing platforms', 'social-icons-widget-by-wpzoom' ); ?></li>
						</ul>
						<a href="<?php echo esc_url( $upgrade_url ); ?>" class="button button-primary button-hero" target="_blank">
							<?php esc_html_e( 'Upgrade to Pro', 'social-icons-widget-by-wpzoom' ); ?>
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

// Initialize the class.
WPZOOM_Floating_Buttons_Upsell::get_instance();
