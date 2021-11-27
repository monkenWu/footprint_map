<div role="tabpanel" class="tab-pane" id="tabs-2-tab-2">
	<section class="box-typical box-typical-padding" id="thisGroup">

		<div class="text-right form-group">
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addGroupModal">新增團隊</button>
		</div>

		<div class="form-group row">
			<label for="staticEmail" class="col-sm-2 col-form-label">選擇你所在的團隊</label>
			<div class="col-sm-10">
		      	<select id="selectGroup" class="form-control">
					
				</select>
			</div>
		</div>

		<table class="table table-striped" id="allGroupTable">
		  <thead>
		    <tr>
		      <th scope="col" style="width: 20%">*</th>
		      <th scope="col" style="width: 40%">會員名稱</th>
		      <th scope="col" style="width: 40%">會員信箱</th>
		    </tr>
		  </thead>
		  <tbody id="contentGroupTable">
		    
		  </tbody>
		</table>

		<div class="text-right form-group" id="addMemberButton">
			
		</div>

	</section>
</div><!--.參與團體-->
<script>

	thisSelect = "-2";
	function getSelect(){
		$.ajax({
          url: '<?php  echo base_url('profile/getGroupSelect') ?>',
          dataType: 'json',
          error:function(){
             swal("錯誤", "連線失敗，請重新送出１", "error");
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
          	
            $('#selectGroup').html('');
            if(json.length == 0){
            	$('#selectGroup').append('<option value="-1">立刻新增新的團隊，或請求他人加入團隊！</option>');
            	thisSelect = "-1";
            	$('#allGroupTable').hide();
            	$('#addMemberButton').hide();
            }else{
            	for(var i = 0 ; i<json.length ; i++){
	            	$('#selectGroup').append('<option value="'+json[i]['key']+'">'+json[i]['name']+'</option>');
	            }
	            thisSelect = json[0]['key'];
	            $('#allGroupTable').show();
	            $('#addMemberButton').show();
	            getGroupTable(json[0]['key']);
            }
          }
      });
	}
	getSelect();

	$("#selectGroup").change(function(event) {
	    $("option:selected", this).each(function(){
	    	console.log(parseInt(this.value));
	    	if(this.value == "-1"){
	    		thisSelect = this.value;
	    		$('#allGroupTable').hide();
            	$('#addMemberButton').hide();
	   		}else{
	    		thisSelect = this.value;
	    		getGroupTable(this.value);
	    	} 
	    });
  	});

  	function getGroupTable(key){
  		$.ajax({
          url: '<?php  echo base_url('profile/getGroupTable') ?>',
          dataType: 'json',
          type:'post',
          data: {groupId : key},
          error:function(){
             swal("錯誤", "連線失敗，請重新送出２", "error");
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
          	$('#contentGroupTable').html('');
          	for(var i = 0 ; i<(json.length)-1 ; i++){
          		$('#contentGroupTable').append('<tr><th scope="row">'+json[i]['button']+'</th><td>'+json[i]['name']+'</td><td>'+json[i]['email']+'</td></tr>');
            }
            $('#addMemberButton').html(json[json.length-1]['add']);
          }
      });
  	}

  	function delMember(num){
  		swal({
		  title: "刪除",
		  text: "確定要將這位會員移出您的團隊嗎？",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
			$.ajax({
		       	url: '<?php  echo base_url('profile/delMemberGroup') ?>',
		        dataType: 'text',
		        type:'post',
		        data: {delId : num,
		        	   groupId:thisSelect},
		        error:function(){
		           swal("錯誤", "連線失敗，請重新送出", "error");
		        },
		        success: function(data){
		        	if (data == 444){
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
		            }else{
		            	swal("成功", "刪除成功", "success");
		        		getGroupTable(thisSelect);
		            }
		        	
		         }
		      });
		  }
		});

  	}

/*

<tr><th scope="row">3</th><td>Larry</td><td>the Bird</td></tr>

*/


</script>
