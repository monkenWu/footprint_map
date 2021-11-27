<br>
<form id="areaForm">
	<div class="form-group row">
		<label for="exampleSelect" class="col-sm-2 form-control-label ">校：</label>
		<div class="col-sm-10">
			<select id="school" class="form-control">
				<option value="elementary">國民小學</option>
				<option value="junior">國民中學</option>
			</select>
		</div>
	</div>
	<div class="my-selector-c">
		<div class="form-group row">
		<label for="exampleSelect" class="col-sm-2 form-control-label ">市：</label>
		<div class="col-sm-10">
			<select id="county" class="form-control">
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label for="exampleSelect" class="col-sm-2 form-control-label ">區：</label>
		<div class="col-sm-10">
			<select id="district" class="form-control">
			</select>
		</div>
	</div>
	</div>
	<h5 class="text-center">篩選屬性</h5>
	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox" id="check-1"/>
		<label for="check-1">偏鄉小學</label>
	</div>
	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox" id="check-2" data="2" />
		<label for="check-2">學生總數</label>
	</div>
	<div class="form-group hide" id="hide-2">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing" value="0" id="num-2">小於</button>
			</div>
			<input id="alltotal" type="text" class="form-control" name="alltotal" value="0">
		</div>
	</div>
	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox" id="check-3" data="3" />
		<label for="check-3">原住民學生數</label>
	</div>
	<div class="form-group hide" id="hide-3">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing" value="0" id="num-3">小於</button>
			</div>
			<input id="allaboriginal" type="text" class="form-control" name="allaboriginal" value="0">
		</div>
	</div>
	<div class="checkbox-toggle" >
		<input type="checkbox" class="checkbox" id="check-4" data="4"/>
		<label for="check-4">新住民家庭學生數</label>
	</div>
	<div class="form-group hide" id="hide-4">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing" value="0" id="num-4">小於</button>
			</div>
			<input id="allimmigrants" type="text" class="form-control" name="allimmigrants" value="0">
		</div>
	</div>
	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox" id="check-5" data="5"/>
		<label for="check-5">被服務次數（系統內）</label>
	</div>
	<div class="form-group hide" id="hide-5">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing" value="0" id="num-5">小於</button>
			</div>
			<input id="allservice" type="text" class="form-control" name="allservice" value="0">
		</div>
	</div>
	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox" id="check-6" data="6"/>
		<label for="check-6">服務評價</label>
	</div>
	<div class="form-group hide" id="hide-6">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing" value="1" id="num-6">大於</button>
			</div>
			<input id="allscore" type="text" class="form-control" name="allscore" value="3">
		</div>
	</div>
	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox" id="check-7"/>
		<label for="check-7">教育優先區</label>
	</div>
	<div class="form-group row text-right" style="padding-right: 15px">
		<button type="submit" class="btn searchButton">搜索</button>
		<button type="button" onclick="showMap();destroy_and_creat()" class="btn btn-success hideSchool">回搜索頁面</button>
		<img style="display: none;" class="searchLoading" src="<?php echo base_url('dist/img/system/button-loader.gif') ?>"  height="50">
	</div>
</form>
<div id="placeMap"></div>

<script>
	//隱藏欄位
	$(document).ready(function(){
		$('.hide').hide();
		openPhotoArr=[];
	});

	//初始化縣市資訊
	$(document).ready(function(){
		new TwCitySelector({
		    el: ".my-selector-c",
		    elCounty: "#county", // 在 el 裡查找 dom
		    elDistrict: "#district", // 在 el 裡查找 dom
	 	});
		$("#county").attr('class',"form-control");
		$("#district").attr('class',"form-control");
		$(".hideSchool").hide();
	});

	//初始化按鍵式數字遞增、遞減
	$(document).ready(function(){
		$("#alltotal").TouchSpin({
			min: 0,
			max: 1500,
			step: 50,
		});
		$("#allaboriginal").TouchSpin({
			min: 0,
			max: 500,
			step: 5,
		});
		$("#allimmigrants").TouchSpin({
			min: 0,
			max: 500,
			step: 5,
		});
		$("#allservice").TouchSpin({
			min: 0,
			max: 100,
			step: 1,
		});
		$("#allscore").TouchSpin({
			min: 0,
			max: 5,
			step: 1,
		});
		
	});

	//按下大於小於給予正確反應
	$('.comparing').click(function() {
		if($(this).attr('value')=="0"){
			$(this).attr('value',"1");
			$(this).html('大於');
		}else{
			$(this).attr('value',"0");
			$(this).html('小於');
		}
	});

	//若改變checkbox給予正確反應
	$('.checkbox').change(function(){
	   if($(this).attr('checked') == undefined){
	   		var thisData = $(this).attr('data');
	   		$(this).attr('checked','');
	        $('#hide-'+thisData).show(200);
	   }else{
	        var thisData = $(this).attr('data');
	        $(this).removeAttr('checked');
	        $('#hide-'+thisData).hide(200);
	   }
	});


    //捕捉市變動內容
    $("#county").change(function(){
    	//調整焦距
    	$('#map').tinyMap('modify', {zoom: 10});
    	$('#map').tinyMap('clear');
    	//移動中心點
    	$('#map').tinyMap('panTo', $("#county").val());
    	$('#map').tinyMap('modify',{
		    'marker': [
		        {
		            'addr': $("#county").val(),
		            'text': '<strong>'+$("#county").val()+'，選取區中心</strong>',
		            'newLabelCSS': 'labels',
		            // 自訂外部圖示
		            'icon': {
		                'url': '<?php echo base_url('dist/img/system/map/bigMaker.png');?>',
		                'scaledSize': [48, 48]
		            },
		            // 動畫效果
		            'animation': 'DROP'
		        }
		    ]
		});
 	}); 

 	//捕捉區縣變動內容
    $("#district").change(function(){
    	$('#map').tinyMap('clear');
    	//調整焦距
    	//$('#map').tinyMap('modify', {zoom: 11});
    	//移動中心點
    	$('#map').tinyMap('panTo', $("#county").val()+($("#district").val()));
    	$('#map').tinyMap('modify',{
		    'marker': [
		        {
		            'addr': $("#county").val()+($("#district").val()),
		            'text': '<strong>'+$("#district").val()+'，選取區中心</strong>',
		            'newLabelCSS': 'labels',
		            // 自訂外部圖示
		            'icon': {
		                'url': '<?php echo base_url('dist/img/system/map/bigMaker.png');?>',
		                'scaledSize': [48, 48]
		            },
		            // 動畫效果
		            'animation': 'DROP'
		        }
		    ]
		});
 	}); 

 	//搜索按鈕點下捕捉動作
    $("#areaForm").submit(function(e){
    	$('#map').show(500);
		$('#schoolWindow').hide(500);
		$("#openImg").html('<img src="<?php echo base_url('dist/img/system/map/loading.gif') ?>" class="img-fluid" alt="Responsive image" />');
        if($("#county").val() == ''){
            e.preventDefault();
            swal({
                title: "注意",
                text: "至少要選擇城市作為搜索依據",
                icon: "warning",
                animation: "slide-from-top"
            });
        }else{
        	$('.searchButton').hide();
        	$('.searchLoading').show();
        	e.preventDefault();
        	var check = new Array("faraway","total","aboriginal","immigrants","service","score","EPA");
        	var checkArr = [];
        	var returnArr = {} ;
        	//一次判斷所有屬性是否被選取
        	for(i=1;i<=7;i++){
        		checkArr[i-1] = $("#check-"+i).attr('checked') == undefined ? false : true;
        	}
        	//將屬性內容包裝給後端
        	for(i=1;i<=7;i++){
        		if(i==1){
        			returnArr[check[i-1]] = checkArr[i-1]?1:0;
        		}else if(i==7){
        			returnArr[check[i-1]] = checkArr[i-1]?1:0;
        		}else{
        			returnArr[check[i-1]] = checkArr[i-1]?1:0;
        			if(checkArr[i-1]){
        				var text = $("#num-"+i).attr('value')=="0"?"<=":">=";
        				text += ","+$("#all"+check[i-1]).val();
        				returnArr[check[i-1]+"_value"] = text;
        			}
        		}
        	}
			
        	//console.log(JSON.stringify(returnArr));

            $.ajax({
                url: '<?php  echo base_url('home/areaSearch') ?>',
                dataType: 'json',
                type:'post',
                traditional: true,
                data: {school : $("#school").val(),
                       county : $('#county').val(),
                       district :!$('#district').val()?false:$('#district').val(),
                       searchJson : JSON.stringify(returnArr)},
                error:function(){
                    swal("錯誤", "連線失敗，請重新送出", "error");
                    $('.searchButton').show();
        			$('.searchLoading').hide();
                },
                success: function(json){
                   	maker = [];
                   	//解析json內容
                   	for(i=0;i<json.length;i++){
                   		//紀錄標記處
                   		maker[i]={'addr':json[i]['position'],
                   				  'text':'<strong>'+
                   				  			'<div class="text-center" id="mapImg'+json[i]['name']+'"><img src="<?php echo base_url('dist/img/system/map/loading.gif') ?>" width="200" height="133"/></div>'+
                   				  			'地址：'+json[i]['addr']+'<br>'+
                   				  			'<a href="'+json[i]['url']+'" target="_blank">學校官網</a>'+
                   				  			'<button type="button" class="btn btn-primary btn-sm btn-block" onclick="openSchoolWindow('+json[i]['number']+',\''+json[i]['name']+'\',\''+json[i]['addr']+'\',\''+json[i]['phone']+'\',\''+json[i]['url']+'\',\''+json[i]['number']+'\',\''+json[i]['type']+'\')">進入學校</button>'+
                   				  		 '</strong>',
                   				  'newLabel': json[i]['name'],
	            				  'newLabelCSS': 'labels',
	            				  'animation': 'DROP',
	            				  'event': {
						                // created 事件於標記建立成功時執行。
						                'click': function (e) {
						                    this.infoWindow.open(this.map, this);
						                    var name = this.newLabel;
						                    var lat = e.latLng.lat();
						                	var lng = e.latLng.lng();
						                	var request = {
						                		location: {lat: e.latLng.lat(),lng:e.latLng.lng()},
											    radius: '1000',
											   	keyword:name
											};
						                	service = new google.maps.places.PlacesService(placeMap);
											service.nearbySearch(request, callback);
											function callback(place) {
												//console.log(place);
												if(place.length == 0){
													openPhotoArr[name]='<?php echo base_url("dist/img/system/map/noSchoolImg.gif") ?>' ;
													$("#mapImg"+name).html('<img src="<?php echo base_url("dist/img/system/map/noSchoolImg.gif") ?>"  height="100" />');
													return;
												}
												var photos = place[0].photos;
											    //取得相片
											    if(photos == undefined){
											    	openPhotoArr[name]='<?php echo base_url("dist/img/system/map/noSchoolImg.gif") ?>' ;
													$("#mapImg"+name).html('<img src="<?php echo base_url("dist/img/system/map/noSchoolImg.gif") ?>"  height="100" />');
													return;
											    }
									        	thisPhoto = photos[0].getUrl({'maxWidth': 200, 'maxHeight': 400});
										        $("#mapImg"+name).html('<img src="'+thisPhoto+'" />');
										        //新增大圖相片陣列
										        openPhotoArr[name]= photos[0].getUrl({'maxWidth': 400, 'maxHeight': 400});
											}
						                }
						            },
						          'infoWindowAutoClose':true
	            				};
                   	}
                   	$('.searchButton').show();
        			$('.searchLoading').hide();
                   	$('#map').tinyMap('clear');
                   	//調整焦距
                   	if(json.length>10){
                   		var thisLen = Math.floor(json.length/2);
                   		//console.log(thisLen);
                   		$('#map').tinyMap('panTo', json[thisLen]['position']);
                   		$('#map').tinyMap('modify', {zoom: 10});
                   		//放下標記處
	                   	$('#map').tinyMap('modify',{
						    'marker': maker
						});
						$('.hamburger--htla').click();
                   	}else if (json.length>0){
                   		$('#map').tinyMap('panTo', json[0]['position']);
                   		$('#map').tinyMap('modify', {zoom: 12});
                   		//放下標記處
	                   	$('#map').tinyMap('modify',{
						    'marker': maker
						});
						$('.hamburger--htla').click();
                   	}else{
                   		swal('注意','未搜索到任何結果，請調整數值再試一次。','info');
                   	}
                   	
                }
            });
        }
    });

	

</script>