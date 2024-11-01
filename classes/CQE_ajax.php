<?php 
/**
 * @package Woocommcerce checkout product quantity change
 */

	class CQE_ajax{
		/*
		* Ajax function for update order
		*/
	public	function cqe_update_order_review() {
             
            $values = array();
            parse_str($_POST['post_data'], $values);
            $cart = $values['cart'];
            foreach ( $cart as $cart_key => $cart_value ){
                WC()->cart->set_quantity( $cart_key, $cart_value['qty'], false );
                WC()->cart->calculate_totals();
                woocommerce_cart_totals();
            }
            exit;
        }
		/*
		* Ajax function for remove product from checkout form
		*/	
		
	public  function cqe_remove_product_fromorder_review() {
				 
	$cart = WC()->instance()->cart;
	$product_id = 	$_POST['post_data']['product_id'];	
	$cart_id = $cart->generate_cart_id($product_id);
	$cart_item_id = $cart->find_product_in_cart($cart_id);

	if($cart_item_id){
	   $cart->set_quantity($cart_item_id, 0);
	}
	return true;
		}
		
	}
	
