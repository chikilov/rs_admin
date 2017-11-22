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
	    $.validator.addMethod("time", function (value, element) {
		    var valuedate = value.split(/-|\s|:/);
		    valuedate = new Date(valuedate[0], valuedate[1] -1, valuedate[2], valuedate[3], valuedate[4], valuedate[5]);
		    if ( typeof valuedate === 'object')
		    {
			    return true;
		    }
		    else
		    {
			    return false;
		    }
		}, "Please enter a valid time.");

		$.validator.addMethod("timeadd", function (value, element) {
			var subvaluedate = $('#begin_at').val().split(/-|\s|:/);
			var valuedate = value.split(/-|\s|:/);
		    subvaluedate = new Date(subvaluedate[0], subvaluedate[1] -1, subvaluedate[2], subvaluedate[3], subvaluedate[4], subvaluedate[5]);
		    valuedate = new Date(valuedate[0], valuedate[1] -1, valuedate[2], valuedate[3], valuedate[4], valuedate[5]);
		    var timeDiff = ( subvaluedate.getTime() / 1000 ) - ( valuedate.getTime() / 1000 );
		    if ( typeof valuedate === 'object' && typeof subvaluedate === 'object' && timeDiff <= -3600 )
		    {
			    return true;
		    }
		    else
		    {
			    return false;
		    }
		}, "Please enter a valid time.");

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
                'begin_at': {
                    required: true,
                    time: true
                },
                'end_at': {
	                required: true,
	                timeadd: true
                },
                'inspection_text': {
	                required: true
                },
                'edit_begin_at': {
                    required: true,
                    time: true
                },
                'edit_end_at': {
	                required: true,
	                timeadd: true
                },
                'edit_inspection_text': {
	                required: true
                }
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

var CheckInfoDatatables = function() {
    // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFullPagination = function() {
        jQuery('#maintenancelog').dataTable({
	        ajax: {
				"type"   : "POST",
				"url"    : '/Server/checklist',
				"data"   : null,
				"dataSrc": ""
			},
			columns: [
				{"className" : "text-center", "data" : "begin_at", "searchable": true},
				{"className" : "text-center", "data" : "end_at", "searchable": true},
				{"className" : "text-center", "data" : "text", "searchable": true},
				{"className" : "text-center", "data" : "url", "searchable": true},
				{"className" : "text-center", "data" : "active", "searchable": true, "render": function ( data, type, row, meta ) {
					return ( data == '0' ? '비활성' : '활성' )
				}},
				{"className" : "text-center", "data" : "_id", "searchable": true, "render": function ( data, type, row, meta ) {
					return '<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-detail" data-objectid="' + data.$id + '" data-beginat="' + row.begin_at + '" data-endat="' + row.end_at + '" data-inspectiontext="' + row.text + '" data-confirmurl="' + row.url + '" data-active="' + row.active + '"><i class="fa fa-pencil"></i></button>';
				}}
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
	CheckInfoDatatables.init();
	$(document).on("click", "#btnCheck", function (e) {
		e.preventDefault();
		swal({
            title: "Are you sure?",
            text: '점검 시작 일시 : ' + $('#begin_at').val() + '\n점검 종료 일시 : ' + $('#end_at').val() + '\n점검 내용 (텍스트) : ' + $('#inspection_text').val() + '\n참고 페이지 주소 : ' + $('#confirm_url').val() + '\n\n 해당 내용으로 점검을 진행 하시겠습니까?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: false
        }, function( isConfirm )
        {
			if (isConfirm) {
				$.ajax({
					method: "POST",
					url: "/Server/checkinsert",
					data: { 'begin_at':$('#begin_at').val(), 'end_at':$('#end_at').val(), 'inspection_text':$('#inspection_text').val(), 'confirm_url':$('#confirm_url').val() },
					dataType: 'html',
					success: function (result) {
						if ( result == '1' )
						{
							swal({
								title: "Success..",
								text: "점검 설정이 완료 되었습니다.",
								type: "success"
							}, function () {
								window.location.reload();
							});
						}
						else
						{
							swal({
								title: "Oop..",
								text: "점검 설정에 오류가 발생하였습니다.",
								type: "error"
							});
						}
					}
				});
			}
		});
	});

	$('#modal-detail').on("show.bs.modal", function (e) {
		var button = $(e.relatedTarget);
		$('#edit_begin_at').val(button.data('beginat'));
		$('#edit_end_at').val(button.data('endat'));
		$('#edit_inspection_text').val(button.data('inspectiontext'));
		$('#edit_confirm_url').val(button.data('confirmurl'));
		$('#edit_id').val(button.data('objectid'));
		$('input[name=edit_active]').each( function () {
			if ( $(this).val() == button.data('active') )
			{
				$(this).prop('checked', true);
			}
		});
	});

	$('#btnCheckEdit').on( "click", function (e) {
		e.preventDefault();
		swal({
            title: "Are you sure?",
            text: '점검 시작 일시 : ' + $('#edit_begin_at').val() + '\n점검 종료 일시 : ' + $('#edit_end_at').val() + '\n점검 내용 (텍스트) : ' + $('#edit_inspection_text').val() + '\n참고 페이지 주소 : ' + $('#edit_confirm_url').val() + '\n상태 : ' + $('input[name=edit_active]:checked').parent().text().replace(/\n/gi, '') + '\n\n 해당 내용으로 점검을 진행 하시겠습니까?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: false
        }, function( isConfirm )
        {
			if (isConfirm) {
				$.ajax({
					method: "POST",
					url: "/Server/checkupdate",
					data: { 'edit_id':$('#edit_id').val(), 'begin_at':$('#edit_begin_at').val(), 'end_at':$('#edit_end_at').val(), 'inspection_text':$('#edit_inspection_text').val(), 'confirm_url':$('#edit_confirm_url').val(), 'active': $('input[name=edit_active]:checked').val() },
					dataType: 'html',
					success: function (result) {
						if ( result == '1' )
						{
							swal({
								title: "Success..",
								text: "점검 설정이 완료 되었습니다.",
								type: "success"
							}, function () {
								window.location.reload();
							});
						}
						else
						{
							swal({
								title: "Oop..",
								text: "점검 설정에 오류가 발생하였습니다.",
								type: "error"
							});
						}
					}
				});
			}
		});
	});
});
