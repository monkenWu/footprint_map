<div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="editServiceModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">編輯足跡</h4>
      </div>
      <div class="modal-body ">
        <form>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">服務名稱</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="editName" placeholder="輸入這個服務或活動的名稱">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">服務開始時間</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input type="text" class="form-control" id="editStarDate">
                <span class="input-group-addon">
                  <span class="fa fa-calendar"></span>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">服務結束時間</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input type="text" class="form-control" id="editOverDate">
                <span class="input-group-addon">
                  <span class="fa fa-calendar"></span>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">服務內容</label>
            <div class="col-sm-9">
              <textarea class="form-control" id="editAddContent" rows="5" placeholder="簡述服務內容或宗旨"></textarea>
            </div>
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="delServiceSubmit()">刪除足跡</button>
        <button type="button" class="btn btn-primary" onclick="editServiceSubmit()">提交</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#editServiceModal').on('hidden.bs.modal', function (e) {
    $('#editName').val('');
    $('#editStarDate').val('');
    $('#editOverDate').val('');
    $('#editAddContent').val('');
  })

  $('#editStarDate').datetimepicker({
    format:"YYYY/MM/DD",
    locale:"zh-tw",
    ignoreReadonly: true,
    allowInputToggle: true,
    widgetPositioning: {
      horizontal: 'left',
      vertical: 'bottom'
      }
  });
  $('#editOverDate').datetimepicker({
    format:"YYYY/MM/DD",
    locale:"zh-tw",
    ignoreReadonly: true,
    allowInputToggle: true,
    widgetPositioning: {
      horizontal: 'left',
      vertical: 'bottom'
      }
  });


  function editServiceSubmit(){
    if($('#editName').val()=="" || $('#editStarDate').val()=="" || $('#editOverDate').val()=="" || $('#editAddContent').val()=="" ){
      swal("注意", "欄位不可為空", "error");
    }else if($('#editName').val().length <= 3 || $('#editName').val().length > 20){
      swal("注意", "服務名稱長度必須大於三或小於二十", "error");
    }else if(Date.parse($('#editStarDate').val()) > Date.parse($('#editOverDate').val())){
      swal("注意", "開始時間不可大於結束時間", "error");
    }else{
      swal({
        title: "提交",
        text: "確定要送出內容嗎？這將會直接覆蓋原有的資料。",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '<?php  echo base_url('service/editService') ?>',
            dataType: 'text',
            type:'post',
            data: {name : $('#editName').val(),
                   starDate : $('#editStarDate').val(),
                   overDate : $('#editOverDate').val(),
                   content : $('#editAddContent').val(),
                   sfKey:thisActivityEditKey},
            error:function(){
                swal("錯誤", "連線失敗，請重新送出", "error");
            },
            success: function(data){
              if(data == 0){
                  swal("錯誤", "已有相同的服務名稱", "error");
              }else if (data == 1){
                  swal("成功", "已變更足跡內容，服務完成後記得來評分喔！", "success").catch(swal.noop).then((value) => {
                    $('#editServiceModal').modal('hide');
                    getService(thisEditSchoolId);
                  },function(dismiss){
                    if(dismiss==='esc'){
                      $('#editServiceModal').modal('hide');
                      getService(thisEditSchoolId);
                    }else if(dismiss==='overlay'){
                      $('#editServiceModal').modal('hide');
                      getService(thisEditSchoolId);
                    }
                  });
              }else if (data == 2){
                  swal("數值不符", "請重新再試", "error");
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
  
  thisActivityEditKey = "";
  function thisActivityEdit(str){
    thisActivityEditKey = str;
    $.ajax({
        url: '<?php  echo base_url('service/getOneEditInfo') ?>',
        dataType: 'json',
        type:'post',
        data: {SFKey : thisActivityEditKey},
        error:function(){
           swal("錯誤", "連線失敗，請重新送出", "error");
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
          $('#editName').val(json['name']);
          $('#editStarDate').val(json['starDate']);
          $('#editOverDate').val(json['endDate']);
          $('#editAddContent').val(json['subject']);
        }
    });
  }
    
  function delServiceSubmit() {
    swal({
      title: "刪除",
      text: "確定要刪除這個足跡嗎？這個動作無法回覆！",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
      $.ajax({
          url: '<?php  echo base_url('service/delOneService') ?>',
          dataType: 'text',
          type:'post',
          data: {SFKey : thisActivityEditKey},
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
              swal("成功", "刪除成功", "success").catch(swal.noop).then((value) => {
                $('#editServiceModal').modal('hide');
                getService(thisEditSchoolId);
              },function(dismiss){
                if(dismiss==='esc'){
                  $('#editServiceModal').modal('hide');
                  getService(thisEditSchoolId);
                }else if(dismiss==='overlay'){
                  $('#editServiceModal').modal('hide');
                  getService(thisEditSchoolId);
                }
              });
            }
           }
        });
      }
    });
  }

</script>