<?php
/**
 * @package Woocommcerce checkout product quantity change
 */

	class CQE_add_quantity{
		
	public 	function cqe_add_quantity_field( $product_title, $cart_item, $cart_item_key ) {
			global $woocommerce;
		    /*
		     * add Delete button on woocommerce checkout order preview 
		     */
		    if (  is_checkout() ) {
		        $cart     = WC()->cart->get_cart();
                foreach ( $cart as $cart_key => $cart_value ){
                   if ( $cart_key == $cart_item_key ){
                        $product_id = $cart_item['product_id'];
                        $_product   = $cart_item['data'] ;
						//checking wc version
						if ( version_compare( $woocommerce->version, '3.0', ">=" ) ) {
						
						$crt_url = wc_get_cart_remove_url( $cart_key );
						
						}else{
							
							$crt_url = WC()->cart->get_remove_url( $cart_key );
						}
                        $return_value = sprintf(
                          '<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                          esc_url( $crt_url ),
                          __( 'Remove this item', 'woocommerce' ),
                          esc_attr( $product_id ),
                          esc_attr( $_product->get_sku() )
                        );
                        $return_value_test = '';
                        $return_value .= '&nbsp; <span class = "cqe_product_name" >' . $product_title . '</span>' ;
                        if ( $_product->is_sold_individually() ) {
                          $return_value .= sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_key );
                        } else {
                          $return_value .= woocommerce_quantity_input( array(
                              'input_name'  => "cart[{$cart_key}][qty]",
                              'input_value' => $cart_item['quantity'],
                              'pattern' => '[0-9]*',
                              'inputmode' => 'numeric',
                              'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
                              'min_value'   => '1'
                                  ), $_product, false );
                        }
                        return $return_value;
                    }
                }
		    }else{
		        
		        $_product   = $cart_item['data'] ;
		        $product_permalink = $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '';
		        if ( ! $product_permalink ) {
		            $return_value = $_product->get_title() . '&nbsp;';
		        } else {
		            $return_value = sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title());
		        }
		        return $return_value;
		    }
		}
		
		/*
		* Add quantity on checkout order preview
		*/
		public function cqoc_add_quantity( $cart_item, $cart_item_key ) {
    	   $product_quantity= '';
    	   return $product_quantity;
    	}
		
	}
	
	
