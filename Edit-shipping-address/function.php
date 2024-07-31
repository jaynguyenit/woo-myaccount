<?php
<?php  
add_action('wp_ajax_update_user_address', 'update_user_address');
add_action('wp_ajax_nopriv_update_user_address', 'update_user_address');
function update_user_address() {
	global $wpdb;
	$user_id = get_current_user_id();
    $address = sanitize_text_field($_POST['address']);
    $ward = sanitize_text_field($_POST['ward']);
    $district = sanitize_text_field($_POST['district']);
    $city = sanitize_text_field($_POST['city']);
    $country = sanitize_text_field($_POST['country']);
    $postcode = sanitize_text_field($_POST['postcode']);

    if($country){
    	update_user_meta($user_id, 'billing_country', $country);
    }
    if($ward){
    	update_user_meta($user_id, 'billing_address_2', $ward);
    }
    if($district){
    	update_user_meta($user_id, 'billing_city', $district);
    }
    if($billing_address_1){
    	update_user_meta($user_id, 'billing_address_1', $address);
    }
    if($city){
    	update_user_meta($user_id, 'billing_state', $city);
    }
    if($postcode){
    	update_user_meta($user_id, 'billing_postcode', $postcode);
    }

    echo 'success';

    die();
}

// Xử lý AJAX request để lấy danh sách tiểu bang dựa trên quốc gia
add_action('wp_ajax_get_states_by_country', 'get_states_by_country_callback');
add_action('wp_ajax_nopriv_get_states_by_country', 'get_states_by_country_callback');

function get_states_by_country_callback() {
    $country = $_POST['country'];
    $current_state = $_POST['state'];
    
    // Gọi hàm của WooCommerce để lấy danh sách tiểu bang
    $states = WC()->countries->get_states($country);

    // Xây dựng danh sách tiểu bang
    if ($states) {
        $response = array(
            'states' => '<option value="">Select State</option>'
        );
        foreach ($states as $state_key => $state) {
            $selected = '';
            if($current_state == $state_key){
                $selected = 'selected';
            }
            $response['states'] .= '<option value="' . $state_key . '" '.$selected.'>' . $state . '</option>';
        }
    }

    // Trả về phản hồi JSON
    wp_send_json($response);
    wp_die();
}

if( ! function_exists( 'get_thanhpho_quanhuyen' ) ){
	function get_thanhpho_quanhuyen(){
	  $temp2 = array();
	  foreach (array_unique(wp_list_pluck(get_all_district(),'matp')) as $key => $city_code) {
		foreach (get_all_district() as $key => $city) {
		  if( $city['matp'] == $city_code ){
			$temp2[$city_code][$city['maqh']] = $city['name'];
		  }
		}
	  }
	  return $temp2;
	}
  }
  
  function search_in_array($array, $key, $value){
	  $results = array();
  
	  if (is_array($array)) {
		  if (isset($array[$key]) && $array[$key] && $array[$key] == $value) {
			  $results[] = $array;
		  }elseif(isset($array[$key]) && is_serialized($array[$key]) && in_array($value,maybe_unserialize($array[$key]))){
			  $results[] = $array;
		  }
		  foreach ($array as $subarray) {
			  $results = array_merge($results, search_in_array($subarray, $key, $value));
		  }
	  }
  
	  return $results;
  }
  
  function get_all_cities(){
	  include 'cities/tinh_thanhpho.php';
	  return $tinh_thanhpho;
  }
  
  function get_all_district(){
	  include 'cities/quan_huyen.php';
	  return $quan_huyen;
  }
  
  function get_all_village(){
	  include 'cities/xa_phuong_thitran.php';
	  return $xa_phuong_thitran;
  }
  function get_name_city($id = ''){
	  $tinh_thanhpho = get_all_cities();
	  //$id_tinh = sprintf("%02d", intval($id));
	  $tinh_thanhpho = (isset($tinh_thanhpho[$id]))?$tinh_thanhpho[$id]:'';
	  return $tinh_thanhpho;
  }
  
  function get_name_district($id = ''){
	  $quan_huyen = get_all_district();
	  $id_quan = sprintf("%03d", intval($id));
	  if(is_array($quan_huyen) && !empty($quan_huyen)){
		  $nameQuan = search_in_array($quan_huyen,'maqh',$id_quan);
		  $nameQuan = isset($nameQuan[0]['name'])?$nameQuan[0]['name']:'';
		  return $nameQuan;
	  }
	  return false;
  }
  
  function get_name_village($id = ''){
	  $xa_phuong_thitran = get_all_village();
	  $id_xa = sprintf("%05d", intval($id));
	  if(is_array($xa_phuong_thitran) && !empty($xa_phuong_thitran)){
		  $name = search_in_array($xa_phuong_thitran,'xaid',$id_xa);
		  $name = isset($name[0]['name'])?$name[0]['name']:'';
		  return $name;
	  }
	  return false;
  }
