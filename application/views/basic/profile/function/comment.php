<div role="tabpanel" class="tab-pane active" id="tabs-2-tab-1">

	<?php if($login==0){ ?>
        <div class="box-typical">
			<input type="text" class="write-something" placeholder="留下對我的留言吧！" onclick="noUserComment()"/>
			<div class="box-typical-footer">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							
						</div>
						<div class="tbl-cell tbl-cell-action">
							<button type="button" onclick="noUserComment()" class="btn btn-rounded">留言</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php }else{?>
	    <div class="box-typical">
			<input type="text" class="write-something" id="messageContent" placeholder="留下對我的留言吧！"/>
			<div class="box-typical-footer">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							
						</div>
						<div class="tbl-cell tbl-cell-action">
							<button type="button" onclick="messageSubmit('<?php echo $id ?>',$('#messageContent').val())" class="btn btn-rounded">留言</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	
	
	<article class="box-typical profile-post">
		<div class="profile-post-header">
			<div class="user-card-row">
				<div class="tbl-row">
					<div class="tbl-cell">
						<div class="user-card-row-name">訪客留言</div>
					</div>
				</div>
			</div>
		</div>
		<div id="messageContainer">
			<div class="comment-rows-container hover-action">
				<div class="comment-row-item">
					<div class="avatar-preview avatar-preview-32">
						<a href="#">
							<img src="<?php echo base_url('dist/img/user/no-user.png') ?>" alt="">
						</a>
					</div>
					<div class="tbl comment-row-item-header">
						<div class="tbl-row">
							<div class="tbl-cell tbl-cell-name">ＯＯＸＸ</div>
							<div class="tbl-cell tbl-cell-date">2018/06/06 19:00</div>
						</div>
					</div>
					<div class="comment-row-item-content">
						<p>安安安安安安安安安安安安安安安.</p>
						<button type="button" class="comment-row-item-action del">
							<i class="font-icon font-icon-trash"></i>
						</button>
					</div>
				</div><!--.comment-row-item-->
			</div><!--.comment-rows-container-->
		</div>

		<div id="messageCount">
			<div class="box-typical-footer profile-post-meta">
				<a class="meta-item">
					<i class="font-icon font-icon-comment"></i>
					尚有18則留言未展開
				</a>
			</div>
		</div>
		

	</article>

</div><!--.tab-pane-->

<script>
	getAllMessage();
	function getAllMessage(){
		var id = "<?php echo $id ?>";
		$.ajax({
			url: '<?php  echo base_url('profile/getMessage') ?>',
			dataType: 'json',
			type:'post',
			data: {id : id},
			error:function(){
				swal("錯誤", "連線失敗，請重新送出", "error");
			},
			success: function(data){
				var json = data;
				$('#messageContainer').html('');
				for(var i=0;i<json['message'].length;i++){
					createMessage(json['message'][i]);
				}
				var allCount = json['count'];
				if((allCount - json['message'].length)>0){
					$('#messageCount').html('<div class="box-typical-footer profile-post-meta"><a class="meta-item" onclick="appendMessage(\''+(json['message'].length+1)+'\')"><i class="font-icon font-icon-comment"></i>尚有'+(allCount - json['message'].length)+'則留言尚未展開</a></div>');
				}else{
					$('#messageCount').html('');
				}
			}
		});
	}

	function appendMessage(start){
		var id = "<?php echo $id ?>";
		$.ajax({
			url: '<?php  echo base_url('profile/appendMessage') ?>',
			dataType: 'json',
			type:'post',
			data: {id : id,
				   startNum : start},
			error:function(){
				swal("錯誤", "連線失敗，請重新送出", "error");
			},
			success: function(data){
				var json = data;
				for(var i=0;i<(json['message'].length);i++){
					createMessage(json['message'][i]);
				}

				var allCount = json['count'];
				if((allCount - json['message'].length)>0){
					$('#messageCount').html('<div class="box-typical-footer profile-post-meta"><a class="meta-item" onclick="appendMessage(\''+(parseInt(start)+parseInt(json['message'].length))+'\')"><i class="font-icon font-icon-comment"></i>尚有'+(allCount - json['message'].length)+'則留言尚未展開</a></div>');
				}else{
					$('#messageCount').html('');
				}
			}
		});
	}


	function createMessage(data){
		$('#messageContainer').append('<div class="comment-rows-container hover-action"><div class="comment-row-item" ><div class="avatar-preview avatar-preview-32"><a href="'+data['url']+'"><img src="<?php echo base_url('dist/img/user/') ?>'+data['photo']+'" alt=""></a></div><div class="tbl comment-row-item-header"><div class="tbl-row"><div class="tbl-cell tbl-cell-name">'+data['name']+'</div><div class="tbl-cell tbl-cell-date">'+data['date']+'</div></div></div><div class="comment-row-item-content"><p>'+data['content']+'</p>'+data['button']+'</div></div></div>');
	}

	<?php if($login==0){ ?>

		function noUserComment(){
			swal({
				title: "尚未登入",
				text: "登入後將享有系統的完整功能！要為您轉跳登入畫面嗎？",
				icon: "warning",
				buttons: true,
				dangerMode: true,
				}).then((willDelete) => {
					if (willDelete) {
						document.location.href='<?php echo base_url('login'); ?>';
					}
				}
			);
		}

	<?php }else{?>
		function messageSubmit(id,value) {
			if(value == ""){
				swal('注意','留言不可為空','error');
			}else{
				$.ajax({
					url: '<?php  echo base_url('profile/addMessage') ?>',
					dataType: 'text',
					type:'post',
					data: {id : id,
						   content: value,
						   token : '<?php echo $token ?>'},
					error:function(){
						swal("錯誤", "連線失敗，請重新送出", "error");
					},
					success: function(data){
						if(data == 0){
							swal("注意", "欄位不可為空", "error");
						}else if (data == 1){
							getAllMessage();
							$('#messageContent').val('');
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

		function messageDel(key){
			swal({
				title: "即將刪除",
				text: "刪除留言無法回復，確認要刪除嗎？",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			}).then((willDelete) => {
				if (willDelete) {
					$.ajax({
						url: '<?php  echo base_url('profile/delMessage') ?>',
						dataType: 'text',
						type:'post',
						data: {key: key},
						error:function(){
							swal("錯誤", "連線失敗，請重新送出", "error");
						},
						success: function(data){
							if(data == 0){
								swal("注意", "未知的錯誤，請稍後再試", "error");
							}else if (data == 1){
								getAllMessage();
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
			});
		}
	<?php } ?>

</script>