<div class="modal fade" id="editGroupModal" tabindex="-1" role="dialog" aria-labelledby="editGroupModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">編輯團隊</h4>
      </div>
      <div class="modal-body">
        <form id="editGroup">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-3 col-form-label">團隊名稱</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="groupName" id="editGroupName" placeholder="團隊名稱">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">隊長設定</label>
            <div class="col-sm-9">
              <select id="selectMember" class="form-control">

              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="editGroupSubmit" onclick="editGroupNameSunmit()">提交</button>
      </div>
    </div>
  </div>
</div>

<script>
  $("#editGroup").submit(function(e){
    e.preventDefault();
    $('#editGroupSubmit').click();
  });

  $('#editGroupModal').on('show.bs.modal', function (e) {
    $.ajax({
      url: '<?php  echo base_url('profile/editGroupInfo') ?>',
      type: 'POST',
      dataType: 'json',
      data: {groupId: thisSelect},
    })
    .done(function(data) {
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
      $('#editGroupName').val(json['name']);
      $('#selectMember').html('');
      for(var i = 0 ; i<json['member'].length ; i++){
        $('#selectMember').append('<option value="'+json['member'][i]['key']+'">'+json['member'][i]['name']+'</option>');
      }
    })
    .fail(function() {
      swal("錯誤", "連線失敗，請重新送出", "error");
    });
  })

  function editGroupNameSunmit(){
    if($('#editGroupName').val()=="" || $('#editGroupName').val().length<3 || $('#editGroupName').val().length>20){
      swal('注意','團隊名稱不可為空，且必須大於三字，小於二十字。','error');
    }else{
      var memberId = "";
      $("option:selected", $('#selectMember')).each(function(){
        memberId=this.value;
      });
      swal({
        title: "確定要變更",
        text: "這將可能影響到你的權限或是團隊名稱。",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willEdit) => {
        if (willEdit) {
           $.ajax({
              url: '<?php  echo base_url('profile/editGroup') ?>',
              dataType: 'text',
              type:'post',
              data: {groupId: thisSelect,
                     groupName : $('#editGroupName').val(),
                     memberId: memberId},
              error:function(){
                  swal("錯誤", "連線失敗，請重新送出", "error");
              },
              success: function(data){
                if(data == 0){
                  swal("錯誤", "系統中已有相同的團隊名稱", "error");
                }else if (data == 1){
                  swal("成功", "已更新您的團隊資料", "success").then((value) => {
                    $('#editGroupModal').modal('hide');
                    getSelect();
                    getMemberInfo();
                  });
                }else if (data == 2){
                  swal("注意", "欄位不可為空，且必須大於三字，小於二十字", "error");
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
                    if(dismiss==='esc'){
                      document.location.href='<?php echo base_url('home/logout'); ?>';
                    }else if(dismiss==='overlay'){
                      document.location.href='<?php echo base_url('home/logout'); ?>';
                    }
                  });
                }
              }
          }); 
        }
      });
    }
  }
</script>