<?php  
add_filter( 'woocommerce_checkout_fields', 'reorder_checkout_fields' );
 
function reorder_checkout_fields( $fields ) {
 
	$fields['billing']['billing_email']['priority'] = 5;
 	$fields['billing']['billing_city']['priority'] = 45;
 	$fields['billing']['billing_address_1']['priority'] = 90;
  	return $fields;
}


add_action('woocommerce_before_billing', function(){
	if(!is_user_logged_in()){
		echo '
			<div class="for-guest text-center">
				<p class="mb-9 for-guest_ask">Already had an account? <a href="/my-account?redirect_to=/checkout" class="no-underline">Log in</a></p>
				<p class="mb-9 for-guest_or">OR</p>
				<p class="mb-6 for-guest_title">CHECK OUT AS GUEST</p> 
			</div>
		'; 
	}
});

add_action('woocommerce_after_billing', function(){
	echo "
		<span class='gia-btn proceed-btn'>Proceed</span>
		<div class='billing-details' style='display:none'></div>
		<div class='payment-step text-center'>
			<p class='payment-step_title'>Payment</p>
			<p class='payment-step_text'>Payment will be proceeded through a payment gateway for due to security and privacy protection</p>
			<img src=".get_stylesheet_directory_uri().'/assets/images/payment-icon.png'.">

			<button class='gia-btn payment-btn'>Proceed payment</button>
		</div>
	";
},90);

// function update_checkout_fields() {
//     $country = isset($_POST['country']) ? sanitize_text_field($_POST['country']) : '';

//     if ($country == 'VN') {
// 		$billing_city_label = 'District&nbsp;<abbr class="required" title="required">*</abbr>';
// 		$billing_address_2_label = 'Commune/Ward/Town&nbsp;<abbr class="required" title="required">*</abbr>';
//         $billing_city_html = '<select name="billing_city" id="billing_city" class="select2-hidden-accessible"><option value="">Select District</option></select>'; 
//         $billing_address_2_html = '<select name="billing_address_2" id="billing_address_2" class="select2-hidden-accessible"><option value="">Select Commune/Ward/Town</option></select>'; 
//     } else {
// 		$billing_city_label = 'Town / City&nbsp;<abbr class="required" title="required">*</abbr>';
// 		$billing_address_2_label = 'Apartment, suite, unit, etc. (optional)';
//         $billing_city_html = '<input type="text" name="billing_city" id="billing_city" class="input-text" />';
//         $billing_address_2_html = '<input type="text" name="billing_address_2" id="billing_address_2" class="input-text" />';
//     }

//     wp_send_json_success(array(
// 		'billing_city_label' => $billing_city_label,
// 		'billing_address_2_label' => $billing_address_2_label,
//         'billing_city_html' => $billing_city_html,
//         'billing_address_2_html' => $billing_address_2_html
//     ));
// }

// add_action('wp_ajax_update_checkout_fields', 'update_checkout_fields');
// add_action('wp_ajax_nopriv_update_checkout_fields', 'update_checkout_fields');

add_action('woocommerce_checkout_before_order_review_heading', 'order_review_bar_mobile');
function order_review_bar_mobile(){
	$cart_total = WC()->cart->total;
	echo '<div class="review-order-bar-mb hidden justify-between align-center">';
		echo '<span class="view-hide-review-order">VIEW CART</span>';
		echo '<span class="review-order-total-mb">$'.$cart_total.'</span>';
	echo '</div>';
}