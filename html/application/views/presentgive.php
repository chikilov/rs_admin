<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content content-boxed">
<!-- Page Content -->
<div class="content">
    <!-- Material Design -->
    <h2 class="content-heading">일괄 지급</h2>
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
	                            <label class="col-xs-12" for="example-file-input">파일 선택</label>
	                            <div class="col-xs-12">
	                                <input type="file" id="xls_up" name="xls_up">
	                            </div>
	                        </div>
		                    <div class="form-group">
		                        <label class="col-xs-12" for="uidshow">Textarea</label>
		                        <div class="col-xs-12">
		                            <textarea class="form-control" id="uidshow" name="uidshow" rows="19"></textarea>
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
	                <div class="block-header">
	                    <h3 class="block-title">선물 정보</h3>
	                </div>
	                <div class="block-content block-content-narrow">
	                    <form class="form-horizontal push-10-t" method="post">
		                    <input type="hidden" name="uidgroup" id="uidgroup">
							<div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material input-group">
			                            <input class="form-control" type="text" id="sendtext" name="sendtext" placeholder="고객에게 보낼 내용을 입력하세요...">
			                            <label for="sendtext">내용</label>
			                            <span class="input-group-addon"></span>
			                        </div>
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material input-group">
			                            <input class="form-control" type="text" id="admin_memo" name="admin_memo" placeholder="운영툴에 표시될 내용을 입력하세요...">
			                            <label for="admin_memo">메모</label>
			                            <span class="input-group-addon"></span>
			                        </div>
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material">
			                            <select class="js-select2 form-control" id="term" name="term" style="width: 100%;" data-placeholder="Choose one..">
			                                <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
			                                <option value="3D">3일</option>
			                                <option value="7D">7일</option>
			                                <option value="30D">30일</option>
			                                <option value="E">무제한</option>
			                            </select>
			                            <label for="example2-select2">보관기간</label>
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
		foreach( $arrItem as $key => $val )
		{
?>
		                 	            	<option value="<?php echo $val['mail_type']; ?>"><?php echo $val['t_name']; ?></option>
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
			                <input class="form-control" type="hidden" id="logt" name="logt" value="<?php echo $randomString; ?>">
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material input-group">
			                            <input class="form-control" type="text" id="logc" name="logc" placeholder="logc">
			                            <label for="logc">LOGC</label>
			                            <span class="input-group-addon"></span>
			                        </div>
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-md-12">
			                        <button class="btn btn-sm btn-primary" id="btnPresent" type="submit">Submit</button>
			                    </div>
			                </div>
	                    </form>
	                </div>
	            </div>
	            <!-- END Floating Labels -->
	        </div>
	    </div>
	    <!-- END Material Design -->
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
            <!-- Datetimepicker (Default forms) -->
            <div class="block">
	            <table class="table table-borderless table-striped table-vcenter" id="messageinfo">
	                <thead>
	                    <tr>
	                        <th class="text-center">지급시각</th>
	                        <th class="text-center">LOGT/LOGC</th>
	                        <th class="hidden-xs text-center">보낸사람</th>
	                        <th class="visible-lg text-center">종류</th>
	                        <th class="hidden-xs text-center">수량</th>
	                        <th class="visible-lg text-center">메모</th>
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
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<!--<script src="<?php echo $one->assets_folder; ?>/js/plugins/chartjs/Chart.min.js"></script>-->
<!-- Page JS Code -->
<script type="text/javascript">
	var mailmax = {
<?php
	foreach( $arrItem as $key => $val )
	{
		echo "\t\t\"".$val['mail_type']."\":\"".$val['mail_max']."\"";
		if ( key($this->lang->language) == $key && end($this->lang->language) == $val )
		{
			echo PHP_EOL;
		}
		else
		{
			echo ','.PHP_EOL;
		}
	}
?>
	};
</script>
<script src="<?php echo $one->assets_folder; ?>/js/pages/presentgive.js"></script>
<?php require 'inc/views/template_footer_end.php'; ?>