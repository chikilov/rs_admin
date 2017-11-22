<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Content -->
<div class="content content-boxed">
    <!-- Top Products and Latest Orders -->
    <div class="row">
        <div class="col-lg-12">
            <!-- Top Products -->
            <div class="block block-opt-refresh-icon4 ">
                <div class="block-header bg-gray-lighter">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">기본정보</h3>
                </div>
                <div class="row" style="margin: 0;">
	                <div class="block-content col-lg-4">
	                    <table class="table table-borderless table-striped table-vcenter" id="basicinfo_part1">
	                        <tbody>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>회원번호</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>닉네임</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>레벨/경험치</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>보유 다이아</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>총 결제 금액</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>상태</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;">&nbsp;</td>
	                                <td></td>
	                            </tr>
	                        </tbody>
	                    </table>
	                </div>
	                <div class="block-content col-lg-4" style="margin-left: -20px;">
	                    <table class="table table-borderless table-striped table-vcenter" id="basicinfo_part2">
	                        <tbody>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>계정</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>학교</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>별/트로피</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>보유 골드</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>친구 초대 수</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>탈퇴 일시</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;">&nbsp;</td>
	                                <td></td>
	                            </tr>
	                        </tbody>
	                    </table>
	                </div>
	                <div class="block-content col-lg-4" style="margin-left: -20px;">
	                    <table class="table table-borderless table-striped table-vcenter" id="basicinfo_part3">
	                        <tbody>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>계정 상태</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>접속 여부</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>최근 로그 아웃</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>가입일</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>휴대폰 번호</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>휴대폰 기종</strong></td>
	                                <td>-</td>
	                            </tr>
	                            <tr>
	                                <td class="text-center" style="width: 100px;"><strong>휴대폰 OS</strong></td>
	                                <td>-</td>
	                            </tr>
	                        </tbody>
	                    </table>
	                </div>
                </div>
            </div>
            <!-- END Top Products -->
        </div>
    </div>
    <!-- END Top Products and Latest Orders -->
    <!-- All Orders -->
    <div class="block">
        <div class="block-header bg-gray-lighter">
            <h3 class="block-title">관리자 로그</h3>
        </div>
        <div class="block-content">
            <table class="table table-borderless table-striped table-vcenter" id="basicinfo_log">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 151px;">적용 일시</th>
                        <th class="hidden-xs text-center" style="width: 140px;">회원번호</th>
                        <th class="text-center">로그명</th>
                        <th class="visible-lg text-center">내용</th>
                        <th class="visible-lg text-center">관리자ID</th>
                        <th class="hidden-xs text-center">메모</th>
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
                        <td class="text-center visible-lg">
                            -
                        </td>
                        <td class="text-right hidden-xs">
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
    <!-- END All Orders -->
</div>
<!-- END Page Content -->
<!-- Large Modal -->
<div class="modal" id="modal_block" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Block Control</h3>
                </div>
                <div class="block-content">
		            <!-- Select2 (Material forms) -->
			        <div class="block-content block-content-narrow">
			            <form class="form-horizontal js-validation-bootstrap push-10-t" method="post" onsubmit="return false;">
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material">
			                            <input class="js-datepicker form-control" type="text" id="account_block_end_at" name="account_block_end_at" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
			                            <label for="account_block_end_at">Choose a date</label>
			                        </div>
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material input-group">
			                            <input class="form-control" type="text" id="blockreason" name="blockreason" placeholder="제제 사유를 입력하세요...">
			                            <label for="admin_memo">제제사유</label>
			                            <span class="input-group-addon"></span>
			                        </div>
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-md-12">
			                        <button class="btn btn-sm btn-primary" type="submit" id="btnBlockAction">Submit</button>
			                    </div>
			                </div>
			            </form>
			        </div>
					<!-- END Select2 (Material forms) -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary" type="button" data-dismiss="modal"><i class="fa fa-check"></i> Ok</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal_gold" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-nm">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">골드 변경</h3>
                </div>
                <div class="block-content">
		            <!-- Select2 (Material forms) -->
			        <div class="block-content block-content-narrow">
			            <form class="form-horizontal js-validation-bootstrap push-10-t" method="post" onsubmit="return false;">
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material">
			                            <input class="form-control" type="text" id="change_amount1" style="width:100%;" name="change_amount1" placeholder="변경 수량을 입력하세요...(ex) 1000, -200...">
			                            <label for="change_amount">골드 변경 수량 ( 현재 수량 : <span id="show_gold"></span> )</label>
			                        </div>
			                    </div>
			                </div>
			            </form>
			        </div>
					<!-- END Select2 (Material forms) -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary" type="button" data-dismiss="modal" id="btnGold"><i class="fa fa-check"></i> Ok</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal_nickname" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-nm">
        <div class="modal-content">
            <form class="form-horizontal js-validation-bootstrap push-10-t" id="frmNickName" method="post" onsubmit="return false;">
	            <div class="block block-themed block-transparent remove-margin-b">
	                <div class="block-header bg-primary-dark">
	                    <ul class="block-options">
	                        <li>
	                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">닉네임 변경</h3>
	                </div>
	                <div class="block-content">
			            <!-- Select2 (Material forms) -->
				        <div class="block-content block-content-narrow">
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material">
			                            <input class="form-control" type="text" id="change_nickname" style="width:100%;" name="change_nickname" placeholder="변경 할 이름을 입력하세요...">
			                            <label for="change_amount">변경 할 이름 ( 현재 이름 : <span id="show_nick"></span> )</label>
			                        </div>
			                    </div>
			                </div>
				        </div>
						<!-- END Select2 (Material forms) -->
	                </div>
	            </div>
	            <div class="modal-footer">
	                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
	                <button class="btn btn-sm btn-primary" type="submit" data-dismiss="modal" id="btnNick"><i class="fa fa-check"></i> Ok</button>
	            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal" id="modal_pcash" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-nm">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">유료 캐시 변경</h3>
                </div>
                <div class="block-content">
		            <!-- Select2 (Material forms) -->
			        <div class="block-content block-content-narrow">
			            <form class="form-horizontal js-validation-bootstrap push-10-t" method="post" onsubmit="return false;">
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material">
			                            <input class="form-control" type="text" id="change_amount2" style="width:100%;" name="change_amount2" placeholder="변경 수량을 입력하세요...(ex) 1000, -200...">
			                            <label for="change_amount">유료 캐시 변경 수량 ( 현재 수량 : <span id="show_pcash"></span> )</label>
			                        </div>
			                    </div>
			                </div>
			            </form>
			        </div>
					<!-- END Select2 (Material forms) -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary" type="button" data-dismiss="modal" id="btnPcash"><i class="fa fa-check"></i> Ok</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal_fcash" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-nm">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">무료 캐시 변경</h3>
                </div>
                <div class="block-content">
		            <!-- Select2 (Material forms) -->
			        <div class="block-content block-content-narrow">
			            <form class="form-horizontal js-validation-bootstrap push-10-t" method="post" onsubmit="return false;">
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material">
			                            <input class="form-control" type="text" id="change_amount3" style="width:100%;" name="change_amount3" placeholder="변경 수량을 입력하세요...(ex) 1000, -200...">
			                            <label for="change_amount">무료 캐시 변경 수량 ( 현재 수량 : <span id="show_fcash"></span> )</label>
			                        </div>
			                    </div>
			                </div>
			            </form>
			        </div>
					<!-- END Select2 (Material forms) -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary" type="button" data-dismiss="modal" id="btnFcash"><i class="fa fa-check"></i> Ok</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal_level" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-nm">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
	            <form class="form-horizontal js-validation-bootstrap push-10-t" method="post" onsubmit="return false;">
	                <div class="block-header bg-primary-dark">
	                    <ul class="block-options">
	                        <li>
	                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
	                        </li>
	                    </ul>
	                    <h3 class="block-title">Block Control</h3>
	                </div>
	                <div class="block-content">
			            <!-- Select2 (Material forms) -->
				        <div class="block-content block-content-narrow">
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material">
			                            <input class="form-control" type="text" id="change_level" name="change_level" placeholder="레벨을 입력하세요...">
			                            <label for="change_level">레벨 ( 현재 레벨 : <span id="show_level"></span> )</label>
			                        </div>
			                    </div>
			                </div>
			                <div class="form-group">
			                    <div class="col-xs-12">
			                        <div class="form-material">
			                            <input class="form-control" type="text" id="change_exp" name="change_exp" placeholder="경험치를 입력하세요...">
			                            <label for="change_exp">경험치 ( 현재 경험치 : <span id="show_exp"></span> )</label>
			                        </div>
			                    </div>
			                </div>
				        </div>
						<!-- END Select2 (Material forms) -->
	                </div>
	        </div>
	        <div class="modal-footer">
	                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
	                <button class="btn btn-sm btn-primary" type="submit" data-dismiss="modal" id="btnLevel"><i class="fa fa-check"></i> Ok</button>
	            </form>
	        </div>
        </div>
    </div>
</div>
<!-- END Large Modal -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->

<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/basicinfo.js"></script>
<script>
    $(function(){
        // Init page helpers (Appear + CountTo plugins)
        $(document).on( 'click', '#btnBlock', function () {
			$('#modal_block').modal();
        });

        $(document).on( 'click', '#btnFree', function () {
	       $.ajax({
		      type: 'POST',
		      url: '/Character/setFree',
		      data: {'uid':$('#searchuid').val(), 'blockterm': $('#blockterm').val(), 'blockreason': $('#blockreason').val()},
		      success: function(result) {
			      if ( result == '1' )
			      {
				    swal({
					    title: "Success..",
					    text: "해제처리가 완료되었습니다.",
					    type: "success"
					});
				    $('#modal_block').modal('hide');
				    $('#basicinfo_part3').DataTable().ajax.reload();
			      }
			      else
			      {
				    swal({
					    title: "Oop..",
					    text: "해제처리에 오류가 발생하였습니다.",
					    type: "error"
					});
			      }
		      }
	       });
        });

		$(document).on( 'click', '#btnBlockAction', function () {
	       $.ajax({
		      type: 'POST',
		      url: '/Character/setBlock',
		      data: {'uid':$('#searchuid').val(), 'account_block_end_at': $('#account_block_end_at').val() + ' 23:59:59', 'blockreason': $('#blockreason').val()},
		      success: function(result) {
			      if ( result == '1' )
			      {
				    swal({
					    title: "Success..",
					    text: "블럭처리가 완료되었습니다.",
					    type: "success"
					});
				    $('#modal_block').modal('hide');
				    $('#basicinfo_part3').DataTable().ajax.reload();
			      }
			      else
			      {
				    swal({
					    title: "Oop..",
					    text: "블럭처리에 오류가 발생하였습니다.",
					    type: "error"
					});
			      }
		      }
	       });
		});

		$(document).on( 'click', '#basicinfo_part1_wrapper .btn-info, #basicinfo_part2_wrapper .btn-info, #basicinfo_part3_wrapper .btn-info', function () {
			if ( $(this).parent().siblings(':first').html() == '보유 골드')
			{
				$('#show_gold').text($(this).parent().text());
				$('#modal_gold').modal('show');
			}
			else if ( $(this).parent().siblings(':first').html() == '닉네임')
			{
				$('#show_nick').text($(this).parent().text());
				$('#modal_nickname').modal('show');
			}
			else if ( $(this).parent().siblings(':first').html() == '유료 캐시')
			{
				$('#show_pcash').text($(this).parent().text());
				$('#modal_pcash').modal('show');
			}
			else if ( $(this).parent().siblings(':first').html() == '무료 캐시')
			{
				$('#show_fcash').text($(this).parent().text());
				$('#modal_fcash').modal('show');
			}
			else if ( $(this).parent().siblings(':first').html() == '레벨/경험치')
			{
				$('#show_level').text($(this).parent().text().split('/')[0]);
				$('#show_exp').text($(this).parent().text().split('/')[1]);
				$('#modal_level').modal('show');
			}
		});

		$(document).on( 'click', '#btnGold', function () {
			var total = parseInt($('#show_gold').text());
			total += parseInt($('#change_amount1').val());
			swal({
	            title: "Are you sure?",
	            text: $('#change_amount1').val() + '를 변경하여 총 골드가 ' + total + '이 됩니다. 진행하시겠습니까?',
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes!",
	            closeOnConfirm: false
	        }, function( isConfirm )
	        {
		        if ( isConfirm )
		        {
			        $.ajax({
						type: 'POST',
						url: '/Character/setgold',
						data: {'uid':$('#searchuid').val(), 'change_amount': $('#change_amount1').val()},
						success: function(result) {
							if ( result == '1' )
							{
								swal({
									title: "Success..",
									text: "골드 변경처리가 완료되었습니다.",
									type: "success"
								});
								$('#change_amount1').val('');
								$('#modal_gold').modal('hide');
								$('#basicinfo_part2').DataTable().ajax.reload();
							}
							else
							{
								swal({
									title: "Oop..",
									text: "골드 변경처리에 오류가 발생하였습니다.",
									type: "error"
								});
								$('#change_amount1').val('');
							}
						}
					});
				}
				else
				{
					$('#change_amount1').val('');
				}
			});
		});

		$(document).on( 'click', '#btnNick', function () {
			swal({
	            title: "Are you sure?",
	            text: '닉네임이 ' + $('#show_nick').text() + '에서 ' + $('#change_nickname').val() + '로 변경 됩니다. 진행하시겠습니까?',
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes!",
	            closeOnConfirm: false
	        }, function( isConfirm )
	        {
		        if ( isConfirm )
		        {
			        $.ajax({
						type: 'POST',
						url: '/Character/setnickname',
						data: {'uid':$('#searchuid').val(), 'change_nickname': $('#change_nickname').val()},
						success: function(result) {
							if ( result == '1' )
							{
								swal({
									title: "Success..",
									text: "닉네임 변경처리가 완료되었습니다.",
									type: "success"
								});
								$('#change_nickname').val('');
								$('#modal_nickname').modal('hide');
								$('#basicinfo_part1').DataTable().ajax.reload();
							}
							else
							{
								swal({
									title: "Oop..",
									text: "닉네임 변경처리에 오류가 발생하였습니다.",
									type: "error"
								});
								$('#change_nickname').val('');
							}
						}
					});
				}
				else
				{
					$('#change_nickname').val('');
				}
			});
		});

		$(document).on( 'click', '#btnPcash', function () {
			var total = parseInt($('#show_pcash').text());
			total += parseInt($('#change_amount2').val());
			swal({
	            title: "Are you sure?",
	            text: $('#change_amount2').val() + '를 변경하여 총 유료캐시가 ' + total + '이 됩니다. 진행하시겠습니까?',
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes!",
	            closeOnConfirm: false
	        }, function( isConfirm )
	        {
		        if ( isConfirm )
		        {
			        $.ajax({
						type: 'POST',
						url: '/Character/setpcash',
						data: {'uid':$('#searchuid').val(), 'change_amount': $('#change_amount2').val()},
						success: function(result) {
							if ( result == '1' )
							{
								swal({
									title: "Success..",
									text: "유료 캐시 변경처리가 완료되었습니다.",
									type: "success"
								});
								$('#change_amount2').val('');
								$('#modal_pcash').modal('hide');
								$('#basicinfo_part1').DataTable().ajax.reload();
							}
							else
							{
								swal({
									title: "Oop..",
									text: "유료 캐시 변경처리에 오류가 발생하였습니다.",
									type: "error"
								});
								$('#change_amount2').val('');
							}
						}
					});
				}
				else
				{
					$('#change_amount2').val('');
				}
			});
		});

		$(document).on( 'click', '#btnFcash', function () {
			var total = parseInt($('#show_fcash').text());
			total += parseInt($('#change_amount3').val());
			swal({
	            title: "Are you sure?",
	            text: $('#change_amount3').val() + '를 변경하여 총 무료캐시가 ' + total + '이 됩니다. 진행하시겠습니까?',
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes!",
	            closeOnConfirm: false
	        }, function( isConfirm )
	        {
		        if ( isConfirm )
		        {
			        $.ajax({
						type: 'POST',
						url: '/Character/setfcash',
						data: {'uid':$('#searchuid').val(), 'change_amount': $('#change_amount3').val()},
						success: function(result) {
							if ( result == '1' )
							{
								swal({
									title: "Success..",
									text: "무료 캐시 변경처리가 완료되었습니다.",
									type: "success"
								});
								$('#change_amount3').val('');
								$('#modal_fcash').modal('hide');
								$('#basicinfo_part1').DataTable().ajax.reload();
							}
							else
							{
								swal({
									title: "Oop..",
									text: "무료 캐시 변경처리에 오류가 발생하였습니다.",
									type: "error"
								});
								$('#change_amount3').val('');
							}
						}
					});
				}
				else
				{
					$('#change_amount3').val('');
				}
			});
		});

		$(document).on( 'click', '#btnLevel', function () {
			swal({
	            title: "Are you sure?",
	            text: '레벨이 ' + $('#show_level').text() + '에서 ' + $('#change_level').val() + '로 \n경험치가 ' + $('#show_exp').text() + '에서 ' + $('#change_exp').val() + '로 변경 됩니다. 진행하시겠습니까?',
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes!",
	            closeOnConfirm: false
	        }, function( isConfirm )
	        {
		        if ( isConfirm )
		        {
			        $.ajax({
						type: 'POST',
						url: '/Character/setlevel',
						data: {'uid':$('#searchuid').val(), 'change_level': $('#change_level').val(), 'change_exp': $('#change_exp').val()},
						success: function(result) {
							if ( result == '1' )
							{
								swal({
									title: "Success..",
									text: "레벨/경험치 변경처리가 완료되었습니다.",
									type: "success"
								});
								$('#change_level').val('');
								$('#change_exp').val('');
								$('#modal_level').modal('hide');
								$('#basicinfo_part1').DataTable().ajax.reload();
							}
							else
							{
								swal({
									title: "Oop..",
									text: "레벨/경험치 캐시 변경처리에 오류가 발생하였습니다.",
									type: "error"
								});
								$('#change_level').val('');
								$('#change_exp').val('');
							}
						}
					});
				}
				else
				{
					$('#change_level').val('');
					$('#change_exp').val('');
				}
			});
		});
    });
</script>

<?php require 'inc/views/template_footer_end.php'; ?>