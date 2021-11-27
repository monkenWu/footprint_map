<br>
<form id="keywordsForm">
	<div class="form-group row">
		<label for="exampleSelect" class="col-sm-2 form-control-label ">校：</label>
		<div class="col-sm-10">
			<select id="school2" class="form-control">
				<option value="elementary">國民小學</option>
				<option value="junior">國民中學</option>
			</select>
		</div>
	</div>
	<div class="my-selector-c2">
		<div class="form-group row">
			<label for="exampleSelect" class="col-sm-2 form-control-label ">市：</label>
			<div class="col-sm-10">
				<select id="county2" class="form-control">
				</select>
			</div>
		</div>
		<div class="form-group row district2">
			<label for="exampleSelect" class="col-sm-2 form-control-label ">區：</label>
			<div class="col-sm-10">
				<select id="district2" class="form-control">
				</select>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-12">
			<input type="text" class="form-control" id="keywordsInputSchool" placeholder="鍵入校名關鍵字">
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-12">
			<input type="text" class="form-control" id="keywordsInputAddr" placeholder="鍵入地址關鍵字">
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
		tcs2 = new TwCitySelector({
		    el: ".my-selector-c2",
		    elCounty: "#county2", // 在 el 裡查找 dom
		    elDistrict: "#district2", // 在 el 裡查找 dom
	 	});
		$("#county2").attr('class',"form-control");
		$(".district2").remove();
		$(".hideSchool").hide();
	});

	//捕捉市變動內容
    $("#county2").change(function(){
    	//調整焦距
    	if($("#county2").val() == "" ){
    		$('#map').tinyMap('modify', {zoom: 8});
	    	$('#map').tinyMap('clear');

	    	//移動中心點
	    	$('#map').tinyMap('panTo', ['23.5', '121']);
    	}else{
    		$('#map').tinyMap('modify', {zoom: 10});
	    	$('#map').tinyMap('clear');
	    	//移動中心點
	    	$('#map').tinyMap('panTo', $("#county2").val());
	    	$('#map').tinyMap('modify',{
			    'marker': [
			        {
			            'addr': $("#county2").val(),
			            'text': '<strong>'+$("#county2").val()+'，選取區中心</strong>',
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

    //按下搜索時動作
 	$("#keywordsForm").submit(function(e){
 		e.preventDefault();
    	$('#map').show(500);
		$('#schoolWindow').hide(500);
		$("#openImg").html('<img src="<?php echo base_url('dist/img/system/map/loading.gif') ?>" class="img-fluid" alt="Responsive image" />');
        if($("#keywordsInputSchool").val().length == "" && $("#keywordsInputAddr").val().length == ""){
        	swal({
                title: "注意",
                text: "至少輸入一個關鍵字進行搜索",
                icon: "warning",
                animation: "slide-from-top"
            });
        }else{
        	$('.searchButton').hide();
        	$('.searchLoading').show();
        	e.preventDefault();			
            $.ajax({
                url: '<?php  echo base_url('home/keywordsSearch') ?>',
                dataType: 'json',
                type:'post',
                traditional: true,
                data: {school : $("#school2").val(),
                       county : $('#county2').val(),
                       keywordsSchool : $('#keywordsInputSchool').val(),
                   	   keywordsAddr : $('#keywordsInputAddr').val()},
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
	            				  'cluster': true,
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