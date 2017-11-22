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
	    $.validator.addMethod("isfuture", function(value, element) {
		    var nowdate = new Date();
		    var valuedate = new Date(value);
		    return (valuedate > nowdate);
	    });

        jQuery('#frmPresent').validate({
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
                'begin_at': {
                    required: true,
                    date: true
                },
                'end_at': {
                    required: true,
                    date: true,
                    isfuture: true
                },
                'sendtext': {
                    required: true,
                    digits: true
                },
                'admin_memo': {
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
                'begin_at': 'Please enter send start datetime.',
                'end_at': {
	                required: 'Please enter send end datetime.',
	                isfuture: 'Input date is already past.'
	            },
                'sendtext': 'Please enter send message.',
                'admin_memo': 'Please enter admin memo.',
                'item_id': 'Please choose item.',
                'v1': 'Please enter only digits!'
            }
        });
        jQuery('#frmPresentEdit').validate({
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
                'edit_begin_at': {
                    required: true,
                    date: true
                },
                'edit_end_at': {
                    required: true,
                    date: true,
                    isfuture: true
                },
                'edit_sendtext': {
                    required: true,
                    digits: true
                },
                'edit_admin_memo': {
                    required: true
                },
                'edit_item_id': {
                    required: true,
                    digits: true
                },
                'edit_v1': {
                    required: true,
                    digits: true
                }
            },
            messages: {
                'begin_at': 'Please enter send start datetime.',
                'end_at': {
	                required: 'Please enter send end datetime.',
	                isfuture: 'Input date is already past.'
	            },
                'sendtext': 'Please enter send message.',
                'admin_memo': 'Please enter admin memo.',
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

var MessageInfoDatatables = function() {
    // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFullPagination = function() {
        jQuery('#presentlog').dataTable({
	        ajax: {
				"type"   : "POST",
				"url"    : '/Present/presentlog',
				"data"   : {'start_date':jQuery('#start-datepicker').val(), 'end_date':jQuery('#end-datepicker').val()},
				"dataSrc": ""
			},
			columns: [
				{"className" : "text-center", "data" : "begin_at", "searchable": true, "render": function (data, type, row, meta) {
						return ( row.begin_at + ' ~ ' + row.end_at );
					}
				},
				{"className" : "text-center", "data" : "item_name", "searchable": true},
				{"className" : "text-center", "data" : "count", "searchable": true},
				{"className" : "text-center", "data" : "admin_memo", "searchable": true},
				{"className" : "text-center", "data" : "item_id", "searchable": true, "render": function (data, type, row, meta) {
						return '- / -';
					}
				},
				{"className" : "text-center", "data" : "admin_id", "searchable": true},
				{"className" : "text-center", "data" : "idx", "searchable": true, "render": function (data, type, row, meta) {
						var nowdate = new Date();
						var beginat = new Date(row.begin_at.replace(/ /gi, 'T') + '+09:00');
						var endat = new Date(row.end_at.replace(/ /gi, 'T') + '+09:00');

						if ( endat <= nowdate )
						{
							return '<span class="label label-success">지급 완료</span>';
						}
						else if ( beginat <= nowdate )
						{
							return '<span class="label label-warning">지급 시작</span>';
						}
						else
						{
							return '<button class="btn btn-sm btn-primary btn-detail" type="button" data-toggle="modal" data-target="#modal-detail" data-idx="' + row.idx + '" data-beginat="' + row.begin_at + '" data-endat="' + row.end_at + '" data-sendtext="' + row.sendtext + '" data-adminmemo="' + row.admin_memo + '" data-itemid="' + row.item_id + '" data-v1="' + row.count + '" data-mongokey="' + row.mongo_key + '">수정</button>&nbsp;<button class="btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#modal-blank" data-idx="' + row.idx + '" data-mongokey="' + row.mongo_key + '" data-beginat="' + row.begin_at + '" data-endat="' + row.end_at + '">삭제</button>';
						}
					}
				}
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
            order: [[0, 'desc']],
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

	$(document).on("click", "#btnPresentSend", function () {
		if ($("#frmPresent").valid())
		{
			$.ajax({
				method: 'POST',
				url: '/Present/presentsendaction',
				data: { 'begin_at':$('#begin_at').val(), 'end_at':$('#end_at').val(), 'sendtext':$('#sendtext').val(), 'admin_memo':$('#admin_memo').val(), 'item_id':$('#item_id').val(), 'v1':$('#v1').val() },
				success: function (result) {
					if ( result == 'true' )
					{
						swal({
					        title: 'Success!',
					        text: '지급이 처리되었습니다.',
					        type: 'success'
					    }, function() {
					      // Redirect the user
					      window.location.href = '/Present/presentsend';
					    });
					}
					else if ( result == 'false' )
					{
						swal('Oops...', '오류가 발생하였습니다.', 'error');
					}
				}
			});
		}
	});

	$(document).on("click", "#btnPresentEdit", function () {
		if ($("#frmPresentEdit").valid())
		{
			$.ajax({
				method: 'POST',
				url: '/Present/presentsendeditaction',
				data: { 'begin_at':$('#edit_begin_at').val(), 'end_at':$('#edit_end_at').val(), 'sendtext':$('#edit_sendtext').val(), 'admin_memo':$('#edit_admin_memo').val(), 'item_id':$('#edit_item_id').val(), 'v1':$('#edit_v1').val(), 'mongokey':$('#edit_mongokey').val(), 'idx':$('#edit_idx').val() },
				success: function (result) {
					if ( result == 'true' )
					{
						swal({
					        title: 'Success!',
					        text: '수정되었습니다.',
					        type: 'success'
					    }, function() {
					      // Redirect the user
					      $('#modal-detail').modal('hide');
					      jQuery('#presentlog').dataTable().api().ajax.reload();
					    });
					}
					else if ( result == 'false1' )
					{
						swal('Oops...', '오류가 발생하였습니다.\n(게임디비 수정오류)', 'error');
					}
					else if ( result == 'false2' )
					{
						swal('Oops...', '오류가 발생하였습니다.\n(관리툴디비 수정오류)', 'error');
					}
					else if ( result == 'false3' )
					{
						swal('Oops...', '오류가 발생하였습니다.\n(게임+관리툴디비 수정오류)', 'error');
					}
				}
			});
		}
	});

	$('#modal-blank').on('show.bs.modal', function (e) {
		e.preventDefault();
		var nowdate = new Date();
		var beginat = new Date($(e.relatedTarget).data('beginat').replace(/ /gi, 'T') + '+09:00');
		var endat = new Date($(e.relatedTarget).data('endat').replace(/ /gi, 'T') + '+09:00');

		if ( endat <= nowdate )
		{
			e.preventDefault();
			swal({
				title: 'Oops...',
				text: '이미 지급이 완료된 항목은 삭제 할 수 없습니다.',
				type: 'error'
			});
		}
		else if ( beginat <= nowdate )
		{
			e.preventDefault();
			swal({
				title: 'Oops...',
				text: '이미 지급이 시작된 항목은 삭제 할 수 없습니다.',
				type: 'error'
			});
		}
		else
		{
			swal({
	            title: "Are you sure?",
	            text: "해당 정보를 삭제하시겠습니까?",
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes, delete it!",
	            closeOnConfirm: false
	        }, function( isConfirm )
	        {
				if (isConfirm) {
					$.ajax({
						method: "POST",
						url: "/Present/presentdelete",
						data: {'idx':$(e.relatedTarget).data('idx'), 'mongokey':$(e.relatedTarget).data('mongokey')},
						dataType: 'html',
						success: function (result) {
							if ( result )
							{
								swal({
						        title: 'Success!',
						        text: '삭제 되었습니다.',
						        type: 'success'
							    }, function() {
									// Redirect the user
									$('#modal-blank').modal('hide');
									jQuery('#presentlog').dataTable().api().ajax.reload();
							    });
							}
							else if ( result == 'false1' )
							{
								swal('Oops...', '오류가 발생하였습니다.\n(게임디비 수정오류)', 'error');
							}
							else if ( result == 'false2' )
							{
								swal('Oops...', '오류가 발생하였습니다.\n(관리툴디비 수정오류)', 'error');
							}
							else if ( result == 'false3' )
							{
								swal('Oops...', '오류가 발생하였습니다.\n(게임+관리툴디비 수정오류)', 'error');
							}
						}
					});
				}
			});
		}
	});

	$('#modal-detail').on('show.bs.modal', function (e) {
		var nowdate = new Date();
		var beginat = new Date($(e.relatedTarget).data('beginat').replace(/ /gi, 'T') + '+09:00');
		var endat = new Date($(e.relatedTarget).data('endat').replace(/ /gi, 'T') + '+09:00');

		if ( endat <= nowdate )
		{
			e.preventDefault();
			swal({
				title: 'Oops...',
				text: '이미 지급이 완료된 항목은 수정 할 수 없습니다.',
				type: 'error'
			});
		}
		else if ( beginat <= nowdate )
		{
			e.preventDefault();
			swal({
				title: 'Oops...',
				text: '이미 지급이 시작된 항목은 수정 할 수 없습니다.',
				type: 'error'
			});
		}
		else
		{
			$('#edit_idx').val( $(e.relatedTarget).data('idx') );
			$('#edit_mongokey').val( $(e.relatedTarget).data('mongokey') );
			$('#edit_begin_at').val( beginat );
			$('#edit_end_at').val( endat );
			$('#edit_sendtext').val( $(e.relatedTarget).data('sendtext') ).trigger('change');
			$('#edit_admin_memo').val( $(e.relatedTarget).data('adminmemo') );
			$('#edit_item_id').val( $(e.relatedTarget).data('itemid') ).trigger('change');
			$('#edit_v1').val( $(e.relatedTarget).data('v1') );
		}
	});
});
