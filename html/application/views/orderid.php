<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content content-boxed">
    <!-- All Orders -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">마켓 주문번호조회</h3>
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
				                    <div class="col-md-8">
				                        <div class="form-material input-group">
				                            <input class="form-control" type="text" id="validation_key" name="validation_key" placeholder="">
				                            <label for="validation_key">VALIDATION KEY</label>
				                            <span class="input-group-addon"></span>
				                        </div>
				                     </div>
				                     <div class="col-md-4">
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
		            <table class="table table-borderless table-striped table-vcenter" id="t_orderid">
		                <thead>
		                    <tr>
		                        <th class="text-center">날짜</th>
		                        <th class="text-center">UID</th>
		                        <th class="text-center">마켓</th>
		                        <th class="text-center">주문번호</th>
		                        <th class="hidden-xs text-center">환불요청</th>
		                        <th class="hidden-xs text-center">상태</th>
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
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<!--<script src="<?php echo $one->assets_folder; ?>/js/plugins/chartjs/Chart.min.js"></script>-->
<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/orderid.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>