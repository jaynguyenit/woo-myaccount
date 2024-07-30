<?php
add_action('wp_ajax_update_user_info', 'update_user_info');
add_action('wp_ajax_nopriv_update_user_info', 'update_user_info');
function update_user_info() {
    global $wpdb;
    $user_id = get_current_user_id();
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $dob_date = sanitize_text_field($_POST['dob_date']);
    $dob_month = sanitize_text_field($_POST['dob_month']);
    $dob_year = sanitize_text_field($_POST['dob_year']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);

    $current_email = get_user_meta( $user_id, 'billing_email', true );
    if($email && $email != $current_email){
        if(email_exists( $email )){
            $message = 'This Email is registered!';
        }else{
            update_user_meta($user_id, 'email', $email);
            update_user_meta($user_id, 'billing_email', $email);
        }
    
    }

    $current_phone = get_user_meta( $user_id, 'billing_phone', true );
    if($phone && $phone != $current_phone){
        $exist_phone = $wpdb->get_results('select * from `wp_usermeta` where meta_key = "billing_phone" and meta_value = "'.$phone.'"');
        if($exist_phone){
           $message = 'Mobile number already exist.';
        }else{
            update_user_meta($user_id, 'billing_phone', $phone);
        }
    }

    if($first_name){
        update_user_meta($user_id, 'first_name', $first_name);
        update_user_meta($user_id, 'billing_first_name', $first_name);
    }
    if($last_name){
        update_user_meta($user_id, 'last_name', $last_name);
        update_user_meta($user_id, 'billing_last_name', $last_name);
    }
    if($dob_date){
        update_user_meta($user_id, 'dob_date', $dob_date);
    }
    if($dob_month){
        update_user_meta($user_id, 'dob_month', $dob_month);
    }
    if($dob_year){
        update_user_meta($user_id, 'dob_year', $dob_year);
    }

    if($message){
        echo $message;
    }else{
        echo 'success';
    }
    die();
}