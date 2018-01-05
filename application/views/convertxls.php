<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content content-boxed">
<!-- Page Content -->
<div class="content">
    <!-- Material Design -->
    <h2 class="content-heading">아이디 변환</h2>
	<div class="block-content">
	    <div class="row">
	        <div class="col-md-6">
	            <!-- Static Labels -->
	            <div class="block">
	                <div class="block-header">
	                    <h3 class="block-title">대상 정보</h3>
	                </div>
	                <div class="block-content block-content-narrow">
	                    <form class="form-horizontal push-10-t" id="frmFile" method="post">
							<div class="form-group">
	                            <div class="col-xs-12">
    	                            <a href="/assets/upload/example_convert.xlsx">샘플 다운로드</a>
	                            </div>
	                            <label class="col-xs-12" for="example-file-input">파일 선택</label>
	                            <div class="col-xs-12">
	                                <input type="file" id="xls_up" name="xls_up">
	                            </div>
	                        </div>
		                    <div class="form-group">
		                        <label class="col-xs-12" for="uidshow">다운로드 링크 : </label>
		                        <div class="col-xs-12">
		                            <a id="uidshow" name="uidshow" href="#"></a>
		                        </div>
		                    </div>
	                    </form>
	                </div>
	            </div>
	            <!-- END Static Labels -->
	        </div>
	    </div>
	    <!-- END Material Design -->
    </div>
</div>
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<!--<script src="<?php echo $one->assets_folder; ?>/js/plugins/chartjs/Chart.min.js"></script>-->
<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/convertxls.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>