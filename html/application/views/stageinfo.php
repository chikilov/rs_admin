<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>
<!-- Page Content -->
<div class="content content-boxed">
    <!-- All Orders -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">스테이지 목록</h3>
        </div>
        <div class="block-content">
            <table class="table table-borderless table-striped table-vcenter" id="stageinfo">
                <thead>
                    <tr>
                        <th class="text-center">스테이지</th>
                        <th class="text-center">미션</th>
                        <th class="text-center">미션기록</th>
                        <th class="text-center">달성일시</th>
                        <th class="text-center">미션달성</th>
                        <th class="text-center">진행횟수</th>
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
		<div class="row" style="min-height: 50px;margin-right: 10px;">
	        <button class="btn btn-info" data-toggle="modal" data-target="#modal-ssedit" style="margin-left:10px;float:right" type="button">영혼석 추가</button>
	        <button class="btn btn-info" data-toggle="modal" data-target="#modal-hins" style="margin-right:10px;float:right" type="button">히어로 추가</button>
	    </div>
    </div>
    <!-- END All Orders -->
</div>
<!-- END Page Content -->
<!-- Large Modal -->
<div class="modal" id="modal-lvedit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">레벨 수정</h3>
                </div>
                <div class="block-content">
		            <!-- Select2 (Material forms) -->
			        <div class="block-content block-content-narrow">
			            <form class="form-horizontal js-validation-bootstrap push-10-t" id="frmHero" method="post" onsubmit="return false;">
				            <input type="hidden" id="heroid" name="heroid">
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material input-group">
			                            <input class="form-control" type="text" id="lv" name="lv">
			                            <label for="lv">레벨</label>
			                            <span class="input-group-addon"></span>
			                        </div>
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material input-group">
			                            <input class="form-control" type="text" id="admin_memo" name="admin_memo" placeholder="메모를 입력하세요...">
			                            <label for="admin_memo">메모</label>
			                            <span class="input-group-addon"></span>
			                        </div>
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-md-12">
			                        <button class="btn btn-sm btn-primary" type="submit" data-dismiss="modal" id="btnlvEdit">Submit</button>
			                    </div>
			                </div>
			            </form>
			        </div>
					<!-- END Select2 (Material forms) -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Large Modal -->
<!-- Large Modal -->
<div class="modal" id="modal-hins" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">캐릭터 지급</h3>
                </div>
                <div class="block-content">
		            <!-- Select2 (Material forms) -->
			        <div class="block-content block-content-narrow">
			            <form class="form-horizontal js-validation-bootstrap push-10-t" id="frmHIns" method="post" onsubmit="return false;">
				            <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="col-xs-6 form-material">
			                            <select class="js-select2 form-control" id="hid2" name="hid2" style="width: 100%;" data-placeholder="Choose one..">
			                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
<?php
	foreach( $heroArray as $row )
	{
?>
			                                <option value="<?php echo $row['hid']; ?>"><?php echo $row['t_name']; ?></option>
<?php
	}
?>
			                            </select>
			                            <label for="hid2">히어로 선택</label>
			                        </div>
			                        <div class="col-xs-6 form-material">
			                            <select class="js-select2 form-control" id="grade" name="grade" style="width: 100%;" disabled="true" data-placeholder="Choose one..">
			                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
			                            </select>
			                        </div>
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material input-group">
			                            <input class="form-control" type="text" id="admin_memo2" name="admin_memo2" placeholder="메모를 입력하세요...">
			                            <label for="admin_memo2">메모</label>
			                            <span class="input-group-addon"></span>
			                        </div>
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-md-12">
			                        <button class="btn btn-sm btn-primary" type="submit" id="btnHIns">Submit</button>
			                    </div>
			                </div>
			            </form>
			        </div>
					<!-- END Select2 (Material forms) -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Large Modal -->
<!-- Large Modal -->
<div class="modal" id="modal-ssedit" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">영혼석 지급 회수</h3>
                </div>
                <div class="block-content">
		            <!-- Select2 (Material forms) -->
			        <div class="block-content block-content-narrow">
			            <form class="form-horizontal js-validation-bootstrap push-10-t" id="frmSSEdit" method="post" onsubmit="return false;">
				            <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material">
			                            <select class="js-select2 form-control" id="hid" name="hid" style="width: 100%;" data-placeholder="Choose one..">
			                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
<?php
	foreach( $heroArray as $row )
	{
?>
			                                <option value="<?php echo $row['hid']; ?>"><?php echo $row['t_name']; ?></option>
<?php
	}
?>
			                            </select>
			                            <label for="example2-select2">영혼석 선택</label>
			                        </div>
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material input-group">
			                            <input class="form-control" type="text" id="amount" name="amount">
			                            <label for="amount">개수</label>
			                            <span class="input-group-addon"></span>
			                        </div>
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material input-group">
			                            <input class="form-control" type="text" id="admin_memo3" name="admin_memo3" placeholder="메모를 입력하세요...">
			                            <label for="admin_memo3">메모</label>
			                            <span class="input-group-addon"></span>
			                        </div>
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-md-12">
			                        <button class="btn btn-sm btn-primary" type="submit" id="btnSSEdit">Submit</button>
			                    </div>
			                </div>
			            </form>
			        </div>
					<!-- END Select2 (Material forms) -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Large Modal -->
<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->

<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/stageinfo.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>