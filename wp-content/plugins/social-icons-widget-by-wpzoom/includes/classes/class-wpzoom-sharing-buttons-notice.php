<?php
/**
 * Sharing Buttons Admin Notice
 *
 * Registers the sharing buttons notice with WPZOOM Notice Center when available.
 *
 * @package WPZOOM_Social_Icons
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WPZOOM_Sharing_Buttons_Notice
 */
class WPZOOM_Sharing_Buttons_Notice {

	/**
	 * Notice ID for Notice Center
	 *
	 * @var string
	 */
	const NOTICE_ID = 'wpzoom_sharing_buttons';

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'wpzoom_notice_center_notices', array( $this, 'register_notice_center' ) );
	}

	/**
	 * Get the sharing config edit URL.
	 *
	 * @return string|false
	 */
	private function get_sharing_config_url() {
		$posts = get_posts(
			array(
				'post_type'      => 'wpzoom-sharing',
				'posts_per_page' => 1,
				'post_status'    => 'publish',
			)
		);

		if ( ! empty( $posts ) ) {
			return admin_url( 'post.php?post=' . $posts[0]->ID . '&action=edit' );
		}

		return false;
	}

	/**
	 * Register the sharing buttons notice with WPZOOM Notice Center.
	 *
	 * @param array $notices Existing notices from the filter.
	 * @return array Notices with sharing notice added when applicable.
	 */
	public function register_notice_center( $notices ) {
		if ( ! is_array( $notices ) ) {
			$notices = array();
		}

		$configure_url = $this->get_sharing_config_url();

		// Only show when at least one sharing config exists.
		if ( ! $configure_url ) {
			return $notices;
		}

		$pro_url = 'https://www.wpzoom.com/plugins/social-share/?utm_source=wpadmin&utm_medium=plugin&utm_campaign=social-icons-free&utm_content=sharing-notice-btn';

		$content  = '<p>' . esc_html__( 'Let your visitors share your content on social media! Enable sharing buttons that appear automatically on all your posts and pages.', 'social-icons-widget-by-wpzoom' ) . '</p>';
		$content .= '<p>';
		$content .= sprintf(
			/* translators: %s: upgrade link */
			esc_html__( 'Want more? %s adds AI Share Buttons, Like Button, Share Counts & Analytics.', 'social-icons-widget-by-wpzoom' ),
			'<a href="https://www.wpzoom.com/plugins/social-share/?utm_source=wpadmin&utm_medium=plugin&utm_campaign=social-icons-free&utm_content=sharing-notice" target="_blank" rel="noopener noreferrer"><strong>' . esc_html__( 'PRO', 'social-icons-widget-by-wpzoom' ) . '</strong></a>'
		);
		$content .= '</p>';

		$notices[] = array(
			'id'               => self::NOTICE_ID,
			'heading'          => __( 'Add Social Sharing Buttons to Your Posts', 'social-icons-widget-by-wpzoom' ),
			'content'          => $content,
			'icon'             => array(
				'type'             => 'dashicon',
				'src'              => '',
				'dashicon'         => 'dashicons-share',
				'color'            => '#3496ff',
				'background_color' => '',
			),
			'primary_button'   => array(
				'label'   => __( 'Configure Sharing Buttons', 'social-icons-widget-by-wpzoom' ),
				'url'     => $configure_url,
				'new_tab' => false,
			),
			'secondary_button' => array(
				'label'   => __( 'Upgrade to Pro', 'social-icons-widget-by-wpzoom' ),
				'url'     => $pro_url,
				'new_tab' => true,
			),
			'capability'       => 'manage_options',
			'screens'          => array( 'dashboard', 'plugins', 'edit-wpzoom-shortcode' ),
			'source'           => 'Social Icons & Sharing',
			'priority'         => 15,
		);

		return $notices;
	}
}

new WPZOOM_Sharing_Buttons_Notice();
