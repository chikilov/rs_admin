<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content content-boxed">
	<!-- Select2 (Material forms) -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">점검 관리</h3>
        </div>
        <div class="block-content block-content-narrow">
            <form class="form-horizontal js-validation-bootstrap push-10-t" id="frmPresent" action="" method="post">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="js-datetimepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="true" data-format="YYYY-MM-DD HH:mm:ss">
                            <input class="form-control" type="text" id="begin_at" name="begin_at" placeholder="Choose a date..">
                            <label for="begin_at">점검 시작 일시</label>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="js-datetimepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="true" data-format="YYYY-MM-DD HH:mm:ss">
                            <input class="form-control" type="text" id="end_at" name="end_at" placeholder="Choose a date..">
                            <label for="end_at">점검 종료 일시</label>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material input-group">
                            <input class="form-control" type="text" id="inspection_text" name="inspection_text" placeholder="클라이언트에 노출 될 점검 내용을 입력하세요...">
                            <label for="inspection_text">점검 내용 (텍스트)</label>
                            <span class="input-group-addon"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material input-group">
                            <input class="form-control" type="text" id="confirm_url" name="confirm_url" placeholder="점검 팝업에서 확인 버튼 링크 웹페이지 주소를 입력하세요...">
                            <label for="confirm_url">참고 페이지 주소</label>
                            <span class="input-group-addon"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-primary" type="submit" id="btnCheck">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Select2 (Material forms) -->
    <!-- All Orders -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">점검 내역</h3>
        </div>
        <div class="block-content">
		    <div class="row">
		        <div class="col-lg-12">
		            <table class="table table-borderless table-striped table-vcenter" id="maintenancelog">
		                <thead>
		                    <tr>
		                        <th class="text-center">점검 시작 일시</th>
		                        <th class="visible-lg text-center">점검 종료 일시</th>
		                        <th class="hidden-xs text-center">점검 내용 (텍스트)</th>
		                        <th class="hidden-xs text-center">참고 페이지 주소</th>
		                        <th class="hidden-xs text-center">상태</th>
		                        <th class="hidden-xs text-center">관리</th>
		                    </tr>
		                </thead>
		                <tbody>
		                    <tr>
		                        <td class="text-center">
		                            -
		                        </td>
		                        <td class="text-center">
			                        -
		                        </td>
		                        <td class="text-center">
		                            -
		                        </td>
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
            <form class="form-horizontal js-validation-bootstrap push-10-t" id="frmEdit" method="post">
                <input type="hidden" name="edit_id" id="edit_id" value="">
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
		                <div class="form-group">
		                    <div class="col-xs-12">
		                        <div class="js-datetimepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="true" data-format="YYYY-MM-DD HH:mm:ss">
		                            <input class="form-control" type="text" id="edit_begin_at" name="edit_begin_at" placeholder="Choose a date..">
		                            <label for="edit_begin_at">점검 시작 일시</label>
		                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                        </div>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <div class="col-xs-12">
		                        <div class="js-datetimepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="true" data-format="YYYY-MM-DD HH:mm:ss">
		                            <input class="form-control" type="text" id="edit_end_at" name="edit_end_at" placeholder="Choose a date..">
		                            <label for="edit_end_at">점검 종료 일시</label>
		                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                        </div>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <div class="col-xs-12">
		                        <div class="form-material input-group">
		                            <input class="form-control" type="text" id="edit_inspection_text" name="edit_inspection_text" placeholder="클라이언트에 노출 될 점검 내용을 입력하세요...">
		                            <label for="edit_inspection_text">점검 내용 (텍스트)</label>
		                            <span class="input-group-addon"></span>
		                        </div>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <div class="col-xs-12">
		                        <div class="form-material input-group">
		                            <input class="form-control" type="text" id="edit_confirm_url" name="edit_confirm_url" placeholder="점검 팝업에서 확인 버튼 링크 웹페이지 주소를 입력하세요...">
		                            <label for="edit_confirm_url">참고 페이지 주소</label>
		                            <span class="input-group-addon"></span>
		                        </div>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <div class="col-xs-12">
	                            <label class="css-input css-radio css-radio-default push-10-r">
	                                <input type="radio" name="edit_active" value="1"><span></span> 활성
	                            </label>
	                            <label class="css-input css-radio css-radio-default">
	                                <input type="radio" name="edit_active" value="0"><span></span> 비활성
	                            </label>
		                    </div>
		                </div>
	                </div>
	            </div>
	            <div class="modal-footer">
	                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
	                <button class="btn btn-sm btn-primary" type="submit" id="btnCheckEdit">Submit</button>
	            </div>
            </form>
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
<script src="<?php echo $one->assets_folder; ?>/js/pages/statusinfo.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>