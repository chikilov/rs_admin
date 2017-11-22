/*
 *  Document   : base_tables_datatables.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Tables Datatables Page
 */

var BaseFormValidation = function() {
    // Init Bootstrap Forms Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
    var initValidationBootstrap = function(){
	    $.validator.addMethod("isDuplicated", function(value, element) {
		    var returnval;
		    $.ajax({
			    type: 'POST',
			    url: '/Character/dupnick',
			    data: {'nickname':value},
			    async: false,
			    success: function (result) {
				    returnval = ( result > 0 ? false : true );
			    }
		    });
		    return returnval;
	    }, 'Please enter valid name.');

        jQuery('#frmNickName').validate({
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
                'change_nickname': {
                    required: true,
                    isDuplicated: true
                }
            },
            messages: {
                'change_nickname': 'Please enter valid name.'
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

var BasicInfoDatatables = function() {
    // Init full extra DataTable, for more examples you can check out https://www.datatables.net/
    var arrEdit = ['닉네임', '레벨/경험치', '유료 캐시', '무료 캐시', '보유 골드'];
    var initDataTableFullPagination = function() {
	    if ( jQuery('#searchuid').val() !== '' && jQuery('#searchuid').val() !== null )
	    {
	        jQuery('#basicinfo_part1').dataTable({
		        ajax: {
					"type"   : "POST",
					"url"    : '/Character/userbasicinfo',
					"data"   : {'part':'1'},
					"dataSrc": ""
				},
				columns: [
					{"className" : "text-center", "data" : "title", "searchable": false, "render" : function ( data, type, row, meta ) {
							return ( row.title == '0' ? '&nbsp;' : row.title );
						}
					},
					{"className" : "text-center", "data" : "value", "searchable": false, "render" : function ( data, type, row, meta ) {
							return '<span style="float:left;">' + ( row.value == '' && row.title != '0' ? '(없음)' : ( row.value == '/' ? '(없음) / (없음)' : row.value ) ) + '</span>' + ( arrEdit.indexOf( row.title ) === -1 ? '' : '<button class="btn btn-info btn-xs push-5-r push-10" style="float:right;" type="button"><i class="fa fa-pencil"></i></button>') + ( row.title == '계정 상태' && row.value == '정상' ? '<button class="btn btn-xs btn-primary" style="float:right;" type="button" id="btnBlock"><i class="fa fa-ban"></i></button>' : '' );
						}
					}
				],
				destroy: true,
				paging: false,
				info: false,
				searching: false,
				ordering: false
	        });
	        jQuery('#basicinfo_part1 > thead').remove();
	        jQuery('#basicinfo_part1').removeClass('no-footer');
	        jQuery('#basicinfo_part2').dataTable({
		        ajax: {
					"type"   : "POST",
					"url"    : '/Character/userbasicinfo',
					"data"   : {'part':'2'},
					"dataSrc": ""
				},
				columns: [
					{"className" : "text-center", "data" : "title", "searchable": false, "render" : function ( data, type, row, meta ) {
							return ( row.title == '0' ? '&nbsp;' : row.title );
						}
					},
					{"className" : "text-center", "data" : "value", "searchable": false, "render" : function ( data, type, row, meta ) {
							return '<span style="float:left;">' + ( row.value == '' && row.title != '0' ? '(없음)' : ( row.value == '/' ? '(없음) / (없음)' : row.value ) ) + '</span>' + ( arrEdit.indexOf( row.title ) === -1 ? '' : '<button class="btn btn-info btn-xs push-5-r push-10" style="float:right;" type="button"><i class="fa fa-pencil"></i></button>') + ( row.title == '계정 상태' && row.value == '정상' ? '<button class="btn btn-xs btn-primary" style="float:right;" type="button" id="btnBlock"><i class="fa fa-ban"></i></button>' : '' );
						}
					}
				],
				destroy: true,
				paging: false,
				info: false,
				searching: false,
				ordering: false
	        });
	        jQuery('#basicinfo_part2 > thead').remove();
	        jQuery('#basicinfo_part2').removeClass('no-footer');
	        jQuery('#basicinfo_part3').dataTable({
		        ajax: {
					"type"   : "POST",
					"url"    : '/Character/userbasicinfo',
					"data"   : {'part':'3'},
					"dataSrc": ""
				},
				columns: [
					{"className" : "text-center", "data" : "title", "searchable": false, "render" : function ( data, type, row, meta ) {
							return ( row.title == '0' ? '&nbsp;' : row.title );
						}
					},
					{"className" : "text-center", "data" : "value", "searchable": false, "render" : function ( data, type, row, meta ) {
							return '<span style="float:left;">' +
								( row.value == '' && row.title != '0' ? '(없음)' : ( row.value == '/' ? '(없음) / (없음)' : row.value ) ) + '</span>' +
								( arrEdit.indexOf( row.title ) === -1 ? '' : '<button class="btn btn-info btn-xs push-5-r push-10" style="float:right;" type="button"><i class="fa fa-pencil"></i></button>') +
								( row.title == '계정 상태' && row.value == '정상' ?
									'<button class="btn btn-xs btn-primary" style="float:right;" type="button" id="btnBlock"><i class="fa fa-ban"></i></button>' :
									( row.title == '계정 상태' && row.value.substr(0, 3) == '제제중' ?
										'&nbsp;<button class="btn btn-xs btn-primary" type="button" id="btnFree"><i class="fa fa-trash"></i></button>' : ''
									)
								);
						}
					}
				],
				destroy: true,
				paging: false,
				info: false,
				searching: false,
				ordering: false
	        });
	        jQuery('#basicinfo_part3 > thead').remove();
	        jQuery('#basicinfo_part3').removeClass('no-footer');
			$('#basicinfo_part1, #basicinfo_part2, #basicinfo_part3').on( 'draw.dt', function () {
				$(this).find('tr').css('height', '56px');
			} );
	    }
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
	BasicInfoDatatables.init();
	BaseFormValidation.init();
});
