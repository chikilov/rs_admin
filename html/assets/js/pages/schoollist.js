// Initialize when page loads
//jQuery(function(){ BaseTableDatatables.init(); });

$(document).ready(function () {
	$(document).on( 'click', '#btnSearch', function () {
		$.ajax({
			type: 'POST',
			url: '/School/search',
			data: {'namesearch': $('#name_search').val()},
			success: function ( result ) {
				var data = eval( result );
				$('#sname').text(data[0].name);
				if ( 'ml' in data[0] )
				{
					$('#ml').text(( data[0].ml == null ? 0 : data[0].ml.length));
					if ( data[0].ml != null )
					{
						strHtml = '';
						for ( var i = 0; i < data[0].ml.length; i++ )
						{
							strHtml += '<tr>';
							strHtml += '<td class="text-center">' + parseInt(i + 1) + '</td>';
							strHtml += '<td class="text-center">' + data[0].ml[i].uid + '</td>';
							strHtml += '<td class="text-center">' + data[0].ml[i].nickname + '</td>';
							strHtml += '<td class="text-center"><button class="btn btn-xs btn-primary btnLeave">탈퇴</button></td>';
							strHtml += '<tr>';
						}

						$('#stdlist > tbody').html(strHtml);
					}
				}
				if ( 'created_at' in data[0] )
				{
					$('#created_at').text(data[0].created_at);
				}
				if ( 'st' in data[0] )
				{
					$('#st').text(data[0].st);
				}
				if ( 'tp3' in data[0] )
				{
					$('#tp3').text(data[0].tp3);
				}
				if ( 'tp4' in data[0] )
				{
					$('#tp4').text(data[0].tp4);
				}
				if ( 'tp5' in data[0] )
				{
					$('#tp5').text(data[0].tp5);
				}
				if ( 'tp6' in data[0] )
				{
					$('#tp6').text(data[0].tp6);
				}
				if ( 'tp9' in data[0] )
				{
					$('#tp9').text(data[0].tp9);
				}
				if ( 'rank' in data[0] )
				{
					if ( 'st' in data[0].rank )
					{
						$('#rst').text(data[0].rank.st);
					}
					if ( 'tp3' in data[0].rank )
					{
						$('#rtp3').text(data[0].rank.tp3);
					}
					if ( 'tp4' in data[0].rank )
					{
						$('#rtp4').text(data[0].rank.tp4);
					}
					if ( 'tp5' in data[0].rank )
					{
						$('#rtp5').text(data[0].rank.tp5);
					}
					if ( 'tp6' in data[0].rank )
					{
						$('#rtp6').text(data[0].rank.tp6);
					}
					if ( 'tp9' in data[0].rank )
					{
						$('#rtp9').text(data[0].rank.tp9);
					}
				}
			}
		});

		$(document).on('click', '.btnLeave', function() {
			var obj = $(this).parent().parent();
			$.ajax({
				type: 'POST',
				url: '/School/stdleave',
				data: {'uid': obj.children('td').eq(1).text(), 'school': $('#sname').text()},
				success: function ( result ) {
					if ( result )
					{
						swal('Ok...', '탈퇴 처리가 완료되었습니다.', 'success');
						$('#btnSearch').trigger('click');
					}
					else
					{
						swal('Oops...', '탈퇴 처리에 오류가 발생하였습니다.', 'error');
					}
				}
			});
		});
	});
});
