// Shorthand for $( document ).ready()
$(function() {

    /*---------------------------------------------------
      CHECKING THE URL FOR PARAMETERS (USER REDIRECTION)
    ------------------------------------------------------*/

    /*Get the dynamic variables stored in the url as parameters and store them as JavaScript variables ready for use in the code:*/
    // example.com?param1=name&param2=&id=6
    // $.urlParam('param1'); // name
    // $.urlParam('id');        // 6
    // $.urlParam('param2');   // null
    $.urlParam = function(name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location
            .href);
        // user is not redirected from the email activation link
        if (results === null) {
            return null;
        }
        // user is redirected from the email activation link
        else {
            return results[1] || 0;
        }
    };
    /*--------  USER EMAIL ACTIVATED OR NOT ---------*/
    /* When activation.php returns the varification variable: (redirecting the user to the page)*/
    //store the parameter in a variable
    var emailVerification = $.urlParam('verification');
    /*verification sucessful, parameter is true*/
    if (emailVerification !== null && emailVerification === 'true') {
        //create an html for the activation fail message

        var verificationMessage_true =
            "<div class='success-activation'><p>Great! Your email is activated. You can now log in.</p><p><a href='#log-in-pill'>Log in</a>  </p></div>";
        $('header').append(verificationMessage_true);
        /*clicking on the login will send the user to the log in area
        the user does not nesseccarily want to log in at this point (optional)
        They want to continue reading the website or try online anyway*/

        //have the log in pill field activated
        $('.nav-tabs a[href="#login-tab"]').tab('show'); // Select tab by name
        /*verification failed, parameter is false*/
    } else if (emailVerification !== null && emailVerification === 'false') {
        //create an html for the activation fail message
        var verificationMessage_false =
            "<div class='failed-activation'><p>Sorry, We couldn't activate your email :(</p><p>Please contact us at <a href='mailto:hello@ethicscanvas.org'>hello@ethicscanvas.org</a>  and we will fix it.</p></div>";
        $('header').append(verificationMessage_false);
    }
    /*This is for testing*/
    if (emailVerification === null) {

    }
    /* -------USER PASSWORD RESET OR NOT ----------*/
    /* When reset.php returns the password reset variable: (redirecting the user to the page)*/
    //changed=true
    var passwordReset = $.urlParam('changed');

    if (passwordReset !== null && passwordReset === 'true') {
        //create an html for the "password changed" message
        var passwordResetMessage_true =
            "<div class='success-activation'><p>Great! Your password is changed. You can now log in.</p><p><a href='#log-in-pill'>Log in</a>  </p></div>";
        $('header').append(passwordResetMessage_true);
        /*clicking on the login will send the user to the log in area
        the user does not nesseccarily want to log in at this point (optional)
        They want to continue reading the website or try online anyway*/

        //have the log in pill field activated
        $('.nav-tabs a[href="#login-tab"]').tab('show'); // Select tab by name
        /*verification failed, parameter is false*/
    } else if (passwordReset !== null && passwordReset === 'false') {
        //create an html for the activation fail message
        var passwordResetMessage_false =
            "<div class='failed-activation'><p>Sorry, We couldn't change your password :(</p><p>Please contact us at <a href='mailto:hello@ethicscanvas.org'>hello@ethicscanvas.org</a>  and we will fix it.</p></div>";
        $('header').append(passwordResetMessage_false);
    }
    /*This is for testing*/
    if (passwordReset === null) {


    }

    //end of password reset change verification

    /*-----------------------------------------------
              SLICK CAROUSEL SETTING
     -----------------------------------------------*/
    $('.slickCarousel').slick({
        autoplay: true,
        autoplaySpeed: 4500,
        dots: true,
        infinite: true,
        fade: true,
        cssEase: 'linear'
    });
    /*-----------------------------------------------
              EMAIL VALIDATION
     -----------------------------------------------*/
    function ValidateEmail(email) {
        var expr =
            /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    }
    /* -------------------------------------------
        SIGN UP FORM SUBMISSION & SERVER FEEDBACK
      ---------------------------------------------*/

    //A. Submitting sign up
    $('.sign-up-form').on('submit', function(event) {
        //prevent the form from getting submit if the passwords don't match or the email is invalid
        var pass1 = $('#password-signup').val();
        var pass2 = $('#password-signup-conf').val();
        if (!ValidateEmail($("#email-signup").val()) || pass1 !== pass2) {
            event.preventDefault();
        } else {
            var url = "php/sign-up.php";
            var sign_up_data = $(this).serialize();

            /* ----------------------------
             Post the serialized form data
             to the sign-up.php file
             -----------------------------*/

            $.post(url, {
                sign_up_data: sign_up_data
            }, function(data, status) {

                // HANDLE sign up SERVER RESPONSE
                if (data == 400) {
                    $('.sign-up-in').find('.form-signup-feedback ').addClass(
                        'success-feedback').html(
                        '<p>Something went wrong! Please contact us at hello@ethicscanvas.org.</p>'
                    );
                    /*user is already registered*/
                } else if (data == 401) {
                    $('.sign-up-in').find('.form-login-feedback ').addClass(
                        'info-feedback').html(
                        '<p>You are already registered. Please log in!</p>');
                    //have the log in pill field activated
                    $('.nav-tabs a[href="#login-tab"]').tab('show'); // Select tab by name
                    /*put the already entered email in the email input
                     of the login form*/
                    //the email that the existing user tried to sign up with
                    var user_email = $('.sign-up-form').find('#email-signup')
                        .val();
                    //put the email in the login form
                    $('.log-in-form').find('#email-login').val(user_email);


                } else if (data == 201) {
                    $('.sign-up-in').find('.form-signup-feedback ').addClass(
                        'success-feedback').html(
                        '<p>Thank you! Please check your email  <span>' + $(
                            "#email-signup").val() +
                        '</span> and activate your account.</p>');
                }

            }).fail(function(jqXHR) {
                console.log("Fail Error -> " + jqXHR.status + ' ' + jqXHR
                    .statustext);
            });

            /* Because the type of the button is submit */

            return false;
        } //end of else
    }); // end of handling the click on THE Sign Up button


    /* -------------------------------------------
        LOGIN FORM SUBMISSION & SERVER FEEDBACK
      ---------------------------------------------*/

    $('.log-in-form').on('submit', function(event) {

        var url = "php/log-in.php";
        var sign_in_data = $(this).serialize();

        /* ---------------------------
         Post the serialized form data
         to the log-in.php file
         -----------------------------*/

        $.post(url, {
            sign_in_data: sign_in_data
        }, function(data, status) {
            //Handling LOGIN form feedback from the server

            if (data == 400) {
                $('.sign-up-in').find('.form-login-feedback').addClass(
                    'warning-feedback').html(
                    '<p>Something went wrong! Please contact us at hello@ethicscanvas.org.</p>'
                );
                /*user is already registered*/
            } else if (data == 401) {
                $('.sign-up-in').find('.form-login-feedback').addClass(
                    'warning-feedback').html(
                    '<p>The username or password is incorrect. Please try again.</p>'
                );

            } else if (data == 200) {
                $('.sign-up-in').find('.form-login-feedback ').addClass(
                    'success-feedback').html(
                    '<p>Great! Going to the canvas now...</p>');
                /*Send the user to their canvas dashbord*/
                window.location.href = 'canvas/php/dashboard.php';
            } else if (data == 402) {
                $('.sign-up-in').find('.form-login-feedback').addClass(
                    'warning-feedback').html(
                    '<p>You already have an account. Please activate it through the email we sent you.</p><button class="resend-activation">Send me the activation email again</button>'
                );
            }
        }).fail(function(jqXHR) {
            console.log("Error " + jqXHR.status + ' ' + jqXHR.statustext);
        });

        /* Because the type of the button is submit */

        return false;

    }); // end of handling the click on THE Sign Up button


    /*------------#Resend The Activation Email --------*/

    $('.sign-up-in').find('.form-login-feedback').on("click",
        '.resend-activation',
        function() {
            var url = 'php/resend-activation.php';
            var email_resend = $('.log-in-form').find('#email-login').serialize();
            $.post(url, {
                email_resend: email_resend
            }, function(data, status) {

                console.log(
                    'User clicked on resend activation email: \n' +
                    'RESPONSE from resend-activation.php => \n' +
                    'data:' + data + '\n status: ' + status);

            }); //end of post
        }); //end of on click for resending activation

    /*------------#Forgot password  --------*/
    $('.log-in-form').find('.forgot-password').on("click", 'a',
        function(e) {
            e.preventDefault();
            //have the reset password pill field activated
            $('.nav-tabs a[href="#reset-password-tab"]').tab('show'); // Select tab by name
            //get the value of the email input field in the login form
            var email_to_reset = $('.log-in-form').find('#email-login').val();
            /*if the user already entered an email adress here, and it's a valid email*/
            /* put that email address in the input field of the password reset*/
            if (email_to_reset !== null && ValidateEmail($("#email-login").val())) {
                $('.reset-password-form').find('#email-reset-password').val(
                    email_to_reset);
            }
        }); //end of click on forgot the password link

    /*--------------- #Reset password ----------------*/

    $('.reset-password-form').on('submit', function() {

        var url = 'php/reset-password.php';
        var reset_password = $('.reset-password-form').find(
            '#email-reset-password').serialize();

        $.post(url, {
            reset_password: reset_password
        }, function(data, status) {

            if (data == 400) {
                $('.sign-up-in').find('.form-reset-password-feedback').addClass('warning-feedback').html('<p>Something is not right :/ Please contact us at hello@thicscanvas.org</p>');
            } else if (data == 401) {
                $('.sign-up-in').find('.form-reset-password-feedback').addClass('warning-feedback').html('<p>Please enter your correct email address.</p>');
            } else if (data == 200) {
                $('.sign-up-in').find('.form-reset-password-feedback').addClass('success-feedback').html('<p>Thanks :) We sent you an email to reset your password</p>');

            }


        }); //end of post
        return false;
    });


    /* -------------------------------------------
                 Inline FRONT END FORM VALIDATION
      ---------------------------------------------*/

    /* ------- Validating the sign up form ------------ */
    $(".sign-up-form").on("click", '.sign-up', function() {

        var user_name = $('#firstname-signup').val();
        if (user_name === '') {
            $('#name-register-message').addClass('message-field').text(
                "Please tell us your name");
        } else {
            $('#name-register-message').removeClass('message-field').text(
                "");
        }

        if (!ValidateEmail($("#email-signup").val())) {
            $('#email-register-message').addClass('message-field').text(
                'please give us a valid email adress.');
        } else {
            $('#email-register-message').removeClass('message-field')
                .text(
                    "");
        }
        var pass1 = $('#password-signup').val();
        var pass2 = $('#password-signup-conf').val();
        if (pass1 === '') {
            $('#pass-register-message').addClass('message-field').text(
                "Please enter a password");
        }

        if (pass2 === '') {
            $('#pass-conf-register-message').addClass('message-field')
                .text(
                    "Please confirm your password");
        }

        if (pass1 !== '' && pass2 !== '' && pass1 !== pass2) {
            $('#pass-register-message, #pass-conf-register-message').addClass(
                'message-field').text(
                "Passwords don't match.");
        }
        if (pass1 !== '' && pass2 !== '' && pass1 === pass2) {
            $('#pass-register-message, #pass-conf-register-message').removeClass(
                'message-field').text(
                "");
        }

    });


    /* -------- Validating the log in form ---------- */
    $(".log-in-form").on("click", '.log-in', function() {
        if (!ValidateEmail($("#email-login").val())) {
            $('#email-login-message').addClass('message-field').text(
                'please give us a valid email adress.');
        }

        var pass1b = $('#password-login').val();

        if (pass1b === '') {
            $('#pass-login-message').addClass('message-field').text(
                "Please enter your password");
        }

    });


    /* -------- Validating the password reset form ---------- */

    $('.reset-password-form').on('click', '#reset-password-btn', function() {

        // if the email input field is empty
        if ($('.reset-password-form').find(
                '#email-reset-password').val() === '') {
            $('.reset-password-form').find('#reset-password-message').addClass('message-field').text('Please enter your email');
        }

    }); // end of click on reset


}); // end of jQuery file
