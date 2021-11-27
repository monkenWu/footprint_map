<div class="modal fade" id="overServiceModal" tabindex="-1" role="dialog" aria-labelledby="overserviceModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">服務結案</h4>
      </div>
      <div class="modal-body ">
        <form>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">服務心得</label>
            <div class="col-sm-9">
              <textarea class="form-control" id="content" rows="6"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">志工人數</label>
            <div class="col-sm-9">
              <input type="number" class="form-control" id="volunteerNum" placeholder="實際進行服務志工數">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">受服務者人數</label>
            <div class="col-sm-9">
              <input type="number" class="form-control" id="studentNum" placeholder="實際進行服務志工數">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">學校配合度</label>
            <div class="col-sm-9">
              <input id="schoolCooperateOver" class="ratin overStar" data-size="xs">
              <input type="text" class="form-control" id="schoolCooperateText" placeholder="給分原因，可留空">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">學生配合度</label>
            <div class="col-sm-9">
              <input id="studentCooperateOver" class="ratin overStar" data-size="xs">
              <input type="text" class="form-control" id="studentCooperateText" placeholder="給分原因，可留空">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">交通方便性</label>
            <div class="col-sm-9">
              <input id="trafficOver" class="ratin overStar" data-size="xs">
              <input type="text" class="form-control" id="trafficText" placeholder="給分原因，可留空">
            </div>
          </div>
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">周邊機能性</label>
            <div class="col-sm-9">
              <input id="aroundOver" class="ratin overStar" data-size="xs">
              <input type="text" class="form-control" id="aroundText" placeholder="給分原因，可留空">
            </div>
          </div>

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="overServiceSunmit()">提交</button>
      </div>
    </div>
  </div>
</div>

<script>
  thisOverFootprint = "";
  function thisActivityOver(key){
    thisOverFootprint = key;
  }

  $('.overStar').rating({
    displayOnly: false,
    step: 0.5,
    starCaptions: {
      0.5: '0.5星',
      1: '1星',
      1.5: '1.5星',
      2: '2星',
      2.5: '2.5星',
      3: '3星',
      3.5: '3.5星',
      4: '4星',
      4.5: '4.5星',
      5: '5星'
    },
    clearButtonTitle: '清除',
    clearCaption: '尚未評分'
  });
  $('#input-3').rating({});

  function overServiceSunmit(){
    if($('#schoolCooperateOver').val() != "" && $('#studentCooperateOver').val()!= "" && $('#trafficOver').val()!= "" && $('#aroundOver').val() != "" && $('#content').val()!= "" && $('#volunteerNum').val()!= "" && $('#studentNum').val()!= ""){
      if(isNaN($('#volunteerNum').val()) || $('#volunteerNum').val() < 1 ){
        swal("錯誤", "志工人數必須為數字，且必須大於0", "error");
      }else if(isNaN($('#studentNum').val()) || $('#studentNum').val() < 1 ){
        swal("錯誤", "受服務者人數必須為數字，且必須大於0", "error");
      }else{
        swal({
          title: "確定結案",
          text: "結案後的足跡活動，將無法再進行更改",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willEdit) => {
          if(willEdit){
            var reason = [];
            reason[0] = $('#schoolCooperateText').val();
            reason[1] = $('#studentCooperateText').val();
            reason[2] = $('#trafficText').val();
            reason[3] = $('#aroundText').val();
            $.ajax({
              url: '<?php  echo base_url('Service/overOneService') ?>',
              dataType: 'text',
              type:'post',
              data: {schoolCooperate : $('#schoolCooperateOver').val(),
                     studentCooperate: $('#studentCooperateOver').val(),
                     traffic         : $('#trafficOver').val(),
                     around          : $('#aroundOver').val(),
                     reason          : reason,
                     content         : $('#content').val(),
                     volunteer       : $('#volunteerNum').val(),
                     student         : $('#studentNum').val(),
                     sfkey : thisOverFootprint
                    },
              error:function(){
                  swal("錯誤", "連線失敗，請重新送出", "error");
              },
              success: function(data){
                if(data == 0){
                    swal("錯誤", "資料格式有誤", "error");
                }else if (data == 1){
                  swal("成功", "你的活動已順利結案", "success").then((value) => {
                    $('#overServiceModal').modal('hide');
                    getService(thisEditSchoolId);
                  });
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
    }else{
      swal("錯誤", "請完成所有必填內容", "error");
    }
  }




</script>