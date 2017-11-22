<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content content-boxed">
    <!-- All Orders -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">학교</h3>
        </div>
        <div class="block-content block-content-narrow">
            <form class="form-horizontal js-validation-bootstrap push-10-t" id="fLoginPresent" action="" method="post">
                <div class="form-group">
                    <div class="col-xs-6">
                        <div class="form-material input-group">
                            <input class="form-control" type="text" id="name_search" name="name_search" placeholder="학교명">
                            <label for="name_search">학교명</label>
                            <span class="input-group-addon"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-sm btn-primary" type="button" id="btnSearch">검색</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="block" style="margin-top:30px;">
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">학교명</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="sname" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">학생수</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="ml" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">생성일</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="created_at" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">보유 트로피 - 학교 보유 스테이지 모드 별</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="st" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">보유 트로피 - 자유모드 3키</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="tp3" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">보유 트로피 - 자유모드 4키</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="tp4" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">보유 트로피 - 자유모드 5키</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="tp5" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">보유 트로피 - 자유모드 6키</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="tp6" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">보유 트로피 - 자유모드 9키</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="tp9" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">순위 - 학교 보유 스테이지 모드 별</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="rst" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">순위 - 자유모드 3키</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="rtp3" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">순위 - 자유모드 4키</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="rtp4" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">순위 - 자유모드 5키</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="rtp5" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">순위 - 자유모드 6키</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="rtp6" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-6 col-lg-4">
	            <div class="block">
	                <div class="block-header" style="border-style: solid; border-color: #e5e5e5; border-width: 1px;">
	                    <ul class="block-options">
	                        <li>
	                            <button type="button"><i class="si si-settings"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">순위 - 자유모드 9키</h3>
	                </div>
	                <div class="block-content" style="border-style: solid; border-color: #e5e5e5; border-width: 1px; border-top-width: 0px;">
	                    <p id="rtp9" class="text-center">-</p>
	                </div>
	            </div>
	        </div>
        </div>
        <div class="block-content">
		    <!-- END Datetimepicker -->
		    <div class="row">
		        <div class="col-lg-12" style="overflow-x: auto;">
		            <table class="table table-borderless table-striped table-vcenter" id="stdlist">
		                <thead>
		                    <tr>
		                        <th class="text-center">No</th>
		                        <th class="hidden-xs text-center">Uid</th>
		                        <th class="text-center">NickName</th>
		                        <th class="visible-lg text-center">탈퇴</th>
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
		                    </tr>
		                </tbody>
		            </table>
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
<script src="<?php echo $one->assets_folder; ?>/js/pages/schoollist.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>