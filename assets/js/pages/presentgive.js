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

var MessageInfoDatatables = function() {
    // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFullPagination = function() {
        jQuery('#messageinfo').dataTable({
	        ajax: {
				"type"   : "POST",
				"url"    : '/Present/presentinfo',
				"data"   : {'start_date':jQuery('#start-datepicker').val(), 'end_date':jQuery('#end-datepicker').val()},
				"dataSrc": ""
			},
			columns: [
				{"className" : "text-center", "data" : "reg_at", "searchable": true, "render": function ( data, type, row, meta ) {
					return data.replace(/ /gi, '<br />');
				}},
				{"className" : "text-left", "data" : "logt", "searchable": true, "render": function ( data, type, row, meta ) {
					return row.mongo_key + '<br />' + row.logc;
				}},
				{"className" : "text-center", "data" : "admin_id", "searchable": true},
				{"className" : "text-center", "data" : "item_id", "searchable": true},
				{"className" : "text-center", "data" : "count", "searchable": true},
				{"className" : "text-center", "data" : "admin_memo", "searchable": true}
				/*
				{"className" : "text-center", "data" : "value", "searchable": false, "render" : function ( data, type, row, meta ) {
						return ( row.value == '' && row.title != '0' ? '-' : ( row.value == '/' ? '- / -' : row.value ) );
					}
				}*/
			],
			dom: "<'row'<'col-sm-1'><'col-sm-1'l><'col-sm-5'B><'col-sm-5'f>>" +
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
            order: [[2, 'desc']],
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
	MessageInfoDatatables.init();
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
					url: "/Present/userfileupload",
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
