<br>
<form id="attributesForm">
	<div class="form-group row">
		<label for="exampleSelect" class="col-sm-2 form-control-label ">校：</label>
		<div class="col-sm-10">
			<select id="school3" class="form-control">
				<option value="elementary">國民小學</option>
				<option value="junior">國民中學</option>
			</select>
		</div>
	</div>
	<div class="my-selector-c3">
		<div class="form-group row">
			<label for="exampleSelect" class="col-sm-2 form-control-label ">市：</label>
			<div class="col-sm-10">
				<select id="county3" class="form-control">
				</select>
			</div>
		</div>
		<div class="form-group row district3">
			<label for="exampleSelect" class="col-sm-2 form-control-label ">區：</label>
			<div class="col-sm-10">
				<select id="district3" class="form-control">
				</select>
			</div>
		</div>
	</div>
	<h5 class="text-center">人數屬性</h5>
	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox2" id="check-2-2" data="2" />
		<label for="check-2-2">學生總數</label>
	</div>
	<div class="form-group hide" id="hide-2-2">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing2" value="0" id="num2-2">小於</button>
			</div>
			<input id="all2total" type="text" class="form-control" value="0">
		</div>
	</div>
	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox2" id="check-2-3" data="3" />
		<label for="check-2-3">原住民學生數</label>
	</div>
	<div class="form-group hide" id="hide-2-3">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing2" value="0" id="num2-3">小於</button>
			</div>
			<input id="all2aboriginal" type="text" class="form-control" value="0">
		</div>
	</div>
	<div class="checkbox-toggle" >
		<input type="checkbox" class="checkbox2" id="check-2-4" data="4"/>
		<label for="check-2-4">新住民家庭學生數</label>
	</div>
	<div class="form-group hide" id="hide-2-4">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing2" value="0" id="num2-4">小於</button>
			</div>
			<input id="all2immigrants" type="text" class="form-control" value="0">
		</div>
	</div>
	<div class="checkbox-toggle" >
		<input type="checkbox" class="checkbox2" id="check-2-12" data="12"/>
		<label for="check-2-12">職員總數</label>
	</div>
	<div class="form-group hide" id="hide-2-12">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing2" value="0" id="num2-12">小於</button>
			</div>
			<input id="all2teacher" type="text" class="form-control" value="0">
		</div>
	</div>

	<h5 class="text-center">校園屬性</h5>
	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox2" id="check-2-13"/>
		<label for="check-2-13">教育優先區</label>
	</div>
	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox2" id="check-2-1"/>
		<label for="check-2-1">偏鄉學校</label>
	</div>
	
	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox2" id="check-2-7" data="7"/>
		<label for="check-2-7">校地面積(平方公尺)</label>
	</div>
	<div class="form-group hide" id="hide-2-7">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing2" value="1" id="num2-7">大於</button>
			</div>
			<input id="all2schoolArea" type="text" class="form-control" value="1000">
		</div>
	</div>

	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox2" id="check-2-8" data="8"/>
		<label for="check-2-8">禮堂數量</label>
	</div>
	<div class="form-group hide" id="hide-2-8">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing2" value="1" id="num2-8">大於</button>
			</div>
			<input id="all2hall" type="text" class="form-control" value="0">
		</div>
	</div>

	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox2" id="check-2-9" data="9"/>
		<label for="check-2-9">教室間數</label>
	</div>
	<div class="form-group hide" id="hide-2-9">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing2" value="1" id="num2-9">大於</button>
			</div>
			<input id="all2schoolClass" type="text" class="form-control" value="0">
		</div>
	</div>

	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox2" id="check-2-10" data="10"/>
		<label for="check-2-10">可上網電腦數</label>
	</div>
	<div class="form-group hide" id="hide-2-10">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing2" value="1" id="num2-10">大於</button>
			</div>
			<input id="all2schoolComputer" type="text" class="form-control" value="0">
		</div>
	</div>

	<h5 class="text-center">服務指數</h5>

	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox2" id="check-2-11"/>
		<label for="check-2-11">需要服務（系統內註記）</label>
	</div>


	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox2" id="check-2-5" data="5"/>
		<label for="check-2-5">被服務次數（系統內）</label>
	</div>
	<div class="form-group hide" id="hide-2-5">
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing2" value="0" id="num2-5">小於</button>
			</div>
			<input id="all2service" type="text" class="form-control" value="0">
		</div>
	</div>

	<div class="checkbox-toggle">
		<input type="checkbox" class="checkbox2" id="check-2-6" data="6"/>
		<label for="check-2-6">服務評價</label>
	</div>
	<div class="form-group hide" id="hide-2-6">
		<h6 class="text-center">學校配合度</h6>
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing2" value="1" id="num-6-1">大於</button>
			</div>
			<input id="all2schoolCooperate" type="text" class="form-control" value="3">
		</div>
		<h6 class="text-center" style="padding-top: 15px">學生配合度</h6>
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing2" value="1" id="num-6-2">大於</button>
			</div>
			<input id="all2studentCooperate" type="text" class="form-control" value="3">
		</div>
		<h6 class="text-center" style="padding-top: 15px">交通方便性</h6>
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing2" value="1" id="num-6-3">大於</button>
			</div>
			<input id="all2traffic" type="text" class="form-control" value="3">
		</div>
		<h6 class="text-center" style="padding-top: 15px">周邊機能性</h6>
		<div class="input-group">
			<div class="input-group-btn">
				<button type="button" class="btn btn-success comparing2" value="1" id="num-6-4">大於</button>
			</div>
			<input id="all2around" type="text" class="form-control" value="3">
		</div>
	</div>

	<div class="form-group row text-right" style="padding-right: 15px">
		<button type="submit" class="btn searchButton">搜索</button>
		<button type="button" onclick="showMap()" class="btn btn-success hideSchool">回搜索頁面</button>
		<img style="display: none;" class="searchLoading" src="<?php echo base_url('dist/img/system/button-loader.gif') ?>"  height="50">
	</div>
</form>

<script>
	//初始化縣市資訊
	$(document).ready(function(){
		tcs3 = new TwCitySelector({
		    el: ".my-selector-c3",
		    elCounty: "#county3", // 在 el 裡查找 dom
		    elDistrict: "#district3", // 在 el 裡查找 dom
	 	});
		$("#county3").attr('class',"form-control");
		$(".district3").remove();
		$(".hideSchool").hide();
	});

	//初始化按鍵式數字遞增、遞減
	$(document).ready(function(){
		$("#all2total").TouchSpin({
			min: 0,
			max: 1500,
			step: 50,
		});
		$("#all2aboriginal").TouchSpin({
			min: 0,
			max: 500,
			step: 5,
		});
		$("#all2immigrants").TouchSpin({
			min: 0,
			max: 500,
			step: 5,
		});
		$("#all2service").TouchSpin({
			min: 0,
			max: 100,
			step: 1,
		});
		$("#all2schoolArea").TouchSpin({
			min: 0,
			max: 100000,
			step: 1000,
		});
		$("#all2hall").TouchSpin({
			min: 0,
			max: 5,
			step: 1,
		});
		$("#all2schoolClass").TouchSpin({
			min: 0,
			max: 100,
			step: 5,
		});
		$("#all2schoolComputer").TouchSpin({
			min: 0,
			max: 150,
			step: 5,
		});
		$("#all2teacher").TouchSpin({
			min: 0,
			max: 200,
			step: 2,
		});

		$("#all2schoolCooperate").TouchSpin({
			min: 0,
			max: 5,
			step: 1,
		});
		$("#all2studentCooperate").TouchSpin({
			min: 0,
			max: 5,
			step: 1,
		});
		$("#all2traffic").TouchSpin({
			min: 0,
			max: 5,
			step: 1,
		});
		$("#all2around").TouchSpin({
			min: 0,
			max: 5,
			step: 1,
		});


		

	});

	//按下大於小於給予正確反應
	$('.comparing2').click(function() {
		if($(this).attr('value')=="0"){
			$(this).attr('value',"1");
			$(this).html('大於');
		}else{
			$(this).attr('value',"0");
			$(this).html('小於');
		}
	});

	//若改變checkbox給予正確反應
	$('.checkbox2').change(function(){
	   if($(this).attr('checked') == undefined){
	   		var thisData = $(this).attr('data');
	   		$(this).attr('checked','');
	        $('#hide-2-'+thisData).show(200);
	   }else{
	        var thisData = $(this).attr('data');
	        $(this).removeAttr('checked');
	        $('#hide-2-'+thisData).hide(200);
	   }
	});

	//捕捉市變動內容
    $("#county3").change(function(){
    	//調整焦距
    	if($("#county3").val() == "" ){
    		$('#map').tinyMap('modify', {zoom: 8});
	    	$('#map').tinyMap('clear');
	    	//移動中心點
	    	$('#map').tinyMap('panTo', ['23.5', '121']);
    	}else{
    		$('#map').tinyMap('modify', {zoom: 10});
	    	$('#map').tinyMap('clear');
	    	//移動中心點
	    	$('#map').tinyMap('panTo', $("#county3").val());
	    	$('#map').tinyMap('modify',{
			    'marker': [
			        {
			            'addr': $("#county3").val(),
			            'text': '<strong>'+$("#county3").val()+'，選取區中心</strong>',
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
    	}
    	
 	}); 

    //搜索按鈕點下捕捉動作
    $("#attributesForm").submit(function(e){
    	e.preventDefault();
    	$('#map').show(500);
		$('#schoolWindow').hide(500);
		$("#openImg").html('<img src="<?php echo base_url('dist/img/system/map/loading.gif') ?>" class="img-fluid" alt="Responsive image" />');
		var sourceArr= new Array("schoolCooperate","studentCooperate","traffic","around");
		var check = new Array("faraway","total","aboriginal","immigrants","service","source","schoolArea","hall","schoolClass","schoolComputer","needService","teacher","EPA");
		//console.log(check);
    	var checkArr = [];
    	var returnArr = {} ;
    	var checkAllNum = 0;
    	//一次判斷所有屬性是否被選取
    	for(i=1;i<=12;i++){
    		checkArr[i-1] = $("#check-2-"+i).attr('checked') == undefined ? false : true;
    		checkAllNum += $("#check-2-"+i).attr('checked') == undefined ? 0 : 1;
    		//console.log(checkAllNum);
    	}
        if(checkAllNum <2){
            e.preventDefault();
            swal({
                title: "注意",
                text: "至少要選擇2個屬性作為搜索依據",
                icon: "warning",
                animation: "slide-from-top"
            });
        }else{
        	$('.searchButton').hide();
        	$('.searchLoading').show();
        	//將屬性內容包裝給後端
        	for(i=1;i<=13;i++){
        		if(i==1){
        			returnArr[check[i-1]] = checkArr[i-1]?1:0;
        		}else if(i==6){
        			returnArr[check[i-1]] = checkArr[i-1]?1:0;
        			if(returnArr[check[i-1]]){
        				returnArr[check[i-1]+"_value"] = {};
	        			for(j=1;j<=4;j++){
	        				var text = $("#num-"+i+"-"+j).attr('value')=="0"?"<=":">=";
	        				text += ","+$("#all2"+sourceArr[j-1]).val();
	        				returnArr[check[i-1]+"_value"][sourceArr[j-1]+"_value"] = text;
	        			}
        			}
        		}else if(i==11){
        			returnArr[check[i-1]] = checkArr[i-1]?1:0;
        		}else if(i==13){
        			returnArr[check[i-1]] = checkArr[i-1]?1:0;
        		}else{
        			returnArr[check[i-1]] = checkArr[i-1]?1:0;
        			if(checkArr[i-1]){
        				var text = $("#num2-"+i).attr('value')=="0"?"<=":">=";
        				text += ","+$("#all2"+check[i-1]).val();
        				returnArr[check[i-1]+"_value"] = text;
        			}
        		}
        	}
        	//console.log(JSON.stringify(returnArr));
			
        	//console.log(JSON.stringify(returnArr));

            $.ajax({
                url: '<?php  echo base_url('home/attributesSearch') ?>',
                dataType: 'json',
                type:'post',
                traditional: true,
                data: {school : $("#school3").val(),
                       county : $('#county3').val(),
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
