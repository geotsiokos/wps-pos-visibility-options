<?php
/**
 * Plugin Name: WPS POS Visibility Options
 * Plugin URI: https://github.com/geotsiokos/wps-pos-visibility-options/blob/master/wps-pos-visibility-options.php
 * Description: Exclude POS-only products from search results when using the Product Search Field by <a href="https://woo.com/products/woocommerce-product-search/">WooCommerce Product Search</a> and Point of Sale for WooCommerce
 * Version: 1.0.0
 * Author: gtsiokos
 * Author URI: http://www.netpad.gr
 * Donate-Link: http://www.netpad.gr
 * License: GPLv3
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}
class WPS_Pos_Visibility_Options {
	
	public static function init() {
		if ( defined( 'WC_POS_VERSION' ) ) {
			add_action('woocommerce_product_search_service_post_ids_for_request', array( __CLASS__, 'woocommerce_product_search_service_post_ids_for_request' ), 10, 2 );
		}
	}

	public static function woocommerce_product_search_service_post_ids_for_request( &$product_ids, $context ) {
		if ( 'yes' === get_option( 'wc_pos_visibility', 'no' ) ) {
			foreach ( $product_ids as $key => $product_id ) {
				$pos_visibility = get_post_meta( $product_id, '_pos_visibility', true );
				if ( $pos_visibility ) {
					if ( $pos_visibility === 'pos' ) {
						unset( $product_ids[$key] );
					}
				}
			}
		}
	}
} WPS_Pos_Visibility_Options::init();