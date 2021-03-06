<?php

/**
 * This controller extends all post edit pages
 *
 * @since 2.0
 */
final class Types_Page_Extension_Edit_Post {

	private static $instance;

	public static function get_instance() {
		if( null == self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		$post = wpcf_admin_get_edited_post();
		$post_type = wpcf_admin_get_edited_post_type( $post );

		// if no post or no page
		if( $post_type != 'post' && $post_type != 'page' ) {
			$custom_types = get_option( WPCF_OPTION_NAME_CUSTOM_TYPES, array() );

			// abort if also no custom post type of types
			if( ! array_key_exists( $post_type, $custom_types ) )
				return false;
		}

		$this->prepare();
	}

	private function __clone() { }


	public function prepare() {
		// documentation urls
		$documentation_urls = include( TYPES_DATA . '/information/documentation-urls.php' );

		// add links to use analytics
		Types_Helper_Url::add_urls( $documentation_urls );

		// set analytics medium
		Types_Helper_Url::set_medium( 'post_editor' );

		// add informations
		$this->prepare_informations();

		// @todo load scripts
		if( function_exists( 'wpcf_edit_post_screen_scripts' ) )
			wpcf_edit_post_screen_scripts();
	}

	private function prepare_informations() {
		$information = new Types_Information_Controller;
		$information->prepare();
	}
}