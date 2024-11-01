<?php 
/**
 * @package Woocommcerce checkout product quantity change
 */

	class CQE_enqueue{
		
		/*
		* Add Script in footer
		*/
		public function cqe_footer_enqueue(){
    	     
            if (  is_checkout() ) {
			
    		
			
            ?>
                <script type="text/javascript">
					
                    <?php  $admin_url = get_admin_url(); ?>
					jQuery("form.checkout").on("change", "input.qty", function(){
                        var __that  = jQuery(this);
                        var data = {
                    		action: 'cqe_update_order_review',
                    		security: wc_checkout_params.update_order_review_nonce,
                    		post_data: jQuery( 'form.checkout' ).serialize()
                    	};
						
						var qty = jQuery( 'form.checkout' ).find('input.qty').val();
						
						//check if vaue is float
						if(qty % 1 !== 0){
							__that.css('border', '1px solid red');
						  return;
					   }
						
                    	jQuery.post( '<?php echo $admin_url; ?>' + 'admin-ajax.php', data, function( response )
                		{
                            jQuery( 'body' ).trigger( 'update_checkout' );
						});
                    });
					jQuery("form.checkout").on("click", "tr.cart_item a.remove", function(event){
                        event.preventDefault();
                        var data = {
                    		action: 'cqe_remove_product_fromorder_review',
                    		security: wc_checkout_params.update_order_review_nonce,
                    		post_data: {'product_id' : jQuery(this).attr('data-product_id')}
                    	};
						
                    	jQuery.post( '<?php echo $admin_url; ?>' + 'admin-ajax.php', data, function( response )
                		{
                            jQuery( 'body' ).trigger( 'update_checkout' );
							//console.log(response);
						});
                    });
					
                </script>
             <?php  
             }
        } 
		
		/*
		* Add Stylsheet for plugin
		*/
		public function cqe_checkout_style(){
			  if (  is_checkout() ) {
				wp_enqueue_style('cqe_style', CQE_URI.'css/checkout.css', array('woocommerce-general') );
			  }
		}
		
		
		
	}
	
