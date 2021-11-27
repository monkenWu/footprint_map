<div  id="schoolWindow" class="container-fluid" style="padding-top: 10px;overflow:auto;height: 100%;">
	<div id="schoolWindowTop" class="container-fluid">
        <div class="row">
            <div class="col-xl-4 dahsboard-column">
                <section class="box-typical box-typical-dashboard panel panel-default scrollable" data-body-height="710" data-expand="false">
                    <div class="box-typical-body panel-body">
                        <table class="tbl-typical">
                            <tr>
                                <th align="center"><div id="schoolName">壽天國小</div></th>
                            </tr>
                            <tr>
                            	<td align="center" id="openImg" class="text-center">
									<img src="<?php echo base_url('dist/img/system/map/loading.gif') ?>" style="margin:auto;" class="img-fluid  rounded mx-auto d-block " alt="Responsive image" />
                            	</td>
                            </tr>
                            <tr style="padding: 0">
                                <td style="padding: 0" class="text-center">
                                    <div class="btn-group text-center" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-secondary" onclick="nailSchool()" style="font-family:Microsoft JhengHei;">釘選學校</button>
                                        <button type="button" class="btn btn-secondary" id="getPhotoButton">提供相片</button>
                                        <a href="" class="btn btn-secondary" id="openNewBlank" target="_blank">開新頁面</a>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                            	<td>
                            		<div class="card" >
										<div class="card-body " style="padding: 20px">
											<p id="addr" style="margin-bottom:0rem">
												<span class="fa-stack fa-lg">
											  		<i class="fa fa-home" style="font-size: 35px"></i>
												</span>
												<addr id="schoolAddr">820-高雄市岡山區公園東路55號</addr>
											</p>
											<p id="phone" style="margin-bottom:0rem">
												<span class="fa-stack fa-lg">
											  		<i class="fa fa-phone " style="font-size: 35px; padding-left: 2px"></i>
												</span>
												<phone id="schoolPhone">(07)6246040<phone>
											</p>
											<p style="margin-bottom:0rem">
												<span class="fa-stack fa-lg">
											  		<i class="fa fa-internet-explorer" style="font-size: 29px"></i>
												</span>
												<a id="schoolUrl" href="http://www.stp.ks.edu.tw">http://www.stp.ks.edu.tw</a>
											</p>
										</div>
									</div>
                            	</td>
                            </tr>
                            <tr>
                            	<td>
                            		<div class="card" >
										<div class="card-body text-center" style="padding: 20px">
											<label for="starInput" class="control-label">服務指數</label>
										 	<input id="starInput" name="starInput" class="ratin" value="4" data-size="xs">
											<label id="starInput_text" for="starInput" class="control-label">4分</label>
										</div>
									</div>
                            	</td>
                            </tr>
                        </table>

                    </div><!--.box-typical-body-->
                </section><!--.box-typical-dashboard-->
            </div><!--.col-->

            <div class="col-xl-8 dahsboard-column">
                <section class="box-typical box-typical-dashboard panel panel-default scrollable" data-body-height="90">
                    <header class="box-typical-header panel-heading">
                        <h3 class="panel-title">建物資訊</h3>
                    </header>
                    <div class="box-typical-body panel-body">
                        <table class="tbl-typical ">
                            <tr>
								<th align="center" style="width: 25%"><div>校地面積</div></th>
								<th align="center" style="width: 25%"><div>禮堂數量</div></th>
								<th align="center" style="width: 25%"><div>教室間數</div></th>
								<th align="center" style="width: 25%"><div>可上網電腦數</div></th>
							</tr>
                            <tr>
								<td align="center" id="areaContent"></td>
								<td align="center" id="hallContent"></td>
								<td align="center" id="classContent"></td>
								<td align="center" id="computerContent"></td>
							</tr>
                        </table>
                    </div><!--.box-typical-body-->
                </section><!--.box-typical-dashboard-->

                <section class="box-typical box-typical-dashboard panel panel-default scrollable" data-body-height="210">
                    <header class="box-typical-header panel-heading">
                        <h3 class="panel-title">學生組成</h3>
                    </header>
                    <div class="box-typical-body panel-body">
                        <table class="tbl-typical " style="border-bottom: solid 1px #d8e2e7;">
                            <tr>
                            	<th align="center" style="width: 4%"><div>*</div></th>
								<th align="center" style="width: 14%"><div>一年級</div></th>
								<th align="center" style="width: 14%"><div>二年級</div></th>
								<th align="center" style="width: 14%"><div>三年級</div></th>
								<th class="juniorTable" align="center" style="width: 14%"><div>四年級</div></th>
								<th class="juniorTable" align="center" style="width: 14%"><div>五年級</div></th>
								<th class="juniorTable" align="center" style="width: 14%"><div>六年級</div></th>
							</tr>
                            <tr>
								<td align="center" style="background-color: #f6f8fa">男</td>
								<td align="center" id="1Male"></td>
								<td align="center" id="2Male"></td>
								<td align="center" id="3Male"></td>
								<td class="juniorTable" align="center" id="4Male"></td>
								<td class="juniorTable" align="center" id="5Male"></td>
								<td class="juniorTable" align="center" id="6Male"></td>
							</tr>
							<tr>
								<td align="center" style="background-color: #f6f8fa">女</td>
								<td align="center" id="1Female"></td>
								<td align="center" id="2Female"></td>
								<td align="center" id="3Female"></td>
								<td class="juniorTable" align="center" id="4Female"></td>
								<td class="juniorTable" align="center" id="5Female"></td>
								<td class="juniorTable" align="center" id="6Female"></td>
							</tr>
							<tr>
								<td align="center" style="background-color: #f6f8fa"></td>
								<td align="center" id="1Class"></td>
								<td align="center" id="2Class"></td>
								<td align="center" id="3Class"></td>
								<td class="juniorTable" align="center" id="4Class"></td>
								<td class="juniorTable" align="center" id="5Class"></td>
								<td class="juniorTable" align="center" id="6Class"></td>
							</tr>
                        </table>
                        <br>
                        <table class="tbl-typical " style="border-top: solid 1px #d8e2e7;border-bottom: solid 1px #d8e2e7;">
                            <tr>
                                <th align="center" style="width: 4%"><div>*</div></th>
                                <th align="center" style="width: 24%"><div>原住民學生</div></th>
                                <th align="center" style="width: 24%"><div>新住民子女</div></th>
                                <th align="center" style="width: 24%"><div>一般學生</div></th>
                                <th align="center" style="width: 24%"><div>總班級數</th>
                            </tr>
                            <tr>
                                <td align="center" style="background-color: #f6f8fa">男</td>
                                <td align="center" id="aboriginalMale"></td>
                                <td align="center" id="colonialMale"></td>
                                <td align="center" id="ordinaryMale"></td>
                                <td align="center" id="allClass" rowspan="3"></td>
                            </tr>
                            <tr>
                                <td align="center" style="background-color: #f6f8fa">女</td>
                                <td align="center" id="aboriginalFemale"></td>
                                <td align="center" id="colonialFemale"></td>
                                <td align="center" id="ordinaryFemale"></td>
                            </tr>
                            <tr>
                                <td align="center" style="background-color: #f6f8fa">總和</td>
                                <td  align="center" id="allStudent" colspan="3"></td>
                            </tr>
                        </table>
                    </div><!--.box-typical-body-->
                </section><!--.box-typical-dashboard-->

                <section class="box-typical box-typical-dashboard panel panel-default scrollable" data-body-height="210">
                    <header class="box-typical-header panel-heading">
                        <h3 class="panel-title">職員組成</h3>
                    </header>
                    <div class="box-typical-body panel-body">
                        <table class="tbl-typical " style="border-bottom: solid 1px #d8e2e7;">
                            <tr>
                                <th align="center" style="width: 4%"><div>*</div></th>
                                <th align="center" style="width: 48%"><div>專任教師數</div></th>
                                <th align="center" style="width: 48%"><div>職員數</div></th>
                            </tr>
                            <tr>
                                <td align="center" style="background-color: #f6f8fa">男</td>
                                <td align="center" id="regularMale"></td>
                                <td align="center" id="teacherMale"></td>
                            </tr>
                            <tr>
                                <td align="center" style="background-color: #f6f8fa">女</tdh>
                                <td align="center" id="regularFemale"></td>
                                <td align="center" id="teacherFemale"></td>
                            </tr>
                            <tr>
                                <td align="center" style="background-color: #f6f8fa">總和</td>
                                <td align="center" id="regularAll"></td>
                                <td align="center" id="teacherAll"></td>
                            </tr>
                        </table>
                    </div><!--.box-typical-body-->
                </section><!--.box-typical-dashboard-->
            </div><!--.col-->

            <div class="col-xl-4 dahsboard-column">

                <section class="box-typical box-typical-dashboard panel panel-default scrollable" data-body-height="560"  data-expand="false">
                    <header class="box-typical-header panel-heading">
                        <h3 class="panel-title">服務評分</h3>
                    </header>
                    <div class="box-typical-body panel-body">
                        <table class="tbl-typical">
                            <tr>
                                <th align="center"><div>細項評分</div></th>
                            </tr>
                            <tr>
                                <td>
                                   <div class="card" style="margin-bottom:15px">
                                        <div class="card-body text-center" style="padding: 10px">
                                            <label for="starInput_school" class="control-label">學校配合度</label>
                                            <input id="starInput_school" name="starInput_school" class="ratin" value="4" data-size="xs">
                                            <label id="starInput_school_text" for="starInput_school" class="control-label">4分</label>
                                        </div>
                                    </div>
                                    <div class="card" style="margin-bottom:15px">
                                        <div class="card-body text-center" style="padding: 10px">
                                            <label for="starInput_student" class="control-label">學生配合度</label>
                                            <input id="starInput_student" name="starInput_student" class="ratin" value="4" data-size="xs">
                                            <label id="starInput_student_text"for="starInput_student" class="control-label">4分</label>
                                        </div>
                                    </div>
                                    <div class="card" style="margin-bottom:15px">
                                        <div class="card-body text-center" style="padding: 10px">
                                            <label for="starInput_traffic" class="control-label">交通方便性</label>
                                            <input id="starInput_traffic" name="starInput_traffic" class="ratin" value="3.5" data-size="xs">
                                            <label id="starInput_traffic_text" for="starInput_traffic" class="control-label">3.5分</label>
                                        </div>
                                    </div>
                                    <div class="card" style="margin-bottom:5px">
                                        <div class="card-body text-center" style="padding: 10px">
                                            <label for="starInput_round" class="control-label">周邊機能性</label>
                                            <input id="starInput_round" name="starInput_round" class="ratin" value="3.5" data-size="xs">
                                            <label id="starInput_round_text" for="starInput_round" class="control-label">3.5分</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div><!--.box-typical-body-->
                </section><!--.box-typical-dashboard-->
            </div><!--.col-->

            <div class="col-xl-8 dahsboard-column">
               <?php  $this->load->view("basic/school/footprint");  ?>
            </div>
            
            <!-- <div class="col-xl-12 dahsboard-colum">
                <?php  //$this->load->view("basic/school/indexChart");  ?>
            </div> -->
        </div>
    </div><!--.container-fluid-->
</div>



<script>

    $(window).resize(function() {
        var thisWindowWidth=$(window).width();
        if(thisWindowWidth<1400){
            $('.btn-group').addClass("btn-group-sm");
        }else{
            $('.btn-group').removeClass("btn-group-sm");
        }
    });
    var thisWindowWidth=$(window).width();
    if(thisWindowWidth<1400){
        $('.btn-group').addClass("btn-group-sm");
    }else{
        $('.btn-group').removeClass("btn-group-sm");
    }

	function panelDraw(){
		$('.panel').lobiPanel({
			sortable: false,
			reload: false,
		    close: false,
		    unpin: false,
		    editTitle: false,
		});
		$('.panel').on('dragged.lobiPanel', function(ev, lobiPanel){
			$('.dahsboard-column').matchHeight();
		});
	}
	//隱藏
	$(document).ready(function(){
		$('#schoolWindow').hide();
		//$('#map').hide();
		//$('#schoolWindow').show();
		panelDraw();
	});

	//星星
	$(document).on('ready', function(){
		$('#starInput').rating({displayOnly: true, step: 0.5});
        $('#starInput_school').rating({displayOnly: true, step: 0.5});
        $('#starInput_student').rating({displayOnly: true, step: 0.5});
        $('#starInput_traffic').rating({displayOnly: true, step: 0.5});
        $('#starInput_round').rating({displayOnly: true, step: 0.5});
	});
    thisNailSchoolType = "";
	//進入學校
	function openSchoolWindow(id,name,addr,phone,url,schoolNumber,schoolClass){
        $(".searchButton").hide();
        $('#getPhotoButton').hide();
        $(".hideSchool").show();
		//console.log(id+","+name);
		$('#map').hide(500);
		$('#schoolWindow').show(500);
        $('#openNewBlank').attr("href","<?php echo base_url('school') ?>?school=\""+schoolClass+"\"&id=\""+id+"\"");
        getService(schoolNumber);
		//載入圖片
		thisload = 0;
        thisPhoto = "";
		var onLoad = window.setInterval(function(){
			if(openPhotoArr[name]!= undefined){
				window.clearInterval(onLoad); 
				$("#openImg").html('<img src="'+openPhotoArr[name]+'" class="img-fluid text-center" style="margin:auto;" alt="Responsive image" />');
                $("#mapImg"+name).html('<img src="'+openPhotoArr[name]+'" height="150" />');
                if(openPhotoArr[name] != "<?php echo base_url('dist/img/system/map/noSchoolImg.gif') ?>"){
                    $('#getPhotoButton').hide();
                }else{
                    //$('#getPhotoButton').show();
                }
                thisPhoto = openPhotoArr[name];
			}else{
				    $("#openImg").html('<img src="<?php echo base_url('dist/img/system/map/loading.gif') ?>" style="margin:auto;" class="img-fluid  rounded mx-auto d-block" alt="Responsive image" />');
                    thisload++;
                if(thisload==2){
                    window.clearInterval(onLoad);
                    $("#openImg").html('<img src="<?php echo base_url('dist/img/system/map/noSchoolImg.gif') ?>" style="margin:auto;" class="img-fluid  rounded mx-auto d-block" alt="Responsive image" />');
                    $("#mapImg"+name).html('<img src="<?php echo base_url('dist/img/system/map/noSchoolImg.gif') ?>" height="150" />');
                    //$('#getPhotoButton').show();
                    openPhotoArr[name]='<?php echo base_url("dist/img/system/map/noSchoolImg.gif") ?>' ;
                    thisPhoto = openPhotoArr[name];
                };
			}
		},500);
        $('#schoolName').html(name);
        $('#schoolUrl').attr('href',url);
        $('#schoolUrl').html(url);
        $('#schoolPhone').html(phone);
        $('#schoolAddr').html(addr);
        
        nailSchool = function(){
            if(nailNumber>4){
                swal({
                    title: "失敗",
                    text: "校園釘選最多四間",
                    icon: "error",
                    animation: "slide-from-top"
                });
            }else{
                if(nailNumber==1){
                    thisNailSchoolType = schoolClass;
                    if(nailSchoolShow(id,name,addr,phone,url,schoolNumber,schoolClass,thisPhoto)){
                        swal({
                            title: "成功",
                            text: "釘選成功",
                            icon: "success",
                            animation: "slide-from-top"
                        });
                    }else{
                        swal({
                            title: "注意",
                            text: "這間學校以在釘選的序列之中",
                            icon: "info",
                            animation: "slide-from-top"
                        });
                    }
                }else if(thisNailSchoolType == schoolClass){
                    if(nailSchoolShow(id,name,addr,phone,url,schoolNumber,schoolClass,thisPhoto)){
                        swal({
                            title: "成功",
                            text: "釘選成功",
                            icon: "success",
                            animation: "slide-from-top"
                        });
                    }else{
                        swal({
                            title: "注意",
                            text: "這間學校以在釘選的序列之中",
                            icon: "info",
                            animation: "slide-from-top"
                        });
                    }
                }else{
                    swal({
                        title: "注意",
                        text: "目前釘選之學校組合為"+(thisNailSchoolType=="junior"?"國中":"國小")+"，若要重新選擇，請清除所有釘選內容，再重新選擇其他屬性。",
                        icon: "info",
                        animation: "slide-from-top"
                    });
                }
                
            }
        }

        tableInsert(id,schoolClass);
        search(addr);
	}
    thisEditSchoolClass = '';
    thisEditSchoolId = '';
    function tableInsert(id,schoolClass){
        thisEditSchoolClass = schoolClass;
        thisEditSchoolId = id;
        $.ajax({
            url: '<?php  echo base_url('home/schoolInfo') ?>',
            dataType: 'json',
            type:'post',
            traditional: true,
            data: {school : schoolClass,
                   id : id},
            error:function(){
                swal("錯誤", "連線失敗，請重新送出", "error");
            },
            success: function(json){
                $('#areaContent').html(json['building']['areaContent']+"　平方公尺");
                $('#hallContent').html(json['building']['hallContent']);
                $('#classContent').html(json['building']['classContent']);
                $('#computerContent').html(json['building']['computerContent']);

                $('#regularMale').html(json['teacherPart']['regularMale']+"位");
                $('#teacherMale').html(json['teacherPart']['teacherMale']+"位");
                $('#regularFemale').html(json['teacherPart']['regularFemale']+"位");
                $('#teacherFemale').html(json['teacherPart']['teacherFemale']+"位");
                $('#regularAll').html(json['teacherPart']['regularAll']+"位");
                $('#teacherAll').html(json['teacherPart']['teacherAll']+"位");

                var thisSchool;
                if(schoolClass == "junior"){
                    $('.juniorTable').hide();
                    thisSchool = 3;
                }else{
                    $('.juniorTable').show();
                    thisSchool = 6;
                }

                for(i=1;i<=thisSchool;i++){
                    $('#'+i+'Male').html(json['studentClass'][i+'Male']+"位");
                    $('#'+i+'Female').html(json['studentClass'][i+'Female']+"位");
                    $('#'+i+'Class').html(json['studentClass'][i+'Class']+"班");
                }
                $('#allClass').html(json['studentClass']['allClass']+"班");

                $('#aboriginalMale').html(json['studentPart']['aboriginalMale']+"位");
                $('#colonialMale').html(json['studentPart']['colonialMale']+"位");
                $('#ordinaryMale').html(json['studentPart']['ordinaryMale']+"位");
                $('#aboriginalFemale').html(json['studentPart']['aboriginalFemale']+"位");
                $('#colonialFemale').html(json['studentPart']['colonialFemale']+"位");
                $('#ordinaryFemale').html(json['studentPart']['ordinaryFemale']+"位");
                $('#allStudent').html(json['studentPart']['allStudent']+"位");

                $('#starInput_school').rating('update', json['source']['schoolCooperate']+"分");
                $('#starInput_student').rating('update', json['source']['studentCooperate']+"分");
                $('#starInput_traffic').rating('update', json['source']['traffic']+"分");
                $('#starInput_round').rating('update', json['source']['around']+"分");
                var allStart = (parseInt(json['source']['schoolCooperate'])+parseInt(json['source']['studentCooperate'])+parseInt(json['source']['traffic'])+parseInt(json['source']['around']))/4;
                $('#starInput').rating('update', allStart);

                $('#starInput_school_text').html(json['source']['schoolCooperate']+"分");
                $('#starInput_student_text').html(json['source']['studentCooperate']+"分");
                $('#starInput_traffic_text').html(json['source']['traffic']+"分");
                $('#starInput_round_text').html(json['source']['around']+"分");
                $('#starInput_text').html(allStart+"分");
            }
        });
    }

    function showMap(){
        $('#map').show(500);
        $('#schoolWindow').hide(500);
        $(".searchButton").show();
        $(".hideSchool").hide();
    }

</script>