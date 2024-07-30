<?php  
	$user_id = get_current_user_id();
    $billing_first_name = get_user_meta($user_id, 'billing_first_name', true );
    $billing_last_name = get_user_meta($user_id, 'billing_last_name', true );
    $dob_date = get_user_meta($user_id, 'dob_date', true );
    $dob_month = get_user_meta($user_id, 'dob_month', true );
    $dob_year = get_user_meta($user_id, 'dob_year', true );
    $billing_address_2 = get_user_meta($user_id, 'billing_address_2', true );
    $billing_city = get_user_meta($user_id, 'billing_city', true );
    $billing_phone = get_user_meta($user_id, 'billing_phone', true );
    $billing_email = get_user_meta($user_id, 'billing_email', true );
    $billing_address_1 = get_user_meta($user_id, 'billing_address_1', true );
    $billing_state = get_user_meta($user_id, 'billing_state', true );
    $billing_country = get_user_meta($user_id, 'billing_country', true );
    $billing_postcode = get_user_meta($user_id, 'billing_postcode', true );
	$cities = get_all_cities();
	$districts = get_all_district();
	$villages = get_all_village();

	$array_address = array();
    if($billing_address_1){
    	$array_address[] = $billing_address_1;
    }
    if($billing_address_2){
    	if($billing_country == 'VN' && get_name_village($billing_address_2)){
    		$array_address[] = get_name_village($billing_address_2);
    	}else{
        	$array_address[] = $billing_address_2;
        }
    }
    if($billing_city){
    	if(get_name_district($billing_city)){
    		$array_address[] = get_name_district($billing_city);
    	}else{
        	$array_address[] = $billing_city;
        }
    }
    if($billing_state){
    	if(get_name_city($billing_state)){
    		$array_address[] = get_name_city($billing_state);
    	}elseif(WC()->countries->get_states( $billing_country )[$billing_state]){
    		$array_address[] = WC()->countries->get_states( $billing_country )[$billing_state];
    	}else{
        	$array_address[] = $billing_state;
        }
    }
    if($billing_country){
    	$array_address[] = WC()->countries->countries[$billing_country];
    }
    if($billing_postcode){
    	$array_address[] = $billing_postcode;
    }
?>
<div class="wrap-account-info">
	<div class="account-info_item user-info">
		<div class="user-info_content">
			<p><?php echo $billing_first_name.' '.$billing_last_name; ?></p>
			<p><?php echo $dob_date; ?>/<?php echo $dob_month; ?>/<?php echo $dob_year; ?></p>
			<p><?php echo $billing_phone; ?></p>
			<p><?php echo $billing_email; ?></p>
		</div>
		<span class="edit-btn edit-user-info" data-popup="popup-user-info">Edit</span>
	</div>

	<div class="account-info_item user-address">
		<div class="user-address_content">
			<p><?php echo join(", ",$array_address); ?></p>
			<p>*Shipping address</p>
		</div>
		<span class="edit-btn edit-address" data-popup="popup-user-address">Edit address</span>
	</div>

	<div class="account-info_item user-pw">
		<div class="user-pw_content">
			<p>Password ••••••••</p>
		</div>
		<span class="edit-btn edit-pw" data-popup="popup-user-pw">Edit</span>
	</div>
</div>

<?php //popup_user_info(); ?>

<?php popup_user_address(); ?>

<?php //popup_user_password(); ?>

<style type="text/css">
	p.input-item input{border-bottom: 1px solid black !important;width: 100% !important;padding: 10px 0 !important;outline: none !important;display: block !important;height: auto !important;clip: unset !important;position: relative !important;margin: 0 !important;overflow: visible !important;}

	p.input-item select {
	    width: 100% !important;
	    border-bottom: 1px solid black !important;
	    padding: 10px 0 !important;
	    display: block !important;
	    position: relative !important;
	    margin: 0 !important;
	    overflow: visible !important;
	    height: auto !important;
	    clip: unset !important;
	}
</style>