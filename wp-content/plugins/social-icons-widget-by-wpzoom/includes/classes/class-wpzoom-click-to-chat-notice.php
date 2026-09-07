<?php
/**
 * Click to Chat Admin Notice
 *
 * Registers the Click to Chat notice with WPZOOM Notice Center when available.
 *
 * @package WPZOOM_Social_Icons
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WPZOOM_Click_To_Chat_Notice
 */
class WPZOOM_Click_To_Chat_Notice {

	/**
	 * Notice ID for Notice Center
	 *
	 * @var string
	 */
	const NOTICE_ID = 'wpzoom_click_to_chat';

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_filter( 'wpzoom_notice_center_notices', array( $this, 'register_notice_center' ) );
	}

	/**
	 * Register the Click to Chat notice with WPZOOM Notice Center.
	 *
	 * @param array $notices Existing notices from the filter.
	 * @return array Notices with the Click to Chat notice added when applicable.
	 */
	public function register_notice_center( $notices ) {
		if ( ! is_array( $notices ) ) {
			$notices = array();
		}

		// Only encourage enabling while the feature is still off.
		if ( class_exists( 'WPZOOM_Click_To_Chat' ) ) {
			$settings = WPZOOM_Click_To_Chat::get_settings();
			if ( ! empty( $settings['enabled'] ) ) {
				return $notices;
			}
		}

		$configure_url = admin_url( 'edit.php?post_type=wpzoom-shortcode&page=wpzoom-click-to-chat' );

		$content  = '<p>' . esc_html__( 'Let visitors reach you instantly! Add a floating Click to Chat button that connects to WhatsApp, Telegram, Messenger and Viber — perfect for turning visitors into customers.', 'social-icons-widget-by-wpzoom' ) . '</p>';

		$notices[] = array(
			'id'             => self::NOTICE_ID,
			'heading'        => __( 'Add a Click to Chat Button to Your Site', 'social-icons-widget-by-wpzoom' ),
			'content'        => $content,
			'icon'           => array(
				'type'             => 'dashicon',
				'src'              => '',
				'dashicon'         => 'dashicons-format-chat',
				'color'            => '#25d366',
				'background_color' => '',
			),
			'primary_button' => array(
				'label'   => __( 'Set Up Click to Chat', 'social-icons-widget-by-wpzoom' ),
				'url'     => $configure_url,
				'new_tab' => false,
			),
			'capability'     => 'manage_options',
			'screens'        => array( 'dashboard', 'plugins', 'edit-wpzoom-shortcode' ),
			'source'         => 'Social Icons & Sharing',
			'priority'       => 14,
		);

		return $notices;
	}
}

new WPZOOM_Click_To_Chat_Notice();
