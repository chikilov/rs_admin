<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content content-boxed">
<!-- Page Content -->
<div class="content">
    <!-- Material Design -->
    <h2 class="content-heading">일괄 제재</h2>
	<div class="block-content">
	    <div class="row">
	        <div class="col-md-6">
	            <!-- Static Labels -->
	            <div class="block">
	                <div class="block-content block-content-narrow">
	                    <form class="form-horizontal push-10-t" id="frmFile" method="post">
							<div class="form-group">
	                            <div class="col-xs-12">
	                                <label class="radio-inline" for="block_type1">
	                                    <input type="radio" id="block_type1" name="block_type" value="1"> 접속 제한
	                                </label>
	                                <label class="radio-inline" for="block_type2">
	                                    <input type="radio" id="block_type2" name="block_type" value="2"> 영구 제재
	                                </label>
	                                <label class="radio-inline" for="block_type3">
	                                    <input type="radio" id="block_type3" name="block_type" value="0"> 제한 해제
	                                </label>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <div class="col-xs-12">
	                                <div class="form-material">
	                                    <select class="js-select2 form-control" id="end_at" name="end_at" style="width: 100%;" disabled="true">
	                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
	                                        <option value="P1D">1일</option>
	                                        <option value="P3D">3일</option>
	                                        <option value="P7D">7일</option>
	                                        <option value="P30D">30일</option>
	                                    </select>
	                                    <label for="end_at">기간 선택</label>
	                                </div>
	                            </div>
	                        </div>
		                    <div class="form-group">
		                        <label class="col-xs-12" for="block_reason">제재사유</label>
		                        <div class="col-xs-12">
		                            <input class="form-control" type="text" id="block_reason" name="block_reason">
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-xs-12" for="admin_memo">메모</label>
		                        <div class="col-xs-12">
		                            <input class="form-control" type="text" id="admin_memo" name="admin_memo">
		                        </div>
		                    </div>
	                    </form>
	                </div>
	            </div>
	            <!-- END Static Labels -->
	        </div>
	        <div class="col-md-6">
	            <!-- Floating Labels -->
	            <div class="block">
	                <div class="block-content block-content-narrow">
	                    <form class="form-horizontal push-10-t" method="post">
							<div class="form-group">
		                        <label class="col-xs-12" for="uidshow">UID</label>
		                        <div class="col-xs-8">
		                            <textarea class="form-control" id="uidgroup" name="uidgroup" rows="8"></textarea>
		                        </div>
		                        <div class="col-xs-4">
		                            <textarea class="form-control" readonly="true" id="uidsample" name="uidsample" rows="8">ex)
1234567890
0987654321
6789012345
5432109876
</textarea>
		                        </div>
		                    </div>
			                <div class="form-group">
			                    <div class="col-md-12">
			                        <button class="btn btn-sm btn-primary" style="float:right;" id="btnBlock" type="submit">Submit</button>
			                    </div>
			                </div>
	                    </form>
	                </div>
	            </div>
	            <!-- END Floating Labels -->
	        </div>
	    </div>
	    <!-- END Material Design -->
        <div class="block" style="padding:30px 30px 0 30px;">
            <table class="table table-borderless table-striped table-vcenter" id="messageinfo">
                <thead>
                    <tr>
                        <th class="text-center">제재시각</th>
                        <th class="text-center">기간</th>
                        <th class="text-center">제재사유</th>
                        <th class="text-center">성공</th>
                        <th class="text-center">실패</th>
                        <th class="text-center">처리자</th>
                        <th class="text-center">상세보기</th>
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
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<!--<script src="<?php echo $one->assets_folder; ?>/js/plugins/chartjs/Chart.min.js"></script>-->
<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/massiveblock.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>