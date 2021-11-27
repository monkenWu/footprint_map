<div role="tabpanel" class="tab-pane" id="tabs-2-tab-4">
	<section class="box-typical profile-settings">
		<section class="box-typical-section">
			<div class="form-group row">
				<div class="col-xl-2">
					<label class="form-label">暱稱</label>
				</div>
				<div class="col-xl-4">
					<input class="form-control" type="text" id="editMemberName" placeholder="名稱"/>
				</div>
			</div>
		</section>
		<section class="box-typical-section">
			<header class="box-typical-header-sm">補充資料</header>
			<div class="form-group row">
				<div class="col-xl-2">
					<label class="form-label">
						<i class="font-icon font-icon-case-3"></i>
						職業
					</label>
				</div>
				<div class="col-xl-4">
					<input class="form-control" type="text" id="editMemberJob" placeholder="你目前從事的職業"/>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xl-2">
					<label class="form-label">
						<i class="font-icon font-icon-learn"></i>
						學校/公司/單位
					</label>
				</div>
				<div class="col-xl-4">
					<input class="form-control" type="text" id="editMemberSchool" placeholder="學校或公司名稱" />
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xl-2">
					<label class="form-label">
						<i class="font-icon font-icon-earth"></i>
						個人主頁
					</label>
				</div>
				<div class="col-xl-8">
					<input class="form-control" type="url" id="editMemberPage" placeholder="個人網頁" />
				</div>
			</div>
		</section>
		<section class="box-typical-section profile-settings-btns">
			<button type="submit" class="btn btn-rounded" onclick="settingSubmit()">送出修改</button>
		</section>
	</section>
</div><!--.tab-pane-->

<script>
	
	function getSettingInfo(){
		$.ajax({
          url: '<?php  echo base_url('profile/getSettingInfo') ?>',
          dataType: 'json',
          type:'post',
          data: {token : '<?php echo $token ?>'},
          error:function(){
             swal("錯誤", "無法取得設定內容", "error");
          },
          success: function(data){
          	var json = data;
          	try{
          		if(json[0]==444){
          			swal({
	                title: '錯誤',
	                text: '本次連線驗證失敗，你沒有操作的權限。',
	                type: 'error',
	                showCancelButton: false,
	                confirmButtonColor: '#3085d6',
	                confirmButtonText: '確定',
	              }).catch(swal.noop).then(function () {
	                document.location.href='<?php echo base_url('home/logout'); ?>';
	              },function(dismiss){
	                if(dismiss==='esc'){
	                  document.location.href='<?php echo base_url('home/logout'); ?>';
	                }else if(dismiss==='overlay'){
	                  document.location.href='<?php echo base_url('home/logout'); ?>';
	                }
	              });
          		}
          	}catch(err){}

          	$('#editMemberName').val(data['name']);
          	$('#editMemberJob').val(data['job']);
          	$('#editMemberSchool').val(data['school']);
          	$('#editMemberPage').val(data['page']);
          }
      });
	}

	//比對姓名
	function checkName(str) {
		var regExp = /^[\w\s\u4e00-\u9fa5]{2,10}$/;
		if(regExp.test(str)){
			return true;
		}else{
			return false;
		}
	}
	//比對網址
	function checkUrl(str) {
		var regExp = /(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?/;
		if(regExp.test(str)){
			return true;
		}else{
			return false;
		}
	}

	function settingSubmit(){
		if(!checkName($('#editMemberName').val())){
			swal('注意','暱稱必須介於2到10個字符之間。不允許特殊字符。','error');
		}else if(!checkUrl($('#editMemberPage').val())){
			swal('注意','請輸入正確的網址','error');
		}else if($('#editMemberJob').val() == ""){
			swal('注意','職稱不可為空','error');
		}else if($('#editMemberSchool').val() == ""){
			swal('注意','單位名稱不可為空','error');
		}else{
			$.ajax({
				url: '<?php  echo base_url('profile/editMemberInfo') ?>',
				dataType: 'text',
				type:'post',
				data: {name : $('#editMemberName').val(),
					   job :　$('#editMemberJob').val(),
					   school : $('#editMemberSchool').val(),
					   page : $('#editMemberPage').val(),
				       token: '<?php echo $token ?>'},
				error:function(){
					swal("錯誤", "連線失敗，無法送出個人資訊", "error");
				},
				success: function(data){
					if(data == 0){
						swal("錯誤", "格式錯誤，請確認後再送出", "error");
					}else if (data == 1){
						swal("成功", "已更改您的個人資訊", "success");
						getSettingInfo();
						getMemberInfo();
					}else if (data == 444){
						swal({
							title: '錯誤',
							text: '本次連線驗證失敗，你沒有操作的權限。',
							type: 'error',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							confirmButtonText: '確定',
						}).catch(swal.noop).then(function () {
							document.location.href='<?php echo base_url('home/logout'); ?>';
						},function(dismiss){
							document.location.href='<?php echo base_url('home/logout'); ?>';
						});
					}
				}
			});
		}
	}


</script>