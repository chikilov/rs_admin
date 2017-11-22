// Initialize when page loads
//jQuery(function(){ BaseTableDatatables.init(); });

$(document).ready(function () {
	$.ajax({
		url: '/Character/schooldata',
		success: function ( result ) {
			var data = eval( result );
			$('#sname').text(data[0].name);
			if ( 'ml' in data[0] )
			{
				$('#ml').text(data[0].ml.length);
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
});
