<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content content-boxed">
    <!-- All Orders -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">레벨 현황 ( 일단위 당일 )</h3>
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
		                            <label class="col-md-1 control-label" for="searchdate">날짜 선택</label>
		                            <div class="col-md-4">
		                                <div class="js-datepicker input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="true">
		                                    <input class="form-control" type="text" id="searchdate" name="searchdate" value="<?php echo date('Y-m-d', strtotime('-1 days') ); ?>" placeholder="Choose a date..">
		                                    <span class="input-group-addon">
		                                        <span class="fa fa-calendar"></span>
		                                    </span>
		                                </div>
		                            </div>
		                            <div class="col-md-1">
		                                <button class="btn btn-sm btn-primary" type="submit" id="btnSearch">Submit</button>
		                            </div>
		                            <div class="col-md-6">
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
		                        <th class="text-center">날짜</th>
		                        <th class="text-center">레벨</th>
		                        <th class="text-center">이용자수 ( UID 기준 )</th>
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
<?php
	$dateTime = DateTime::createFromFormat('Ymd', $limitdate);
	$newDate = $dateTime->sub( new DateInterval( 'P1D' ) )->format('Y-m-d');
	$maxDate = new DateTime();
	$maxDate = $maxDate->format('Y-m-d');
?>
<script type="text/javascript">
	var minDate = '<?php echo $newDate; ?>';
	var maxDate = '<?php echo $maxDate; ?>';
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/statlist6.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>