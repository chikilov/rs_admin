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
        jQuery('#fAddPatchInfo').validate({
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
                'app_ver': {
                    required: true
                },
                'name': {
                    required: true
                },
                'md5': {
                    required: true
                },
                'size': {
                    required: true,
                    digits: true
                }
            },
            messages: {
                'app_ver': 'Please enter app_ver',
                'name': 'Please enter name.',
                'md5': 'Please enter md5.',
                'size': 'Please enter only digits!'
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

var VersionInfoDatatables = function() {
    // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFullPagination = function() {
        jQuery('#versioninfo').dataTable({
	        ajax: {
				"type"   : "POST",
				"url"    : '/Server/versionlog',
				"data"   : null,
				"dataSrc": ""
			},
			columns: [
				{"className" : "text-center", "data" : "app_ver", "searchable": true },
				{"className" : "text-center", "data" : "version", "searchable": true},
				{"className" : "text-center", "data" : "name", "searchable": true},
				{"className" : "text-center", "data" : "md5", "searchable": true},
				{"className" : "text-center", "data" : "size", "searchable": true},
				{"className" : "text-center", "data" : "app_ver", "searchable": true,"render":function(data, type, row, meta){
					return '<button class="btn btn-xs btn-info btn-del" style="float:right" type="button">삭제</button>'
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
	VersionInfoDatatables.init();

	$(document).on( 'change', '#app_ver_s', function () {
		if ( $('#app_ver_s > option:selected').text() == '신규 등록' )
		{
			$('#frmgroupSel').hide();
			$('#frmgroupIpt').show();
			$('#app_ver').val('');
		}
		else
		{
			$('#app_ver').val($('#app_ver_s > option:selected').val());
		}
	});

	$(document).on( 'click', '#btnTextCancel', function () {
		$('#app_ver').val('');
		$('#app_ver_s').select2("val", "");
		$('#frmgroupSel').show();
		$('#frmgroupIpt').hide();
	});

	$(document).on( 'click', '#btnSubmit', function () {
        if ($("#fAddPatchInfo").valid()) {
    		$.ajax({
    			type:'POST',
    			url: '/Server/versioninsert',
    			data: {'app_ver':$('#app_ver').val(), 'name':$('#name').val(), 'md5':$('#md5').val(), 'size':$('#size').val(), 'admin_memo':$('#admin_memo').val()},
    			success: function (result) {
    				if ( result == 'true' )
    				{
    					swal({
    				        title: 'Success!',
    				        text: '입력 되었습니다.',
    				        type: 'success'
    				    }, function() {
    						// Redirect the user
    						$('#modal-large').modal('hide');
    						jQuery('#versioninfo').dataTable().api().ajax.reload();
    				    });
    				}
    			}
    		})
        }
	});

	$(document).on( 'click', '#btnSubmit2', function () {
        if ($("#fAddPatchInfo2").valid()) {
    		$.ajax({
    			type:'POST',
    			url: '/Server/versioninsert',
    			data: {'json_str':$('#json_str').val()},
    			success: function (result) {
					swal({
				        title: 'Success!',
				        text: result + '건 입력 되었습니다.',
				        type: 'success'
				    }, function() {
						// Redirect the user
						$('#json_str').val('');
						$('#modal-large2').modal('hide');
						jQuery('#versioninfo').dataTable().api().ajax.reload();
				    });
    			}
    		})
        }
	});

    $(document).on( 'click', '#btnParseform', function () {
        var text = $('#parseform').val();
        var items = text.split(',');
        if (items.length > 0) $('#name').val(items[0].trim());
        if (items.length > 1) $('#md5').val(items[1].trim());
        if (items.length > 2) $('#size').val(items[2].trim());
    });

	$(document).on( 'click', '.btn-del', function (e) {
		var app_ver = $(this).parent().parent().find('td').eq(0).text();
		var version = $(this).parent().parent().find('td').eq(1).text();
		swal({
	        title: "Are you sure?",
	        text: "password again!",
	        type: "input",
	        showCancelButton: true,
	        confirmButtonColor: "#DD6B55",
	        confirmButtonText: "Check Password!",
	        closeOnConfirm: false
	    }, function (inputval) {
	        if (inputval == '' || inputval == null) return;
	        $.ajax({
	            url: "/Login/checkpw",
	            type: "POST",
	            async: false,
	            data: { 'passwd': inputval },
	            success: function ( result ) {
		            if (result == 'true')
		            {
					    $.ajax({
				            url: "/Server/versiondel",
				            type: "POST",
				            data: { 'app_ver': app_ver, 'version': version},
				            success: function (result) {
					            if ( result == '1' )
					            {
						            swal("Delete Complete!", "Delete Complete", "success");
						            $('#versioninfo').dataTable().api().ajax.reload();
					            }
					            else
					            {
						            swal("Delete occurs Error!", "Delete Error", "error");
					            }
					        }
					    })
					}
					else
					{
		                swal("Password Incorrect!", "Please try again", "error");
					}
	            },
	            error: function (xhr, ajaxOptions, thrownError) {
	                swal("Password Incorrect!", "Please try again", "error");
	            }
	        });
	    });
	});
});
