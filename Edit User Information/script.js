$(document).on("click", ".update-user-info", function (event) {
  event.preventDefault();
  $(".wp-message").text("");
  var current_popup = $(this).closest(".form-popup_inner");
  const firstName = $('.popup-user-info input[name="first_name"]');
  const lastName = $('.popup-user-info input[name="last_name"]');
  const dob_date = $('.popup-user-info input[name="dob_date"]');
  const dob_month = $('.popup-user-info input[name="dob_month"]');
  const dob_year = $('.popup-user-info input[name="dob_year"]');
  const email = $('.popup-user-info input[name="email"]');
  const phone = $('.popup-user-info input[name="phone"]');
  const tele = $('.popup-user-info input[name="tele"]');

  var message = "";
  var count_error = 0;

  if (firstName.val() === "") {
    add_span_error("Please enter your first name!", firstName);
    count_error++;
  } else {
    remove_span_error(firstName);
  }

  if (lastName.val() === "") {
    add_span_error("Please enter your last name!", lastName);
    count_error++;
  } else {
    remove_span_error(lastName);
  }

  if (dob_date.val() === "") {
    dob_date.addClass("error");
    count_error++;
  } else {
    dob_date.removeClass("error");
  }

  if (dob_month.val() === "") {
    dob_month.addClass("error");
    count_error++;
  } else {
    dob_month.removeClass("error");
  }

  if (dob_year.val() === "") {
    dob_year.addClass("error");
    count_error++;
  } else {
    dob_year.removeClass("error");
  }

  if (phone.val() === "") {
    add_span_error("Please enter a valid phone number!", phone);
    count_error++;
  } else {
    remove_span_error(phone);
  }

  if (phone.val() === "") {
    add_span_error("Please enter a valid phone number!", phone);
    count_error++;
  } else {
    remove_span_error(phone);
  }

  if (email.val() === "" || !isEmail(email.val())) {
    add_span_error("Please enter a valid email address!", email);
    count_error++;
  } else {
    remove_span_error(email);
  }

  if (count_error === 0) {
    current_popup.addClass("loading");

    $.ajax({
      type: "POST",
      url: woocommerce_params.ajax_url,
      data: {
        action: "update_user_info",
        first_name: firstName.val(),
        last_name: lastName.val(),
        dob_date: dob_date.val(),
        dob_month: dob_month.val(),
        dob_year: dob_year.val(),
        email: email.val(),
        phone: phone.val(),
        tele: tele.val(),
      },
      success: function (response) {
        if (response) {
          if (response == "success") {
            message = "Personal information updated!";
            current_popup.removeClass("loading");
            $(".user-info_content").html(`
                                  <p>${firstName.val()} ${lastName.val()}</p>
                                  <p>${dob_date.val()}/${dob_month.val()}/${dob_year.val()}</p>
                                  <p>${phone.val()}</p>
                                  <p>${email.val()}</p>
                              `);
          } else {
            message = response;
            current_popup.removeClass("loading");
          }
          console.log(message);
          $(".wp-message").html(message);
          //scroll_to_element($('.wp-message'));
        }
      },
    });
  }
});