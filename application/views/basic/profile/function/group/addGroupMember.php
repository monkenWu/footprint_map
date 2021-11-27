<div class="modal fade" id="addGroupMemberModal" tabindex="-1" role="dialog" aria-labelledby="addGroupMemberModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">新增團員</h4>
      </div>
      <div class="modal-body">
        <form id="addGroupMember">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-3 col-form-label">團員帳號</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="member_id" placeholder="團員帳號">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addGroupMemberSubmit" onclick="addMemberGroupSunmit()">提交</button>
      </div>
    </div>
  </div>
</div>

<script>
  $("#addGroupMember").submit(function(e){
    e.preventDefault();
    $('#addGroupMemberSubmit').click();
  });
  
  function addMemberGroupSunmit(){
    if($('#member_id').val()==""){
      swal("注意", "團員帳號不可為空", "error");
    }else{
     $.ajax({
        url: '<?php  echo base_url('profile/addGroupMember') ?>',
        dataType: 'text',
        type:'post',
        data: {account : $('#member_id').val(),
               id : thisSelect},
        error:function(){
            swal("錯誤", "連線失敗，請重新送出3", "error");
        },
        success: function(data){
            if(data == 0){
                swal("錯誤", "找不到這個會員", "error");
            }else if (data == 1){
                swal("成功", "現在會員以在你的團隊中了", "success").then((value) => {
                  $('#addGroupMemberModal').modal('hide');
                  getSelect();
                });
            }else if (data == 2){
                swal("錯誤", "會員已存在於團隊中", "error");
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
    $('#member_id').val('');
  }


</script>