<form class="sign-box" id="form-recover_v3" name="form-recover_v3">
  <div class="sign-avatar">
      <img src="<?php echo base_url('dist/img/system/loginLogo.jpg'); ?>" alt="">
  </div>
  <header class="sign-title">忘記密碼</header>
  <header class="sign-title"><h6>輸入新的密碼</h6></header>
  <div class="form-group">
      <div class="form-control-wrapper">
          <div class="form-group">
              <div class="form-control-wrapper">
                  <input placeholder="密碼"
                         id="password"
                         class="form-control"
                         name="password"
                         type="password" data-validation="[L>=6, L<=20, MIXED]"
                         data-validation-message="密碼必須介於6到20個字符之間。不允許特殊字符。">
              </div>
          </div>
          <div class="form-group">
              <div class="form-control-wrapper">
                  <input placeholder="重複密碼"
                         id="password-confirm"
                         class="form-control"
                         name="password-confirm"
                         type="password" data-validation="[V==password]"
                         data-validation-message="必須與密碼相符">
              </div>
          </div>
      </div>
  </div>
  <button type="submit" class="btn btn-rounded">確定</button>
</form>

<script>
  //預設隱藏
    $('#form-recover_v3').hide();
  //驗證碼驗證區
  $('#form-recover_v3').validate({
      submit: {
          settings: {
              inputContainer: '.form-group',
              errorListClass: 'form-tooltip-error'
          },
          callback: {
              onSubmit : function (node, formData) {
                  submitRecaptcha3(node, formData);
              }
          }    
      }
  });

  //送出動作
  function submitRecaptcha3(node, formData){
    $.ajax({
        url: '<?php  echo base_url('recover/password') ?>',
        dataType: 'text',
        type:'post',
        data: {email : $('#email').val(),
                number : $('#number').val(),
                password : $('#password').val()},
        error:function(){
            swal("錯誤", "連線失敗，請重新送出", "error");
        },
        success: function(data){
            if(data == '0'){
                swal("修改失敗", "若重複出現此錯誤請重新再試", "error");
            }else if (data == '1'){
                swal("修改成功", "即將轉跳登入頁面", "success").then((value) => {
                    document.location.href='<?php  echo base_url('login') ?>';
                });
            }
        }
    });
  }
</script>