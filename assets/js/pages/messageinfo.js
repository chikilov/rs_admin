/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */

var MessageInfoDatatables = function() {
    // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFullPagination = function() {
        jQuery('#messageinfo').dataTable({
	        ajax: {
				"type"   : "POST",
				"url"    : '/Character/usermessageinfo',
				"data"   : {'start_date':jQuery('#start-datepicker').val(), 'end_date':jQuery('#end-datepicker').val()},
				"dataSrc": ""
			},
			columns: [
				{"className" : "text-left", "data" : "logt", "searchable": true, "render": function ( data, type, row, meta ) {
					return row.logt + '<br />' + row.logc;
				}},
				{"className" : "text-center", "data" : "nickname", "searchable": true},
				{"className" : "text-center", "data" : "created_at", "searchable": true, "render": function ( data, type, row, meta ) {
					return data.replace(/ /gi, '<br />');
				}},
				{"className" : "text-center", "data" : "type", "searchable": true},
				{"className" : "text-center", "data" : "amount", "searchable": true},
				{"className" : "text-center", "data" : "value", "searchable": true},
				{"className" : "text-center", "data" : "isRead", "searchable": true},
				{"className" : "text-center", "data" : "read_at", "searchable": true, "render": function ( data, type, row, meta ) {
					return ( row.isRead != '미수령' ? ( row.isRead == '삭제(회수)' ? data.replace(/ /gi, '<br />') + '&nbsp;<button class="btn btn-xs btn-primary btnUndoRe" data-objectid="'+ row._id.$id +'"><i class="fa fa-undo"></i></button>' : data.replace(/ /gi, '<br />') ) : data );
				}},
				{"className" : "text-center", "data" : "expired_at", "searchable": true, "render": function ( data, type, row, meta ) {
					return ( data == null ? '(없음)' : data.replace(/ /gi, '<br />') );
				}}
				/*
				{"className" : "text-center", "data" : "value", "searchable": false, "render" : function ( data, type, row, meta ) {
						return ( row.value == '' && row.title != '0' ? '-' : ( row.value == '/' ? '- / -' : row.value ) );
					}
				}*/
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

	$(document).on("click", ".btnUndo", function () {
		var idVal = $(this).data('objectid');
		swal({
            title: "Are you sure?",
            text: $('#searchname').val() + '님의 ' + $(this).parent().parent().children('td').eq(3).text() + ' : ' + $(this).parent().parent().children('td').eq(4).text() + '를 회수 하시겠습니까?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: false
        }, function( isConfirm )
        {
	        if ( isConfirm )
	        {
				$.ajax({
					type: 'POST',
					url: '/Character/setrecall',
					data: { '_id': idVal },
					success: function (result) {
						if ( result == '1' )
						{
							swal({
								title: "Success..",
								text: "회수 처리가 완료되었습니다.",
								type: "success"
							});
							jQuery('#messageinfo').dataTable().api().ajax.reload();
						}
						else
						{
							swal({
								title: "Oop..",
								text: "회수 처리에 오류가 발생하였습니다.",
								type: "error"
							});
						}
					}
				});
			}
		});
	});

	$(document).on("click", ".btnUndoRe", function () {
		var idVal = $(this).data('objectid');
		swal({
            title: "Are you sure?",
            text: $('#searchname').val() + '님의 ' + $(this).parent().parent().children('td').eq(3).text() + ' : ' + $(this).parent().parent().children('td').eq(4).text() + '를 다시 지급 하시겠습니까?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: false
        }, function( isConfirm )
        {
	        if ( isConfirm )
	        {
				$.ajax({
					type: 'POST',
					url: '/Character/setrecallre',
					data: { '_id': idVal },
					success: function (result) {
						if ( result == '1' )
						{
							swal({
								title: "Success..",
								text: "지급 처리가 완료되었습니다.",
								type: "success"
							});
							jQuery('#messageinfo').dataTable().api().ajax.reload();
						}
						else
						{
							swal({
								title: "Oop..",
								text: "지급 처리에 오류가 발생하였습니다.",
								type: "error"
							});
						}
					}
				});
			}
		});
	});
});
