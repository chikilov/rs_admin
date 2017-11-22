<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content content-boxed">
	<!-- Select2 (Material forms) -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">전체유저 지급</h3>
        </div>
        <div class="block-content block-content-narrow">
            <form class="form-horizontal js-validation-bootstrap push-10-t" id="frmPresent" action="" method="post">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="js-datetimepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="true">
                            <input class="form-control" type="text" id="begin_at" name="begin_at" placeholder="Choose a date..">
                            <label for="begin_at">지급 시작 일시</label>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="js-datetimepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="true">
                            <input class="form-control" type="text" id="end_at" name="end_at" placeholder="Choose a date..">
                            <label for="end_at">지급 종료 일시</label>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material input-group">
	                        <select class="js-select2 form-control" id="sendtext" name="sendtext" style="width: 100%;" data-placeholder="고객에게 보낼 선물 메시지를 선택하세요...">
                                <option></option>
<?php
	if ( !empty($arrMessage) )
	{
		foreach( $arrMessage as $row )
		{
?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['t_text']; ?></option>
<?php
		}
	}
?>
	                        </select>
                            <label for="sendtext">선물 메시지</label>
                            <span class="input-group-addon"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material input-group">
                            <input class="form-control" type="text" id="admin_memo" name="admin_memo" placeholder="운영툴에 표시될 내용을 입력하세요...">
                            <label for="admin_memo">메모</label>
                            <span class="input-group-addon"></span>
                        </div>
                    </div>
                </div>
                <!--<div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material">
                            <select class="js-select2 form-control" id="term" name="term" style="width: 100%;" data-placeholder="Choose one..">
                                <option></option>
                                <option value="1">3일</option>
                                <option value="2">7일</option>
                                <option value="3">30일</option>
                                <option value="4">무제한</option>
                            </select>
                            <label for="example2-select2">보관기간</label>
                        </div>
                    </div>
                </div>-->
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material">
                            <select class="js-select2 form-control" id="item_id" name="item_id" style="width: 100%;" data-placeholder="Choose item..">
                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
<?php
	if ( !empty($arrItem) )
	{
		foreach( $arrItem as $row )
		{
?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['t_name']; ?></option>
<?php
		}
	}
?>
                            </select>
                            <label for="item_id">아이템</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material input-group">
                            <input class="form-control" type="text" id="v1" name="v1" placeholder="수량">
                            <label for="v1">수량</label>
                            <span class="input-group-addon"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-primary" type="button" id="btnPresentSend">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Select2 (Material forms) -->
    <!-- All Orders -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">전체 유저 지급 이력</h3>
        </div>
        <div class="block-content">
	        <!-- Datetimepicker -->
		    <div class="row">
		        <div class="col-lg-12">
		            <!-- Datetimepicker (Default forms) -->
		            <div class="block">
		                <div class="block-content block-content-narrow">
		                    <form class="form-horizontal" action="base_forms_pickers_more.php" method="post" onsubmit="return false;">
		                        <div class="form-group">
		                            <label class="col-md-2 control-label" for="start-datetimepicker">날짜 선택</label>
		                            <div class="col-md-4">
		                                <div class="js-datepicker input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="true">
		                                    <input class="form-control" type="text" id="start-datepicker" name="start-datepicker" value="<?php echo date('Y-m-d', strtotime('-7 days') ); ?>" placeholder="Choose a date..">
		                                    <span class="input-group-addon">
		                                        <span class="fa fa-calendar"></span>
		                                    </span>
		                                </div>
		                            </div>
		                            <label class="col-md-1 control-label" style="text-align: center;" for="end-datepicker">~</label>
		                            <div class="col-md-4">
		                                <div class="js-datepicker input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="true">
		                                    <input class="form-control" type="text" id="end-datepicker" name="end-datepicker" value="<?php echo date('Y-m-d'); ?>" placeholder="Choose a date..">
		                                    <span class="input-group-addon">
		                                        <span class="fa fa-calendar"></span>
		                                    </span>
		                                </div>
		                            </div>
		                            <div class="col-md-1">
		                                <button class="btn btn-sm btn-primary" type="submit" id="btnSearch">Submit</button>
		                            </div>
		                        </div>
		                    </form>
		                </div>
		            </div>
		            <!-- END Datetimepicker (Default forms) -->
		        </div>
		    </div>
		    <!-- END Datetimepicker -->
		    <div class="row">
		        <div class="col-lg-12">
		            <table class="table table-borderless table-striped table-vcenter" id="presentlog">
		                <thead>
		                    <tr>
		                        <th class="text-center">지급시간</th>
		                        <th class="visible-lg text-center">아이템명</th>
		                        <th class="hidden-xs text-center">수량</th>
		                        <th class="hidden-xs text-center">메모</th>
		                        <th class="hidden-xs text-center">성공/실패</th>
		                        <th class="hidden-xs text-center">보낸사람</th>
		                        <th class="hidden-xs text-center">관리</th>
		                    </tr>
		                </thead>
		                <tbody>
		                    <tr>
		                        <td class="text-center">
		                            -
		                        </td>
		                        <td class="hidden-xs text-center">
			                        -
		                        </td>
		                        <td class="visible-lg">
		                            -
		                        </td>
		                        <td class="text-center visible-lg">
		                            -
		                        </td>
		                        <!--<td class="text-right hidden-xs">
		                            -
		                        </td>-->
		                        <td class="text-center">
		                            -
		                        </td>
		                        <td class="text-center">
		                            -
		                        </td>
		                        <td class="text-center">
		                            -
		                        </td>
		                    </tr>
		                </tbody>
		            </table>
		        </div>
		    </div>
        </div>
    </div>
    <!-- END All Orders -->
</div>
<!-- Large Modal -->
<div class="modal" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">지급 내역 수정</h3>
                </div>
                <div class="block-content block-content-narrow">
                   <!-- Select2 (Material forms) -->
		            <form class="form-horizontal js-validation-bootstrap push-10-t" id="frmPresentEdit" action="" method="post">
			            <input type="hidden" id="edit_idx" name="edit_idx" value="">
			            <input type="hidden" id="edit_mongokey" name="edit_mongokey" value="">
		                <div class="form-group">
		                    <div class="col-xs-12">
		                        <div class="js-datetimepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="true">
		                            <input class="form-control" type="text" id="edit_begin_at" name="edit_begin_at" placeholder="Choose a date..">
		                            <label for="begin_at">지급 시작 일시</label>
		                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                        </div>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <div class="col-xs-12">
		                        <div class="js-datetimepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="true">
		                            <input class="form-control" type="text" id="edit_end_at" name="edit_end_at" placeholder="Choose a date..">
		                            <label for="end_at">지급 종료 일시</label>
		                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                        </div>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <div class="col-xs-12">
		                        <div class="form-material input-group">
			                        <select class="js-select2 form-control" id="edit_sendtext" name="edit_sendtext" style="width: 100%;" data-placeholder="고객에게 보낼 선물 메시지를 선택하세요...">
		                                <option></option>
<?php
	if ( !empty($arrMessage) )
	{
		foreach( $arrMessage as $row )
		{
?>
		                                <option value="<?php echo $row['id']; ?>"><?php echo $row['t_text']; ?></option>
<?php
		}
	}
?>
			                        </select>
		                            <label for="sendtext">선물 메시지</label>
		                            <span class="input-group-addon"></span>
		                        </div>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <div class="col-xs-12">
		                        <div class="form-material input-group">
		                            <input class="form-control" type="text" id="edit_admin_memo" name="edit_admin_memo" placeholder="운영툴에 표시될 내용을 입력하세요...">
		                            <label for="admin_memo">메모</label>
		                            <span class="input-group-addon"></span>
		                        </div>
		                    </div>
		                </div>
		                <!--<div class="form-group">
		                    <div class="col-xs-12">
		                        <div class="form-material">
		                            <select class="js-select2 form-control" id="term" name="term" style="width: 100%;" data-placeholder="Choose one..">
		                                <option></option>
		                                <option value="1">3일</option>
		                                <option value="2">7일</option>
		                                <option value="3">30일</option>
		                                <option value="4">무제한</option>
		                            </select>
		                            <label for="example2-select2">보관기간</label>
		                        </div>
		                    </div>
		                </div>-->
		                <div class="form-group">
		                    <div class="col-xs-12">
		                        <div class="form-material">
		                            <select class="js-select2 form-control" id="edit_item_id" name="edit_item_id" style="width: 100%;" data-placeholder="Choose item..">
		                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
<?php
	if ( !empty($arrItem) )
	{
		foreach( $arrItem as $row )
		{
?>
		                                <option value="<?php echo $row['id']; ?>"><?php echo $row['t_name']; ?></option>
<?php
		}
	}
?>
		                            </select>
		                            <label for="item_id">아이템</label>
		                        </div>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <div class="col-xs-12">
		                        <div class="form-material input-group">
		                            <input class="form-control" type="text" id="edit_v1" name="edit_v1" placeholder="수량">
		                            <label for="v1">수량</label>
		                            <span class="input-group-addon"></span>
		                        </div>
		                    </div>
		                </div>
		            </form>
					<!-- END Select2 (Material forms) -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary" type="button" id="btnPresentEdit">Submit</button>
            </div>
        </div>
    </div>
</div>
<!-- Large Modal -->
<div class="modal" id="modal-blank" tabindex="-1" role="dialog" aria-hidden="true">
</div>
<!-- END Large Modal -->

<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<!--<script src="<?php echo $one->assets_folder; ?>/js/plugins/chartjs/Chart.min.js"></script>-->
<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/presentsend.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>