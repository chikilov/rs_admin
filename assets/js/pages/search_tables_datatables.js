/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */

var BaseTableDatatables = function() {
    // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFullPagination = function() {
        jQuery('.js-dataTable-full-pagination').dataTable({
	        ajax: {
				"type"   : "POST",
				"url"    : '/Dashboard/userlistdata',
				"data"   : { 'searchval' : $("#searchval").val()},
				"dataSrc": ""
			},
			columns: [
				{"className" : "text-center", "data" : "uid", "searchable": true, "render" : function ( data, type, row, meta ) {
						if ( row.hasOwnProperty('uid') ) { return '<a class="searchResult" style="cursor:pointer;">' + row.uid + '</a>'; } else { return '-'; }
					}
				},
				{"className" : "text-center", "data" : "nickname", "searchable": true, "render" : function ( data, type, row, meta ) {
						if ( row.hasOwnProperty('nickname') ) { return row.nickname; } else { return '-'; }
					}
				}
				/*
				{"className" : "text-center", "data" : "email", "searchable": false},
				{"className" : "text-center", "data" : "affiliate_name", "searchable": true},
				{"className" : "text-center", "data" : "affiliate_type", "searchable": true},
				{"className" : "text-center", "data" : "reg_date", "searchable": false},
				{"className" : "text-center", "data" : "limit_type", "searchable": false, "render" : function ( data, type, row, meta ) { if ( row.limit_type == 'R' && row.retire_date != '' ) { return '탈퇴'; } else { if ( row.limit_type == 'R' ) { return '정지'; } else { return '정상'; } } } },
				{"className" : "text-center", "data" : "retire_date", "searchable": false}
				*/
			],
			destroy: true,
            pagingType: "full_numbers",
            autoWidth: false,
            columnDefs: [ { orderable: true } ],
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
                "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
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
	$(document).on("click", ".searchResult", function (e) {
		e.preventDefault();
		$("#searchuid").val($(this).text());
		$("#searchname").val($(this).parent().siblings(0).text());
		$("#modal-search").modal('hide');
		$("#searchbar").attr('action', document.URL);
		$("#searchbar").submit();
	});
	$(document).on("click", ".js-header-search > form > div > span", function (e) {
		var searchval = $(".js-header-search > form > div > input").val();
		if ( $.type(searchval) === 'string' && searchval != '' )
		{
			$("#commonSearchResult > tbody").html('');
			BaseTableDatatables.init();
		}
		else
		{
            swal('Oops...', '검색할 값을 입력하세요.', 'error');
			$("#modal-search").modal('hide');
		}
	});
});
