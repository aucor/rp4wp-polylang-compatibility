<?php
/*
Plugin Name: Related Posts for WordPress - Polylang Compatibility
Plugin URI: https://github.com/aucor/
Version: 1.0
Author: Aucor Oy
Author URI: http://www.aucor.fi/
Description: Add Polylang support to Related Posts for WordPress Premium
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) or die( 'Get out of here stalker!' );

class RP4WP_Polylang {

	/**
	 * Constructor
	 */
	public function __construct() {
		if ( $this->check_dependencies() ) {
			$this->setup();
		}
	}

	/**
	 * Dependency RP4WP notice
	 */
	public function dep_notice_rp4wp() {
		?>
		<div id="message" class="error"><p><strong><a
						href="https://www.relatedpostsforwp.com/?utm_source=rp4wp-polylang-compatibility&utm_medium=link&utm_campaign=notice"
						target="_blank">Related Posts for WordPress Premium</a> 1.3.3 or higher</strong> must be
				installed and activated to use <strong>Related Posts for WordPress - Polylang Compatibility</strong>.</p>
		</div><?php
	}

	/**
	 * Dependency Polylang notice
	 */
	public function dep_notice_polylang() {
		?>
		<div id="message" class="error"><p><strong>Polylang</strong> must be installed and activated to use <strong>Related
					Posts for WordPress - Polylang Compatibility</strong>.</p></div><?php
	}

	/**
	 * Check plugin dependencies
	 *
	 * @return bool
	 */
	private function check_dependencies() {

		// Check RP4WP
		if ( ! defined( 'RP4WP_PLUGIN_FILE' ) || ! defined( 'RP4WP_Constants::PREMIUM' ) || true !== RP4WP_Constants::PREMIUM ) {
			add_action( 'admin_notices', array( $this, 'dep_notice_rp4wp' ) );

			return false;
		}

		// Check Polylang
		if ( ! function_exists('pll_register_string') ) {
			add_action( 'admin_notices', array( $this, 'dep_notice_polylang' ) );

			return false;
		}

		return true;
	}

	/**
	 * Setup method
	 */
	private function setup() {
		add_filter( 'rp4wp_get_related_posts_sql', array( $this, 'filter_related_posts_sql' ), 10, 4 );
	}

	/**
	 * Add language to related posts fetch SQL so we only fetch posts of current post's language
	 *
	 * @param String $sql
	 * @param int $post_id
	 * @param String $post_type
	 * @param int $limit
	 *
	 * @return String
	 */
	public function filter_related_posts_sql( $sql, $post_id, $post_type, $limit ) {
		global $wpdb;

			$sql_replace = "
		INNER JOIN " . $wpdb->term_relationships . " ON (R.`post_id` = " . $wpdb->term_relationships . ".object_id)
		INNER JOIN " . $wpdb->term_taxonomy . " ON (" . $wpdb->term_relationships . ".term_taxonomy_id = " . $wpdb->term_taxonomy . ".term_taxonomy_id)
		WHERE 1=1
		AND " . $wpdb->term_taxonomy . ".taxonomy = 'language'
		AND " . $wpdb->term_taxonomy . ".term_id IN ( SELECT TT.term_id FROM " . $wpdb->term_taxonomy . " TT INNER JOIN " . $wpdb->term_relationships . " TR ON TR.term_taxonomy_id = TT.term_taxonomy_id WHERE TR.object_id = " . $post_id . " )
		";

		return str_ireplace( 'WHERE 1=1', $sql_replace, $sql );
	}
}

function __rp4wp_polylang_main() {
	new RP4WP_Polylang();
}

add_action( 'plugins_loaded', '__rp4wp_polylang_main', 20 );
