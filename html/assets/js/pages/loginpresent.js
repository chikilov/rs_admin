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
	    $.validator.addMethod("checkdate", function(value, element) {
		    var nowdate = new Date();
		    var valuedate = new Date(value);
            nowdate.setHours(0,0,0,0);
            valuedate.setHours(0,0,0,0);
		    return (valuedate >= nowdate);
	    });

        jQuery('#fLoginPresent').validate({
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
                'login_date': {
                    required: true,
                    date: true,
                    checkdate: true
                },
                'login_hour': {
                    required: true,
                    digits: true
                },
                'push_message': {
                    required: true
                },
                'item_id': {
                    required: true,
                    digits: true
                },
                'v1': {
                    required: true,
                    digits: true
                }
            },
            messages: {
                'login_date': 'Please enter date Ymd.',
                'login_hour': 'Please enter hour 0-23',
                'push_message': 'Please enter send message.',
                'item_id': 'Please choose item.',
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

var LoginPresentDatatables = function() {
    // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFullPagination = function() {
        jQuery('#t_loginpresent').dataTable({
	        ajax: {
				"type"   : "POST",
				"url"    : '/Present/loginpresent_get',
				"data"   : null,
				"dataSrc": ""
			},
			columns: [
				{"className" : "text-center", "data" : "date", "searchable": true },
				{"className" : "text-center", "data" : "cron_exp", "searchable": true, "render":function(data, type, row, meta){
                    var res = data.match(/[0-9]?[0-9]/g);
                    if (res.length <= 0) {
                        return '(error)';
                    }
                    if (res.length == 1) {
                        return res[0] + ':00 ~ ' + (Number(res[0])+1) + ':00';
                    }
                    if (res.length > 1) {
                        return res[0] + ':00 ~ ' + (Number(res[1])+1) + ':00';
                    }
                    return data;
                }},
				{"className" : "text-center", "data" : "item_name", "searchable": true},
				{"className" : "text-center", "data" : "count", "searchable": true},
				{"className" : "text-center", "data" : "message", "searchable": true},
                {"className" : "text-center", "data" : "push_id", "searchable": true,"render":function(data, type, row, meta){
					return '<button class="btn btn-xs btn-info btn-push" data-pushid="' + row.push_id + '" style="float:right" type="button">' + (data > 0 ? '푸시 삭제' : '푸시 등록' ) + '</button>';
				}},
				{"className" : "text-center", "data" : "date", "searchable": true,"render":function(data, type, row, meta){
					return '<button class="btn btn-xs btn-info btn-del" data-pushid="' + row.push_id + '" style="float:right" type="button">삭제</button>'
				}},
			],
			dom: "<'row'<'col-sm-1'l><'col-sm-6'B><'col-sm-5'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
	        buttons: [
	            'copy',
	            'excel',
	            'csv',
	            'pdf'
	        ],
			destroy: true,
            pagingType: "full_numbers",
            columnDefs: [ { orderable: true } ],
            autoWidth: false,
            order: [[0, 'desc'], [1, 'desc']],
            pageLength: 10,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]]
        });
    };

    // DataTables Bootstrap integration
    var bsDataTables = function() {
        var $DataTable = jQuery.fn.dataTable;

        // Set the defaults for DataTables init
        jQuery.extend( true, $DataTable.defaults, {
            dom:
                "<'row'<'col-sm-2'l><'col-sm-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            renderer: 'bootstrap',
            oLanguage: {
                sLengthMenu: "_MENU_",
                sInfo: "Showing <strong>_START_</strong>-<strong>_END_</strong> of <strong>_TOTAL_</strong>",
                oPaginate: {
                    sPrevious: '<i class="fa fa-angle-left"></i>',
                    sNext: '<i class="fa fa-angle-right"></i>'
                }
            }
        });

        // Default class modification
        jQuery.extend($DataTable.ext.classes, {
            sWrapper: "dataTables_wrapper form-inline dt-bootstrap",
            sFilterInput: "form-control",
            sLengthSelect: "form-control"
        });

        // Bootstrap paging button renderer
        $DataTable.ext.renderer.pageButton.bootstrap = function (settings, host, idx, buttons, page, pages) {
            var api     = new $DataTable.Api(settings);
            var classes = settings.oClasses;
            var lang    = settings.oLanguage.oPaginate;
            var btnDisplay, btnClass;

            var attach = function (container, buttons) {
                var i, ien, node, button;
                var clickHandler = function (e) {
                    e.preventDefault();
                    if (!jQuery(e.currentTarget).hasClass('disabled')) {
                        api.page(e.data.action).draw(false);
                    }
                };

                for (i = 0, ien = buttons.length; i < ien; i++) {
                    button = buttons[i];

                    if (jQuery.isArray(button)) {
                        attach(container, button);
                    }
                    else {
                        btnDisplay = '';
                        btnClass = '';

                        switch (button) {
                            case 'ellipsis':
                                btnDisplay = '&hellip;';
                                btnClass = 'disabled';
                                break;

                            case 'first':
                                btnDisplay = lang.sFirst;
                                btnClass = button + (page > 0 ? '' : ' disabled');
                                break;

                            case 'previous':
                                btnDisplay = lang.sPrevious;
                                btnClass = button + (page > 0 ? '' : ' disabled');
                                break;

                            case 'next':
                                btnDisplay = lang.sNext;
                                btnClass = button + (page < pages - 1 ? '' : ' disabled');
                                break;

                            case 'last':
                                btnDisplay = lang.sLast;
                                btnClass = button + (page < pages - 1 ? '' : ' disabled');
                                break;

                            default:
                                btnDisplay = button + 1;
                                btnClass = page === button ?
                                        'active' : '';
                                break;
                        }

                        if (btnDisplay) {
                            node = jQuery('<li>', {
                                'class': classes.sPageButton + ' ' + btnClass,
                                'aria-controls': settings.sTableId,
                                'tabindex': settings.iTabIndex,
                                'id': idx === 0 && typeof button === 'string' ?
                                        settings.sTableId + '_' + button :
                                        null
                            })
                            .append(jQuery('<a>', {
                                    'href': '#'
                                })
                                .html(btnDisplay)
                            )
                            .appendTo(container);

                            settings.oApi._fnBindAction(
                                node, {action: button}, clickHandler
                            );
                        }
                    }
                }
            };

            attach(
                jQuery(host).empty().html('<ul class="pagination"/>').children('ul'),
                buttons
            );
        };

        // TableTools Bootstrap compatibility - Required TableTools 2.1+
        if ($DataTable.TableTools) {
            // Set the classes that TableTools uses to something suitable for Bootstrap
            jQuery.extend(true, $DataTable.TableTools.classes, {
                "container": "DTTT btn-group",
                "buttons": {
                    "normal": "btn btn-default",
                    "disabled": "disabled"
                },
                "collection": {
                    "container": "DTTT_dropdown dropdown-menu",
                    "buttons": {
                        "normal": "",
                        "disabled": "disabled"
                    }
                },
                "print": {
                    "info": "DTTT_print_info"
                },
                "select": {
                    "row": "active"
                }
            });

            // Have the collection use a bootstrap compatible drop down
            jQuery.extend(true, $DataTable.TableTools.DEFAULTS.oTags, {
                "collection": {
                    "container": "ul",
                    "button": "li",
                    "liner": "a"
                }
            });
        }
    };

    return {
        init: function() {
            // Init Datatables
            bsDataTables();
            initDataTableFullPagination();
        }
    };
}();

// Initialize when page loads
//jQuery(function(){ BaseTableDatatables.init(); });

$(document).ready(function () {
	BaseFormValidation.init();
	LoginPresentDatatables.init();

	$(document).on( 'click', '#btnLoginPresent', function () {
        if ($("#fLoginPresent").valid()) {
    		$.ajax({
    			type:'POST',
    			url: '/Present/loginpresent_insertaction',
    			data: {'login_date':$('#login_date').val(), 'login_hour':$('#login_hour').val(), 'push_status':$('#push_status').val(), 'item_id':$('#item_id').val(), 'v1':$('#v1').val(), 'push_message':$('#push_message').val()},
    			success: function (result) {
    				if ( result == 'true' )
    				{
    					swal({
    				        title: 'Success!',
    				        text: '입력 되었습니다.',
    				        type: 'success'
    				    }, function() {
    						jQuery('#t_loginpresent').dataTable().api().ajax.reload();
    				    });
    				}
                    else {
                        swal('Oops...', 'Unknown error!\n' + result, 'error');
                    }
    			},
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
    		})
        }
	});

	$(document).on( 'click', '.btn-del', function (e) {
		var push_id = $(this).data('pushid');
        swal({
                title: "Are you sure?",
                text: "Delete PUSH_ID = " + push_id,
                showCancelButton: true,
                onfirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type:'POST',
                        url: '/Present/loginpresent_delete',
                        data: {'push_id':push_id},
                        success: function (result) {
                            if (result == 'true') {
                                swal("Deleted!");
                                jQuery('#t_loginpresent').dataTable().api().ajax.reload();
                            }
                            else {
                                swal('Oops...', 'Unknown error!', 'error');
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert("Status: " + textStatus); alert("Error: " + errorThrown);
                        }
                    })
                }
            }
        );
	});

	$(document).on( 'click', '.btn-push', function (e) {
		var push_id = $(this).data('pushid');
		swal({
                title: "Are you sure?",
                text: "Turn off PUSH = " + push_id,
                showCancelButton: true,
                onfirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, turn off it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type:'POST',
                        url: '/Present/loginpresent_off',
                        data: {'push_id':push_id},
                        success: function (result) {
                            if (result == 'true') {
                                swal("Turned Off!");
                                jQuery('#t_loginpresent').dataTable().api().ajax.reload();
                            }
                            else {
                                swal('Oops...', 'Unknown error!', 'error');
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert("Status: " + textStatus); alert("Error: " + errorThrown);
                        }
                    })
                }
            }
        );
	});
});
