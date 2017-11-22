<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content content-boxed">
	<!-- Select2 (Material forms) -->
    <div class="block">
    <!-- All Orders -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">버전 관리</h3>
        </div>
        <div class="block-content">
		    <!-- END Datetimepicker -->
		    <div class="row">
		        <div class="col-lg-12">
		            <table class="table table-borderless table-striped table-vcenter" id="versioninfo">
		                <thead>
		                    <tr>
		                        <th class="text-center">app_ver</th>
		                        <th class="visible-lg text-center">version</th>
		                        <th class="hidden-xs text-center">name</th>
		                        <th class="hidden-xs text-center">md5</th>
		                        <th class="hidden-xs text-center">size</th>
		                        <th class="hidden-xs text-center">삭제</th>
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
		    <div class="row" style="min-height: 50px;margin-right: 10px;">
		        <button class="btn btn-info" data-toggle="modal" data-target="#modal-large2" style="float:right;margin-left:10px;" type="button">일괄등록</button>
		        <button class="btn btn-info" data-toggle="modal" data-target="#modal-large" style="float:right" type="button">등록</button>
		    </div>
        </div>
    </div>
    <!-- END All Orders -->
</div>
<div class="modal in" id="modal-large" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="block block-themed">
                <div class="block-header bg-primary">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                        <li>
                            <button type="button" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">버전 등록</h3>
                </div>
                <div class="block-content">
                    <form class="form-horizontal push-10-t push-10" id="fAddPatchInfo" method="post" onsubmit="return false;">
                        <div class="form-group">
                            <div class="col-xs-12" id="frmgroupSel">
                                <div class="form-material">
                                    <select class="js-select2 form-control" id="app_ver_s" name="app_ver_s" style="width: 100%;">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
<?php
	foreach ( $arrAppver as $key => $val )
	{
?>
										<option value="<?php echo $val; ?>"><?php echo $val; ?></option>
<?php
	}
?>
										<option value="-">신규 등록</option>
                                    </select>
                                    <label for="example2-select2">App ver.</label>
                                </div>
                            </div>
                            <div class="col-xs-12" id="frmgroupIpt" style="display: none;">
                                <div class="form-material col-xs-8">
                                    <input class="form-control" type="text" id="app_ver" name="app_ver" style="width:80%;">
                                    <label for="name">App ver.</label>
                                </div>
                                <div class="col-xs-4" style="float:right">
									<button class="btn btn-sm btn-default" type="button" id="btnTextCancel">취소</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material col-xs-10">
                                    <input class="form-control" type="text" id="parseform" name="parseform" placeholder="파일이름,MD5,Size">
                                    <label for="parseform">한번에 입력</label>
                                </div>
                                <div class="col-xs-2" style="float:right">
                                    <button class="btn btn-sm btn-success" type="button" id="btnParseform">확인</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="name" name="name">
                                    <label for="name">Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="md5" name="md5">
                                    <label for="md5">MD5</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="size" name="size">
                                    <label for="size">Size</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="admin_memo" name="admin_memo">
                                    <label for="admin_memo">Admin Memo</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary" type="button" id="btnSubmit"><i class="fa fa-check"></i> Ok</button>
            </div>
        </div>
    </div>
</div>
<div class="modal in" id="modal-large2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="block block-themed">
                <div class="block-header bg-primary">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                        <li>
                            <button type="button" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">버전 등록</h3>
                </div>
                <div class="block-content">
                    <form class="form-horizontal push-10-t push-10" id="fAddPatchInfo2" method="post" onsubmit="return false;">
                        <div class="form-group">
                            <div class="form-material col-xs-12">
                                <label for="json_str" style="margin-left:20px;">JSON Data</label>
                                <textarea id="json_str" style="margin-top:10px;" name="json_str" rows="20" class="col-xs-12"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary" type="button" id="btnSubmit2"><i class="fa fa-check"></i> Ok</button>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<!--<script src="<?php echo $one->assets_folder; ?>/js/plugins/chartjs/Chart.min.js"></script>-->
<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/versioninfo.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>