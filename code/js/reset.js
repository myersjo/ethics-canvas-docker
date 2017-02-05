// js for the  reset.html file
$(function() {

  console.log('reset.js is working!');


  /* -----Validating the new password form in reset.html ---------- */
  $(".new-password-form").on("click", '.new-pass-btn', function(event) {

    var pass1 = $('#new-password').val();
    var pass2 = $('#new-password-conf').val();
    console.log(pass1);
    console.log(pass2);
    if (pass1 === '') {
      console.log("Didn't enter password.");
      $('#new-password-message1').addClass('message-field').text(
        "Please enter a password");
        //don't submit the form
        event.preventDefault();
    }

    if (pass2 === '') {
      console.log("Didn't confirm password.");
      $('#new-password-message2').addClass('message-field')
        .text(
          "Please confirm your password");
          //don't submit the form
          event.preventDefault();
    }

    if (pass1 !== '' && pass2 !== '' && pass1 !== pass2) {
      console.log("Passwords don't match.");
      $('#new-password-message1, #new-password-message2').addClass(
        'message-field').text(
        "Passwords don't match.");
        //don't submit the form
        event.preventDefault();
    }
    if (pass1 !== '' && pass2 !== '' && pass1 === pass2) {
      $('#new-password-message1, #new-password-message2').removeClass(
        'message-field').text(
        "");
    }

  });
});// end of jQuery file
