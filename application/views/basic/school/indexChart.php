<section class="box-typical box-typical-dashboard panel panel-default scrollable"  data-body-height="400"  data-expand="false">
    <header class="box-typical-header panel-heading">
        <h3 class="panel-title">地區評估</h3>
    </header>
    <br>
    <!-- <div id="introduce" class="col-md-12" >載入中...</div> -->
    <div class="col-md-12" style="min-height: 20px;"></div> <!-- 預留空白 -->
    <br>
    <div id="indexChart" class="box-typical-body panel-body col-md-12">

        <div id="chart" class="col-md-12" >
			<div class='col-xl-6' name='doughnut'>
				<canvas id='doughnut'></canvas>
			</div>
			<div class='col-xl-6' name='pie'>
        		<canvas class='col-sm-12' id='pie'></canvas>
        	</div>
        </div>

    </div><!--.box-typical-body-->
    <div id="indexChart" class="box-typical-body panel-body col-md-12">

        <div id="chart" class="col-md-12" >
        	<div class='col-xl-3'> </div>
        	<div class='col-xl-6' name='radar'>
        		<canvas class='col-sm-12' id='radar'></canvas>
        	</div>
        	<div class='col-xl-3'> </div>
        </div>

    </div><!--.box-typical-body-->
</section><!--.box-typical-dashboard-->

<script type="text/javascript">
	var lifeScore,trafficScore,age,latlng,lat,lng,LMIH_CNT_rlp,LIH_CNT_rlp,population;

	function destroy_and_creat(){
		$("#doughnut").remove();
		$("#pie").remove();
		$("#radar").remove();

		$("[name='doughnut']").append("<canvas id='doughnut'></canvas>");
		$("[name='pie']").append("<canvas id='pie'></canvas>");
		$("[name='radar']").append("<canvas id='radar'></canvas>");
		console.log("destroy");
	}
	function search(addr){
		$('#introduce').html('載入中...');
		lifeScore=0;
		trafficScore=0;
		console.log(addr);
		$.ajax({
			url:'<?php echo base_url('api/getSearchJson')?>',
			type:"POST",
			data:{searchText:addr},
			dataType:"json",
			success:function(data){
				console.log(data);
				//var intact_addr=data['results'][0]['formatted_address'];
				lat=data['results'][0]['geometry']['location']['lat'];
				lng=data['results'][0]['geometry']['location']['lng'];
				console.log(addr,lat,lng);
				getdata(addr,lat,lng);
			}

		});

		function getdata(str,lat,lng){
			console.log("getdata start");
			$.ajax({
				url: "<?php echo base_url('api/addrSearch')?>",
				type: "POST",
				data: {addr: str },
				dataType: "json",
				success: function (data) {
					if(data != 444){
						//接值
						$('#indexChart').show();
						console.log(data[0]);
						lifeScore=data[0]['lifeindex'];
					    trafficScore=data[0]['accident'];
			            age=data[0]['age'].split(',');
			            LMIH_CNT_rlp=data[2]['LMIH_CNT_rlp'];
			            LIH_CNT_rlp=data[2]['LIH_CNT_rlp'];
			            population=parseInt(age[0])+parseInt(age[1])+parseInt(age[2])+parseInt(age[3])-parseInt(LMIH_CNT_rlp)-parseInt(LIH_CNT_rlp);
			            radar(lifeScore,trafficScore);
			            doughnut();
			            pie();
			        }else{
			        	console.log("false");
	    				alert("Can't find data for this location.");
	    			}
	    			//introduceSearch(addr);
		        },
		        error: function(){
		        	console.log("error");
		        	$('#indexChart').hide();
		        	//introduceSearch(addr);
		        }
		    })
		}

	}


	function radar(data1,data2){ //安全指數
		var chartRadarDOM = $('#radar');
		var graphData =new Array();
		graphData.push(data1);
		graphData.push(data2);
		var radarChart = new Chart(chartRadarDOM, {
			"type": "horizontalBar",
			"data": {
				"labels": ["生活安全分數", "交通安全分數"],
				"datasets": [{
					"data": graphData,
					"fill": false,
					"backgroundColor": ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)"],
					"borderColor": ["rgb(255, 99, 132)", "rgb(255, 159, 64)"],
					"borderWidth": 1
				}]
			},
			"options": {
				title:{
					display:true,
					text:'地點評分',
					fontFamily:'微軟正黑體',
					fontSize:25
				},
				"scales": {
					"xAxes": [{
						"ticks": {
							"beginAtZero": true,
							"min":0,
							"max":100
						}
					}]
				},
				"legend":{
					display:false
				}
			}
		});
	}
	function doughnut(){ //年齡分布
		//$("div[id='chart']").append("<div class='col-xl-6'> <canvas id='doughnut'></canvas> </div>");
		var ctx=$("#doughnut");
		var doughnutChart = new Chart(ctx,{
			type: 'doughnut',
			data: {
				labels : ['0~14','15~64','65↑','others'],
				datasets : [{
					backgroundColor : ['#9191FF','#FF8585','#6CFF92','#FFB047'],
					data : age
				}]
			},
			options:{
				title:{
					display:true,
					text:'年齡分布',
					fontFamily:'微軟正黑體',
					fontSize:25
				},
				legend:{
					display:true,
					position:'top',
					labels:{
						fontColor:'black' ,
						fontSize:15
					},
				},
				animation:{
					duration:5000
				}
			}
		});
	}
	function pie(){ //中低收入戶 戶數
		//$("div[id='chart']").append("<div class='col-xl-6'> <canvas id='doughnut'></canvas> </div>");
		var ctx=$("#pie");
		var pieChart = new Chart(ctx,{
			type: 'pie',
			data: {
				labels : ['低收入戶','中低收入戶','其他'],
				datasets : [{
					backgroundColor : ['#9191FF','#FF8585','#6CFF92',],
					data : [LMIH_CNT_rlp,LIH_CNT_rlp,population]
				}]
			},
			options:{
				title:{
					display:true,
					text:'中低收人數比',
					fontFamily:'微軟正黑體',
					fontSize:25
				},
				legend:{
					display:true,
					position:'top',
					labels:{
						fontColor:'black' ,
						fontSize:15
					},
				},
				animation:{
					duration:5000
				}
			}
		});

	}

</script>

<script type="text/javascript">

	function introduceSearch(addr){
		console.log('introduce start');
		//取得鄉鎮市區
		addr=addr.substr(addr.indexOf(']')+4,4);
		if(addr.indexOf('區')>=1){
			addr=addr.substring(0,addr.indexOf('區')+1);
		}else if(addr.indexOf('市')>=1){
			addr=addr.substring(0,addr.indexOf('市')+1);
		}else if(addr.indexOf('鄉')>=1){
			addr=addr.substring(0,addr.indexOf('鄉')+1);
		}else if(addr.indexOf('鎮')>=1){
			addr=addr.substring(0,addr.indexOf('鎮')+1);
		}

		$.ajax({
			url:'<?php echo base_url('api/getWikiSearch')?>',
			type:"POST",
			data:{searchText:addr},
			dataType:"text",
			success:function(data){
				console.log(data);
				data=data.replace(/\\r/g,'');
				data=data.replace(/\\n/g,'');
				data=data.replace(/"/g,'');
				document.getElementById('introduce').innerHTML=data;
			}

		});
		//console.log("introduce finish");
	}

</script>