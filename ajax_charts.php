<?php
include 'stats_web_core/classes.php';
$player = new stats_player(htmlentities($_GET['p'], ENT_QUOTES, 'UTF-8'));
?>
	var all_kills_data = [
	<?php
	$all_kills = $player->get_all_kills();
	echo '{ label: "'.$all_kills[0][0].'",  data: '.$all_kills[0][1].'}'; unset($all_kills[0]);
	foreach($all_kills as $kill){
		echo ',{ label: "'.$kill[0].'",  data: '.$kill[1].'}';
	}
	?>
	];

	var all_deaths_data = [
	<?php
	$all_deaths = $player->get_all_deaths();
	echo '{ label: "'.$all_deaths[0][0].'",  data: '.$all_deaths[0][1].'}'; unset($all_deaths[0]);
	foreach($all_deaths as $death){
		echo ',{ label: "'.$death[0].'",  data: '.$death[1].'}';
	}
	?>
	];


	if($("#piechart_kills").length)
	{
		$.plot($("#piechart_kills"), all_kills_data,
		{
			series: {
				pie: {
					show: true,
					radius: 1,
					label: {
						formatter: function(label, series){
							return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
						},
						show: false,
						radius: 3/4,
						background: {
							opacity: 0.5,
							color: '#000'
						}
					}
				}
			},
			grid: {
					hoverable: true,
					clickable: true
			},
			legend: {
				show: false
			}
		});
		
		function pieHover_kills(event, pos, obj)
		{
			if (!obj)
					return;
			percent = parseFloat(obj.series.percent).toFixed(2);
			$("#hover_kills").html('<span style="font-weight: bold; color: '+obj.series.color+'">'+obj.series.label+' ('+percent+'%)</span>');
			//$("#hover_kills").css('top', pos.pageY-($('#hover_kills span').height()+5));
			//$("#hover_kills").css('left', pos.pageX);
		}

		$("#piechart_kills").bind("plothover", pieHover_kills);
		//$("#piechart_kills").bind("plotclick", pieClick);
	}

	if($("#piechart_deaths").length)
	{
		$.plot($("#piechart_deaths"), all_deaths_data,
		{
			series: {
				pie: {
					show: true,
					radius: 1,
					label: {
						formatter: function(label, series){
							return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
						},
						show: false,
						radius: 3/4,
						background: {
							opacity: 0.5,
							color: '#000'
						}
					}
				}
			},
			grid: {
					hoverable: true,
					clickable: true
			},
			legend: {
				show: false
			}
		});
		
		function pieHover_deaths(event, pos, obj)
		{
			if (!obj)
					return;
			percent = parseFloat(obj.series.percent).toFixed(2);
			$("#hover_deaths").html('<span style="font-weight: bold; color: '+obj.series.color+'">'+obj.series.label+' ('+percent+'%)</span>');
			//$("#hover_deaths").css('top', pos.pageY-($('#hover_deaths span').height()+5));
			//$("#hover_deaths").css('left', pos.pageX);

		}

		$("#piechart_deaths").bind("plothover", pieHover_deaths);
	}