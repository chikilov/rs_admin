/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */

var MessageInfoDatatables = function() {
    // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFullPagination = function() {
        jQuery('#t_orderid').dataTable({
	        ajax: {
				"type"   : "POST",
				"url"    : '/Purchase/orderid_request',
				"data"   : {'validation_key':jQuery('#validation_key').val()},
				"dataSrc": ""
			},
			columns: [
				{"className" : "text-left", "data" : "created_at", "searchable": true},
				{"className" : "text-center", "data" : "uid", "searchable": true},
				{"className" : "text-center", "data" : "market", "searchable": true},
                {"className" : "text-center", "data" : "order_id", "searchable": true},
                {"className" : "text-center", 
                    "data" : {
                        "order_id":"order_id",
                        "validation_key":"validation_key",
                        "state":"state"
                    },
                    "searchable": true,
                    "render":function(data, type, row, meta) {
                            if (data.state == 2) {
                                return '<button class="btn btn-xs btn-danger btn-refund" style="float:right" type="button" value="' + data.validation_key + '"">환불요청</button>';
                            }
                            return '<button class="btn btn-xs btn-danger btn-refund" disabled style="float:right" type="button">환불요청</button>';
                    }
                },
                {"className" : "text-center", "data" : "state", "searchable": true,
                    "render":function(data, type, row, meta) {
                        var msg = '잘못된 키 값';
                        var label = 'danger';

                        if (data == 0) { msg = '결제 확인 중'; label = 'info'; }
                        else if (data == 1) { msg = '결제 확인 완료'; label = 'success'; }
                        else if (data == 2) { msg = '구매 완료'; label = 'primary'; }
                        else if (data == 3) { msg = '환불 처리 완료'; label = 'default'; }

                        return '<span class="label label-'+label+'">'+msg+'</span>';
                    }
                },
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
	$(document).on("click", "#btnSearch", function () {
		if ( jQuery('#validation_key').val() != '' )
		{
			MessageInfoDatatables.init();
		}
	});

    $(document).on( 'click', '.btn-refund', function (e) {
        var uid = $(this).parent().parent().find('td').eq(1).text();
        var validation_key = e.currentTarget.value;
        swal({
                title: "환불을 요청하시겠습니까? 요청 후 담당자에게 이메일이 발송되며, 실제 환불은 추후 처리됩니다.",
                text: "VALIDATION_KEY = " +  validation_key,
                type: "warning",
                showCancelButton: true,
                onfirmButtonClass: "btn-danger",
                confirmButtonText: "환불요청",
                cancelButtonText: "취소",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type:'POST',
                        url: '/Purchase/orderid_finishrefund',
                        data: {'uid':uid,'validation_key':validation_key},
                        success: function (result) {
                            if (result == 'true') {
                                swal("환불이 요청되었습니다.");
                                jQuery('#t_orderid').dataTable().api().ajax.reload();
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
