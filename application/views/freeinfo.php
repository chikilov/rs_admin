<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>
<!-- Page Content -->
<div class="content content-boxed">
    <!-- All Orders -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">자유모드 목록</h3>
        </div>
        <div class="block-content">
            <table class="table table-borderless table-striped table-vcenter" id="freeinfo">
                <thead>
                    <tr>
                        <th class="text-center">곡명</th>
                        <th class="text-center">키</th>
                        <th class="text-center">난이도</th>
                        <th class="text-center">달성일시(최고기록)</th>
                        <th class="text-center">트로피 개수</th>
                        <th class="text-center">플레이 횟수</th>
                        <th class="text-center">클리어 횟수</th>
                        <th class="text-center">실패 횟수</th>
                        <th class="text-center">플레이 횟수(클리어전)</th>
                        <th class="text-center">실패 횟수(클리어전)</th>
                        <th class="text-center">최고점수</th>
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
	        <button class="btn btn-info" data-toggle="modal" data-target="#modal-hins" style="margin-right:10px;float:right" type="button">곡해금 추가</button>
	    </div>
    </div>
    <!-- END All Orders -->
</div>
<!-- END Page Content -->
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
                    <h3 class="block-title">곡해금 추가</h3>
                </div>
                <div class="block-content">
		            <!-- Select2 (Material forms) -->
			        <div class="block-content block-content-narrow">
			            <form class="form-horizontal js-validation-bootstrap push-10-t" id="frmIns" method="post" onsubmit="return false;">
				            <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="col-xs-6 form-material">
			                            <select class="js-select2 form-control" id="th" name="th" style="width: 100%;" data-placeholder="Choose one..">
			                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
<?php
	foreach( $freemode as $key => $val )
	{
		if ( $val == '' )
		{
			continue;
		}
?>
			                                <option value="<?php echo $val; ?>"><?php echo $key.'Key'; ?></option>
<?php
	}
?>
			                            </select>
			                            <label for="hid2">해금대상곡 선택</label>
			                        </div>
			                        <div class="col-xs-6 form-material">
			                            <select class="js-select2 form-control" id="tid" name="tid" style="width: 100%;" disabled="true" data-placeholder="Choose one..">
			                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
			                            </select>
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
<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->

<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/freeinfo.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>