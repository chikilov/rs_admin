/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */
/*
 *  Document   : base_forms_validation.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Form Validation Page
 */

var BaseFormValidation = function() {
    // Init Bootstrap Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationBootstrap = function(){
        jQuery('.js-validation-bootstrap').validate({
            ignore: [],
            errorClass: 'help-block animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function(error, e) {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: function(e) {
                var elem = jQuery(e);

                elem.closest('.form-group').removeClass('has-error').addClass('has-error');
                elem.closest('.help-block').remove();
            },
            success: function(e) {
                var elem = jQuery(e);

                elem.closest('.form-group').removeClass('has-error');
                elem.closest('.help-block').remove();
            },
            rules: {
                'v1': {
                    required: true,
                    digits: true,
                    checkmax: true
                }
            },
            messages: {
                'v1': 'Please enter only digits!'
            }
        });
    };

    return {
        init: function () {
            // Init Bootstrap Forms Validation
            initValidationBootstrap();

            // Init Validation on Select2 change
            jQuery('.js-select2').on('change', function(){
                jQuery(this).valid();
            });
        }
    };
}();

// Initialize when page loads
//jQuery(function(){ BaseTableDatatables.init(); });

$(document).ready(function () {
	BaseFormValidation.init();

	$(document).on("click", "#btnSearch", function () {
		if ( jQuery('#start-datepicker').val() != '' && jQuery('#start-datepicker').val() != null && jQuery('#end-datepicker').val() != '' && jQuery('#end-datepicker').val() != null )
		{
			MessageInfoDatatables.init();
		}
		else
		{
			swal('Oops...', '날짜를 선택하세요.', 'error');
		}
	});

	$(document).on("click", "#btnPresent", function (e) {
		e.preventDefault();
		swal({
            title: "Are you sure?",
            text: '아이템 : ' + $('#item_id > option:selected').text() + '\nLOGC : ' + $('#logc').val() + '\n수량 : ' + $('#v1').val() + '\n\n지급 하시겠습니까?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: false
        }, function( isConfirm )
        {
			if ( parseInt( mailmax[$('#item_id').val()] ) >= parseInt( $('#v1').val() ) )
	        {
				if (isConfirm) {
					$.ajax({
						method: "POST",
						url: "/Present/sendpresent",
						data: {'uid':$('#uidgroup').val(), 'type':$('#item_id').val(), 'v1':$('#v1').val(), 'logc':$('#logc').val(), 'logt':$('#logt').val(), 'term': $('#term').val(), 'sendtext': $('#sendtext').val(), 'admin_memo':$('#admin_memo').val()},
						dataType: 'html',
						success: function (result) {
							if ( result == '1' )
							{
								swal({
									title: "Success..",
									text: "메일이 발송 되었습니다.",
									type: "success"
								}, function () {
									window.location.reload();
								});
							}
							else
							{
								swal({
									title: "Oop..",
									text: "메일 발송에 오류가 발생하였습니다.",
									type: "error"
								});
							}
						}
					});
				}
			}
			else
			{
				swal({
					title: "Oop..",
					text: $('#item_id > option:selected').text() + "의 최대 수량은 " + mailmax[$('#item_id').val()] + " 입니다.",
					type: "error"
				});
			}
		});
	});

	$(document).on('change', '#xls_up', function (e) {
		files = e.target.files;
		var data = new FormData();
		$.each(files, function(key, value)
		{
		    data.append(key, value);
		});

		var filename = $(this).val().substring($(this).val().lastIndexOf('\\') + 1, $(this).val().length);
		swal({
            title: "Are you sure?",
            text: filename + ' 파일을 업로드 하시겠습니까?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: true
        }, function( isConfirm )
        {
	        if ( isConfirm )
	        {
				$.ajax({
					url: "/Present/convertfileupload",
					type: "POST",
					data: data,
					async: false,
					cache: false,
					contentType: false,
					processData: false,
					success:  function(data){
						$('#uidshow').val(data);
						$('#uidgroup').val(data);
					}
				});
			}
        });
	});

	$(document).on('change', '#uidshow', function () {
		$('#uidgroup').val($(this).val());
	});
});
