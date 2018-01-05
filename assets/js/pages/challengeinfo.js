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
        jQuery('#stageinfo').dataTable({
	        ajax: {
				"type"   : "POST",
				"url"    : '/Character/challengelist',
				"data"   : {},
				"dataSrc": ""
			},
			columns: [
				{"className" : "text-center", "data" : "t_song", "searchable": true, "render": function (data, type, row, meta) {
					return row.t_name + ( data ? ' ( ' + data + ' )' : '' );
				}},
				{"className" : "text-center", "data" : "c_cond", "searchable": true, "render":function(data, type, row, meta) {
					if ( row.c_cond )
					{
						var strCond = '';
						for ( var i in row.c_cond )
						{
							strCond += '<br />';
							var val = eval( 'row.c_cond.' + i );
							if ( i == 'sc' )
							{
								strCond += '스코어 : ' + val;
							}
							else if ( i == 'ac' )
							{
								strCond = '정확도(%)가 일정 이상 : ' + val;
							}
							else if ( i == 'cb' )
							{
								strCond = '콤보 갯수 : ' + val;
							}
							else if ( i == 'mi' )
							{
								strCond = '미스 판정 갯수 : ' + val;
							}
							else if ( i == 'ni' )
							{
								strCond = '배드 이상 판정 갯수 : ' + val;
							}
							else if ( i == 'gd' )
							{
								strCond = '굿 이상 판정 갯수 : ' + val;
							}
							else if ( i == 'gt' )
							{
								strCond = '그레이트 이상 판정 갯수 : ' + val;
							}
							else if ( i == 'pf' )
							{
								strCond = '퍼펙트 이상 판정 갯수 : ' + val;
							}
							else if ( i == 'kill' )
							{
								strCond = '몬스터 퇴치 수 : ' + val;
							}
							else
							{
								strCond = '몬스터 ' + i + ' : ' + val;
							}
						}

						return strCond;
					}
					else
					{
						return '-';
					}
				}},
				{"className" : "text-center", "data" : "hs", "searchable": true, "render": function (data, type, row, meta) {
					return 'score : ' + row.hs + '<br />accuracy : ' + row.a + '<br />combo : ' + row.cb + '<br />miss count : not in service'
						+ '<br />over bad : ' + (row.gds[1] + row.gds[2] + row.gds[3] + row.gds[4]) + '<br />over good : ' + (row.gds[2] + row.gds[3] + row.gds[4])
						+ '<br />over great : ' + (row.gds[3] + row.gds[4]) + '<br />over perfect : ' + row.gds[4] + '<br />kill : ' + row.ec + '<br />monster info : not in service';
				}},
				{"className" : "text-center", "data" : "u_at", "searchable": true},
				{"className" : "text-center", "data" : "st", "searchable": true},
				{"className" : "text-center", "data" : "pc", "searchable": true, "render": function (data, type, row, meta) {
					return '플레이 횟수 : ' + row.pc + '<br />클리어 횟수 : ' + row.cc + '<br />실패 횟수 : ' + row.fc + '<br />클리어 전까지 플레이 횟수 : ' + row.tc + '<br /> 클리어 전까지 실패 횟수 : ' + row.cfc;
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

	$(document).on('show.bs.modal', '#modal-lvedit', function (e) {
		var button = $(e.relatedTarget);
		$('#heroid').val(button.data('id'));
		$('#lv').val(button.data('lv'));
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
							jQuery('#stageinfo').dataTable().api().ajax.reload();
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

	$(document).on('change', '#hid', function () {
		if ( $(this).parent().parent().parent().hasClass('has-error') )
		{
			$('#frmSSEdit').valid();
		}
	});

	$(document).on('click', '#btnSSEdit', function (e) {
		e.preventDefault();
		if ( $('#frmSSEdit').valid() )
		{
			$.ajax({
				type:'POST',
				url:'/Character/soulstoneedit',
				data:{'hid':$('#hid').val(), 'amount':$('#amount').val(), 'admin_memo':$('#admin_memo3').val()},
				success: function (result) {
					if ( result == '1' )
					{
						swal({
							title: "Success..",
							text: "영혼석이 지급되었습니다.",
							type: "success"
						}, function () {
							$('#modal-ssedit').modal('hide');
							jQuery('#stageinfo').dataTable().api().ajax.reload();
						});
					}
					else
					{
						swal({
							title: "Fail..",
							text: "영혼석 지급에 실패하였습니다.",
							type: "error"
						});
					}
				}
			});
		}
	});

	$(document).on('click', '.btn-delete', function () {
	    var button = $(this);
		swal({
            title: "Are you sure?",
            text: 'UID : ' + $('#searchuid').val() + '\n히어로 : ' + $(this).parent().parent().children('td').eq(0).text() + '\n회수 하시겠습니까?\n\n아래에 관리자메모를 입력하세요',
            type: "input",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: false
        }, function( isConfirm )
        {
			if (isConfirm != '') {
				$.ajax({
					method: "POST",
					url: "/Character/recallhero",
					data: {'id':button.data('id'), 'admin_memo':$('.sweet-alert').find('input').val()},
					dataType: 'html',
					success: function (result) {
						if ( result == '1' )
						{
							swal({
								title: "Success..",
								text: "회수처리가 완료되었습니다.",
								type: "success"
							}, function () {
								$('#stageinfo').dataTable().api().ajax.reload();
							});
						}
						else
						{
							swal({
								title: "Oop..",
								text: "회수처리에 오류가 발생하였습니다.",
								type: "error"
							});
						}
					}
				});
			}
		});
	});

	$(document).on('change', '#hid2', function () {
		if ( $(this).val() != '' )
		{
			var hid = $(this).val();
			$('#grade').attr('disabled', false);
			$.ajax({
				method: "POST",
				url: "/Character/gradelist",
				data: {'hid':hid},
				dataType: 'html',
				success: function (result) {
					var obj = eval(result);
					for( var i = 0; i < obj.length; i++ )
					{
						$('#grade').append($('<option>', { value:obj[i].hid, text:obj[i].hid.toString().substr(obj[i].hid.toString().length - 2, obj[i].hid.toString().length) }));
					}
				}
			});
		}
		else
		{
			$('#grade').attr('disabled', true);
		}
	});

	$(document).on('click', '#btnHIns', function () {
		swal({
            title: "Are you sure?",
            text: 'UID : ' + $('#searchuid').val() + '\n히어로 : ' + $('#hid2 > option:selected').text() + ' - (' + $('#grade > option:selected').text() + ')\n지급 하시겠습니까?',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            closeOnConfirm: true
        }, function( isConfirm )
        {
			if (isConfirm != '') {
				$.ajax({
					method: "POST",
					url: "/Character/sendhero",
					data: {'hid':$('#grade > option:selected').val(), 'admin_memo':$('#admin_memo2').val()},
					dataType: 'html',
					success: function (result) {
						if ( result == '1' )
						{
							swal({
								title: "Success..",
								text: "지급처리가 완료되었습니다.",
								type: "success"
							}, function () {
								$('#stageinfo').dataTable().api().ajax.reload();
							});
						}
						else
						{
							swal({
								title: "Oop..",
								text: "지급처리에 오류가 발생하였습니다.",
								type: "error"
							});
						}
					}
				});
			}
		});
	});
});
