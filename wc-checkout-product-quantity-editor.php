<?php
/**
 * @package Woocommcerce checkout product quantity change
 */
/*
Plugin Name:  Woocommcerce checkout product quantity change
Plugin URI: https://github.com/deepintowp/woocommcerce-checkout-product-quantity-change
Description:  This plugin will allow user to change product quantity on checkout field. 
Version: 1.0.0
Author: Subhasish Manna
Author URI: http://subhasishmanna.com
License: GPLv2 or later
Text Domain: cqe
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}
/*****************************************
CHECK WORDPRESS WERSION
*****************************************/
if ( version_compare( get_bloginfo('version'), '4.0', '<') )  {
    $message = "WordPress version is lower than 4.0.Need WordPress version 4.0 or higher.";
	die($message);
}

/*********
constants
**********/
define( 'CQE_PATH', plugin_dir_path(__FILE__)   );
define( 'CQE_URI', plugin_dir_url( __FILE__ )   );

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    
    	class CQE_Core{
    		public function __construct(){
    			/**
    			 * Include Files
    			 */
				 require(CQE_PATH.'/classes/CQE_add_quantity.php');
				 require(CQE_PATH.'/classes/CQE_enqueue.php');
				 require(CQE_PATH.'/classes/CQE_ajax.php');
				 
				 
				

    			/**
    			 * HOOKS 
    			 */
				add_filter ('woocommerce_cart_item_name',  array( new CQE_add_quantity(), 'cqe_add_quantity_field'), 10, 3 );
				add_filter ('woocommerce_checkout_cart_item_quantity', array( new CQE_add_quantity(), 'cqoc_add_quantity'), 10, 2 );
				add_action( 'wp_footer', array( new CQE_enqueue(), 'cqe_footer_enqueue'), 100 );
				add_action( 'wp_enqueue_scripts', array( new CQE_enqueue(), 'cqe_checkout_style'), 100 );
				add_action( 'wp_ajax_nopriv_cqe_update_order_review', array( new CQE_ajax(), 'cqe_update_order_review' ) );
                add_action( 'wp_ajax_nopriv_cqe_remove_product_fromorder_review',  array( new CQE_ajax(), 'cqe_remove_product_fromorder_review' ) );
				add_action( 'wp_ajax_cqe_update_order_review',     array( new CQE_ajax(), 'cqe_update_order_review' ));
                add_action( 'wp_ajax_cqe_remove_product_fromorder_review',  array( new CQE_ajax(), 'cqe_remove_product_fromorder_review') );
    		}
    	}
    	$cqe_init = new CQE_Core();
   
}

