<div class="page-content" id="contentTopDiv"  style=" padding-left:0;">
   	
</div>

<div class="container-fluid" id="contentDiv" style="margin-top:30px">

</div>

<div id="map" style="border:0;width: 100%;">
		
</div>


<script src="<?php echo base_url('dist/build/js/lib/jQuery-tinyMap-master/jquery.tinyMap.js'); ?>"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXdusGmRw8Jk-mvzTy220ilPkjDcbDrVg&libraries=places"></script>
<script>

	school = "";
	id = "";

	<?php
		if(isset($error)){
			echo  'swal("'.$error.'").then((value) => {document.location.href="'.base_url().'"});';
		}else{
			echo 'school='.$school.';';
			echo 'id='.$id.';';
			echo 'getContent(school,id);';
		}
	?>

	function getContent(school,id){
		$.ajax({
            url: '<?php  echo base_url('comparing/getAllContent') ?>',
            dataType: 'json',
            type:'post',
            async: false,
            data: {school : school,
                   id : id},
            error:function(){
                swal("錯誤", "連線失敗，請重新送出", "error");
            },
            success: function(json){
            	setContent(json);
            }
        });
	}

	

	function setContent(data){

		screenBig = 12/data.length;
		screenMin = 0;
		if(data.length == 3){
			screenMin = 4;
		}else{
			screenMin = 6;
		}
		$('#contentTopDiv').append('<div class="container-fluid overlay" id="contentOverTop"></div>');

		
		for( i=0;i<data.length;i++){
			//浮動式標題
			$('#contentOverTop').append('<div class="col-xl-'+screenBig+' col-sm-'+screenMin+' text-center overlayDiv" ><div class="overlayDivText"><b>'+data[i]['school']['name']+'</b></div></div>');
			$('#contentDiv').append('<div class="col-xl-'+screenBig+' col-sm-'+screenMin+' dahsboard-column" id="content-'+i+'"></div>');
			$('#content-'+i).append('<div class="box-typical-body panel-body" id="panel-'+i+'"></div>');
			//var thisPhoto;
			
			//console.log(thisPhoto);
			console.log(data[i]['school']['position']);
			$('#panel-'+i).append('<table class="tbl-typical" id="table-'+i+'"><tr class="miniTop"><td align="center" style="font-size: 1rem;"><b>'+data[i]['school']['name']+'</b></td></tr><tr style="background-color:#FFFFFF"><td id="openImg" class="text-center"><img src="<?php echo base_url('dist/img/system/map/loading.gif') ?>" class="img-fluid  rounded mx-auto d-block img"  id="thisPhoto_'+i+'" heigth="300" alt="Responsive image" style="margin:auto;height:300px;" ></td></tr>');
			$('#table-'+i).append('<tr><td style="background-color:#FFFFFF"><div class="card text-center" ><div class="card-body "><p style="margin-bottom:0rem; font-size: 14px"><span class="fa-stack fa-lg"><i class="fa fa-home" style="font-size: 25px"></i></span>'+data[i]['school']['addr']+'</p><p style="margin-bottom:0rem"><span class="fa-stack fa-lg"><i class="fa fa-phone " style="font-size: 25px; padding-left: 2px"></i></span>'+data[i]['school']['phone']+'</p><p style="margin-bottom:0rem"><span class="fa-stack fa-lg"><i class="fa fa-internet-explorer" style="font-size: 25px"></i></span><a href="'+data[i]['school']['url']+'">官方網站</a></p></div></div></td></tr>');
			$('#table-'+i).append('<tr><td  style="background-color:#FFFFFF"><div class="card" id="sourceColor'+i+'" style="background-color:#ccffcc"><div class="card-body text-center"><label for="starInput" class="control-label">服務指數</label><input id="source'+i+'" name="starInput" class="ratin" value="4" data-size="xs"><label id="sourceText'+i+'" class="control-label">4分</label></div></div></td></tr></table>');

			$('#panel-'+i).append('<table class="tbl-typical" style="border-top: solid 1px #d8e2e7;" id="allsource'+i+'"><tr><th align="center"><div>細項評分</div></th></tr></table>');
			$('#allsource'+i).append('<tr><td><div class="card" style="margin-bottom:15px"><div class="card-body text-center" style="padding: 10px;background-color: #CCFFCC" id="schoolCooperateColor'+i+'"><label for="starInput_school" class="control-label">學校配合度</label><input id="schoolCooperate'+i+'" name="starInput_school" class="ratin" value="4" data-size="xs"><label id="schoolCooperateText'+i+'" for="starInput_school" class="control-label">4分</label></div></div><div class="card" style="margin-bottom:15px"><div class="card-body text-center" style="padding: 10px;background-color: #CCFFCC" id="studentCooperateColor'+i+'"><label for="starInput_student" class="control-label">學生配合度</label><input id="studentCooperate'+i+'" name="starInput_student" class="ratin" value="4" data-size="xs"><label id="studentCooperateText'+i+'"for="starInput_student" class="control-label">4分</label></div></div><div class="card" style="margin-bottom:15px"><div class="card-body text-center" style="padding: 10px;background-color: #CCFFCC" id="trafficColor'+i+'"><label for="starInput_traffic" class="control-label">交通方便性</label><input id="traffic'+i+'" name="starInput_traffic" class="ratin" value="3.5" data-size="xs"><label id="trafficText'+i+'" for="starInput_traffic" class="control-label">3.5分</label></div></div><div class="card" style="margin-bottom:5px"><div class="card-body text-center" style="padding: 10px;background-color: #CCFFCC" id="aroundColor'+i+'"><label for="starInput_round" class="control-label">周邊機能性</label><input id="around'+i+'" name="starInput_round" class="ratin" value="3.5" data-size="xs"><label id="aroundText'+i+'" for="starInput_round" class="control-label">3.5分</label></div></div></td></tr>');

			$('#panel-'+i).append('<table class="tbl-typical" style="border-top: solid 1px #d8e2e7;"><tr><th align="center" colspan="4"><div>建物資訊</div></th></tr><tr><th align="center" style="width: 25%"><div>校地面積</div></th><th align="center" style="width: 25%"><div>禮堂數量</div></th><th align="center" style="width: 25%"><div>教室間數</div></th><th align="center" style="width: 25%"><div>可上網電腦數</div></th></tr><tr><td align="center" id="areaContent'+i+'" style="background-color: #CCFFCC">1</td><td align="center" id="hallContent'+i+'"  style="background-color: #CCFFCC">2</td><td align="center" id="classContent'+i+'"  style="background-color: #CCFFCC">3</td><td align="center" id="computerContent'+i+'"  style="background-color: #CCFFCC">4</td></tr></table>');

			$('#panel-'+i).append('<table class="tbl-typical " style="border-top: solid 1px #d8e2e7;border-bottom: solid 1px #d8e2e7;"><tr><th align="center" colspan="5"><div>學生資訊</div></th></tr><tr><th align="center" style="width: 20%"><div>原住民學生</div></th><th align="center" style="width: 20%"><div>新住民子女</div></th><th align="center" style="width: 20%"><div>一般學生</div></th><th align="center" style="width: 20%"><div>總班級數</th><th align="center" style="width: 20%"><div>總學生數</th></tr><tr><td align="center" id="aboriginal'+i+'" style="background-color: #CCFFCC">1</td><td align="center" id="colonial'+i+'" style="background-color: #CCFFCC">2</td><td align="center" id="ordinary'+i+'" style="background-color: #CCFFCC">3</td><td align="center" id="allClass'+i+'" style="background-color: #CCFFCC">4</td><td align="center" id="allStudent'+i+'" style="background-color: #CCFFCC">5</td></tr></table>');

			$('#panel-'+i).append('<table class="tbl-typical " style="border-bottom: solid 1px #d8e2e7;border-bottom: solid 1px #d8e2e7;margin-bottom:50px"><tr><th align="center" colspan="2"><div>教師資訊</div></th></tr><tr><th align="center" style="width: 50%"><div>專任教師</div></th><th align="center" style="width: 50%"><div>職員數</div></th></tr><tr><td align="center" id="regularAll'+i+'" style="background-color: #CCFFCC">1</td><td align="center" id="teacherAll'+i+'" style="background-color: #CCFFCC">2</td></tr></table>');
			
		}

		num=0;
		var location = data[num]['school']['position'].split(",");
		var text = {lat: parseFloat(location[0]), lng: parseFloat(location[1])};
		getPhoto(text,data[num]['school']['name']);

		function getPhoto(location,school){
			var request = {
			    location: location,
			    radius: '1000',
			   	keyword:school
			};
			service = new google.maps.places.PlacesService(map);
			service.nearbySearch(request, createPhotoMarker);
		}
		
		function createPhotoMarker(place) {
			//console.log(place);
			if (place.length == 0) {
				$('#thisPhoto_'+num).attr('src', '<?php echo base_url("dist/img/system/map/noSchoolImg.gif") ?>');
				num++;
				if(num<data.length){
					var location = data[num]['school']['position'].split(",");
					var text = {lat: parseFloat(location[0]), lng: parseFloat(location[1])};
					getPhoto(text,data[num]['school']['name']);
				}
				return;
			}
			var photos = place[0].photos;
			$('#thisPhoto_'+num).attr('src', photos[0].getUrl({'maxWidth': 400, 'maxHeight': 400}));
			num++
			if(num<data.length){
				var location = data[num]['school']['position'].split(",");
				var text = {lat: parseFloat(location[0]), lng: parseFloat(location[1])};
				getPhoto(text,data[num]['school']['name']);
			}
		}
		//console.log(data.length);

		setStart("source");
		setStart("schoolCooperate");
		setStart("studentCooperate");
		setStart("around");
		setStart("traffic");
		function setStart(str){
			var sourceTemp = [] ;
			if(str=="source"){
				for(i=0;i<data.length;i++){
					var sourceNum = (parseFloat(data[i][str]['around'])+parseFloat(data[i][str]['schoolCooperate'])+parseFloat(data[i][str]['studentCooperate'])+parseFloat(data[i][str]['traffic']))/4.0;
					if(sourceNum>4.0&&sourceNum<5.0){
						sourceNum = 4.5;
					}else if (sourceNum>3.0&&sourceNum<4.0){
						sourceNum = 3.5;
					}else if (sourceNum>2.0&&sourceNum<3.0){
						sourceNum = 2.5;
					}else if (sourceNum>1.0&&sourceNum<2.0){
						sourceNum = 1.5;
					}else if (sourceNum>0  &&sourceNum<1){
						sourceNum = 0.5;
					}
					$('#source'+i).val(sourceNum);
					$('#source'+i).rating({displayOnly: true, step: 0.5});
					$('#sourceText'+i).html(sourceNum+"分");
					sourceTemp[i] = {};
					sourceTemp[i].num = sourceNum;
					sourceTemp[i].id = i;
				}
				sourceTemp.sort(function(a,b){return b.num-a.num;});
				if(sourceTemp.length == 2){
					if(sourceTemp[(sourceTemp.length)-1].num != sourceTemp[(sourceTemp.length)-2].num){
						$('#sourceColor'+sourceTemp[(sourceTemp.length)-1].id).attr('style', 'background-color:#FFCCCC');
					}
				}else if(sourceTemp.length == 3){
					if(sourceTemp[(sourceTemp.length)-1].num == sourceTemp[(sourceTemp.length)-2].num){
						if(sourceTemp[(sourceTemp.length)-3].num != sourceTemp[(sourceTemp.length)-2].num){
							$('#sourceColor'+sourceTemp[(sourceTemp.length)-1].id).attr('style', 'background-color:#FFCCCC');
							$('#sourceColor'+sourceTemp[(sourceTemp.length)-2].id).attr('style', 'background-color:#FFCCCC');
						}
					}else{
						$('#sourceColor'+sourceTemp[(sourceTemp.length)-1].id).attr('style', 'background-color:#FFCCCC');
					}
				}else if (sourceTemp.length == 4){
					if(sourceTemp[(sourceTemp.length)-1].num == sourceTemp[(sourceTemp.length)-2].num){
						if(sourceTemp[(sourceTemp.length)-3].num != sourceTemp[(sourceTemp.length)-2].num){
							if(sourceTemp[(sourceTemp.length)-4].num != sourceTemp[(sourceTemp.length)-2].num){
								$('#sourceColor'+sourceTemp[(sourceTemp.length)-1].id).attr('style', 'background-color:#FFCCCC');
								$('#sourceColor'+sourceTemp[(sourceTemp.length)-2].id).attr('style', 'background-color:#FFCCCC');
							}
						}else{
							if(sourceTemp[(sourceTemp.length)-3].num != sourceTemp[(sourceTemp.length)-4].num){
								$('#sourceColor'+sourceTemp[(sourceTemp.length)-1].id).attr('style', 'background-color:#FFCCCC');
								$('#sourceColor'+sourceTemp[(sourceTemp.length)-2].id).attr('style', 'background-color:#FFCCCC');
								$('#sourceColor'+sourceTemp[(sourceTemp.length)-3].id).attr('style', 'background-color:#FFCCCC');
							}	
						}
					}else{
						$('#sourceColor'+sourceTemp[(sourceTemp.length)-1].id).attr('style', 'background-color:#FFCCCC');
					}
				}
				
				console.log(sourceTemp);
			}else{
				for(i=0;i<data.length;i++){
					var sourceNum = parseFloat(data[i]['source'][str]);
					if(sourceNum>4.0&&sourceNum<5.0){
						sourceNum = 4.5;
					}else if (sourceNum>3.0&&sourceNum<4.0){
						sourceNum = 3.5;
					}else if (sourceNum>2.0&&sourceNum<3.0){
						sourceNum = 2.5;
					}else if (sourceNum>1.0&&sourceNum<2.0){
						sourceNum = 1.5;
					}else if (sourceNum>0  &&sourceNum<1){
						sourceNum = 0.5;
					}
					$('#'+str+''+i).val(sourceNum);
					$('#'+str+''+i).rating({displayOnly: true, step: 0.5});
					$('#'+str+'Text'+i).html(sourceNum+"分");
					sourceTemp[i] = {};
					sourceTemp[i].num = sourceNum;
					sourceTemp[i].id = i;
				}
				sourceTemp.sort(function(a,b){return b.num-a.num;});
				if(sourceTemp.length == 2){
					if(sourceTemp[(sourceTemp.length)-1].num != sourceTemp[(sourceTemp.length)-2].num){
						$('#'+str+'Color'+sourceTemp[(sourceTemp.length)-1].id).css("background-color","#FFCCCC");
					}
				}else if(sourceTemp.length == 3){
					if(sourceTemp[(sourceTemp.length)-1].num == sourceTemp[(sourceTemp.length)-2].num){
						if(sourceTemp[(sourceTemp.length)-3].num != sourceTemp[(sourceTemp.length)-2].num){
							$('#'+str+'Color'+sourceTemp[(sourceTemp.length)-1].id).css("background-color","#FFCCCC");
							$('#'+str+'Color'+sourceTemp[(sourceTemp.length)-2].id).css("background-color","#FFCCCC");
						}
					}else{
						$('#'+str+'Color'+sourceTemp[(sourceTemp.length)-1].id).css("background-color","#FFCCCC");
					}
				}else if (sourceTemp.length == 4){
					if(sourceTemp[(sourceTemp.length)-1].num == sourceTemp[(sourceTemp.length)-2].num){
						if(sourceTemp[(sourceTemp.length)-3].num != sourceTemp[(sourceTemp.length)-2].num){
							if(sourceTemp[(sourceTemp.length)-4].num != sourceTemp[(sourceTemp.length)-2].num){
								$('#'+str+'Color'+sourceTemp[(sourceTemp.length)-1].id).css("background-color","#FFCCCC");
								$('#'+str+'Color'+sourceTemp[(sourceTemp.length)-2].id).css("background-color","#FFCCCC");
							}
						}else{
							if(sourceTemp[(sourceTemp.length)-3].num != sourceTemp[(sourceTemp.length)-4].num){
								$('#'+str+'Color'+sourceTemp[(sourceTemp.length)-1].id).css("background-color","#FFCCCC");
								$('#'+str+'Color'+sourceTemp[(sourceTemp.length)-2].id).css("background-color","#FFCCCC");
								$('#'+str+'Color'+sourceTemp[(sourceTemp.length)-3].id).css("background-color","#FFCCCC");
							}	
						}
					}else{
						$('#'+str+'Color'+sourceTemp[(sourceTemp.length)-1].id).css("background-color","#FFCCCC");
					}
				}
			}
		}

		setContent('building','areaContent');
		setContent('building','classContent');
		setContent('building','computerContent');
		setContent('building','hallContent');

		setContent('studentPart','aboriginal');
		setContent('studentPart','colonial');
		setContent('studentPart','ordinary');
		setContent('studentPart','allClass');
		setContent('studentPart','allStudent');

		setContent('teacherPart','regularAll');
		setContent('teacherPart','teacherAll');

		function setContent(join,str){
			var sourceTemp = [] ;
			for(i=0;i<data.length;i++){
				$('#'+str+i).html(data[i][join][str]);
				sourceTemp[i] = {};
				sourceTemp[i].num = parseInt(data[i][join][str]);
				sourceTemp[i].id = i;
			}
			sourceTemp.sort(function(a,b){return b.num-a.num;});
			if(sourceTemp.length == 2){
				if(sourceTemp[(sourceTemp.length)-1].num != sourceTemp[(sourceTemp.length)-2].num){
					$('#'+str+sourceTemp[(sourceTemp.length)-1].id).css("background-color","#FFCCCC");
				}
			}else if(sourceTemp.length == 3){
				if(sourceTemp[(sourceTemp.length)-1].num == sourceTemp[(sourceTemp.length)-2].num){
					if(sourceTemp[(sourceTemp.length)-3].num != sourceTemp[(sourceTemp.length)-2].num){
						$('#'+str+sourceTemp[(sourceTemp.length)-1].id).css("background-color","#FFCCCC");
						$('#'+str+sourceTemp[(sourceTemp.length)-2].id).css("background-color","#FFCCCC");
					}
				}else{
					$('#'+str+sourceTemp[(sourceTemp.length)-1].id).css("background-color","#FFCCCC");
				}
			}else if (sourceTemp.length == 4){
				if(sourceTemp[(sourceTemp.length)-1].num == sourceTemp[(sourceTemp.length)-2].num){
					if(sourceTemp[(sourceTemp.length)-3].num != sourceTemp[(sourceTemp.length)-2].num){
						if(sourceTemp[(sourceTemp.length)-4].num != sourceTemp[(sourceTemp.length)-2].num){
							$('#'+str+sourceTemp[(sourceTemp.length)-1].id).css("background-color","#FFCCCC");
							$('#'+str+sourceTemp[(sourceTemp.length)-2].id).css("background-color","#FFCCCC");
						}
					}else{
						if(sourceTemp[(sourceTemp.length)-3].num != sourceTemp[(sourceTemp.length)-4].num){
							$('#'+str+sourceTemp[(sourceTemp.length)-1].id).css("background-color","#FFCCCC");
							$('#'+str+sourceTemp[(sourceTemp.length)-2].id).css("background-color","#FFCCCC");
							$('#'+str+sourceTemp[(sourceTemp.length)-3].id).css("background-color","#FFCCCC");
						}	
					}
				}else{
					$('#'+str+sourceTemp[(sourceTemp.length)-1].id).css("background-color","#FFCCCC");
				}
			}
		}
	}

	$(window).resize(function() {
        miniResize();
    });

	miniResize();
    function miniResize(){
    	var thisWidth=$(window).width();
        if(thisWidth<1200){
        	$('.miniTop').show();
        	$('.overlayDiv').hide();
        }else{
        	$('.overlayDiv').show();
        	$('.miniTop').hide();
        }
    }

/*
*/
</script>


