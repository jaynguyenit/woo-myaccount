<?php  
	function popup_user_address(){
		$user_id = get_current_user_id();
	    $billing_address_2 = get_user_meta($user_id, 'billing_address_2', true );
	    $billing_city = get_user_meta($user_id, 'billing_city', true );
	    $billing_address_1 = get_user_meta($user_id, 'billing_address_1', true );
	    $billing_state = get_user_meta($user_id, 'billing_state', true );
	    $billing_country = get_user_meta($user_id, 'billing_country', true );
	    $billing_postcode = get_user_meta($user_id, 'billing_postcode', true );
		$cities = get_all_cities();
		$districts = get_all_district();
		$villages = get_all_village();
?>
	<div class="form-popup popup-user-address hidden">
		<div class="form-popup_inner">
			<span class="close-popup">
				<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
				  <path d="M1 1L25 25" stroke="black"/>
				  <path d="M1 25L25 0.999999" stroke="black"/>
				</svg>
			</span>

			<div class="wp-message text-center"></div>

			<p class="input-item">
		        <?php  
		        	global $woocommerce;
				    $wc_countries   = new WC_Countries();
				    $countries   = $wc_countries->__get('countries');
				    
				    if($countries){
				    	echo '<select id="billing_country" name="country" class="woocommerce-Input woocommerce-Select">';
		        			foreach($countries as $key => $value){
		        				$selected = ($billing_country == $key) ? 'selected' : '';
		        				echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
		        			}
		        		echo '</select>';
				    }
		        ?>
		    </p> 
		     <p class="input-item">
		    	<select id="billing_state" name="billing_state">
				    <option value="">Select City</option>
				   	<?php
			            foreach ($cities as $key => $value) {
			                $selected = ($key === $billing_state) ? 'selected' : '';
			                echo "<option value='$key' $selected>$value</option>";
			            }
		            ?>
				</select>
		    </p>
		    <p class="input-item">
		    	<select id="billing_city" name="billing_city">
				    <option value="">Select District</option>
				    <?php
			            $selectedQuanHuyen = array_filter($districts, function($item) use ($billing_state) {
					        return $item['matp'] === $billing_state;
					    });

			            foreach ($selectedQuanHuyen as $key => $value) {
			                $selected = ($value['maqh'] === $billing_city) ? 'selected' : '';
			                echo "<option value='$key' $selected>{$value['name']}</option>";
			            }
		            ?>
				</select>
		    </p>
		    <p class="input-item">
		    	<select id="billing_address_2" name="billing_address_2">
				    <option value="">Select Commune/Ward/Town</option>
			     	<?php
			            $selectedXaPhuong = array_filter($villages, function($item) use ($billing_city) {
					        return $item['maqh'] === $billing_city;
					    });

			            foreach ($selectedXaPhuong as $key => $value) {
			                $selected = ($value['xaid'] === $billing_address_2) ? 'selected' : '';
			                echo "<option value='$key' $selected>{$value['name']}</option>";
			            }
		            ?>
				</select>
		    </p>
		    <p class="input-item">
		        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_address_1" placeholder="House number and street name" value="<?php echo $billing_address_1; ?>" />
		    </p>

		    <p class="input-item">
		        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_postcode" placeholder="Postcode" value="<?php echo $billing_postcode; ?>" />
		    </p>

		    <input type="submit" class="black-btn update-user-address" name="register" value="Save information"  />
		</div>
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

			$('#billing_country').change(function() {
				var current_popup = $(this).closest('.form-popup_inner');
		        var country = $(this).val();
		        var data = {
		            'action': 'get_states_by_country',
		            'country': country
		        };
		        current_popup.addClass('loading');
		        $.ajax({
		            url: ajaxurl,
		            type: 'POST',
		            data: data,
		            success: function(response) {
		            	if (response && response.states !== undefined) {
		            		if(country == 'VN'){
		            			$('#billing_state').replaceWith('<select id="billing_state" name="billing_state"></select>');
		            			$('#billing_city').replaceWith('<select id="billing_city" name="billing_city"><option value="">Select District</option></select>');
		            			$('#billing_address_2').replaceWith('<select id="billing_address_2" name="billing_address_2"><option value="">Select Commune/Ward/Town</option></select>');
		            			$('#billing_state').html(response.states);
		            		}else if(country == 'AU'){
		            			$('#billing_state').replaceWith('<select id="billing_state" name="billing_state"></select>');
		            			$('#billing_city').replaceWith('<input type="text" name="billing_city" id="billing_city" placeholder="Suburb" />');
			                	$('#billing_address_2').replaceWith('<input class="hidden" type="text" name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit, etc." />');;
		            			$('#billing_state').html(response.states);
		            		} else {
			                	$('#billing_state').replaceWith('<select id="billing_state" name="billing_state"></select>');
			                	$('#billing_city').replaceWith('<input type="text" name="billing_city" id="billing_city" placeholder="Town/City" />');
			                	$('#billing_address_2').replaceWith('<input class="hidden" type="text" name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit, etc." />');
			                    $('#billing_state').html(response.states);
			                }
			            }else{
			            	$('#billing_state').replaceWith('<input type="text" name="billing_state" id="billing_state" placeholder="State/County" />');
		                    $('#billing_city').replaceWith('<input type="text" name="billing_city" id="billing_city" placeholder="Town/City" />');
		                    $('#billing_address_2').replaceWith('<input class="hidden" type="text" name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit, etc." />');
			            }
			            current_popup.removeClass('loading');
		            },
		            error: function() {
		                console.log('Error occurred.');
		                current_popup.removeClass('loading');
		            }
		        });
		    });

		    $(document).on('change','#billing_state', function() {
			    var selectedState = $(this).val();
			    $('#billing_city').html("<option value=''>Select District</option>");
			    $('#billing_address_2').html("<option value=''>Select Commune/Ward/Town</option>");

			    if (selectedState !== "") {
			        <?php foreach ($districts as $key => $value) { ?>
			            if ("<?php echo $value['matp']; ?>" === selectedState) {
			                $('#billing_city').append("<option value='<?php echo $key; ?>'><?php echo $value['name']; ?></option>");
			            }
			        <?php } ?>
			    }
			});

			$(document).on('change', '#billing_city', function() {
			    var selectedCity = $(this).val();
			    $('#billing_address_2').html("<option value=''>Select Commune/Ward/Town</option>");

			    if (selectedCity !== "") {
			        <?php foreach ($villages as $key => $value) { ?>
			            if ("<?php echo $value['maqh']; ?>" === selectedCity) {
			                $('#billing_address_2').append("<option value='<?php echo $key; ?>'><?php echo $value['name']; ?></option>");
			            }
			        <?php } ?>
			    }
			});

			$(document).on('click', '.edit-address', function() {
				var current_popup = $(this).closest('.form-popup_inner');
		    	var country = $('select[name="country"]').val();
		    	if(country == 'VN'){
		    		return;
		    	}
		    	var state = '<?php echo $billing_state; ?>';
		        var data = {
		            'action': 'get_states_by_country',
		            'country': country,
		            'state': state
		        };
		        current_popup.addClass('loading');
		        $.ajax({
		            url: ajaxurl,
		            type: 'POST',
		            data: data,
		            success: function(response) {
		            	if (response && response.states !== undefined) {
		            		if(country == 'VN'){
		            			$('#billing_state').replaceWith('<select id="billing_state" name="billing_state"></select>');
		            			$('#billing_city').replaceWith('<select id="billing_city" name="billing_city"><option value="">Select District</option></select>');
		            			$('#billing_address_2').replaceWith('<select id="billing_address_2" name="billing_address_2"><option value="">Select Commune/Ward/Town</option></select>');
		            			$('#billing_state').html(response.states);
		            		}else if(country == 'AU'){
		            			$('#billing_state').replaceWith('<select id="billing_state" name="billing_state"></select>');
		            			$('#billing_city').replaceWith('<input type="text" name="billing_city" id="billing_city" placeholder="Suburb" />');
			                	$('#billing_address_2').replaceWith('<input class="hidden" type="text" name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit, etc." />');;
		            			$('#billing_state').html(response.states);
		            		} else {
			                	$('#billing_state').replaceWith('<select id="billing_state" name="billing_state"></select>');
			                	$('#billing_city').replaceWith('<input type="text" name="billing_city" id="billing_city" placeholder="Town/City" value="<?php echo $billing_city; ?>" />');
			                	$('#billing_address_2').replaceWith('<input class="hidden" type="text" name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit, etc." value="<?php echo $billing_address_2; ?>" />');
			                    $('#billing_state').html(response.states);
			                }
			            }else{
			            	$('#billing_state').replaceWith('<input type="text" name="billing_state" id="billing_state" placeholder="State/County" value="<?php echo $billing_state; ?>" />');
		                    $('#billing_city').replaceWith('<input type="text" name="billing_city" id="billing_city" placeholder="Town/City" value="<?php echo $billing_city; ?>" />');
		                	$('#billing_address_2').replaceWith('<input class="hidden" type="text" name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit, etc." value="<?php echo $billing_address_2; ?>" />');
			            }
			            current_popup.removeClass('loading');
		            },
		            error: function() {
		            	current_popup.removeClass('loading');
		                console.log('Error occurred.');
		            }
		        });
		    });
		});
	</script>
<?php } ?>