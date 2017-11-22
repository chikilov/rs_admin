/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */
var BaseTableDatatables = function() {
    // Init full DataTable, for more examples you can check out https://www.datatables.net/
    $.validator.addMethod('checktype', function (value, element) {
	    return ( jQuery('#search_type > option:selected').index() > 0 );
    }, lang['need_type']);
    var initValidator = function () {
	    jQuery('.js-validation-register').validate({
		    ignore: "",
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
                'search_value': {
	                checktype: true,
	                required: true
                }
            },
            messages: {
                'search_value': {
	                required: lang['need_value']
                }
            }
        });
    };

    // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFullPagination = function() {
        jQuery('.js-dataTable-full-pagination').dataTable({
            pagingType: "full_numbers",
            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
            pageLength: 10,
            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
			retrieve: true
        });
    };

    // DataTables Bootstrap integration
    var bsDataTables = function() {
        var $DataTable = jQuery.fn.dataTable;

        // Set the defaults for DataTables init
        jQuery.extend( true, $DataTable.defaults, {
            dom:
                "<'row'<'col-sm-6'Bl><'col-sm-6'f>>" +
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
            },
            buttons: [
            	'copy', 'csv', 'excel', 'pdf', 'print'
			]
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
            initValidator();
        }
    };
}();

// Initialize when page loads
jQuery(function(){ BaseTableDatatables.init(); });
jQuery(function(){
    // Init page helpers (BS Datepicker + BS Datetimepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
    App.initHelpers(['datepicker', 'select2', ]);

    jQuery(document).on( 'click', '#search_term1', function () {
	    var now = moment();
		jQuery('#daterange2').val(now.format('YYYY[-]MM[-]DD'));
		jQuery('#daterange1').val(now.add(-7, 'days').format('YYYY[-]MM[-]DD'));
    });

    jQuery(document).on( 'click', '#search_term2', function () {
	    var now = moment();
		jQuery('#daterange2').val(now.format('YYYY[-]MM[-]DD'));
		jQuery('#daterange1').val(now.add(-1, 'months').format('YYYY[-]MM[-]DD'));
    });

    jQuery(document).on( 'click', '#btnSearch', function () {
		if ( jQuery('.js-validation-register').valid() )
		{
			jQuery('#log_info').dataTable({
	            columnDefs: [ { orderable: false, targets: [ 0 ] } ],
	            pageLength: 10,
	            lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
				"ajax": {
					"type"   : "POST",
					"url"    : '/Admin/adminloglist',
					"data"   : {'daterange1': jQuery('#daterange1').val(), 'daterange2': jQuery('#daterange2').val(), 'search_type': jQuery('#search_type').val(), 'search_value': jQuery('#search_value').val()},
					"dataSrc": ""
				},
				columns: [
					{"className" : "text-center", "data" : "idx"},
					{"className" : "text-center", "data" : "created_at"},
					{"className" : "text-center", "data" : "admin_id"},
					{"className" : "text-center", "data" : "uid"},
					{"className" : "text-center", "data" : "action"},
					{"className" : "", "data" : "details", "render":function ( data, type, row, meta ) {
						return data.replace(/\\n/gi, '<br />');
					}}
				],
				destroy: true,
				autoWidth: false,
				paging: true,
				info: true,
				searching: true,
				ordering: true,
				order: [[ 3, 'desc' ]]
	        });
		}
    });
// Login Check Start
    jQuery.fn.dataTable.ext.errMode = 'none';
	jQuery(document).ajaxError(function(event, jqxhr, settings, thrownError) {
		if ( jqxhr.status == 901 )
		{
			swal({
				title: lang['need_to_login'],
				text: lang['need_to_login'],
				type: 'error'
			}, function () {
				window.location.href = '/Login';
			});
			return;
		}
		else
		{
			swal({
				title: lang['data_load_error'],
				text: lang['data_load_error'],
				type: 'error'
			}, function () {
				window.location.href = '/User/userinfo';
			});
			return;
		}
	});
// Login Check End
});
