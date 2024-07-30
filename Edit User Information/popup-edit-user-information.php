<?php function popup_user_info(){ 
	$user_id = get_current_user_id();
    $billing_first_name = get_user_meta($user_id, 'billing_first_name', true );
    $billing_last_name = get_user_meta($user_id, 'billing_last_name', true );
    $dob_date = get_user_meta($user_id, 'dob_date', true );
    $dob_month = get_user_meta($user_id, 'dob_month', true );
    $dob_year = get_user_meta($user_id, 'dob_year', true ); 
    $billing_phone = get_user_meta($user_id, 'billing_phone', true );
    $billing_email = get_user_meta($user_id, 'billing_email', true );
?>
	<div class="form-popup popup-user-info hidden">
		<div class="form-popup_inner">
			<span class="close-popup">
				<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
				  <path d="M1 1L25 25" stroke="black"/>
				  <path d="M1 25L25 0.999999" stroke="black"/>
				</svg>
			</span>
			<div class="wp-message text-center"></div>
			<p class="input-item">
		        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="first_name" placeholder="First Name" value="<?php echo $billing_first_name; ?>" />
		    </p>
		    <p class="input-item">
		        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="last_name" placeholder="Last Name" value="<?php echo $billing_last_name; ?>" />
		    </p>
		    <p class="input-item register-dob flex gap-6">
		        <input type="tel" class="woocommerce-Input woocommerce-Input--text input-text" name="dob_date" placeholder="Date" value="<?php echo $dob_date; ?>" />
		        <input type="tel" class="woocommerce-Input woocommerce-Input--text input-text" name="dob_month" placeholder="Month" value="<?php echo $dob_month; ?>" />
		        <input type="tel" class="woocommerce-Input woocommerce-Input--text input-text" name="dob_year" placeholder="Year" value="<?php echo $dob_year; ?>" />
		    </p>
		    <p class="input-item">
		        <input type="tel" class="woocommerce-Input woocommerce-Input--text input-text" name="phone" placeholder="Phone Number" value="<?php echo $billing_phone; ?>" />
		    </p>
		    <p class="input-item">
		        <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" placeholder="Email" value="<?php echo $billing_email; ?>" />
		    </p>

		    <input type="submit" class="black-btn update-user-info" name="register" value="Save information"  />
		</div>
	</div>
<?php } ?>