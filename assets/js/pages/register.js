/*
 *  Document   : base_pages_login.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Login Page
 */

var BasePagesLogin = function() {
	var res = false;
    // Init Login Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    $.validator.addMethod('passwordck', function (value, element) {
	    return /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,}$/.test(value);
    }, '숫자, 문자, 특수문자를 모두 포함하여야 합니다.' );
    $.validator.addMethod('duplicationcheck', function (value, element) {
	    $.ajax({
		    type: "POST",
			url: "/Login/duplicationcheck",
			data: { "register-username": value },
			async: false,
			success:function( result ) {
				( result == 'true' ? res = true : res = false )
			}
	    });
	    return res;
    }, '동일한 계정이 존재합니다.' );
    var initValidationLogin = function(){
        jQuery('.js-validation-register').validate({
            errorClass: 'help-block text-right animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function(error, e) {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: function(e) {
                jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            success: function(e) {
                jQuery(e).closest('.form-group').removeClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            rules: {
                'register-username': {
                    required: true,
                    duplicationcheck: true
                },
                'register-password': {
                    required: true,
                    minlength: 8,
                    passwordck: true
                },
                'register-password2': {
                    required: true,
                    minlength: 8,
                    equalTo : '#register-password'
                },
                'register-name': {
                    required: true
                },
                'register-depart': {
                    required: true
                },
                'register-reason': {
                    required: true
                }
            },
            messages: {
                'register-username': {
                    required: lang['username_comment']
                },
                'register-password': {
                    required: lang['password_comment'],
                    minlength: lang['password_minlength'],
                    passwordck: lang['password_passwordck']
                },
                'register-password2': {
                    required: lang['password_comment'],
                    minlength: lang['password_minlength'],
                    equalTo: lang['password_not_same']
                },
                'register-name': {
                    required: lang['name_comment']
                },
                'register-depart': {
                    required: lang['depart_comment']
                },
                'register-reason': {
                    required: lang['reason_comment']
                }
            }
        });
    };

    return {
        init: function () {
            // Init Login Form Validation
            initValidationLogin();
        }
    };
}();

// Initialize when page loads
jQuery(function(){ BasePagesLogin.init(); });