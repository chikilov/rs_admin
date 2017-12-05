/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */
$.fn.modal.Constructor.prototype.enforceFocus = function() {};
var HeroEditValidation = function() {
    // Init Bootstrap Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationBootstrap = function(){
        jQuery('#frmHero').validate({
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
	            'lv': {
                    required: true
                },
                'admin_memo': {
	                required: true
                }
            },
            messages: {
	            'lv': {
		            required: '레벨을 입력하세요.'
	            },
                'admin_memo': {
	                required: '관리자 메모를 입력하세요.'
                }
            }
        });

        jQuery('#frmSSEdit').validate({
            ignore: ['input[type=hidden]'],
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
	            'hid': {
                    required: true
                },
	            'amount': {
                    required: true
                },
                'admin_memo2': {
	                required: true
                }
            },
            messages: {
	            'hid': {
		            required: '지급할 영혼석을 선택하세요.'
	            },
	            'amount': {
		            required: '지급할 영혼석의 수량을 입력하세요.'
	            },
                'admin_memo2': {
	                required: '관리자 메모를 입력하세요.'
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

var HeroInfoDatatables = function() {
    // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
    var initDataTableFullPagination = function() {
        jQuery('#freeinfo').dataTable({
	        ajax: {
				"type"   : "POST",
				"url"    : '/Character/freelist',
				"data"   : {},
				"dataSrc": ""
			},
			columns: [
				{"className" : "text-center", "data" : "t_song", "searchable": true},
				{"className" : "text-center", "data" : "key", "searchable": true},
				{"className" : "text-center", "data" : "diff", "searchable": true},
				{"className" : "text-center", "data" : "u_at", "searchable": true, "render": function (data, type, row, meta) {
    				if ( typeof(data) != 'undefined' ) {
    				    return moment.unix(row.u_at.sec).format('YYYY-MM-DD HH:mm:ss');
    				} else {
        				return '';
    				}
				}},
				{"className" : "text-center", "data" : "tp", "searchable": true, "render": function (data, type, row, meta) {
    				if ( typeof(data) != 'undefined' ) {
    				    return row.tp;
    				} else {
        				return '';
    				}
				}},
				{"className" : "text-center", "data" : "pc", "searchable": true, "render": function (data, type, row, meta) {
    				if ( typeof(data) != 'undefined' ) {
    				    return row.pc;
    				} else {
        				return '';
    				}
				}},
				{"className" : "text-center", "data" : "cc", "searchable": true, "render": function (data, type, row, meta) {
    				if ( typeof(data) != 'undefined' ) {
    				    return row.cc;
    				} else {
        				return '';
    				}
				}},
				{"className" : "text-center", "data" : "fc", "searchable": true, "render": function (data, type, row, meta) {
    				if ( typeof(data) != 'undefined' ) {
    				    return row.fc;
    				} else {
        				return '';
    				}
				}},
				{"className" : "text-center", "data" : "tc", "searchable": true, "render": function (data, type, row, meta) {
    				if ( typeof(data) != 'undefined' ) {
    				    return row.tc;
    				} else {
        				return '';
    				}
				}},
				{"className" : "text-center", "data" : "cfc", "searchable": true, "render": function (data, type, row, meta) {
    				if ( typeof(data) != 'undefined' ) {
    				    return row.cfc;
    				} else {
        				return '';
    				}
				}},
				{"className" : "text-center", "data" : "hs", "searchable": true, "render": function (data, type, row, meta) {
    				if ( typeof(data) != 'undefined' ) {
    				    return row.hs;
    				} else {
        				return '';
    				}
				}}
				//, "render": function (data, type, row, meta) {}
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
            order: [[0, 'asc']],
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
	HeroEditValidation.init();
	HeroInfoDatatables.init();

	$(document).on('show.bs.modal', '#modal-hins', function (e) {
		$.ajax({
    		type:'POST',
            url:'/Character/freeGetList',
			data:{},
			success: function (result) {
    			var obj = eval('(' + result + ')');
    			$('#tid').empty();
    			$('#bms').empty();
    			$('#tid').append('<option value=""></option>');
    			for( prop in obj ) {
        			$('#tid').append('<option value="' + prop + '">' + obj[prop].t_song + '</option>');
        			$('#tid').select2().trigger('change');
    			}
			}
		});
	});

	$(document).on('click', '#btnlvEdit', function () {
		if ( $('#frmHero').valid() )
		{
			$.ajax({
				type:'POST',
				url:'/Character/heroleveledit',
				data:{'id':$('#heroid').val(), 'lv':$('#lv').val(), 'admin_memo':$('#admin_memo').val()},
				success: function (result) {
					if ( result == '1' )
					{
						swal({
							title: "Success..",
							text: "레벨이 변경되었습니다.",
							type: "success"
						}, function () {
							jQuery('#heroinfo').dataTable().api().ajax.reload();
						});
					}
					else
					{
						swal({
							title: "Fail..",
							text: "레벨변경이 처리되지 않았습니다.",
							type: "error"
						});
					}
				}
			});
		}
	});

	$(document).on('change', '#tid', function () {
		if ( $(this).val() != '' )
		{
			$('#bms').attr('disabled', false);
			$.ajax({
        		type:'POST',
                url:'/Character/freeGetList',
    			data:{},
    			success: function (result) {
        			var obj = eval('(' + result + ')');
        			$('#bms').empty();
        			obj = obj[$('#tid').val()];
                    $('#bms').append('<option value=""></option>');
        			for( prop in obj['bms'] ) {
            			$('#bms').append('<option value="' + Object.keys(obj['bms'][prop])[0] + '">' + obj['bms'][prop][Object.keys(obj['bms'][prop])[0]] + '</option>');
            			$('#bms').select2().trigger('change');
        			}
    			}
    		});
		}
		else
		{
			$('#bms').attr('disabled', true);
		}
	});

	$(document).on('click', '#btnHIns', function () {
		swal({
            title: "Are you sure?",
            text: 'UID : ' + $('#searchuid').val() + '\n해금곡 : ' + $('#tid > option:selected').text() + ' - (' + $('#bms > option:selected').text() + ')\n해금 하시겠습니까?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: false
        }, function( isConfirm )
        {
			if (isConfirm)
			{
				$.ajax({
					method: "POST",
					url: "/Character/sendfreestage",
					data: {'bms':$('#bms > option:selected').val(), 'tid':$('#tid > option:selected').val(), 'admin_memo':$('#admin_memo').val()},
					dataType: 'html',
					success: function (result) {
						if ( result == '1' )
						{
							swal({
								title: "Success..",
								text: "해금처리가 완료되었습니다.",
								type: "success"
							}, function () {
								$('#modal-hins').modal('hide');
								$('#tid').val('').trigger('change');
								$('#bms').val('').trigger('change');
								$('#admin_memo').val('');
								$('#freeinfo').dataTable().api().ajax.reload();
							});
						}
						else
						{
							swal({
								title: "Oop..",
								text: "해금처리에 오류가 발생하였습니다.",
								type: "error"
							});
						}
					}
				});
			}
		});
	});
});
