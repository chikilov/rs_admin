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
var BlockFormValidation = function() {
    // Init Bootstrap Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationBootstrap = function(){
	    $.validator.addMethod("checkend", function(value, element) {
		    return ( $('#block_type1').is(':checked') == false || ($('#block_type1').is(':checked') && value != '') );
	    });
        jQuery('#frmFile').validate({
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
                'block_type': {
                    required: true
                },
                'end_at': {
	                checkend: true
                }
            },
            messages: {
	            'block_type': {
		            required: '제재 방법을 선택하세요.'
	            },
                'end_at': {
	                checkend: '기간을 선택하세요.'
                },
                'block_reason': {
	                checkend: '사유를 입력하세요.'
                },
                'admin_memo': {
	                checkend: '관리자 메모를 입력하세요.'
                }
            }
        });
    };

    return {
        init: function () {
            // Init Bootstrap Forms Validation
            initValidationBootstrap();
        }
    };
}();

var MessageInfoDatatables = function() {
    // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFullPagination = function() {
        jQuery('#messageinfo').dataTable({
	        ajax: {
				"type"   : "POST",
				"url"    : '/Block/blockinfo',
				"data"   : {'start_date':jQuery('#start-datepicker').val(), 'end_date':jQuery('#end-datepicker').val()},
				"dataSrc": ""
			},
			columns: [
				{"className" : "text-center", "data" : "created_at", "searchable": true, "render": function ( data, type, row, meta ) {
					return data.replace(/ /gi, '<br />');
				}},
				{"className" : "text-left", "data" : "logt", "searchable": true, "render": function ( data, type, row, meta ) {
					return ( row.block_type == '0' ? '제한 해제' : ( row.block_type == '2' ? '영구 제재' : row.end_at.match(/[0-9]+/g) + '일 제한' ) );
				}},
				{"className" : "text-center", "data" : "block_reason", "searchable": true},
				{"className" : "text-center", "data" : "succ", "searchable": true},
				{"className" : "text-center", "data" : "fail", "searchable": true},
				{"className" : "text-center", "data" : "admin_id", "searchable": true},
				{"className" : "text-center", "data" : "idx", "searchable": true, "render": function ( data, type, row, meta ) {
					return '<button class="btn btn-xs btn-warning btn-xls" data-idx=' + data + '><i class="fa fa-file-excel-o"></i></button>';
				}}
			],
			dom: "<'row'<'col-sm-1'l><'col-sm-5'B><'col-sm-2'><'col-sm-4'f>>" +
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
	BlockFormValidation.init();
	MessageInfoDatatables.init();
	$(document).on("click", "#block_type1", function () {
		$('#end_at').attr('disabled', false)
	});

	$(document).on("click", "#block_type2, #block_type3", function () {
		$('#end_at').attr('disabled', true)
	});

	$(document).on("click", "#btnBlock", function (e) {
		e.preventDefault();
		if ( $('#frmFile').valid() )
		{
			var uidgroup = $('#uidgroup').val().split('\n');
			uidgroup = uidgroup.filter(function(e){return e});
			var uidgrouptext = $('#uidgroup').val().replace( / /gi, '' );
			while ( uidgrouptext.indexOf('\n\s*\n') >= 0 )
			{
				uidgrouptext = uidgrouptext.replace(/\n\s*\n/g, '\n');
			}

			swal({
	            title: "Are you sure?",
	            text: $('#uidgroup').val().replace(/\n\s*\n/gi, '\n') + '\n\n위의 ' + uidgroup.length + '명의 ' + ( $('input[name=block_type]:checked').val() == '0' ? '접속제한을 해제' : '접속을 ' + ( $('input[name=block_type]:checked').val() == '1' ? $('#end_at > option:selected').text() + '간' : '영구적으로' ) + ' 제재' ) + ' 하시겠습니까?',
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes!",
	            closeOnConfirm: false
	        }, function( isConfirm )
	        {
				if (isConfirm) {
					var obj;
					$.ajax({
						method: "POST",
						url: "/Block/setblock",
						data: {'uidgroup':$('#uidgroup').val(), 'type':$('input[name=block_type]:checked').val(), 'end_at':$('#end_at').val(), 'block_reason':$('#block_reason').val(), 'admin_memo':$('#admin_memo').val()},
						success: function (result) {
							obj = eval(result);
							var strTable = '<div id="resultlist" style="height:300px;overflow-y:auto"><table class=\"table table-condensed\"><thead><tr><th class=\"text-center\" style=\"width: 50px;\">#</th><th>UID</th><th class=\"hidden-xs\" style=\"width: 15%;\">Result</th></tr></thead><tbody>';
                            for( var i = 0; i < obj.length; i++ )
                            {
	                        	strTable += '<tr><td class="text-center">' + (i + 1) + '</td>';
	                        	strTable += '<td>' + obj[i].uid + '</td><td class="hidden-xs">';
	                        	strTable += '<span class="label label-' + ( obj[i].result == 'Y' ? 'success' : 'danger' ) + '">' + ( obj[i].result == 'Y' ? 'success' : 'danger' ) + '</span></td></tr>';
                            }
                            strTable += '</tbody></table></div>';

							swal({
								title: "Success..",
								text: "계정 제재처리 결과\n",
								type: "success"
							}, function () {

							});

							$('.sweet-alert > p').append( strTable );
							$('.sweet-alert').css( 'margin-top', '-400px' );
						}
					});
				}
			});
		}
	});

	$(document).on('click', '.btn-xls', function () {
		window.open('/Block/makeexcel/' + $(this).data('idx'));
	});
});
