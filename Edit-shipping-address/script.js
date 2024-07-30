function validateUserAddress() {
  var count_error = 0;

  const billing_address_1 = $('input[name="billing_address_1"]');
  if (billing_address_1.val() === "") {
    add_span_error("Please fill in the blank field!", billing_address_1);
    count_error++;
  } else {
    remove_span_error(billing_address_1);
  }

  if ($("#billing_address_2").is("select")) {
    var billing_address_2 = $(
      '.popup-user-address select[name="billing_address_2"]'
    );
    if (billing_address_2.val() === "") {
      add_span_error(
        "Please select a Commune/Ward/Town!",
        billing_address_2
      );
      count_error++;
    } else {
      remove_span_error(billing_address_2);
    }
  } else {
    var billing_address_2 = $(
      '.popup-user-address input[name="billing_address_2"]'
    );
    if (billing_address_2.val() === "") {
      add_span_error(
        "Please fill in the blank field!",
        billing_address_2
      );
      count_error++;
    } else {
      remove_span_error(billing_address_2);
    }
  }

  if ($("#billing_city").is("select")) {
    var district = $('.popup-user-address select[name="billing_city"]');
    if (district.val() === "") {
      add_span_error("Please select a district!", district);
      count_error++;
    } else {
      remove_span_error(district);
    }
  } else {
    var district = $('.popup-user-address input[name="billing_city"]');
    if (district.val() === "") {
      add_span_error("Please fill in the blank field!", district);
      count_error++;
    } else {
      remove_span_error(district);
    }
  }

  if ($("#billing_state").is("select")) {
    var city = $('.popup-user-address select[name="billing_state"]');
    if (city.val() === "") {
      add_span_error("Please select a state!", city);
      count_error++;
    } else {
      remove_span_error(city);
    }
  } else {
    var city = $('.popup-user-address input[name="billing_state"]');
    if (city.val() === "") {
      add_span_error("Please fill in the blank field!", city);
      count_error++;
    } else {
      remove_span_error(city);
    }
  }

  if (count_error == 0) {
    return true;
  }
}

$(document).on("click", ".update-user-address", function (event) {
  event.preventDefault();
  $(".wp-message").text("");
  var current_popup = $(this).closest(".form-popup_inner");
  const billing_address_1 = $(
    '.popup-user-address input[name="billing_address_1"]'
  ).val();
  const country = $('.popup-user-address select[name="country"]').val();
  const country_label = $(
    '.popup-user-address select[name="country"] option:selected'
  ).text();

  var content = [];
  if (billing_address_1) {
    content.push(billing_address_1);
  }
  if ($("#billing_address_2").is("select")) {
    var ward = $(
      '.popup-user-address select[name="billing_address_2"]'
    ).val();
    var ward_label = $(
      '.popup-user-address select[name="billing_address_2"] option:selected'
    ).text();
  } else {
    var ward = $(
      '.popup-user-address input[name="billing_address_2"]'
    ).val();
    var ward_label = ward;
  }
  if (ward_label) {
    content.push(ward_label);
  }

  if ($("#billing_city").is("select")) {
    var district = $(
      '.popup-user-address select[name="billing_city"]'
    ).val();
    var district_label = $(
      '.popup-user-address select[name="billing_city"] option:selected'
    ).text();
  } else {
    var district = $(
      '.popup-user-address input[name="billing_city"]'
    ).val();
    var district_label = district;
  }
  if (district_label) {
    content.push(district_label);
  }

  if ($("#billing_state").is("select")) {
    var city = $(
      '.popup-user-address select[name="billing_state"]'
    ).val();
    var city_label = $(
      '.popup-user-address select[name="billing_state"] option:selected'
    ).text();
  } else {
    var city = $('.popup-user-address input[name="billing_state"]').val();
    var city_label = city;
  }
  if (city_label) {
    content.push(city_label);
  }

  if (country_label) {
    content.push(country_label);
  }

  const billing_postcode = $(
    '.popup-user-address input[name="billing_postcode"]'
  ).val();
  if (billing_postcode) {
    content.push(billing_postcode);
  }

  if (validateUserAddress()) {
    current_popup.addClass("loading");
    $.ajax({
      type: "POST",
      url: woocommerce_params.ajax_url,
      data: {
        action: "update_user_address",
        address: billing_address_1,
        ward: ward,
        district: district,
        city: city,
        country: country,
        postcode: billing_postcode,
      },
      success: function (response) {
        if (response) {
          if (response == "success") {
            message = "Shipping address updated!";
            current_popup.removeClass("loading");
            $(".user-address_content").html(`
                                  <p>
                                      ${content.join(", ")}
                                  </p>
                                  <p>*Shipping address</p>
                              `);
          }
          $(".wp-message").html(message);
          //scroll_to_element($('.wp-message'));
        }
      },
    });
  }
});
