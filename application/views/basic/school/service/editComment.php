<div class="modal fade" id="editCommentModal" tabindex="-1" role="dialog" aria-labelledby="editComment">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">編輯留言</h4>
      </div>
      <div class="modal-body">
        <form id="editCommentGroup">
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-3 col-form-label">留言內容</label>
            <div class="col-sm-9">
              <textarea class="form-control" rows="5" id="editCommentInput" placeholder="輸入留言內容"> </textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer" id="commentEditDiv">
        <button type="button" data-key="" data-num="" class="btn btn-primary" id="editCommentSubmit" onclick="editCommentSubmit('',this)">提交</button>
      </div>
    </div>
  </div>
</div>

<script>
  $("#editCommentGroup").submit(function(e){
    e.preventDefault();
    $('#editCommentSubmit').click();
  });
  function editCommentSubmit(key,object){
    var sfKey = $(object).data("key");
    var num = $(object).data("num");
    if($('#editCommentInput').val()==""){
      swal("注意", "留言內容不可為空", "error");
    }else{
     $.ajax({
        url: '<?php  echo base_url('service/editComment') ?>',
        dataType: 'text',
        type:'post',
        data: {text : $('#editCommentInput').val(),
               comentKey: key},
        error:function(){
            swal("錯誤", "連線失敗，請重新送出", "error");
        },
        success: function(data){
          if(data == 0){
            swal("注意", "留言內容不可為空", "error");
          }else if (data == 1){
            swal("成功", "修改成功", "success");
            $('#editCommentModal').modal('hide');
            getContentAllComment(sfKey,num); 
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