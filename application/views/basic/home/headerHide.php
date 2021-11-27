<!--右方隱藏欄 以及上方左側欄-->
<div class="site-header-collapsed">
	<div class="row top-bg" id="topBgDiv">
		<div id="nailSchoolArea">

		</div>
		<div class="col col-sm-2 text-center" id="comparingSchoolDiv">
			<a class="btn btn-secondary btn-block schoolHide" id="comparingSchoolButton" target="_blank" href="">比較學校</a>
		</div>
	<div>
    
</div>
<!--右方隱藏欄 以及上方左側欄-->

<!-- JS  -->
		  
<script>
	nailNumber = 1;
	nailThisSchool = [0];
	$('#comparingSchoolDiv').hide();

	$(window).resize(function() {
        var thisWidth=$(window).width();
        if(thisWidth<1250 && thisWidth>=1057){
        	$('.schoolHide').addClass("btn-sm");
        	$('.bigSchoolNail').show();
        	$('.smallSchoolNail').hide();
        	$('#comparingSchoolDiv').removeClass("col-sm-12");
        	$('#comparingSchoolDiv').addClass("col-sm-2");
        	$('#topBgDiv').addClass("top-bg");
        }else{
        	$('.schoolHide').removeClass("btn-sm");
        	$('.bigSchoolNail').show();
        	$('.smallSchoolNail').hide();
        	$('#comparingSchoolDiv').removeClass("col-sm-12");
        	$('#comparingSchoolDiv').addClass("col-sm-2");
        	$('#topBgDiv').addClass("top-bg");
        }
        //console.log($(window).width());
        if(thisWidth<1057){
        	$('.bigSchoolNail').hide();
        	$('.smallSchoolNail').show();
        	$('#comparingSchoolDiv').addClass("col-sm-12");
        	$('#comparingSchoolDiv').removeClass("col-sm-2");
        	$('#topBgDiv').removeClass("top-bg");
        }
    });

    var thisWidth=$(window).width();
    if(thisWidth<1250 && thisWidth>=1057){
    	$('.schoolHide').addClass("btn-sm");
    }else{
    	$('.schoolHide').removeClass("btn-sm");
    }

    if(thisWidth<1057){
    	$('.schoolHide').removeClass("btn-sm");
    	$('#comparingSchoolDiv').addClass("col-sm-12");
        $('#comparingSchoolDiv').removeClass("col-sm-2");
        $('#topBgDiv').removeClass("top-bg");
    }


	function nailSchoolShow(id,name,addr,phone,url,schoolNumber,schoolClass,photo){

		if(nailThisSchool.indexOf(id)!=(-1)){
			return false;
		}

		nailThisSchool[nailNumber] = id;

		if(nailThisSchool.length>2){
			$('#comparingSchoolDiv').show();
		}else{
			$('#comparingSchoolDiv').hide();
		}

		var splitName = name.split("");
		var thisShowName = "";
		for(i=2;i<6;i++){
			thisShowName += splitName[i];
		}
		if(splitName.length>6){
			thisShowName += "...";
		}

		var splitAddr = addr.split("");
		var thisShowAddr = "";
		for(i=5;i<11;i++){
			thisShowAddr += splitAddr[i];
		}
		thisShowAddr += "...";

		var thisWidth=$(window).width();

		var hrefUrl = "";
		for(i=1;i<=(nailThisSchool.length-1);i++){
			hrefUrl += nailThisSchool[i];
			hrefUrl += i==(nailThisSchool.length-1)?"":",";
		}
		$("#comparingSchoolButton").attr("href","<?php echo base_url('comparing') ?>?school=\""+schoolClass+"\"&id=\""+hrefUrl+"\"");

		//外框架
		$('#nailSchoolArea').append('<div class="col col-sm-2 text-center nail bigSchoolNail" id="nailSchool_'+schoolNumber+'" style="padding:0"></div>');
		//手機外框架
		$('#nailSchoolArea').append('<div class="footPrint-card smallSchoolNail" id="nailSmallSchool_'+schoolNumber+'" style="padding-bottom: 10px;"></div>');
		if(thisWidth<1057){
			$('.bigSchoolNail').hide();
		}else{
			$('.smallSchoolNail').hide();
		}

		//按鈕群組框架
		$('#nailSchool_'+schoolNumber).append('<div class="btn-group d-none d-xl-block" id="nailContent_'+schoolNumber+'"></div>');
		
		if(thisWidth<1250){
			//學校按鈕
			$('#nailContent_'+schoolNumber).append('<button type="button" class="btn btn-success btn-sm schoolHide" onclick="$(\'#map\').show(100);$(\'#schoolWindow\').hide(100);openSchoolWindow('+id+',\''+name+'\',\''+addr+'\',\''+phone+'\',\''+url+'\',\''+schoolNumber+'\',\''+schoolClass+'\')">'+thisShowName+'</button>');
			//標籤按鈕
			$('#nailContent_'+schoolNumber).append('<button type="button" class="btn btn-success btn-sm schoolHide dropdown-toggle dropdown-toggle-split" onclick="delCol()" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>');
		}else{
			//學校按鈕
			$('#nailContent_'+schoolNumber).append('<button type="button" class="btn btn-success schoolHide" onclick="$(\'#map\').show(100);$(\'#schoolWindow\').hide(100);openSchoolWindow('+id+',\''+name+'\',\''+addr+'\',\''+phone+'\',\''+url+'\',\''+schoolNumber+'\',\''+schoolClass+'\')">'+thisShowName+'</button>');
			//標籤按鈕
			$('#nailContent_'+schoolNumber).append('<button type="button" class="btn btn-success schoolHide dropdown-toggle dropdown-toggle-split" onclick="delCol()" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>');
		}
		
		//標籤框架
		$('#nailContent_'+schoolNumber).append('<div class="dropdown-menu" id="nailBottomContent_'+schoolNumber+'"></div>');

		//圖片
		$('#nailBottomContent_'+schoolNumber).append('<div class="text-center"><img src="'+photo+'" height="105" /></div>');
		//校園資訊框架
		$('#nailBottomContent_'+schoolNumber).append('<div class="card-body " id="nailBottomContent-card_'+schoolNumber+'" style="padding-left: 10px"></div>');
		//地址
		$('#nailBottomContent-card_'+schoolNumber).append('<p style="margin-bottom:0rem"><span class="fa-stack fa-lg"><i class="fa fa-home" style="font-size: 20px"></i></span><addr id="nailSchoolAddr_'+schoolNumber+'" data-toggle="tooltip" data-placement="right" title="'+addr+'">'+thisShowAddr+'</addr></p>');
		//電話
		$('#nailBottomContent-card_'+schoolNumber).append('<p style="margin-bottom:0rem"><span class="fa-stack fa-lg"><i class="fa fa-phone " style="font-size: 20px; padding-left: 2px"></i></span><phone>'+phone+'</phone></p>');
		//連接
		$('#nailBottomContent-card_'+schoolNumber).append('<p style="margin-bottom:0rem"><span class="fa-stack fa-lg"><i class="fa fa-internet-explorer" style="font-size: 20px"></i></span><a href="'+url+'" target="_blank">官方網站</a></p>');

		//分隔線
		$('#nailBottomContent_'+schoolNumber).append('<div class="dropdown-divider"></div>');
		//取消釘選
		$('#nailBottomContent_'+schoolNumber).append('<button type="button" class="btn btn-danger btn-sm btn-block" onclick="nailSchoolRemove('+schoolNumber+')">取消釘選</button>');
		//進入學校
		$('#nailBottomContent_'+schoolNumber).append('<button type="button" class="btn btn-primary btn-sm btn-block"  onclick="$(\'#map\').show(100);$(\'#schoolWindow\').hide(100);openSchoolWindow('+id+',\''+name+'\',\''+addr+'\',\''+phone+'\',\''+url+'\',\''+schoolNumber+'\',\''+schoolClass+'\')">進入學校</button>');

		$('#nailSchoolAddr_'+schoolNumber).tooltip('enable');


		//手機版展開按鈕
		$('#nailSmallSchool_'+schoolNumber).append('<button class="card-btn-top card-btn-open btn-block" style="border-color: #d0e9c6;background-color: #edf9ee;height: 43px;" data-toggle="collapse" data-target="#collapse'+schoolNumber+'" aria-expanded="true" aria-controls="collapse'+schoolNumber+'"><div class="row"><div class="text-center">'+name+'</div></div></button>');
		//展開內容框架
		$('#nailSmallSchool_'+schoolNumber).append('<div id="collapse'+schoolNumber+'" class="collapse" aria-labelledby="heading'+schoolNumber+'" data-parent="#accordion" style="padding-top: 8px"></div>');
		//卡片框架
		$('#collapse'+schoolNumber).append('<div class="card-body text-center" id="smallCard'+schoolNumber+'"></div>');
		//圖片
		$('#smallCard'+schoolNumber).append('<img src="'+photo+'" height="135" >');

		//資訊群組
		$('#smallCard'+schoolNumber).append('<div class="col col-sm-12 text-center" id="smailInfo'+schoolNumber+'" style="padding:0"></div>');
		//地址
		$('#smailInfo'+schoolNumber).append('<p style="margin-bottom:0rem;margin-top:5px;text-align: left;"><span class="fa-stack fa-lg" style="line-height: 0;height: 0; width: 1em;vertical-align: -15%;"><i class="fa fa-home" style="font-size: 10px"></i></span><addr style="font-size: 12px;">'+addr+'</addr></p>');
		//電話及網址
		$('#smailInfo'+schoolNumber).append('<p style="margin-bottom:0rem;margin-top:0px;text-align: left;"><span class="fa-stack fa-lg" style="line-height: 0;height: 0; width: 1em;vertical-align: -15%;"><i class="fa fa-phone" style="font-size: 10px"></i></span><addr style="font-size: 13px">'+phone+'</addr><span class="fa-stack fa-lg" style="margin-left: 10px; line-height: 0;height: 0; width: 1em;vertical-align: -15%;"><i class="fa fa-phone" style="font-size: 10px"></i></span><addr style="font-size: 13px"><a href="'+url+'" target="_blank">官方網站</a></addr></p>');

		//按鈕群組
		$('#smallCard'+schoolNumber).append('<div class="col col-sm-12 text-center" style="padding-right: 0;padding-left: 0;padding-top: 5px"><button type="button" class="btn btn-danger btn-sm btn-block" onclick="nailSchoolRemove('+schoolNumber+')">取消釘選</button><button type="button" class="btn btn-primary btn-sm btn-block"  onclick="$(\'#map\').show(100);$(\'#schoolWindow\').hide(100);openSchoolWindow('+id+',\''+name+'\',\''+addr+'\',\''+phone+'\',\''+url+'\',\''+schoolNumber+'\',\''+schoolClass+'\')" >進入學校</button></div>');

		nailNumber++;
		return true;

	}

	function delCol(){
		//console.log('on');
		setTimeout("$('.dropdown-backdrop').remove()", 10 );
	}

	function nailSchoolRemove(thisNum){
		$('#nailSchool_'+thisNum).remove();
		$('#nailSmallSchool_'+thisNum).remove();
		nailThisSchool[nailThisSchool.indexOf(thisNum)] = "";

		var newArray = []
		for (i = 0, len = nailThisSchool.length ; i < len ; i++){
		    newArray[i] = nailThisSchool[i];
		}
		nailThisSchool = [0];
		var thisIndex=1;
		for (i = 0, len = newArray.length ; i < len ; i++){
			if(newArray[i] != ""){
				nailThisSchool[thisIndex] = newArray[i];
				thisIndex++;
			}
		}

		nailNumber = nailThisSchool.length;

		var hrefUrl = "";
		for(i=1;i<=(nailThisSchool.length-1);i++){
			hrefUrl += nailThisSchool[i];
			hrefUrl += i==(nailThisSchool.length-1)?"":",";
		}
		$("#comparingSchoolButton").attr("href","<?php echo base_url('comparing') ?>?school=\""+thisNailSchoolType+"\"&id=\""+hrefUrl+"\"");

		if(nailNumber<=2){
			$('#comparingSchoolDiv').hide();
		}
	}
</script>
<!-- JS  -->
