<form class="sign-box" id="form-recover_v2" name="form-recover_v2">
    <div class="sign-avatar">
        <img src="<?php echo base_url('dist/img/system/loginLogo.jpg'); ?>" alt="">
    </div>
    <header class="sign-title">忘記密碼</header>
    <header class="sign-title"><h6>信件中的六碼認證碼</h6></header>
    <div class="form-group">
        <div class="form-control-wrapper">
            <input placeholder="輸入認證碼"
                   id="number"
                   class="form-control"
                   name="number"
                   type="text" data-validation="[L==6, MIXED]"
                   data-validation-message="認證碼長度為6，並且無特殊符號">
        </div>
    </div>
    <button type="submit" class="btn btn-rounded">確定</button>
</form>

<script>
  //預設隱藏
  $('#form-recover_v2').hide();

  //驗證碼驗證區
  $('#form-recover_v2').validate({
      submit: {
          settings: {
              inputContainer: '.form-group',
              errorListClass: 'form-tooltip-error'
          },
          callback: {
              onSubmit : function (node, formData) {
                  submitRecaptcha2(node, formData);
              }
          }    
      }
  });

  //送出動作
  function submitRecaptcha2(node, formData){
       $.ajax({
          url: '<?php  echo base_url('recover/number') ?>',
          dataType: 'text',
          type:'post',
          data: {email : $('#email').val(),
                  number : $('#number').val()},
          error:function(){
              swal("錯誤", "連線失敗，請重新送出", "error");
          },
          success: function(data){
              if(data == '0'){
                  swal("驗證失敗", "請確認驗證碼是否正確", "error");
              }else if (data == '1'){
                  swal("驗證成功", "請更新密碼", "success").then((value) => {
                      $('#form-recover_v2').hide();
                      $('#form-recover_v3').show();
                  });
              }
          }
      });
  }
</script>