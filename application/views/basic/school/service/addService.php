<div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addserviceModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">留下足跡</h4>
      </div>
      <div class="modal-body ">
        <form>
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-3 col-form-label">服務團隊</label>
            <div class="col-sm-9">
              <select class="form-control" id="selectGroup">

              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">服務名稱</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="addName" placeholder="輸入這個服務或活動的名稱">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">服務開始時間</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input type="text" class="form-control" id="starDate">
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
                <input type="text" class="form-control" id="overDate">
                <span class="input-group-addon">
                  <span class="fa fa-calendar"></span>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">服務內容</label>
            <div class="col-sm-9">
              <textarea class="form-control" id="addContent" rows="5" placeholder="簡述服務內容或宗旨"></textarea>
            </div>
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="addServiceSunmit()">提交</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#addServiceModal').on('hidden.bs.modal', function (e) {
    $('#addName').val('');
    $('#starDate').val('');
    $('#overDate').val('');
    $('#addContent').val('');
  })

  $('#starDate').datetimepicker({
    format:"YYYY/MM/DD",
    locale:"zh-tw",
    ignoreReadonly: true,
    allowInputToggle: true,
    widgetPositioning: {
      horizontal: 'left',
      vertical: 'bottom'
      }
  });
  $('#overDate').datetimepicker({
    format:"YYYY/MM/DD",
    locale:"zh-tw",
    ignoreReadonly: true,
    allowInputToggle: true,
    widgetPositioning: {
      horizontal: 'left',
      vertical: 'bottom'
      }
  });

  function addServiceSunmit(){
    if($('#addName').val()=="" || $('#starDate').val()=="" || $('#overDate').val()=="" || $('#addContent').val()=="" ){
      swal("注意", "欄位不可為空", "error");
    }else if($('#addName').val().length < 3 || $('#addName').val().length > 20){
      swal("注意", "服務名稱長度必須大於三或小於二十", "error");
    }else if(Date.parse($('#starDate').val()) > Date.parse($('#overDate').val())){
      swal("注意", "開始時間不可大於結束時間", "error");
    }else{
     $.ajax({
          url: '<?php  echo base_url('service/addService') ?>',
          dataType: 'text',
          type:'post',
          data: {name : $('#addName').val(),
                 starDate : $('#starDate').val(),
                 overDate : $('#overDate').val(),
                 content : $('#addContent').val(),
                 school:thisEditSchoolClass,
                 schoolNumber:thisEditSchoolId,
                 groupId : thisAddSelect},
          error:function(){
              swal("錯誤", "連線失敗，請重新送出", "error");
          },
          success: function(data){
              if(data == 0){
                  swal("錯誤", "已有相同的服務名稱", "error");
              }else if (data == 1){
                  swal("成功", "已留下足跡，服務完成後記得來評分喔！", "success").catch(swal.noop).then((value) => {
                    $('#addServiceModal').modal('hide');
                    getService(thisEditSchoolId);
                  },function(dismiss){
                    if(dismiss==='esc'){
                      $('#addServiceModal').modal('hide');
                      getService(thisEditSchoolId);
                    }else if(dismiss==='overlay'){
                      $('#addServiceModal').modal('hide');
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
  }

  thisAddSelect = '';
  function getSelect(){
    $.ajax({
        url: '<?php  echo base_url('service/getGroupSelect') ?>',
        dataType: 'json',
        error:function(){
           swal("錯誤", "連線失敗，請重新送出", "error");
        },
        success: function(data){
          var json = data;
          $('#selectGroup').html('');
          if(json.length == 0){
            $('#selectGroup').append('<option value="-1">您不是任何一個服務隊的隊長</option>');
            swal("注意", "您不是任何一個服務隊的隊長\r\n您可以進入「個人資訊」頁面創建團隊", "info").then((value) => {
              $('#addServiceModal').modal('hide');
            });
          }else{
            for(var i = 0 ; i<json.length ; i++){
              $('#selectGroup').append('<option value="'+json[i]['key']+'">'+json[i]['name']+'</option>');
            }
            thisAddSelect = json[0]['key'];
          }
        }
    });
  }
  



</script>