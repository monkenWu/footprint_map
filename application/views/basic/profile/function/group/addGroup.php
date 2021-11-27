<div class="modal fade" id="addGroupModal" tabindex="-1" role="dialog" aria-labelledby="addGroupModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">新增團隊</h4>
      </div>
      <div class="modal-body">
        <form id="addGroup">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-3 col-form-label">團隊名稱</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="groupName" id="groupName" placeholder="團隊名稱">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addGroupSubmit" onclick="addGroupSunmit()">提交</button>
      </div>
    </div>
  </div>
</div>

<script>
  $("#addGroup").submit(function(e){
    e.preventDefault();
    $('#addGroupSubmit').click();
  });
  function addGroupSunmit(){
    if($('#groupName').val()=="" || $('#groupName').val().length<=3 || $('#groupName').val().length>20){
      swal("注意", "團隊名稱不可為空，且必須大於三字，小於二十字", "error");
    }else{
     $.ajax({
        url: '<?php  echo base_url('profile/addGroup') ?>',
        dataType: 'text',
        type:'post',
        data: {groupName : $('#groupName').val(),
               token: '<?php echo $token ?>'},
        error:function(){
            swal("錯誤", "連線失敗，請重新送出", "error");
        },
        success: function(data){
          if(data == 0){
            swal("錯誤", "系統中已有相同的團隊名稱", "error");
          }else if (data == 1){
            swal("成功", "現在可以編輯團隊了！", "success").then((value) => {
              $('#addGroupModal').modal('hide');
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
  }


</script>