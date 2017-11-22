<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content content-boxed">
    <!-- All Orders -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">메세지 함</h3>
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
		            <table class="table table-borderless table-striped table-vcenter" id="messageinfo">
		                <thead>
		                    <tr>
		                        <th class="text-center">LOGT/LOGC</th>
		                        <th class="hidden-xs text-center">보낸사람</th>
		                        <th class="text-center">메세지 도착 일시</th>
		                        <!--<th class="visible-lg text-center">제목</th>-->
		                        <th class="visible-lg text-center">종류</th>
		                        <th class="hidden-xs text-center">수량</th>
		                        <th class="visible-lg text-center">기타</th>
		                        <th class="hidden-xs text-center">상태</th>
		                        <th class="hidden-xs text-center">수령 및 삭제일시</th>
		                        <th class="hidden-xs text-center">만료일시</th>
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
		                        <!--<td class="text-right hidden-xs">
		                            -
		                        </td>-->
		                        <td class="text-center visible-lg">
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
<script src="<?php echo $one->assets_folder; ?>/js/pages/messageinfo.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>