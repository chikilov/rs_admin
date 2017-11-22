<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content content-boxed">
    <!-- All Orders -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">입학학교</h3>
        </div>
        <div class="block" style="margin-top:30px;">
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">학교명</h3>
	                </div>
	                <div class="block-content">
	                    <p id="sname" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">학생수</h3>
	                </div>
	                <div class="block-content">
	                    <p id="ml" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">생성일</h3>
	                </div>
	                <div class="block-content">
	                    <p id="created_at" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">보유 트로피 - 학교 보유 스테이지 모드 별</h3>
	                </div>
	                <div class="block-content">
	                    <p id="st" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">보유 트로피 - 자유모드 3키</h3>
	                </div>
	                <div class="block-content">
	                    <p id="tp3" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">보유 트로피 - 자유모드 4키</h3>
	                </div>
	                <div class="block-content">
	                    <p id="tp4" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">보유 트로피 - 자유모드 5키</h3>
	                </div>
	                <div class="block-content">
	                    <p id="tp5" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">보유 트로피 - 자유모드 6키</h3>
	                </div>
	                <div class="block-content">
	                    <p id="tp6" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">보유 트로피 - 자유모드 9키</h3>
	                </div>
	                <div class="block-content">
	                    <p id="tp9" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">순위 - 학교 보유 스테이지 모드 별</h3>
	                </div>
	                <div class="block-content">
	                    <p id="rst" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">순위 - 자유모드 3키</h3>
	                </div>
	                <div class="block-content">
	                    <p id="rtp3" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">순위 - 자유모드 4키</h3>
	                </div>
	                <div class="block-content">
	                    <p id="rtp4" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">순위 - 자유모드 5키</h3>
	                </div>
	                <div class="block-content">
	                    <p id="rtp5" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">순위 - 자유모드 6키</h3>
	                </div>
	                <div class="block-content">
	                    <p id="rtp6" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">순위 - 자유모드 9키</h3>
	                </div>
	                <div class="block-content">
	                    <p id="rtp9" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
        </div>
    </div>
    <!-- END All Orders -->
</div>
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<!--<script src="<?php echo $one->assets_folder; ?>/js/plugins/chartjs/Chart.min.js"></script>-->
<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/schoolinfo.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>