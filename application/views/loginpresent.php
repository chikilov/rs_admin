<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content content-boxed">
	<!-- Select2 (Material forms) -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">접속 보상 설정</h3>
        </div>
        <div class="block-content block-content-narrow">
            <form class="form-horizontal js-validation-bootstrap push-10-t" id="fLoginPresent" action="" method="post">
				<div class="form-group">
                    <div class="col-xs-12">
                        <div class="js-datepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="true">
                            <input class="form-control" type="text" id="login_date" name="login_date" placeholder="Choose a date..">
                            <label for="login_date">접속 날짜</label>
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                    	<div class="form-material">
                            <select class="js-select2 form-control" id="login_hour" name="login_hour" style="width: 100%;" data-placeholder="오후 2시 => 14">
	                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
<?php
	for( $h = 0; $h <= 22; $h ++ )
	{
?>
		                        <option value="<?php echo $h; ?>"><?php
		                            echo $h.':00 ~ '.($h+2).':00'; ?>
		                        </option>
<?php
	}
?>
                            </select>
                            <label for="login_hour">접속 시간</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material">
                            <select class="js-select2 form-control" id="push_status" name="push_status" style="width: 100%;" data-placeholder="Choose item..">
                                <option value="0" selected="true">Off</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                <option value="1">On</option>
                            </select>
                            <label for="push_status">푸시 On/Off</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material input-group">
                            <input class="form-control" type="text" id="push_message" name="push_message" placeholder="푸시 메시지">
                            <label for="push_message">푸시 메시지</label>
                            <span class="input-group-addon"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material">
                            <select class="js-select2 form-control" id="item_id" name="item_id" style="width: 100%;" data-placeholder="Choose item..">
                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
<?php
	if ( !empty($arrItem) )
	{
		foreach( $arrItem as $row )
		{
?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['t_name']; ?></option>
<?php
		}
	}
?>
                            </select>
                            <label for="item_id">아이템</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material input-group">
                            <input class="form-control" type="text" id="v1" name="v1" placeholder="수량">
                            <label for="v1">수량</label>
                            <span class="input-group-addon"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-primary" type="button" id="btnLoginPresent">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Select2 (Material forms) -->
    <!-- All Orders -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">접속 보상 설정 내역</h3>
        </div>
        <div class="block-content">
		    <div class="row">
		        <div class="col-lg-12">
		            <table class="table table-borderless table-striped table-vcenter" id="t_loginpresent">
		                <thead>
		                    <tr>
		                        <th class="text-center">날짜</th>
		                        <th class="text-center">시간(cron_exp)</th>
		                        <th class="visible-lg text-center">아이템명</th>
		                        <th class="hidden-xs text-center">수량</th>
		                        <th class="hidden-xs text-center">푸시메시지</th>
		                        <th class="hidden-xs text-center">push_key</th>
		                        <th class="hidden-xs text-center">삭제</th>
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
<script src="<?php echo $one->assets_folder; ?>/js/pages/loginpresent.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>