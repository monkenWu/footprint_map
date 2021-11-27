<div class="modal fade" id="imgUploadModal" tabindex="-1" role="dialog" aria-labelledby="imgUploadModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">上傳新頭貼</h4>
      </div>
      <div class="modal-body">
        <div class="upload-msg">
          <a class="">
            <span>點擊進行頭貼更新</span>
            <input type="file" id="upload" value="Choose a file" accept="image/*"/>
          </a>
        </div>

        <div class="crop text-center">
          <div id="upload-demo"></div>
          <button type="button" class="btn btn-success" id="reUpload">更換圖片</button>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="imgUploadSunmit" >提交</button>
      </div>
    </div>
  </div>
</div>

<script>
  $("#addGroup").submit(function(e){
    e.preventDefault();
    $('#addGroupSubmit').click();
  });

  $('#imgUploadModal').on('hidden.bs.modal', function (e) {
    $(".crop").hide();
    $(".upload-msg").show();
  })

  $(function(){
    var uploadCrop;
    $('.crop').hide();

      function readFile(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          
          reader.onload = function (e) {
            uploadCrop.croppie('bind', {
              url: e.target.result
            });
          }

          reader.readAsDataURL(input.files[0]);
        }else{
          //alert("Sorry - you're browser doesn't support the FileReader API");
        }
      }

      uploadCrop = $('#upload-demo').croppie({
        viewport: {
          width: 200,
          height: 200,
          type: 'circle'
        },
        boundary: {
          width: 300,
          height: 300
        }
      });

      $('#upload').on('change', function () { 
        $(".crop").show();
        $(".upload-msg").hide();
        readFile(this); 
      });

      $('#imgUploadSunmit').on('click', function (ev) {
        uploadCrop.croppie('result', 'base64').then(function (resp) {
          submitImg(resp);
        });
      });

      $('#reUpload').on('click', function (ev) {
        $('#upload').click();
      });

      function submitImg(base64){
        swal({
          title: "即將送出更變",
          text: "這將影響到你的大頭貼",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willEdit) => {
          if (willEdit) {
            $.ajax({
              url: '<?php  echo base_url('profile/upLoadImg') ?>',
              dataType: 'text',
              type:'post',
              data: {imgInput: base64,
                     token: '<?php echo $token ?>'},
              error:function(){
                  swal("錯誤", "連線失敗，請重新送出", "error");
              },
              success: function(data){
                if(data == 0){
                  swal("錯誤", "圖片無法解析，請重新再試", "error");
                }else if (data == 1){
                  swal("成功", "已更新您的大頭貼", "success").then((value) => {
                    $('#imgUploadModal').modal('hide');
                    getMemberImg();
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
  });




  /*var uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 200,
        height: 200,
        type: 'circle'
    },
    boundary: {
        width: 300,
        height: 300
    }
  });*/



</script>