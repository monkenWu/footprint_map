<div class="col-xl-3 col-lg-4">
	<aside class="profile-side">
		<section class="box-typical profile-side-user">
			<photo class="avatar-preview avatar-preview-128" id="memberPhoto">
				<img src="" alt=""/>
			</photo>
			<?php
				if($member == 0){
					//<button type="button" class="btn btn-rounded">私訊</button>
			?>
					
			<?php
				}else{
			?>
					<button type="button" class="btn btn-rounded"  data-toggle="modal" data-target="#imgUploadModal">上傳圖片</button>
			<?php
				}
			?>
			<div class="text-center" style="padding-top: 10px" id="memberProfileName"><h5>吳孟賢</h5></div>
		</section>

		<section class="box-typical profile-side-stat">
			<div class="tbl">
				<div class="tbl-row">
					<div class="tbl-cell">
						<span class="number" id="footprintNumber">59</span>
						次足跡
					</div>
					<div class="tbl-cell">
						<span class="number" id="commentNumber">12</span>
						次評論
					</div>
				</div>
			</div>
		</section>

		<section class="box-typical">
			<header class="box-typical-header-sm bordered">
				<p class="line-with-icon" style="margin:0">
					<i class="font-icon font-icon-users-two"></i>
					參與團體
				</p>
			</header>
			<div class="box-typical-inner" id="profileGroup">
				
			</div>
		</section>

		<section class="box-typical">
			<header class="box-typical-header-sm bordered">
				<p class="line-with-icon" style="margin:0">
					<i class="font-icon font-icon-pin-2"></i>
					參與服務
				</p>
			</header>
			<div class="box-typical-inner" id="profileActivity">
				
			</div>
		</section>

		<section class="box-typical">
			<header class="box-typical-header-sm bordered">個人資訊</header>
			<div class="box-typical-inner">
				<p class="line-with-icon" id="profileJob">
					<i class="font-icon font-icon-case-3"></i>
					
				</p>
				<p class="line-with-icon" id="profileSchool">
					<i class="font-icon font-icon-learn"></i>
					
				</p>
				<p class="line-with-icon" id="profileUrl">
					<i class="font-icon font-icon-earth"></i>
					
				</p>
			</div>
		</section>
	</aside><!--.profile-side-->
</div>
<script>
	getMemberInfo();
	getMemberImg();
	function getMemberInfo(){
		$.ajax({
			url: '<?php echo base_url('profile/getMemberInformation') ?>',
			type: 'POST',
			dataType: 'json',
			data: {memberId: '<?php echo $id ?>'},
		})
		.done(function(json) {
			//console.log(json);
			$('#profileGroup').html('');
			$('#profileActivity').html('');
			$('#profileJob').html('<i class="font-icon font-icon-case-3"></i>');
			$('#profileSchool').html('<i class="font-icon font-icon-learn"></i>');
			$('#profileUrl').html('<i class="font-icon font-icon-earth"></i>');

			if(json['group'].length == 0){
				$('#profileGroup').append('尚未加入團體');
			}else{
				for(i=0;i<json['group'].length;i++){
					$('#profileGroup').append(json['group'][i]);
					if((i+1)!=json['group'].length){
						$('#profileGroup').append("<br>");
					}
				}
			}

			if(json['service'].length == 0){
				$('#profileActivity').append('尚未有服務紀錄');
			}else{
				for(i=0;i<json['service'].length;i++){
					$('#profileActivity').append(json['service'][i]);
					if((i+1)!=json['service'].length){
						$('#profileActivity').append("<br>");
					}
				}
			}
			
			$('#memberProfileName').html('<h5>'+json['profile']['name']+'</h5>');
			$('#profileJob').append(json['profile']['job'] != null ? json['profile']['job'] : '尚未提供');
			$('#profileSchool').append(json['profile']['school'] != null ? json['profile']['school'] : '尚未提供');
			$('#profileUrl').append(json['profile']['web'] != null ? '<a href="'+json['profile']['web']+'" target="_blank">個人網站</a>' : '尚未提供');

			$('#footprintNumber').html('<h5>'+json['count']['footprint']+'</h5>');

			$('#commentNumber').html('<h5>'+json['count']['comment']+'</h5>');

			
		})
		.fail(function() {
			swal('錯誤','無法取得個人資料訊息，請稍後再試','error');
		});
	}

	function getMemberImg(){
		$.ajax({
			url: '<?php echo base_url('profile/getMemberImg') ?>',
			type: 'POST',
			dataType: 'json',
			data: {memberId: '<?php echo $id ?>'},
		})
		.done(function(json) {
			//console.log(json);
			$('#memberPhoto').html('');
			$('#memberPhoto').append('<img src="<?php echo base_url('dist/img/user/') ?>'+json['pictureName']+'" alt=""/>');
			
			
		})
		.fail(function() {
			swal('錯誤','無法取得個人圖片，請稍後再試','error');
		});
	}
</script>